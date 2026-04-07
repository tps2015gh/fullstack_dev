<?php

namespace App\Models;

use CodeIgniter\Model;

class ServerModel extends Model
{
    protected $table            = 'servers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'hostname', 'ip_address', 'os_name', 'os_version', 
        'cpu', 'ram_total', 'disk_info', 'status', 'last_audit_at'
    ];
    protected $useTimestamps = true;
}
