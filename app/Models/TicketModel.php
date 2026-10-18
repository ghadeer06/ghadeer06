<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketModel extends Model
{
    // قائمة الأقسام: لإضافة قسم جديد أضيفي سطر هنا فقط
    public const DEPARTMENTS = [
        'support'  => 'دعم فني',
        'network'  => 'شبكات وإنترنت',
        'software' => 'برامج وأنظمة',
        'hardware' => 'أجهزة',
        'printer'  => 'طابعات',
        'web_page' => 'الموقع الإلكتروني',
        'other'    => 'أخرى',
    ];

    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'title', 'description', 'priority', 'status', 'category',
        'created_by', 'assigned_to', 'has_new_reply',
        'review_status', 'review_note', 'reviewed_by', 'reviewed_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';
}