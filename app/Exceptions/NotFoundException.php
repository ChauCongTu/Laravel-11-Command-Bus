<?php

namespace App\Exceptions;

use App\Constants\ResponseMessage;
use App\Helpers\ResponseHelper;
use Exception;

class NotFoundException extends Exception
{
    public function __construct($message = ResponseMessage::NOT_FOUND)
    {
        parent::__construct($message);
    }
    /**
     * Render the exception as an HTTP response.
     */
    public function render()
    {
        return ResponseHelper::response(404, $this->getMessage());
    }
}
