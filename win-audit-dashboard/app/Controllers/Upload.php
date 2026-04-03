<?php

namespace App\Controllers;

use App\Models\ServerModel;
use App\Models\AuditHistoryModel;

class Upload extends BaseController
{
    public function index()
    {
        return view('upload/index', ['title' => 'Upload Audit JSON']);
    }

    public function process()
    {
        $file = $this->request->getFile('audit_file');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'Invalid file');
        }

        $jsonContent = file_get_contents($file->getTempName());
        $data = json_decode($jsonContent, true);

        if (!$data || !isset($data['hostname'])) {
            return redirect()->back()->with('error', 'Invalid JSON format');
        }

        $serverModel = new ServerModel();
        $historyModel = new AuditHistoryModel();

        // 1. Update or Create Server
        $server = $serverModel->where('hostname', $data['hostname'])->first();
        
        $serverData = [
            'hostname'      => $data['hostname'],
            'ip_address'    => isset($data['network_info'][0]['ips'][0]) ? $data['network_info'][0]['ips'][0] : 'N/A',
            'os_name'       => $data['os_info']['name'] ?? 'N/A',
            'os_version'    => $data['os_info']['version'] ?? 'N/A',
            'cpu'           => $data['hardware_info']['cpu'] ?? 'N/A',
            'ram_total'     => $data['hardware_info']['ram_total'] ?? 'N/A',
            'disk_info'     => json_encode($data['hardware_info']['disk_partitions'] ?? []),
            'status'        => 'online',
            'last_audit_at' => date('Y-m-d H:i:s'),
        ];

        if ($server) {
            $serverId = $server['id'];
            $serverModel->update($serverId, $serverData);
        } else {
            $serverId = $serverModel->insert($serverData);
        }

        // 2. Save JSON file to uploads directory
        $newName = $file->getRandomName();
        $file->move(WRITEPATH . 'uploads/audits', $newName);

        // 3. Add to Audit History
        $historyModel->insert([
            'server_id'     => $serverId,
            'upload_date'   => date('Y-m-d H:i:s'),
            'raw_json_path' => 'uploads/audits/' . $newName,
            'summary'       => 'Audit completed for ' . $data['hostname'] . ' at ' . $data['timestamp'],
        ]);

        return redirect()->to('/dashboard')->with('success', 'Audit processed successfully');
    }
}
