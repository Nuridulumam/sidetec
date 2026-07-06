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

        // admin has full access to everything (acts as superadmin)
        if ($role === 'admin') {
            return null;
        }

        // Define permissions maps: allowed methods per role
        $permissions = [
            'perawat' => [
                'dashboard',
                'pasien',
                'pasienShow',
                'pasienCreate',
                'pasienStore',
                'pasienEdit',
                'pasienUpdate',
                'pasienDelete',
            ],
            'petugas' => [
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
                'laporan',
                'laporanExport',
            ]
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
