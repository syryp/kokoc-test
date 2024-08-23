<?php

namespace App\Exceptions;

use App\Exceptions\ApiException;

class InternalErrorException extends ApiException
{
    public const EXCEPTION_NAME = 'internal_error_exception';
    public const EXCEPTION_CODE = 500;
}
