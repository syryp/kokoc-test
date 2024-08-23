<?php

namespace App\Exceptions;

use App\Http\Presenters\ValidationExceptionPresenter;

class   ValidationException extends ApiException
{
    const EXCEPTION_NAME = 'validation';
    const EXCEPTION_CODE = 400;

    protected $presenter = ValidationExceptionPresenter::class;
}
