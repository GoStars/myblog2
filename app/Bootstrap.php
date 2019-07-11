<?php
    namespace Myblog2;

    use Whoops\Run;
    use Whoops\Handler\PrettyPageHandler;

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

    throw new \Exception;