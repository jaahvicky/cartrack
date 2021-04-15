<?php

$Routes = array();
define('BASEDIR', '/custom_mvc/');
define("DS", DIRECTORY_SEPARATOR);

define("ROOT", getcwd() . DS);

define("APP_PATH", ROOT . 'app' . DS);

define("CORE_PATH", ROOT . "core" . DS);

define("PUBLIC_PATH", ROOT . "public" . DS);

define("CONFIG_PATH", APP_PATH . "config" . DS);

define("CONTROLLER_PATH", APP_PATH . "controllers" . DS);

define("ROUTE_PATH", APP_PATH . "routes" . DS);

define("MODEL_PATH", APP_PATH . "models" . DS);

$GLOBALS['config'] = include CONFIG_PATH . "config.php";

// Start session
session_start();