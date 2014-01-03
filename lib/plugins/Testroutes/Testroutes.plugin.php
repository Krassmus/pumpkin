<?php

class Testroutes {
    
    static public function getTestRoutes($paramater) {
        $paramater['app']->get('/api/user/:username/feed', function ($username) {
            $feed_example = array();
            echo json_encode($feed_example);
        });
        $paramater['app']->post('/api/user/:username/feed', function ($username) {
            //write a posting as the user in the user's stream
        });
    }
    
    public function __construct() {
        Hooks::bind("init_routes", "Testroutes::getTestRoutes");
    }
}