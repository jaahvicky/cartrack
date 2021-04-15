<?php
class Response
{
    public static function setStatus($code)
    {
        header('Content-Type: application/json');
        http_response_code($code);

    }
    public static function sendJson($data = array(), $status = 200)
    {
        Response::setStatus($status);
        echo json_encode($data);
    }
}
