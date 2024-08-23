<?php

namespace App\Http\Presenters;

class DataResultPresenter extends AbstractPresenter
{
    protected function resolve()
    {
        return [
            'error' => false,
            'content' => $this->resource,
        ];
    }
}
