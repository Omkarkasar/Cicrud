<?php

use App\Controllers\StudentController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/',[StudentController::class,'index']);
$routes->post('/storestudent',[StudentController::class,'storestudent']);
$routes->get('/editstudent/(:num)',[StudentController::class,'editstudent']);

$routes->post('/updatestudent/(:num)',[StudentController::class,'updatestudent']);
$routes->post('/deletestudent/(:num)',[StudentController::class,'deletestudent']);