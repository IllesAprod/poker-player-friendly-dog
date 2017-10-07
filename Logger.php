<?php

/**
 * Created by PhpStorm.
 * User: aprodilles
 * Date: 2017. 10. 07.
 * Time: 13:46
 */
class Logger
{
    public function log($message) {
        file_put_contents("php://stderr", $message);
    }
}