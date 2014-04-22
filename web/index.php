<?php
// The full public path to the application
define('BASE_URL', '/path/to/app');

// The location of the application's directory
define('ROOT_PATH', '../');

require_once ROOT_PATH . 'bootstrap.php';

$router->dispatch($request);