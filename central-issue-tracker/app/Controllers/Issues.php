<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\IssueModel;

class Issues extends BaseController
{
    public function index()
    {
        $model = new IssueModel();
        $data = [
            'issues' => $model->getIssuesWithProject(),
            'title'  => 'All Tasks & Issues'
        ];
        return view('issues/index', $data);
    }

    public function add()
    {
        $projectModel = new ProjectModel();
        $data = [
            'projects' => $projectModel->findAll(),
            'title'    => 'Create New Task'
        ];
        return view('issues/add', $data);
    }

    public function save()
    {
        $model = new IssueModel();
        $model->save($this->request->getPost());
        return redirect()->to('/dashboard')->with('success', 'Task created successfully');
    }

    public function updateStatus($id, $status)
    {
        $model = new IssueModel();
        $model->update($id, ['status' => $status]);
        return redirect()->back()->with('success', 'Status updated');
    }

    public function delete($id)
    {
        $model = new IssueModel();
        $model->delete($id);
        return redirect()->back()->with('success', 'Issue removed');
    }
}
