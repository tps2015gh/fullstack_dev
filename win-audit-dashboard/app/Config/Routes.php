<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    
    // Servers
    $routes->get('/servers', 'Server::index');
    $routes->get('/servers/add', 'Server::add');
    $routes->post('/servers/save', 'Server::save');
    $routes->get('/servers/edit/(:num)', 'Server::edit/$1');
    $routes->post('/servers/update/(:num)', 'Server::update/$1');
    $routes->get('/servers/delete/(:num)', 'Server::delete/$1');
    
    // Upload
    $routes->get('/upload', 'Upload::index');
    $routes->post('/upload/process', 'Upload::process');
    
    // History
    $routes->get('/history', 'History::index');
    $routes->get('/history/delete/(:num)', 'History::delete/$1');
    
    // Theme
    $routes->get('/theme/switch/(:any)', 'Dashboard::switchTheme/$1');
});
