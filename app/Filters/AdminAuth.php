<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('admin_id')) {
            return redirect()->to(site_url('admin/login'));
        }

        $role = session()->get('admin_role');
        $router = service('router');
        $method = $router->methodName();

        // superadmin has full access to everything
        if ($role === 'superadmin') {
            return null;
        }

        // Define permissions maps: allowed methods per role
        $permissions = [
            'petugas poli' => [
                'dashboard',
                'pasien',
                'pasienShow',
                'pasienCreate',
                'pasienStore',
                'pasienEdit',
                'pasienUpdate',
                'pasienDelete',
                'laporan',
                'laporanExport',
            ],
            'petugas sik' => [
                'dashboard',
                'pasien',
                'pasienShow',
                'ruleKlasifikasi',
                'ruleKlasifikasiShow',
                'ruleKlasifikasiCreate',
                'ruleKlasifikasiStore',
                'ruleKlasifikasiEdit',
                'ruleKlasifikasiUpdate',
                'ruleKlasifikasiDelete',
            ],
            'admin' => [
                'dashboard',
                'pasien',
                'pasienShow',
                'ruleKlasifikasi',
                'ruleKlasifikasiShow',
                'laporan',
                'laporanExport',
                'users',
                'usersShow',
                'usersCreate',
                'usersStore',
                'usersEdit',
                'usersUpdate',
                'usersDelete',
            ],
        ];

        $allowed = $permissions[$role] ?? [];

        if (! in_array($method, $allowed, true)) {
            return redirect()->to(site_url('admin'))
                ->with('error', 'Anda tidak memiliki hak akses untuk mengakses halaman tersebut.');
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return null;
    }
}
