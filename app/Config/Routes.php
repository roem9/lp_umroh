<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);  // Pastikan auto-routing diaktifkan
$routes->post('/registrasi/save', 'Registrasi::save');
// $routes->get('/setordata/agent', 'Registrasi::agent');
// $routes->get('/setordata/agent/(.*)', 'Registrasi::agent/$1');
$routes->get('/setordata/(.*)/(.*)', 'Registrasi::registrasi/$1/$2');
$routes->get('/daerah/getKota', 'Daerah::getKota');
$routes->get('/daerah/getProvinsi', 'Daerah::getProvinsi');
$routes->get('/daerah/getDaerah', 'Daerah::getDaerah');
$routes->get('/daerah/search', 'Daerah::search');
$routes->get('/(.*)', 'Home::landing_page/$1');