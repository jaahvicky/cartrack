<?php
class URI
{

    public static function hasResource($file)
    {
        $controller = CONTROLLER_PATH . ucwords($file) . "Controller.php";
        if (file_exists($controller)) {
            require true;
        } else {
            return false;
        }
    }

}
