<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected UserModel $users;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->users = model(UserModel::class);
        helper(['url', 'form']);
    }

    public function login()
    {
        if (session()->get('admin_id')) {
            return redirect()->to(site_url('admin'));
        }

        return view('admin/login');
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->users->findActiveByEmail($email ?? '');
        if ($user === null || ! password_verify((string) $password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau kata sandi salah.');
        }

        session()->set([
            'admin_id'    => $user['id'],
            'admin_name'  => $user['full_name'],
            'admin_email' => $user['email'],
            'admin_role'  => $user['role'],
        ]);

        return redirect()->to(site_url('admin'));
    }

    public function logout()
    {
        session()->remove(['admin_id', 'admin_name', 'admin_email', 'admin_role']);

        return redirect()->to(site_url('admin/login'))->with('message', 'Anda telah keluar.');
    }
}
