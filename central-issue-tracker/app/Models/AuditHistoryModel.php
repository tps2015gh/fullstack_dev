<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditHistoryModel extends Model
{
    protected $table            = 'audit_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['server_id', 'upload_date', 'raw_json_path', 'summary'];
}
