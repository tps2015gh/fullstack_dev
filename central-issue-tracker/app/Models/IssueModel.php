<?php

namespace App\Models;

use CodeIgniter\Model;

class IssueModel extends Model
{
    protected $table            = 'issues';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'project_id', 'title', 'description', 'type', 
        'priority', 'status', 'due_date'
    ];
    protected $useTimestamps = true;

    public function getIssuesWithProject()
    {
        return $this->select('issues.*, projects.name as project_name')
                    ->join('projects', 'projects.id = issues.project_id')
                    ->orderBy('issues.created_at', 'DESC')
                    ->findAll();
    }
}
