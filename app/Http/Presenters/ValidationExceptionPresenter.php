<?php


namespace App\Http\Presenters;

class ValidationExceptionPresenter extends ApiExceptionPresenter
{
    protected function resolve()
    {
        $errorBag = [];

        foreach ($this->resource['bag'] as $fieldName => $errorMessages) {
            $errorBag[] = [
                'field' => $fieldName,
                'messages' => $errorMessages,
            ];
        }

        return [
            'error' => true,
            'errorCode' => $this->resource['name'] ?? null,
            'errorBag' => $errorBag,
            'errorMessage' => 'Ошибка валидации',
        ];
    }
}
