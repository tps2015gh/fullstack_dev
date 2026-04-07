<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\IssueModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();
        $issueModel = new IssueModel();

        $data = [
            'totalProjects' => $projectModel->countAll(),
            'openIssues'    => $issueModel->whereNotIn('status', ['completed', 'closed'])->countAllResults(),
            'recentIssues'  => $issueModel->getIssuesWithProject(),
            'title'         => 'Tracker Overview'
        ];

        return view('dashboard/index', $data);
    }
}
