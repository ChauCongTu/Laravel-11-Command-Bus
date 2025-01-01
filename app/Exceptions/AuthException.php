<?php

namespace App\Exceptions;

use App\Constants\ResponseMessage;
use App\Helpers\ResponseHelper;
use Exception;

class AuthException extends Exception
{
    public function __construct($message = ResponseMessage::UNAUTHORIZED)
    {
        parent::__construct($message);
    }
    /**
     * Render the exception as an HTTP response.
     */
    public function render()
    {
        return ResponseHelper::response(401, $this->getMessage());
    }
}
