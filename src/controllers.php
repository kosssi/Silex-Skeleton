<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/*
 * User
 */

function getUser($app)
{
    $token = $app['security']->getToken();
    if (null !== $token) {
        return $token->getUser();
    }
    return null;
}

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('security/login.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
});

$app->get('/admin/account', function () use ($app) {
    if (null === $user = getUser($app)) {
        return $app->redirect('/login');
    }

    return $app['twig']->render('security/account.twig');
});git branch 

/*
 * Pages static
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
