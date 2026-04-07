<?php

namespace App\Controllers;

use App\Models\AuditHistoryModel;

class History extends BaseController
{
    public function index()
    {
        $model = new AuditHistoryModel();
        $data = [
            'history' => $model->select('audit_history.*, servers.hostname')
                               ->join('servers', 'servers.id = audit_history.server_id')
                               ->orderBy('upload_date', 'DESC')
                               ->findAll(),
            'title' => 'Audit History'
        ];
        return view('history/index', $data);
    }

    public function delete($id)
    {
        $model = new AuditHistoryModel();
        $entry = $model->find($id);
        if ($entry) {
            if (file_exists(WRITEPATH . $entry['raw_json_path'])) {
                unlink(WRITEPATH . $entry['raw_json_path']);
            }
            $model->delete($id);
        }
        return redirect()->to('/history')->with('success', 'History entry deleted');
    }
}
