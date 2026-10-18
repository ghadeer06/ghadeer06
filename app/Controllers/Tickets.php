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

    // بلاغات الموظف الحالي فقط
    public function index()
    {
        $data['tickets'] = $this->ticketModel
            ->where('created_by', session()->get('user_id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('tickets/index', $data);
    }

    public function create()
    {
        return view('tickets/create');
    }

    // حفظ بلاغ جديد (يدخل مرحلة التدقيق)
    public function store()
    {
        $departments = implode(',', array_keys(TicketModel::DEPARTMENTS));

        $rules = [
            'title'       => 'required|min_length[5]|max_length[255]',
            'category'    => 'required|in_list[' . $departments . ']',
            'description' => 'required|min_length[10]',
            'priority'    => 'required|in_list[low,medium,high]',
        ];

        if (!$this->validate($rules)) {
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

    // تفاصيل بلاغ + المحادثة
    public function show($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket || $ticket['created_by'] != session()->get('user_id')) {
            return redirect()->to('/tickets')->with('error', 'البلاغ غير موجود');
        }

        // تصفير إشعار الرد الجديد
        if ($ticket['has_new_reply']) {
            $this->ticketModel->update($id, ['has_new_reply' => 0]);
            $ticket['has_new_reply'] = 0;
        }

        $data['ticket']  = $ticket;
        $data['replies'] = $this->replyModel
            ->select('ticket_replies.*, users.name as sender_name, users.role as sender_role')
            ->join('users', 'users.id = ticket_replies.user_id')
            ->where('ticket_id', $id)
            ->orderBy('ticket_replies.created_at', 'ASC')
            ->findAll();

        return view('tickets/show', $data);
    }

    // رد الموظف (فقط بعد الاعتماد وقبل إنهاء البلاغ)
    public function reply($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket || $ticket['created_by'] != session()->get('user_id')) {
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