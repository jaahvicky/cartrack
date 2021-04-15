<?php
class Dispatch
{
    public static function resource($controller, $action = "index")
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;

        $hasChildRoute = isset(explode('/', $url)[2]) ? true : false;
        $controllerStringName = (isset(explode('/', $url)[1]) ? explode('/', $url)[1] : false);
        if (Route::isRouteValid()) {

            $controllerFirstPart = explode('Controller', $controller)[0];
            // Create the view controller.
            if ($hasChildRoute) {

                if (strpos(strtolower($controllerFirstPart), substr($controllerStringName, 0, -1)) !== false) {
                    require_once CONTROLLER_PATH . "$controller.php";
                } else {
                    return Response::sendJson(["message" => 'Invalid route.'], 404);
                }

            } else if ($url === null && strpos(strtolower($controllerFirstPart), 'home') !== false) {
                require_once CONTROLLER_PATH . "$controller.php";
            } else if (strpos(strtolower($controllerFirstPart), substr($controllerStringName, 0, -1)) !== false) {
                require_once CONTROLLER_PATH . "$controller.php";
            } else {
                return Response::sendJson(["message" => 'Invalid route.'], 404);
            }

            $controllerName = $controller;
            $controller = new $controllerName;
            $request = $_POST;
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $controller->store($request);
                    break;
                case 'PUT':
                    if ($hasChildRoute) {
                        $controller->update(explode('/', $url)[2], Request::put());
                    } else {
                        return Response::sendJson(["message" => 'Invalid route.'], 404);
                    }
                    break;
                case "DELETE":
                    if ($hasChildRoute) {
                        $controller->destroy(explode('/', $url)[2]);
                    } else {
                        return Response::sendJson(["message" => 'Invalid route.'], 404);
                    }

                    break;
                default:
                    if ($hasChildRoute) {
                        $controller->show(explode('/', $url)[2]);
                    } else {
                        $controller->index();
                    }

                    break;

            }

        } else {
            return Response::sendJson(["message" => 'Invalid route.'], 404);

        }

    }

}