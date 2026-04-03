<?php

namespace App\Controllers;

use App\Models\ServerModel;

class Server extends BaseController
{
    public function index()
    {
        $model = new ServerModel();
        $historyModel = new \App\Models\AuditHistoryModel();
        
        $servers = $model->findAll();
        
        // Get latest audit and security patch count for each server
        foreach ($servers as &$server) {
            $lastAudit = $historyModel->where('server_id', $server['id'])
                                      ->orderBy('upload_date', 'DESC')
                                      ->first();
            
            $server['security_patch_count'] = 0;
            $server['total_patch_count'] = 0;
            $server['last_audit_at'] = $server['last_audit_at'] ?? null;
            
            if ($lastAudit && file_exists(WRITEPATH . $lastAudit['raw_json_path'])) {
                $jsonContent = file_get_contents(WRITEPATH . $lastAudit['raw_json_path']);
                $auditData = json_decode($jsonContent, true);
                
                if (isset($auditData['system_updates'])) {
                    foreach ($auditData['system_updates'] as $update) {
                        $server['total_patch_count']++;
                        if (($update['type'] ?? '') === 'Security Update') {
                            $server['security_patch_count']++;
                        }
                    }
                }
            }
        }
        
        $data = [
            'servers' => $servers,
            'title'   => 'Server Management'
        ];
        return view('server/index', $data);
    }

    public function add()
    {
        return view('server/add', ['title' => 'Add Server']);
    }

    public function save()
    {
        $model = new ServerModel();
        $data = [
            'hostname'   => $this->request->getPost('hostname'),
            'ip_address' => $this->request->getPost('ip_address'),
            'status'     => $this->request->getPost('status'),
        ];
        $model->insert($data);
        return redirect()->to('/servers')->with('success', 'Server added');
    }

    public function detail($id)
    {
        $model = new ServerModel();
        $historyModel = new \App\Models\AuditHistoryModel();
        
        $data = [
            'server'     => $model->find($id),
            'lastAudit'  => $historyModel->where('server_id', $id)
                                         ->orderBy('upload_date', 'DESC')
                                         ->first(),
            'title'      => 'Server Details'
        ];
        
        // Load full JSON data if available
        if ($data['lastAudit'] && file_exists(WRITEPATH . $data['lastAudit']['raw_json_path'])) {
            $jsonContent = file_get_contents(WRITEPATH . $data['lastAudit']['raw_json_path']);
            $data['fullAuditData'] = json_decode($jsonContent, true);
        } else {
            $data['fullAuditData'] = null;
        }
        
        return view('server/detail', $data);
    }

    public function edit($id)
    {
        $model = new ServerModel();
        $historyModel = new \App\Models\AuditHistoryModel();
        
        $data = [
            'server'     => $model->find($id),
            'lastAudit'  => $historyModel->where('server_id', $id)
                                         ->orderBy('upload_date', 'DESC')
                                         ->first(),
            'title'      => 'Edit Server'
        ];
        return view('server/edit', $data);
    }

    public function update($id)
    {
        $model = new ServerModel();
        $data = [
            'hostname'   => $this->request->getPost('hostname'),
            'ip_address' => $this->request->getPost('ip_address'),
            'status'     => $this->request->getPost('status'),
        ];
        $model->update($id, $data);
        return redirect()->to('/servers')->with('success', 'Server updated');
    }

    public function delete($id)
    {
        $model = new ServerModel();
        $model->delete($id);
        return redirect()->to('/servers')->with('success', 'Server deleted');
    }
}
