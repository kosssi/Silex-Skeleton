<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/*
 * Pages
 */

$pages = array(
    'index'      => array('name' => 'Index')
);

$app['pages'] = $pages;

foreach ($pages as $route => $params) {
    $app->get('/'.$route, function () use ($app, $route) {
        return $app['twig']->render('pages/'.$route . '.twig');
    })->bind($route);
}


/*
 * Default
 */

$app->get('/', function () use ($app) {
    return $app->redirect('/index');
})->bind('homepage');

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    $page = 404 == $code ? '404.twig' : '500.twig';

    return new Response($app['twig']->render('errors/'.$page, array('code' => $code)), $code);
});
