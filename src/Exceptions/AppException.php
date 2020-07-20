<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    /**
     * AppException constructor.
     *
     * @param string $message
     */
    public function __construct($message = "")
    {
        $message = "\e[31m" . $message . "\e[0m";

        parent::__construct($message);
    }
}