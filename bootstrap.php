<?php
define('APP_ENV', !empty($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'production');
define('APP_PATH', ROOT_PATH . 'src');

require_once __DIR__ . '/vendor/autoload.php';

// Routes to load
$routes = [];

// Sqlite configuration
ORM::configure('sqlite:' . ROOT_PATH . '/database.db');
// MySQL configuration
//ORM::configure('mysql:host=localhost;dbname=database');
//ORM::configure('username', '');
//ORM::configure('password', '');
//ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
ORM::configure('return_result_sets', true);

$router = new \Klein\Klein();
$request = getKleinRequest();

// Start PHP's session
$router->service()->startSession();

/**
 * A fix for Klein's handling (or lack thereof) of non-webroot deployments
 */
function getKleinRequest() {
    // Grab the server-passed "REQUEST_URI"
    $request = \Klein\Request::createFromGlobals();
    $uri = $request->server()->get('REQUEST_URI');

    // Set the request URI to a modified one (without the "subdirectory") in it
    $request->server()->set('REQUEST_URI', substr($uri, strlen(BASE_URL)));

    return $request;
}

$router->respond(function ($request, $response, $service, $app) use ($router) {
    // Hook up twig
    $app->register('twig', function() {
        $loader = new Twig_Loader_Filesystem(APP_PATH . '/templates/');
        $twig = new Twig_Environment($loader, [
            'cache' => ROOT_PATH . '/cache/',
        ]);

        // Enable some helpful things for development
        if (APP_ENV === 'development') {
            $twig->enableDebug();
            $twig->enableAutoReload();
            $twig->addExtension(new Twig_Extension_Debug());
        }

        return $twig;
    });

    // A fixed redirect method
    // Removing the full path from the request uri to make routing work
    // will of course has the side effect of incorrect redirects.
    // TODO: Maybe submit a patch for better handling of this in Klein.
    $app->redirect = function($url, $code = 302) {
        return $router->response()->redirect(BASE_URL . $url, $code);
    };
});

// Load the routes
foreach ($routes as $route) {
    require_once APP_PATH . '/routes/' . $route . '.php';
}

// Show an error template on any HTTP error
$router->onHttpError(function ($code, $router) {
    $uri = $router->request()->uri();
    $response = $router->app()->twig->render('error.html.twig', [
        'title' => $code,
        'message' => "An HTTP $code error occurred for URI $uri"
    ]);

    $router->response()->body($response);
});