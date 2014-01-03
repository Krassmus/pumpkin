<?php

require 'vendor/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

require_once 'lib/classes/Hooks.class.php';

//load and initialize plugins
$registered_plugins = array('Testroutes');
$GLOBALS['plugins'] = array();
foreach ($registered_plugins as $plugin) {
    $pluginpath = 'lib/plugins/'.$plugin."/".$plugin.".plugin.php";
    if (file_exists($pluginpath)) {
        include_once $pluginpath;
    } else {
        trigger_error("Could not locate and include registered plugin ".$plugin, "E_USER_WARNING");
    }
    if (class_exists($plugin)) {
        $GLOBALS['plugins'][] = new $plugin();
    }
}

$GLOBALS['app'] = new \Slim\Slim();
Hooks::trigger("init_routes", "null", array('app' => $GLOBALS['app']));
