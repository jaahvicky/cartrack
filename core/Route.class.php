<?php
class Route
{
    public function isRouteValid()
    {
        global $Routes;
        // $uri = $_SERVER['REQUEST_URI'];
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);

        if (empty($url[0])) {
            return true;
        }

        if (isset($url[2])) {
            $hasRoute = strpos($Routes[0], $url[1]);
            if ($hasRoute === false) {
                return false;
            }
        } else if (isset($url[1])) {
            $hasRoute = strpos($Routes[0], $url[1]);

            if ($hasRoute === false && URI::hasResource($url[1]) === false) {
                return false;
            }
        } else {
            $hasRoute = strpos($Routes[0], $url[0]);
            if ($hasRoute && URI::hasResource($url[0])) {
                return true;
            }
            return false;

        }
        return true;
    }

    // Insert the route into the $Routes array.
    private static function registerRoute($route)
    {

        global $Routes;

        if (!in_array((BASEDIR . $route), $Routes)) {
            $Routes[] = BASEDIR . $route;
        }

    }

    // This method creates dynamic routes.
    public static function dyn($dyn_routes)
    {
        // Split the route on '/', i.e api/<1>
        $route_components = explode('/', $dyn_routes);
        // Split the URI on '/', i.e api/vehicle
        $uri_components = explode('/', substr($_SERVER['REQUEST_URI'], strlen(BASEDIR) - 1));
        // Loop through $route_components, this allows infinite dynamic parameters in the future.
        for ($i = 0; $i < count($route_components); $i++) {
            // Ensure we don't go out of range by enclosing in an if statement.
            if ($i + 1 <= count($uri_components) - 1) {
                // Replace every occurrence of <n> with a parameter.
                $route_components[$i] = str_replace("<$i>", $uri_components[$i + 1], $route_components[$i]);
            }
        }

        // Join the array back into a string.
        $route = implode($route_components, '/');
        // Return the route.
        return $route;
    }

    // Register the route and run the closure using __invoke().
    public static function set($route, $closure)
    {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $hasChildRoute = isset(explode('/', $url)[2]) ? true : false;

        if ($_SERVER['REQUEST_URI'] == BASEDIR . $route) {
            self::registerRoute($route);
            $closure->__invoke();
        } else if (explode('?', $_SERVER['REQUEST_URI'])[0] == BASEDIR . $route) {
            self::registerRoute($route);
            $closure->__invoke();
        } else if ($url == explode('/', $route)[0]) {
            self::registerRoute(self::dyn($route));
            $closure->__invoke();
        } else if ($hasChildRoute) {
            self::registerRoute($url);
            $closure->__invoke();
        } else {
            if (explode('/', $route)[0] === $url) {
                self::registerRoute($url);
                $closure->__invoke();
            }
        }
    }
}