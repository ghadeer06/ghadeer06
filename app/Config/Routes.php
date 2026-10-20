<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// تسجيل الدخول
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');

// صفحات الموظف (وحسابي لكل الأدوار)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/tickets', 'Tickets::index');
    $routes->get('/tickets/create', 'Tickets::create');
    $routes->post('/tickets/store', 'Tickets::store');
    $routes->get('/tickets/show/(:num)', 'Tickets::show/$1');
    $routes->post('/tickets/reply/(:num)', 'Tickets::reply/$1');
    $routes->get('/tickets/edit/(:num)', 'Tickets::edit/$1');
    $routes->post('/tickets/resubmit/(:num)', 'Tickets::resubmit/$1');

    $routes->get('/profile', 'Profile::index');
    $routes->post('/profile/update-password', 'Profile::updatePassword');
});

// صفحات المدقق
$routes->group('reviewer', ['filter' => 'reviewer'], function($routes) {
    $routes->get('tickets', 'Reviewer::index');
    $routes->get('tickets/export', 'Reviewer::export');
    $routes->post('tickets/decide/(:num)', 'Reviewer::decide/$1');
});

// صفحات التقني
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('tickets', 'Admin::index');
    $routes->get('tickets/export', 'Admin::export');
    $routes->get('tickets/show/(:num)', 'Admin::show/$1');
    $routes->post('tickets/reply/(:num)', 'Admin::reply/$1');
    $routes->get('tickets/delete/(:num)', 'Admin::delete/$1');

    $routes->get('users', 'Users::index');
    $routes->get('users/create', 'Users::create');
    $routes->post('users/store', 'Users::store');
    $routes->get('users/delete/(:num)', 'Users::delete/$1');
});