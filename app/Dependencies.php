<?php
    $injector = new Auryn\Injector;

    $injector->alias('Http\Request', 'Http\HttpRequest');
    $injector->share('Http\HttpRequest');
    $injector->define('Http\HttpRequest', [
        ':get' => $_GET,
        ':post' => $_POST,
        ':cookies' => $_COOKIE,
        ':files' => $_FILES,
        ':server' => $_SERVER
    ]);

    $injector->alias('Http\Response', 'Http\HttpResponse');
    $injector->share('Http\HttpResponse');

    $injector->alias('Myblog2\Template\Renderer', 'Myblog2\Template\MustacheRenderer');
    $injector->define('Mustache_Engine', [
        ':options' => [
            'loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/view/templates', [
                'extension' => '.html'
            ])
        ]
    ]);

    $injector->alias('Myblog2\Page\PageReader', 'Myblog2\Page\FilePageReader');
    $injector->share('Myblog2\Page\FilePageReader');
    $injector->define('Myblog2\Page\FilePageReader', [
        ':pageFolder' => __DIR__ . '/../pages'
    ]);

    return $injector;