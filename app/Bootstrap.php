<?php
    namespace Myblog2;

    use Whoops\Run;
    use Whoops\Handler\PrettyPageHandler;
    use FastRoute\RouteCollector;
    use FastRoute\Dispatcher;

    require __DIR__ . '/../vendor/autoload.php';

    error_reporting(E_ALL);

    $environment = 'development';

    /**
     * Ragister the error handler
    */
    $whoops = new Run;

    if ($environment !== 'production') {
        $whoops->pushHandler(new PrettyPageHandler);
    } else {
        $whoops->pushHandler(function($e) {
            echo 'Todo: Friendly error page and send an email to the developer';
        });
    }

    $whoops->register();

    $injector = include('Dependencies.php');

    $request = $injector->make('Http\HttpRequest');
    $response = $injector->make('Http\HttpResponse');

    $routeDefinitionCallback = function(RouteCollector $r) {
        $routes = include('Routes.php');

        foreach ($routes as $route) {
            $r->addRoute($route[0], $route[1], $route[2]);
        }
    };

    $dispatcher = \FastRoute\simpleDispatcher($routeDefinitionCallback);

    $routeInfo = $dispatcher->dispatch(
        $request->getMethod(), 
        $request->getPath()
    );

    switch ($routeInfo[0]) {
        case Dispatcher::NOT_FOUND:
            $response->setContent('404 - Page not found!');
            $response->setStatusCode(404);
            break;
        case Dispatcher::METHOD_NOT_ALLOWED:
            $response->setContent('405 - Method not allowed!');
            $response->setStatusCode(405);
            break;
        case Dispatcher::FOUND:
            $className = $routeInfo[1][0];
            $method = $routeInfo[1][1];
            $vars = $routeInfo[2];

            $class = $injector->make($className);
            $class->$method($vars);
            break;
    }

    echo $response->getContent();