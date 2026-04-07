<?php

namespace App\Controllers;

use App\Models\ProjectModel;

class Projects extends BaseController
{
    public function index()
    {
        $model = new ProjectModel();
        $data = [
            'projects' => $model->findAll(),
            'title'    => 'Manage Applications'
        ];
        return view('projects/index', $data);
    }

    public function add()
    {
        return view('projects/add', ['title' => 'Add Application']);
    }

    public function save()
    {
        $model = new ProjectModel();
        $model->save($this->request->getPost());
        return redirect()->to('/projects')->with('success', 'Application added successfully');
    }

    public function delete($id)
    {
        $model = new ProjectModel();
        $model->delete($id);
        return redirect()->to('/projects')->with('success', 'Application deleted');
    }
}
