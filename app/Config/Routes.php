<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('deteksi-dini', 'Home::deteksiDini');
$routes->post('deteksi-dini', 'Home::prosesDeteksiDini', ['filter' => 'csrf']);
$routes->get('deteksi-dini/hasil/(:any)', 'Home::deteksiDiniHasil/$1');


$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin', ['filter' => 'csrf']);
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminauth'], static function ($routes) {
    $routes->get('/', 'DashboardController::dashboard');
    $routes->get('pasien', 'PasienController::pasien');
    $routes->get('pasien/create', 'PasienController::pasienCreate');
    $routes->post('pasien/store', 'PasienController::pasienStore', ['filter' => 'csrf']);
    $routes->get('pasien/(:any)/edit', 'PasienController::pasienEdit/$1');
    $routes->post('pasien/(:any)/update', 'PasienController::pasienUpdate/$1', ['filter' => 'csrf']);
    $routes->post('pasien/(:any)/delete', 'PasienController::pasienDelete/$1', ['filter' => 'csrf']);
    $routes->get('pasien/(:any)', 'PasienController::pasienShow/$1');
    $routes->get('laporan/pasien/(:any)', 'PasienController::pasienShow/$1');
    
    $routes->get('gejala/create', 'PasienController::gejalaCreate');
    $routes->post('gejala/store', 'PasienController::gejalaStore', ['filter' => 'csrf']);
    $routes->post('gejala/(:any)/delete', 'PasienController::gejalaDelete/$1', ['filter' => 'csrf']);
    $routes->get('rule-klasifikasi', 'RuleKlasifikasiController::ruleKlasifikasi');
    $routes->get('rule-klasifikasi/create', 'RuleKlasifikasiController::ruleKlasifikasiCreate');
    $routes->post('rule-klasifikasi/store', 'RuleKlasifikasiController::ruleKlasifikasiStore', ['filter' => 'csrf']);
    $routes->get('rule-klasifikasi/(:any)/edit', 'RuleKlasifikasiController::ruleKlasifikasiEdit/$1');
    $routes->post('rule-klasifikasi/(:any)/update', 'RuleKlasifikasiController::ruleKlasifikasiUpdate/$1', ['filter' => 'csrf']);
    $routes->post('rule-klasifikasi/(:any)/delete', 'RuleKlasifikasiController::ruleKlasifikasiDelete/$1', ['filter' => 'csrf']);
    $routes->get('rule-klasifikasi/(:any)', 'RuleKlasifikasiController::ruleKlasifikasiShow/$1');
    $routes->get('laporan', 'LaporanController::laporan');
    $routes->get('laporan/export', 'LaporanController::laporanExport');

    $routes->get('users/create', 'UserController::usersCreate');
    $routes->post('users/store', 'UserController::usersStore', ['filter' => 'csrf']);
    $routes->get('users/(:num)/edit', 'UserController::usersEdit/$1');
    $routes->post('users/(:num)/update', 'UserController::usersUpdate/$1', ['filter' => 'csrf']);
    $routes->post('users/(:num)/delete', 'UserController::usersDelete/$1', ['filter' => 'csrf']);
    $routes->get('users/(:num)', 'UserController::usersShow/$1');
    $routes->get('users', 'UserController::users');
});
