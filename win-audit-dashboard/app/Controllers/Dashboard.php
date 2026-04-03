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

        // Get recent audits with full JSON data
        $recentAudits = $historyModel->select('audit_history.*, servers.hostname')
                                           ->join('servers', 'servers.id = audit_history.server_id')
                                           ->orderBy('upload_date', 'DESC')
                                           ->limit(5)
                                           ->find();
        
        // Parse JSON data for each audit to show detailed patch info
        foreach ($recentAudits as &$audit) {
            $jsonPath = WRITEPATH . $audit['raw_json_path'];
            if (file_exists($jsonPath)) {
                $jsonContent = file_get_contents($jsonPath);
                $audit['full_data'] = json_decode($jsonContent, true);
                
                // Count security patches
                $audit['security_patch_count'] = 0;
                $audit['os_patch_count'] = 0;
                if (isset($audit['full_data']['system_updates'])) {
                    foreach ($audit['full_data']['system_updates'] as $update) {
                        if (isset($update['type']) && $update['type'] === 'Security Update') {
                            $audit['security_patch_count']++;
                        } else {
                            $audit['os_patch_count']++;
                        }
                    }
                }
            } else {
                $audit['full_data'] = null;
            }
        }

        $data = [
            'totalServers' => $serverModel->countAll(),
            'onlineServers' => $serverModel->where('status', 'online')->countAll(),
            'warningServers' => $serverModel->where('status', 'warning')->countAll(),
            'recentAudits' => $recentAudits,
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
