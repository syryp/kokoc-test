<?php


namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

class BaseResource extends JsonResource
{
    /**
     * @param string $key
     * @param string $resourceNameSpace
     * @param callable $cb Дополнительная обработка полей. Сортировку добавить или еще чего.
     * @return array
     */
    public function getRelation(string $key, string $resourceNameSpace, callable $cb = null): array
    {
        $isLoaded = (bool) $this?->relationLoaded($key);
        if (!$isLoaded) {
            return [];
        }
        $resourceData = $this->{$key};

        if ($cb) {
            $resourceData = $cb($resourceData);
        }

        return [
            $key => match (true) {
                $resourceData instanceof Collection,
                    $resourceData instanceof SupportCollection,
                    is_array($resourceData) && !$this->isAssociative($resourceData)
                => $resourceNameSpace::collection($resourceData),
                default => new $resourceNameSpace($this->{$key})
            },
        ];
    }

    public function subCollection(Collection|LengthAwarePaginator $collection, string $resourceNameSpace, string $resourceName): array
    {
        return [
            $resourceName => $resourceNameSpace::collection($collection),
        ];
    }

    private function isAssociative(array $arr): bool
    {
        return (bool) count(array_filter(array_keys($arr), "is_string")) == count($arr);
    }

    /**Объединяет сущности в связи через запятую
     * @param $entity string название связи
     * @return array
     */
    protected function getEntityListString(string $entity, string $fieldName = 'name'): array
    {
        if (!$this?->relationLoaded($entity)) {
            return [];
        }

        $entities = $this[$entity];
        if ($entities->isEmpty()) {
            return ["{$entity}_string" => ''];
        }
        return ["{$entity}_string" => $entities->pluck($fieldName)->join(', ')];
    }

    public function getAttribute(string $name): array
    {
        return $this->offsetExists($name)
            ? [$name => $this[$name]]
            : [];
    }
}
