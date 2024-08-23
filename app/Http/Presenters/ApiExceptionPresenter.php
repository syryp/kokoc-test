<?php


namespace App\Http\Presenters;

class ApiExceptionPresenter extends AbstractPresenter
{
    protected function resolve()
    {
        $errorBag = [];
        $errorMessage = '';
        $resourceErrorBag = $this->resource['bag'];

        if (is_string($resourceErrorBag)) {
            $errorMessage = $resourceErrorBag;
        }
        else {
            $errorMessage = trans('exceptions.' . $this->resource['name']);
        }

        if (is_array($resourceErrorBag)) {
            foreach ($resourceErrorBag as $errorMessage) {
                $errorBag[] = [
                    'messages' => [
                        $errorMessage,
                    ],
                ];
            }
        }

        return [
            'error' => true,
            'errorCode' => $this->resource['name'] ?? null,
            'errorBag' => $errorBag,
            'errorMessage' => $errorMessage,
        ];
    }
}
