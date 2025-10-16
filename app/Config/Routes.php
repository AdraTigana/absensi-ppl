<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//login
$routes->get('/', 'AuthController::index');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

//absensi
$routes->group('absensi', ['filter' => 'auth'], function ($routes) {
    $routes->post('checkin', 'AbsensiController::checkIn');
    $routes->post('checkout', 'AbsensiController::checkOut');
    $routes->get('status', 'AbsensiController::getStatus'); // NEW
});

$routes->group('mahasiswa', ['filter' => 'role:mahasiswa'], function ($routes) {
    $routes->get('dashboard', 'DashboardController::index');
    $routes->post('checkin', 'AbsenController::checkIn');
    $routes->post('checkout', 'AbsenController::checkOut');
    $routes->get('riwayat', 'AbsenController::riwayatMahasiswa');
});

// Guru
$routes->group('guru', ['filter' => 'role:guru'], function ($routes) {
    $routes->get('dashboard', 'GuruController::index');
    $routes->get('riwayat', 'AbsenController::riwayatSemua');
});

// Admin
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::index');
    $routes->post('create', 'AdminController::create');
    $routes->post('update', 'AdminController::update');
    $routes->post('delete', 'AdminController::delete');
});
