<?php

namespace App\Controllers;

use App\Libraries\SimpleXlsx;
use App\Models\TicketModel;
use App\Models\TicketReplyModel;
use App\Models\UserModel;

class Admin extends BaseController
{
    protected $ticketModel;
    protected $replyModel;
    protected $userModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
        $this->replyModel  = new TicketReplyModel();
        $this->userModel   = new UserModel();
    }

    // يرجع البلاغ فقط إذا كان معتمدًا من المدقق
    protected function findApproved($id)
    {
        return $this->ticketModel
            ->select('tickets.*, users.name as employee_name')
            ->join('users', 'users.id = tickets.created_by')
            ->where('tickets.id', $id)
            ->where('tickets.review_status', 'approved')
            ->first();
    }

    // نفس الاستعلام للعرض وللتصدير
    protected function approvedQuery(array $filters): TicketModel
    {
        $this->ticketModel
            ->select('tickets.*, users.name as employee_name')
            ->join('users', 'users.id = tickets.created_by')
            ->where('tickets.review_status', 'approved')
            ->applyFilters($filters);

        return $this->ticketModel;
    }

    // كل البلاغات المعتمدة (15 بكل صفحة) مع البحث والفلترة
    public function index()
    {
        $filters = TicketModel::cleanFilters($this->request->getGet());

        // عدادات المربعات (كل المعتمدة بغض النظر عن الفلاتر)
        $counts = ['open' => 0, 'in_progress' => 0, 'resolved' => 0];

        $rows = $this->ticketModel
            ->select('status, COUNT(*) AS total')
            ->where('review_status', 'approved')
            ->groupBy('status')
            ->findAll();

        foreach ($rows as $row) {
            $counts[$row['status']] = (int) $row['total'];
        }

        $tickets = $this->approvedQuery($filters)
            ->orderBy("FIELD(tickets.priority, 'high', 'medium', 'low')", '', false)
            ->orderBy('tickets.created_at', 'DESC')
            ->paginate(15);

        return view('admin/index', [
            'tickets' => $tickets,
            'pager'   => $this->ticketModel->pager,
            'counts'  => $counts,
            'filters' => $filters,
        ]);
    }

    // تفاصيل بلاغ + المحادثة
    public function show($id)
    {
        $ticket = $this->findApproved($id);

        if (!$ticket) {
            return redirect()->to('/admin/tickets')->with('error', 'البلاغ غير موجود');
        }

        $data['ticket']  = $ticket;
        $data['replies'] = $this->replyModel
            ->select('ticket_replies.*, users.name as sender_name, users.role as sender_role')
            ->join('users', 'users.id = ticket_replies.user_id')
            ->where('ticket_id', $id)
            ->orderBy('ticket_replies.created_at', 'ASC')
            ->findAll();

        return view('admin/show', $data);
    }

    // رد التقني + تحديث الحالة + إنهاء المحادثة
    public function reply($id)
    {
        $ticket = $this->findApproved($id);

        if (!$ticket) {
            return redirect()->to('/admin/tickets')->with('error', 'البلاغ غير موجود');
        }

        if ($ticket['status'] === 'resolved') {
            return redirect()->to('/admin/tickets/show/' . $id)->with('error', 'هذا البلاغ مغلق بالفعل');
        }

        $message     = trim((string) $this->request->getPost('message'));
        $status      = $this->request->getPost('status');
        $statusOnly  = $this->request->getPost('update_status_only');
        $closeTicket = $this->request->getPost('close_ticket');

        if ($closeTicket) {
            $this->ticketModel->update($id, [
                'status'      => 'resolved',
                'assigned_to' => session()->get('user_id'),
            ]);
            return redirect()->to('/admin/tickets/show/' . $id)->with('success', 'تم إنهاء البلاغ بنجاح');
        }

        if ($statusOnly) {
            if (!empty($status) && in_array($status, ['open', 'in_progress', 'resolved'], true)) {
                $this->ticketModel->update($id, [
                    'status'      => $status,
                    'assigned_to' => session()->get('user_id'),
                ]);
            }
            return redirect()->to('/admin/tickets/show/' . $id)->with('success', 'تم تحديث الحالة بنجاح');
        }

        if ($message !== '') {
            $this->replyModel->save([
                'ticket_id' => $id,
                'user_id'   => session()->get('user_id'),
                'message'   => $message,
            ]);

            $this->ticketModel->update($id, ['has_new_reply' => 1]);
        }

        return redirect()->to('/admin/tickets/show/' . $id)->with('success', 'تم إرسال الرد بنجاح');
    }

    // حذف بلاغ
    public function delete($id)
    {
        $ticket = $this->findApproved($id);

        if (!$ticket) {
            return redirect()->to('/admin/tickets')->with('error', 'البلاغ غير موجود');
        }

        $this->ticketModel->delete($id);

        return redirect()->to('/admin/tickets')->with('success', 'تم حذف البلاغ بنجاح');
    }

    // تصدير البلاغات المعتمدة (بنفس الفلاتر المعروضة) إلى إكسل
    public function export()
    {
        if (!SimpleXlsx::isAvailable()) {
            return redirect()->back()->with('error', 'تصدير إكسل يحتاج تفعيل إضافة zip: افتحي php.ini وفعّلي السطر extension=zip ثم أعيدي تشغيل السيرفر');
        }

        $filters = TicketModel::cleanFilters($this->request->getGet());

        $tickets = $this->approvedQuery($filters)
            ->orderBy('tickets.created_at', 'DESC')
            ->findAll();

        $headers = ['رقم البلاغ', 'العنوان', 'القسم', 'الموظف', 'الأولوية', 'الحالة', 'تاريخ الإرسال'];

        $rows = [];
        foreach ($tickets as $t) {
            $rows[] = [
                (int) $t['id'],
                $t['title'],
                TicketModel::DEPARTMENTS[$t['category']] ?? 'أخرى',
                $t['employee_name'],
                TicketModel::PRIORITIES[$t['priority']] ?? $t['priority'],
                TicketModel::STATUSES[$t['status']] ?? $t['status'],
                date('Y-m-d H:i', strtotime($t['created_at'])),
            ];
        }

        $binary   = SimpleXlsx::build('البلاغات', $headers, $rows);
        $filename = 'tickets_report_' . date('Y-m-d') . '.xlsx';

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'no-store')
            ->setBody($binary);
    }
}