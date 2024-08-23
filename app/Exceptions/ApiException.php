<?php

namespace App\Exceptions;

use App\Http\Presenters\ApiExceptionPresenter;

abstract class ApiException extends AbstractException
{
    protected $presenter = ApiExceptionPresenter::class;

    public function render()
    {
        return (new $this->presenter([
            'name' => static::EXCEPTION_NAME,
            'http_code' => $this->code ?: static::EXCEPTION_CODE,
            'bag' => $this->data,
        ]));
    }
}
