<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    // لإضافة قسم جديد أضيفي سطر هنا فقط
    public const DEPARTMENTS = [
        'support'  => 'دعم فني',
        'network'  => 'شبكات وإنترنت',
        'software' => 'برامج وأنظمة',
        'hardware' => 'أجهزة',
        'printer'  => 'طابعات',
        'web_page' => 'الموقع الإلكتروني',
        'other'    => 'أخرى',
    ];

    public const PRIORITIES = [
        'low'    => 'منخفضة',
        'medium' => 'متوسطة',
        'high'   => 'عالية',
    ];

    public const STATUSES = [
        'open'        => 'جديد',
        'in_progress' => 'قيد المعالجة',
        'resolved'    => 'تم الحل',
    ];

    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'title', 'description', 'priority', 'status', 'category',
        'created_by', 'assigned_to', 'has_new_reply',
        'review_status', 'review_note', 'reviewed_by', 'reviewed_at',
        'resubmit_count', 'has_new_decision',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    // ينظّف قيم الفلاتر القادمة من الرابط ويقبل القيم المسموحة فقط
    public static function cleanFilters(array $input): array
    {
        $str = static function ($key) use ($input): string {
            return (isset($input[$key]) && is_string($input[$key])) ? trim($input[$key]) : '';
        };

        $pick = static function (string $value, array $allowed): string {
            return array_key_exists($value, $allowed) ? $value : '';
        };

        return [
            'q'        => $str('q'),
            'dept'     => $pick($str('dept'), self::DEPARTMENTS),
            'priority' => $pick($str('priority'), self::PRIORITIES),
            'status'   => $pick($str('status'), self::STATUSES),
        ];
    }

    // يطبّق الفلاتر على الاستعلام (يلزم وجود join مع جدول users)
    public function applyFilters(array $filters): self
    {
        if (($filters['q'] ?? '') !== '') {
            $this->groupStart()
                    ->like('tickets.title', $filters['q'])
                    ->orLike('users.name', $filters['q'])
                    ->orLike('tickets.description', $filters['q'])
                 ->groupEnd();
        }

        if (!empty($filters['dept'])) {
            $this->where('tickets.category', $filters['dept']);
        }

        if (!empty($filters['priority'])) {
            $this->where('tickets.priority', $filters['priority']);
        }

        if (!empty($filters['status'])) {
            $this->where('tickets.status', $filters['status']);
        }

        return $this;
    }
}