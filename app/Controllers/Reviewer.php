<?php

namespace App\Controllers;

use App\Models\TicketModel;

class Reviewer extends BaseController
{
    protected $ticketModel;

    public function __construct()
    {
        $this->ticketModel = new TicketModel();
    }

    // يتأكد إن التبويب من القيم المسموحة
    protected function normalizeTab($tab): string
    {
        return in_array($tab, ['pending', 'approved', 'rejected'], true) ? $tab : 'pending';
    }

    // يجيب بلاغات التبويب (نفس الاستعلام للعرض وللتصدير)
    protected function ticketsByTab(string $tab): array
    {
        $query = $this->ticketModel
            ->select('tickets.*, users.name as employee_name')
            ->join('users', 'users.id = tickets.created_by')
            ->where('tickets.review_status', $tab);

        if ($tab === 'pending') {
            // الأعلى أولوية أول، وداخل كل أولوية الأقدم أول
            $query->orderBy("FIELD(tickets.priority, 'high', 'medium', 'low')", '', false)
                  ->orderBy('tickets.created_at', 'ASC');
        } else {
            $query->orderBy('tickets.reviewed_at', 'DESC');
        }

        return $query->findAll();
    }

    // حماية ملف الإكسل: النص اللي يبدأ برمز صيغة (= + - @) يتحول لنص عادي
    protected function csvSafe($value): string
    {
        $value = (string) $value;

        if ($value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $value;
        }

        return $value;
    }

    protected function formatDate($date): string
    {
        return $date ? date('Y-m-d H:i', strtotime($date)) : '';
    }

    // قائمة البلاغات حسب التبويب
    public function index()
    {
        $tab = $this->normalizeTab($this->request->getGet('tab'));

        $counts = [];
        foreach (['pending', 'approved', 'rejected'] as $status) {
            $counts[$status] = $this->ticketModel->where('review_status', $status)->countAllResults();
        }

        $data = [
            'tickets' => $this->ticketsByTab($tab),
            'tab'     => $tab,
            'counts'  => $counts,
        ];

        return view('reviewer/index', $data);
    }

    // تصدير بلاغات التبويب المحدد إلى إكسل (CSV)
    public function export()
    {
        $tab     = $this->normalizeTab($this->request->getGet('tab'));
        $tickets = $this->ticketsByTab($tab);

        $departments    = TicketModel::DEPARTMENTS;
        $priorityLabels = ['low' => 'منخفضة', 'medium' => 'متوسطة', 'high' => 'عالية'];
        $statusLabels   = ['open' => 'جديد', 'in_progress' => 'قيد المعالجة', 'resolved' => 'تم الحل'];

        // الأعمدة تختلف حسب التبويب
        $headers = ['رقم البلاغ', 'العنوان', 'القسم', 'الموظف', 'الأولوية', 'تاريخ الإرسال'];

        if ($tab === 'approved') {
            $headers[] = 'حالة المعالجة';
            $headers[] = 'تاريخ التدقيق';
        } elseif ($tab === 'rejected') {
            $headers[] = 'سبب الرفض';
            $headers[] = 'تاريخ التدقيق';
        }

        $output = fopen('php://temp', 'w');
        fwrite($output, "\xEF\xBB\xBF"); // عشان العربي يطلع صح بإكسل

        fputcsv($output, $headers, ';');

        foreach ($tickets as $t) {
            $row = [
                $t['id'],
                $this->csvSafe($t['title']),
                $departments[$t['category']] ?? 'أخرى',
                $this->csvSafe($t['employee_name']),
                $priorityLabels[$t['priority']] ?? $t['priority'],
                $this->formatDate($t['created_at']),
            ];

            if ($tab === 'approved') {
                $row[] = $statusLabels[$t['status']] ?? $t['status'];
                $row[] = $this->formatDate($t['reviewed_at']);
            } elseif ($tab === 'rejected') {
                $row[] = $this->csvSafe($t['review_note'] ?? '');
                $row[] = $this->formatDate($t['reviewed_at']);
            }

            fputcsv($output, $row, ';');
        }

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        $filename = 'reviewer_' . $tab . '_' . date('Y-m-d') . '.csv';

        $response = service('response');
        $response->setHeader('Content-Type', 'text/csv; charset=UTF-8');
        $response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response->setBody($csvContent);
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
            'review_status' => $decision,
            'review_note'   => ($decision === 'rejected' && $note !== '') ? $note : null,
            'reviewed_by'   => session()->get('user_id'),
            'reviewed_at'   => date('Y-m-d H:i:s'),
        ]);

        $message = $decision === 'approved'
            ? 'تم اعتماد البلاغ وتحويله للتقني'
            : 'تم رفض البلاغ ولن يصل للتقني';

        return redirect()->to('/reviewer/tickets')->with('success', $message);
    }
}