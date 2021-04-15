<?php
class App
{
    private function initRoutes()
    {
        require_once './app/routes/Routes.php';
    }
    public function run()
    {
        $this->initRoutes();
    }

}