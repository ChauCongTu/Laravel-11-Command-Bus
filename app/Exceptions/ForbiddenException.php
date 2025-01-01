<?php

namespace App\Exceptions;

use App\Constants\ResponseMessage;
use App\Helpers\ResponseHelper;
use Exception;

class ForbiddenException extends Exception
{
    public function __construct($message = ResponseMessage::FORBIDDEN)
    {
        parent::__construct($message);
    }
    /**
     * Render the exception as an HTTP response.
     */
    public function render()
    {
        return ResponseHelper::response(403, $this->getMessage());
    }
}
