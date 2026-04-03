<?php

namespace App\Controllers;

use App\Models\ServerModel;
use App\Models\AuditHistoryModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $serverModel = new ServerModel();
        $historyModel = new AuditHistoryModel();

        $data = [
            'totalServers' => $serverModel->countAll(),
            'onlineServers' => $serverModel->where('status', 'online')->countAll(),
            'warningServers' => $serverModel->where('status', 'warning')->countAll(),
            'recentAudits' => $historyModel->select('audit_history.*, servers.hostname')
                                           ->join('servers', 'servers.id = audit_history.server_id')
                                           ->orderBy('upload_date', 'DESC')
                                           ->limit(5)
                                           ->find(),
            'title' => 'Dashboard Overview'
        ];

        return view('dashboard/index', $data);
    }

    public function switchTheme($theme)
    {
        session()->set('theme', $theme);
        return redirect()->back();
    }
}
