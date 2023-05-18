<?php

/**
 * Front controller
 *
 * PHP version 8.2
 */


/**
 * Composer
 */
require '../vendor/autoload.php';


/**
 * Twig
 */
//Twig_Autoloader::register();


/**
 * Autoloader
 */

 spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);   // get the parent directory
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $root . '/' . str_replace('\\', '/', $class) . '.php';
    }
});


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Sessions
 */
session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' =>'activate']);
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->add('home', ['controller' => 'HomeLogin', 'action' => 'index']);
$router->add('expenses/add', ['controller' => 'Expenses', 'action' => 'add']);

$router->add('balancesheet', ['controller' => 'BalanceSheet', 'action' => 'index']);

$router->add('profile/editcategory', ['controller' => 'Profile', 'action' => 'editcategory']);

$router->add('deleteincomescategory', ['controller' => 'Category', 'action' => 'deleteincomescategory']);
$router->add('deleteexpensescategory', ['controller' => 'Category', 'action' => 'deleteexpensescategory']);

$router->add('addincomescategory', ['controller' => 'Category', 'action' => 'addincomescategory'] );
$router->add('addexpensescategory', ['controller' => 'Category', 'action' => 'addexpensescategory'] );

$router->add('deletepaymentmethod', ['controller' => 'Category', 'action' => 'deletepaymentmethod']);

$router->add('addpaymentmethod', ['controller' => 'Category', 'action' => 'addpaymentmethod']);

$router->add('deleteaccount', ['controller' => 'Profile', 'action' => 'deleteaccount']);

$router->dispatch($_SERVER['QUERY_STRING']);
