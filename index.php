<?php

require 'vendor/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/api/user/:username/feed', function ($username) {
    $feed_example = array();
    echo json_encode($feed_example);
});
$app->post('/api/user/:username/feed', function ($username) {
    //write a posting as the user in the user's stream
});
$app->run();