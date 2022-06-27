<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->group('admin', function ($routes) {
    $routes->get('/', 'Login::index');
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'authadmin']);
    $routes->get('transaksi-penarikan', 'Penarikan::index_admin', ['filter' => 'authadmin']);
    $routes->get('setor-sampah', 'SetorSampah::index', ['filter' => 'authadmin']);
    $routes->get('sampah', 'Sampah::index', ['filter' => 'authadmin']);
    $routes->get('jenis', 'Jenis::index', ['filter' => 'authadmin']);
    $routes->get('satuan', 'Satuan::index', ['filter' => 'authadmin']);
    $routes->get('profil', 'Profil::index', ['filter' => 'authadmin']);
    $routes->get('user', 'User::index', ['filter' => 'authadmin']);
    $routes->get('logout', 'Dashboard::logout', ['filter' => 'authadmin']);
});

$routes->group('user', function ($routes) {
    $routes->get('/', 'Login::login_user');
    $routes->get('register', 'Login::register_user');
    $routes->get('dashboard', 'Dashboard::index_user', ['filter' => 'authuser']);
    $routes->get('transaksi-setor-sampah', 'SetorSampah::index_user', ['filter' => 'authuser']);
    $routes->get('transaksi-penarikan', 'Penarikan::index_user', ['filter' => 'authuser']);
    $routes->get('profil', 'Profil::index_user', ['filter' => 'authuser']);
    $routes->get('logout', 'Dashboard::logout_user', ['filter' => 'authuser']);
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
