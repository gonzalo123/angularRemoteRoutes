<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
$app          = new Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), [
        'twig.path'    =>  __DIR__.'/../../views',
        'twig.options' => [
            'cache'       => __DIR__ . '/../../cache',
            'auto_reload' => true
        ]
    ]);

$app->before(function() use ($app){
    $app['twig']->setLexer( new Twig_Lexer($app['twig'], [
            'tag_comment'   => ['[#', '#]'],
            'tag_block'     => ['[%', '%]'],
            'tag_variable'  => ['[[', ']]'],
            'interpolation' => ['#[', ']'],
        ]));
    });

$app->get('/pages/{name}', function($name) use ($app){
    return $app['twig']->render('hello.html.twig', ['name' => $name]);
});

$app->get('/pages/js/{name}', function($name) use ($app){
        $response = new Response($app['twig']->render('hello.js', ['name' => $name]));
        $response->headers->set("Content-Type", 'application/javascript');

        return $response;
    });

$app->run();