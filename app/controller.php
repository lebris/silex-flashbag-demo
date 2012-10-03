<?php

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

$app->match('/', function () use ($app) {
    $app['session']->getFlashBag()->add(
            'info',
            array(
                'title'   => 'Hello world',
                'message' => 'Here is an example for a info alert.',
            )
    );
    return $app['twig']->render('home/index.html.twig');
});

$app->match('/zob', function () use ($app) {
$app['session']->getFlashBag()->add('info', 'Your changes were saved!');
$app['session']->getFlashBag()->add('info', 'You should take a break.');
return $app['twig']->render('home/index.html.twig');
});

$app->match('/multi', function () use ($app) {
    $number = 1;
    
    $form = $app['form.factory']->createBuilder('form')
        ->add('number', 'integer', array(
            'label'       => 'Number of alert to display',
            'constraints' => array(
                new Assert\NotBlank(),
                new Assert\Min(1),
            ),
        ))
        ->add('type', 'choice', array(
            'label'      => 'Type',
            'empty_value' => '',
            'choices'    => array(
                'error'   => 'Error',
                'warning' => 'Warning',
                'info'    => 'Info',
                'success' => 'Success',
            ),
            'multiple'  => false,
        ))
        ->getForm();
        
    if ('POST' === $app['request']->getMethod()) {
        $form->bindRequest($app['request']);
        
        if ($form->isValid()) {
            $number = $form->get('number')->getData();            
            $type   = $form->get('type')->getData();            
        }
        
    }
    
    if ($number == 1) {
        $app['session']->getFlashBag()->add(
            'error',
            array(
                'title'   => 'Error : This is a example.',
                'message' => 'Change the number of errors you want to display.',
            )
        );
    } else {
        for ($i =1; $i <= $number; $i++) {
            $app['session']->getFlashBag()->add(
                    empty($type) ? 'error' : $type,
                    array(
                        'title'   => 'Error #'.$i.' : This is a example.',
                        'message' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rutrum leo nec sem elementum in tincidunt dui placerat.',
                    )
            );
        }

    }
    
    return $app['twig']->render('multi/index.html.twig', array(
        'form' => $form->createView()
    ));
});