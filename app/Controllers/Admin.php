<?php

namespace App\Controllers;

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

    // كل البلاغات المعتمدة
    public function index()
    {
        $data['tickets'] = $this->ticketModel
            ->select('tickets.*, users.name as employee_name')
            ->join('users', 'users.id = tickets.created_by')
            ->where('tickets.review_status', 'approved')
            ->orderBy("FIELD(tickets.priority, 'high', 'medium', 'low')", '', false)
            ->orderBy('tickets.created_at', 'DESC')
            ->findAll();

        return view('admin/index', $data);
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

    // تصدير البلاغات المعتمدة إلى إكسل (CSV)
    public function exportCsv()
    {
        $tickets = $this->ticketModel
            ->select('tickets.*, users.name as employee_name')
            ->join('users', 'users.id = tickets.created_by')
            ->where('tickets.review_status', 'approved')
            ->orderBy('tickets.created_at', 'DESC')
            ->findAll();

        $filename = 'tickets_report_' . date('Y-m-d') . '.csv';

        $departments    = TicketModel::DEPARTMENTS;
        $priorityLabels = ['low' => 'منخفضة', 'medium' => 'متوسطة', 'high' => 'عالية'];
        $statusLabels   = ['open' => 'جديد', 'in_progress' => 'قيد المعالجة', 'resolved' => 'تم الحل'];

        $response = service('response');
        $response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $output = fopen('php://temp', 'w');
        fwrite($output, "\xEF\xBB\xBF");

        fputcsv($output, ['رقم البلاغ', 'العنوان', 'القسم', 'الموظف', 'الأولوية', 'الحالة', 'تاريخ الإرسال'], ';');

        foreach ($tickets as $t) {
            fputcsv($output, [
                $t['id'],
                $t['title'],
                $departments[$t['category']] ?? 'أخرى',
                $t['employee_name'],
                $priorityLabels[$t['priority']] ?? $t['priority'],
                $statusLabels[$t['status']] ?? $t['status'],
                date('Y-m-d H:i', strtotime($t['created_at'])),
            ], ';');
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return $response->setBody($csvContent);
    }
}