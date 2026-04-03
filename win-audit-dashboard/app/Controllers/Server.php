<?php

namespace App\Controllers;

use App\Models\ServerModel;

class Server extends BaseController
{
    public function index()
    {
        $model = new ServerModel();
        $data = [
            'servers' => $model->findAll(),
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

    public function edit($id)
    {
        $model = new ServerModel();
        $data = [
            'server' => $model->find($id),
            'title'  => 'Edit Server'
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
