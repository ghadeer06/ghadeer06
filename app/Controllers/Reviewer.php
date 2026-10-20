<?php

namespace App\Controllers;

use App\Libraries\SimpleXlsx;
use App\Models\TicketModel;

class Reviewer extends BaseController
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
    }

    protected function normalizeTab($tab): string
    {
        return in_array($tab, ['pending', 'approved', 'rejected'], true) ? $tab : 'pending';
    }

    // فلاتر المدقق: بحث + قسم + أولوية (الحالة يحددها التبويب)
    protected function currentFilters(): array
    {
        $filters           = TicketModel::cleanFilters($this->request->getGet());
        $filters['status'] = '';

        return $filters;
    }

    // نفس الاستعلام للعرض وللتصدير
    protected function ticketsQuery(string $tab, array $filters): TicketModel
    {
        $this->ticketModel
            ->select('tickets.*, users.name as employee_name')
            ->join('users', 'users.id = tickets.created_by')
            ->where('tickets.review_status', $tab)
            ->applyFilters($filters);

        if ($tab === 'pending') {
            // الأعلى أولوية أول، وداخل كل أولوية الأقدم أول
            $this->ticketModel
                ->orderBy("FIELD(tickets.priority, 'high', 'medium', 'low')", '', false)
                ->orderBy('tickets.created_at', 'ASC');
        } else {
            $this->ticketModel->orderBy('tickets.reviewed_at', 'DESC');
        }

        return $this->ticketModel;
    }

    protected function formatDate($date): string
    {
        return $date ? date('Y-m-d H:i', strtotime($date)) : '';
    }

    // قائمة البلاغات حسب التبويب والفلاتر (10 بكل صفحة)
    public function index()
    {
        $tab     = $this->normalizeTab($this->request->getGet('tab'));
        $filters = $this->currentFilters();

        $counts = [];
        foreach (['pending', 'approved', 'rejected'] as $status) {
            $counts[$status] = $this->ticketModel->where('review_status', $status)->countAllResults();
        }

        $tickets = $this->ticketsQuery($tab, $filters)->paginate(10);

        return view('reviewer/index', [
            'tickets' => $tickets,
            'pager'   => $this->ticketModel->pager,
            'tab'     => $tab,
            'counts'  => $counts,
            'filters' => $filters,
        ]);
    }

    // تصدير بلاغات التبويب الحالي (بنفس الفلاتر) إلى إكسل
    public function export()
    {
        if (!SimpleXlsx::isAvailable()) {
            return redirect()->back()->with('error', 'تصدير إكسل يحتاج تفعيل إضافة zip: افتحي php.ini وفعّلي السطر extension=zip ثم أعيدي تشغيل السيرفر');
        }

        $tab     = $this->normalizeTab($this->request->getGet('tab'));
        $filters = $this->currentFilters();
        $tickets = $this->ticketsQuery($tab, $filters)->findAll();

        $headers = ['رقم البلاغ', 'العنوان', 'القسم', 'الموظف', 'الأولوية', 'تاريخ الإرسال'];

        if ($tab === 'approved') {
            $headers[] = 'حالة المعالجة';
            $headers[] = 'تاريخ التدقيق';
        } elseif ($tab === 'rejected') {
            $headers[] = 'سبب الرفض';
            $headers[] = 'تاريخ التدقيق';
        }

        $rows = [];
        foreach ($tickets as $t) {
            $row = [
                (int) $t['id'],
                $t['title'],
                TicketModel::DEPARTMENTS[$t['category']] ?? 'أخرى',
                $t['employee_name'],
                TicketModel::PRIORITIES[$t['priority']] ?? $t['priority'],
                $this->formatDate($t['created_at']),
            ];

            if ($tab === 'approved') {
                $row[] = TicketModel::STATUSES[$t['status']] ?? $t['status'];
                $row[] = $this->formatDate($t['reviewed_at']);
            } elseif ($tab === 'rejected') {
                $row[] = (string) ($t['review_note'] ?? '');
                $row[] = $this->formatDate($t['reviewed_at']);
            }

            $rows[] = $row;
        }

        $tabNames = ['pending' => 'بانتظار التدقيق', 'approved' => 'المعتمدة', 'rejected' => 'غير المعتمدة'];

        $binary   = SimpleXlsx::build($tabNames[$tab], $headers, $rows);
        $filename = 'reviewer_' . $tab . '_' . date('Y-m-d') . '.xlsx';

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'no-store')
            ->setBody($binary);
    }

    // قرار المدقق: معتمد أو غير معتمد
    public function decide($id)
    {
        $ticket = $this->ticketModel->find($id);

        if (!$ticket) {
            return redirect()->to('/reviewer/tickets')->with('error', 'البلاغ غير موجود');
        }

        if ($ticket['review_status'] !== 'pending') {
            return redirect()->to('/reviewer/tickets')->with('error', 'تم اتخاذ قرار بشأن هذا البلاغ مسبقًا');
        }

        $decision = $this->request->getPost('decision');
        if (!in_array($decision, ['approved', 'rejected'], true)) {
            return redirect()->to('/reviewer/tickets')->with('error', 'قرار غير صحيح');
        }

        $note = trim((string) $this->request->getPost('review_note'));

        $this->ticketModel->update($id, [
            'review_status'    => $decision,
            'review_note'      => ($decision === 'rejected' && $note !== '') ? $note : null,
            'reviewed_by'      => session()->get('user_id'),
            'reviewed_at'      => date('Y-m-d H:i:s'),
            'has_new_decision' => 1, // إشعار للموظف
        ]);

        $message = $decision === 'approved'
            ? 'تم اعتماد البلاغ وتحويله للتقني'
            : 'تم رفض البلاغ ولن يصل للتقني';

        return redirect()->to('/reviewer/tickets')->with('success', $message);
    }
}