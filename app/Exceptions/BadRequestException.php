<?php

namespace App\Exceptions;

use App\Constants\ResponseMessage;
use App\Helpers\ResponseHelper;
use Exception;

class BadRequestException extends Exception
{
    public function __construct($message = ResponseMessage::FAIL)
    {
        parent::__construct($message);
    }
    /**
     * Render the exception as an HTTP response.
     */
    public function render()
    {
        return ResponseHelper::response(400, $this->getMessage());
    }
}
