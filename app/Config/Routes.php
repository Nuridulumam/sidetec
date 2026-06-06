<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], static function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::attemptLogin', ['filter' => 'csrf']);
    $routes->get('logout', 'AuthController::logout');
});

$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'adminauth'], static function ($routes) {
    $routes->get('/', 'AdminController::dashboard');
    $routes->get('pasien', 'AdminController::pasien');
    $routes->get('pasien/create', 'AdminController::pasienCreate');
    $routes->post('pasien/store', 'AdminController::pasienStore', ['filter' => 'csrf']);
    $routes->get('pasien/(:num)/edit', 'AdminController::pasienEdit/$1');
    $routes->post('pasien/(:num)/update', 'AdminController::pasienUpdate/$1', ['filter' => 'csrf']);
    $routes->post('pasien/(:num)/delete', 'AdminController::pasienDelete/$1', ['filter' => 'csrf']);
    $routes->get('pasien/(:num)', 'AdminController::pasienShow/$1');
    $routes->get('rule-klasifikasi', 'AdminController::ruleKlasifikasi');
    $routes->get('rule-klasifikasi/create', 'AdminController::ruleKlasifikasiCreate');
    $routes->post('rule-klasifikasi/store', 'AdminController::ruleKlasifikasiStore', ['filter' => 'csrf']);
    $routes->get('rule-klasifikasi/(:num)/edit', 'AdminController::ruleKlasifikasiEdit/$1');
    $routes->post('rule-klasifikasi/(:num)/update', 'AdminController::ruleKlasifikasiUpdate/$1', ['filter' => 'csrf']);
    $routes->post('rule-klasifikasi/(:num)/delete', 'AdminController::ruleKlasifikasiDelete/$1', ['filter' => 'csrf']);
    $routes->get('rule-klasifikasi/(:num)', 'AdminController::ruleKlasifikasiShow/$1');
    $routes->get('laporan', 'AdminController::laporan');
    $routes->get('laporan/export', 'AdminController::laporanExport');

    $routes->get('users/create', 'AdminController::usersCreate');
    $routes->post('users/store', 'AdminController::usersStore', ['filter' => 'csrf']);
    $routes->get('users/(:num)/edit', 'AdminController::usersEdit/$1');
    $routes->post('users/(:num)/update', 'AdminController::usersUpdate/$1', ['filter' => 'csrf']);
    $routes->post('users/(:num)/delete', 'AdminController::usersDelete/$1', ['filter' => 'csrf']);
    $routes->get('users/(:num)', 'AdminController::usersShow/$1');
    $routes->get('users', 'AdminController::users');
});
