<?php

class Request
{

    public static function put()
    {
        parse_str(file_get_contents("php://input"), $putRequest);
        return $putRequest;
    }

}