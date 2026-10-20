<?php

namespace App\Controllers;

use App\Models\TicketModel;
use App\Models\TicketReplyModel;

class Tickets extends BaseController
{
    protected $ticketModel;
    protected $replyModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->replyModel  = new TicketReplyModel();
    }

    // يرجع البلاغ فقط إذا كان للموظف الحالي
    protected function findMine($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket || $ticket['created_by'] != session()->get('user_id')) {
            return null;
        }

        return $ticket;
    }

    protected function ticketRules(): array
    {
        $departments = implode(',', array_keys(TicketModel::DEPARTMENTS));

        return [
            'title'       => 'required|min_length[5]|max_length[255]',
            'category'    => 'required|in_list[' . $departments . ']',
            'description' => 'required|min_length[10]',
            'priority'    => 'required|in_list[low,medium,high]',
        ];
    }

    // بلاغات الموظف الحالي فقط (10 بكل صفحة)
    public function index()
    {
        $tickets = $this->ticketModel
            ->where('created_by', session()->get('user_id'))
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('tickets/index', [
            'tickets' => $tickets,
            'pager'   => $this->ticketModel->pager,
        ]);
    }

    public function create()
    {
        return view('tickets/create');
    }

    // حفظ بلاغ جديد (يدخل مرحلة التدقيق)
    public function store()
    {
        if (!$this->validate($this->ticketRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->ticketModel->save([
            'title'         => $this->request->getPost('title'),
            'description'   => $this->request->getPost('description'),
            'priority'      => $this->request->getPost('priority'),
            'category'      => $this->request->getPost('category'),
            'status'        => 'open',
            'review_status' => 'pending',
            'created_by'    => session()->get('user_id'),
        ]);

        return redirect()->to('/tickets')->with('success', 'تم إرسال البلاغ وهو الآن بانتظار التدقيق');
    }

    // نموذج تعديل بلاغ مرفوض (نفس نموذج الفتح)
    public function edit($id)
    {
        $ticket = $this->findMine($id);

        if (!$ticket) {
            return redirect()->to('/tickets')->with('error', 'البلاغ غير موجود');
        }

        if ($ticket['review_status'] !== 'rejected') {
            return redirect()->to('/tickets/show/' . $id)->with('error', 'يمكن تعديل البلاغات غير المعتمدة فقط');
        }

        return view('tickets/create', ['ticket' => $ticket]);
    }

    // إعادة إرسال البلاغ المرفوض للتدقيق
    public function resubmit($id)
    {
        $ticket = $this->findMine($id);

        if (!$ticket) {
            return redirect()->to('/tickets')->with('error', 'البلاغ غير موجود');
        }

        if ($ticket['review_status'] !== 'rejected') {
            return redirect()->to('/tickets/show/' . $id)->with('error', 'يمكن إعادة إرسال البلاغات غير المعتمدة فقط');
        }

        if (!$this->validate($this->ticketRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // نبقي سبب الرفض السابق ليراه المدقق، ويتصفّر عند القرار الجديد
        $this->ticketModel->update($id, [
            'title'            => $this->request->getPost('title'),
            'description'      => $this->request->getPost('description'),
            'priority'         => $this->request->getPost('priority'),
            'category'         => $this->request->getPost('category'),
            'status'           => 'open',
            'review_status'    => 'pending',
            'reviewed_by'      => null,
            'reviewed_at'      => null,
            'has_new_decision' => 0,
            'resubmit_count'   => (int) $ticket['resubmit_count'] + 1,
        ]);

        return redirect()->to('/tickets')->with('success', 'تم تعديل البلاغ وإعادة إرساله للتدقيق');
    }

    // تفاصيل بلاغ + المحادثة
    public function show($id)
    {
        $ticket = $this->findMine($id);

        if (!$ticket) {
            return redirect()->to('/tickets')->with('error', 'البلاغ غير موجود');
        }

        // تصفير الإشعارات (رد جديد / قرار جديد) عند فتح البلاغ
        $reset = [];
        if (!empty($ticket['has_new_reply'])) {
            $reset['has_new_reply'] = 0;
        }
        if (!empty($ticket['has_new_decision'])) {
            $reset['has_new_decision'] = 0;
        }
        if ($reset) {
            $this->ticketModel->update($id, $reset);
        }

        $replies = $this->replyModel
            ->select('ticket_replies.*, users.name as sender_name, users.role as sender_role')
            ->join('users', 'users.id = ticket_replies.user_id')
            ->where('ticket_id', $id)
            ->orderBy('ticket_replies.created_at', 'ASC')
            ->findAll();

        return view('tickets/show', [
            'ticket'  => $ticket,
            'replies' => $replies,
        ]);
    }

    // رد الموظف (فقط بعد الاعتماد وقبل إنهاء البلاغ)
    public function reply($id)
    {
        $ticket = $this->findMine($id);

        if (!$ticket) {
            return redirect()->to('/tickets')->with('error', 'البلاغ غير موجود');
        }

        if ($ticket['review_status'] !== 'approved' || $ticket['status'] === 'resolved') {
            return redirect()->to('/tickets/show/' . $id)->with('error', 'لا يمكن إضافة رد على هذا البلاغ');
        }

        $message = trim((string) $this->request->getPost('message'));

        if ($message !== '') {
            $this->replyModel->save([
                'ticket_id' => $id,
                'user_id'   => session()->get('user_id'),
                'message'   => $message,
            ]);
        }

        return redirect()->to('/tickets/show/' . $id);
    }
}