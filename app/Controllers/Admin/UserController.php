<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class UserController extends BaseController
{
    /** Nilai role yang diizinkan (harus selaras dengan dropdown di users_form). */
    protected string $userRoleRule = 'required|regex_match[#^(admin|operator|superadmin|petugas poli|petugas sik)$#u]';

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['url', 'form']);
    }

    public function users()
    {
        $rows = db_connect()->table('users')
            ->select('id, email, full_name, role, is_active, created_at, updated_at')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/layout', [
            'title'    => 'Kelola Pengguna',
            'active'   => 'users',
            'mainView' => view('admin/pages/users', ['rows' => $rows]),
        ]);
    }

    public function usersCreate()
    {
        return view('admin/layout', [
            'title'    => 'Tambah Pengguna',
            'active'   => 'users',
            'mainView' => view('admin/pages/users_form', ['record' => null]),
        ]);
    }

    public function usersStore()
    {
        $rules = [
            'email'     => 'required|valid_email|max_length[191]|is_unique[users.email]',
            'password'  => 'required|min_length[8]',
            'full_name' => 'required|min_length[3]|max_length[150]',
            'role'      => $this->userRoleRule,
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(UserModel::class)->insert([
            'email'           => $this->request->getPost('email'),
            'password_hash'   => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name'       => $this->request->getPost('full_name'),
            'role'            => $this->request->getPost('role'),
            'is_active'       => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ]);

        return redirect()->to(site_url('admin/users'))->with('message', 'Pengguna berhasil ditambahkan.');
    }

    public function usersShow(string $id)
    {
        $user = db_connect()->table('users')
            ->select('id, email, full_name, role, is_active, created_at, updated_at')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/layout', [
            'title'    => 'Detail Pengguna',
            'active'   => 'users',
            'mainView' => view('admin/pages/users_detail', ['user' => $user]),
        ]);
    }

    public function usersEdit(string $id)
    {
        $user = db_connect()->table('users')
            ->select('id, email, full_name, role, is_active')
            ->where('id', (int) $id)
            ->get()
            ->getRowArray();

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('admin/layout', [
            'title'    => 'Edit Pengguna',
            'active'   => 'users',
            'mainView' => view('admin/pages/users_form', ['record' => $user]),
        ]);
    }

    public function usersUpdate(string $id)
    {
        $userId = (int) $id;

        $existing = model(UserModel::class)->find($userId);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'email'     => "required|valid_email|max_length[191]|is_unique[users.email,id,{$userId}]",
            'password'  => 'permit_empty|min_length[8]',
            'full_name' => 'required|min_length[3]|max_length[150]',
            'role'      => $this->userRoleRule,
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'email'     => $this->request->getPost('email'),
            'full_name' => $this->request->getPost('full_name'),
            'role'      => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active') === '1' ? 1 : 0,
        ];

        $pwd = $this->request->getPost('password');
        if ($pwd !== null && $pwd !== '') {
            $data['password_hash'] = password_hash((string) $pwd, PASSWORD_DEFAULT);
        }

        model(UserModel::class)->update($userId, $data);

        return redirect()->to(site_url('admin/users'))->with('message', 'Pengguna berhasil diperbarui.');
    }

    public function usersDelete(string $id)
    {
        $userId = (int) $id;

        if ($userId === (int) session()->get('admin_id')) {
            return redirect()->to(site_url('admin/users'))->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $existing = model(UserModel::class)->find($userId);
        if ($existing === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        model(UserModel::class)->delete($userId);

        return redirect()->to(site_url('admin/users'))->with('message', 'Pengguna berhasil dihapus.');
    }
}
