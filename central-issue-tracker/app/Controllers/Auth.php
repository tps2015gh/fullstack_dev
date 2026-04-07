<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function login()
    {
        $model = new UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $sessionData = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'isLoggedIn' => true,
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard');
            } else {
                session()->setFlashdata('error', 'Wrong Password');
                return redirect()->to('/auth');
            }
        } else {
            session()->setFlashdata('error', 'Username not found');
            return redirect()->to('/auth');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}
