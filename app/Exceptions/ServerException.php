<?php

namespace App\Exceptions;

use App\Constants\ResponseMessage;
use App\Helpers\ResponseHelper;
use Exception;

class ServerException extends Exception
{
    public function __construct($message = ResponseMessage::SERVER_ERROR)
    {
        parent::__construct($message);
    }
    /**
     * Render the exception as an HTTP response.
     */
    public function render()
    {
        return ResponseHelper::response(500, $this->getMessage());
    }
}
