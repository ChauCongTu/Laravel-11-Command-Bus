<?php

namespace App\Constants;

final class ResponseMessage
{
    // General messages
    public const SUCCESS = 'SUCCESS';
    public const FAIL = 'FAIL';

    public const UNAUTHORIZED = 'UNAUTHORIZED';
    public const FORBIDDEN = 'FORBIDDEN';
    public const INVALID_CREDENTIALS = 'INVALID_CREDENTIALS';
    public const TOKEN_EXPIRED = 'TOKEN_EXPIRED';
    public const TOKEN_INVALID = 'TOKEN_INVALID';

    public const VALIDATION_ERROR = 'VALIDATION_ERROR';
    public const INVALID_INPUT = 'INVALID_INPUT';

    public const NOT_FOUND = 'RECORD_NOT_FOUND';
    public const CREATED_SUCCESSFULLY = 'CREATED_SUCCESSFULLY';
    public const UPDATED_SUCCESSFULLY = 'UPDATED_SUCCESSFULLY';
    public const DELETED_SUCCESSFULLY = 'DELETED_SUCCESSFULLY';

    public const SERVER_ERROR = 'SERVER_ERROR';
    public const SERVICE_UNAVAILABLE = 'SERVICE_UNAVAILABLE';

    public const OPERATION_FAILED = 'OPERATION_FAILED';
    public const OPERATION_SUCCESSFUL = 'OPERATION_SUCCESSFUL';
}
