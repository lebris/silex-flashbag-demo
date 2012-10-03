<?php

$app['locale'] = 'en';

// Upload directory
$app['upload.webPath'] = 'uploads/';
$app['upload.rootDirectory'] = realpath(__DIR__ . '/../../web/uploads');
