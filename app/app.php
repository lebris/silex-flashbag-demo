<?php

use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Silex\Application();

$app->register(new SessionServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());

$app->register(new TranslationServiceProvider(), array(
    'locale'          => $app['locale'],
));
$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());

    $translator->addResource('yaml', __DIR__.'/locale/fr.yml', 'fr');

    return $translator;
}));

$app->register(new TwigServiceProvider(), array(
    'twig.options'          => array('cache' => false, 'strict_variables' => true),
    'twig.form.templates'   => array('form_div_layout.html.twig', 'common/form_div_layout.html.twig'),
    'twig.path'             => array(__DIR__ . '/views')
));


return $app;
