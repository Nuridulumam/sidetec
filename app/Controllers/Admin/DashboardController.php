<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class DashboardController extends BaseController
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['url', 'form']);
    }

    public function dashboard()
    {
        $db = db_connect();

        $counts = [
            'pasien' => $db->table('pasien')->countAll(),
            'rules'  => $db->table('rule_klasifikasi')->countAll(),
            'laporan'=> $db->table('laporan')->countAll(),
            'users'  => $db->table('users')->countAll(),
        ];

        return view('admin/layout', [
            'title'    => 'Dashboard',
            'active'   => 'dashboard',
            'mainView' => view('admin/pages/dashboard', ['counts' => $counts]),
        ]);
    }
}
