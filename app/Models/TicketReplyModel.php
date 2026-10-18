<?php

namespace App\Models;

use CodeIgniter\Model;

class TicketReplyModel extends Model
{
    protected $table            = 'ticket_replies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = ['ticket_id', 'user_id', 'message'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $dateFormat    = 'datetime';
}