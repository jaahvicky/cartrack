<?php

class HomeController extends Controller
{
    public function index()
    {
        return Response::sendJson(["message" => "welcome to Vehicle API"], 200);
    }
}