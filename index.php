<?php

require_once './app/_Globals.php';

function __autoload($class_name)
{
    if (substr($class_name, -5) === "Model" && $class_name != "Model") {
        require_once MODEL_PATH . "$class_name.php";

    } else {
        require_once './core/' . $class_name . '.class.php';
    }

}

$app = new App();
$app->run();