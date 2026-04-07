<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/dashboard', 'Dashboard::index');

// Projects (Intranet Apps)
$routes->get('/projects', 'Projects::index');
$routes->get('/projects/add', 'Projects::add');
$routes->post('/projects/save', 'Projects::save');
$routes->get('/projects/delete/(:num)', 'Projects::delete/$1');

// Issues (Bugs, Tasks, Plans)
$routes->get('/issues', 'Issues::index');
$routes->get('/issues/add', 'Issues::add');
$routes->post('/issues/save', 'Issues::save');
$routes->get('/issues/status/(:num)/(:any)', 'Issues::updateStatus/$1/$2');
$routes->get('/issues/delete/(:num)', 'Issues::delete/$1');
