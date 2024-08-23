<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class AbstractRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**Собирает запрос в БД по заданным условиям и возвращает перую найденную запись или null
     * @param  array        $filters    фильтры для запроса [поле => значение]
     * @param  array        $with       аналогичен Builder->with()
     * @param  array        $select     аналогичен Builder->select()
     * @param  array        $orderBy    аналогичен Builder->orderBy()
     * @param  int|null     $limit      число записей на странице
     * @param  int|null     $offset     номер страницы
     * @param  bool         $paginate   Вернуть обьект пагинации или нет?
     * @return Collection| LengthAwarePaginator
     */
    public function getList(
        array $filters = [],
        array $with = [],
        array $select = ['*'],
        array $orderBy = [],
        ?int $limit = null,
        ?int $offset = null,
        bool $paginate = false,
    ): Collection|LengthAwarePaginator {
        if ($paginate) {
            return $this->buildQuery($filters, $with, $select, $orderBy)
                ->paginate(
                    perPage: $limit,
                    page: $offset,
                );
        }


        return $this->buildQuery($filters, $with, $select, $orderBy, $limit, $offset)
            ->get();
    }


    /**Собирает запрос в БД по заданным условиям и возвращает перую найденную запись или null
     * @param  array        $filters    фильтры для запроса [поле => значение]
     * @param  array        $with       аналогичен Builder->with()
     * @param  array        $select     аналогичен Builder->select()
     * @param  array        $orderBy    аналогичен Builder->orderBy()
     * @return Model|null
     */
    public function find(array $filters = [], array $with = [], array $select = ['*'], array $orderBy = []): ?Model
    {
        return $this->buildQuery($filters, $with, $select, $orderBy)
            ->take(1)
            ->get()
            ->first();
    }

    public function buildQuery(array $filters = [], array $with = [], array $select = ['*'], array $orderBy = [], ?int $limit = null, ?int $offset = null): Builder
    {
        $query = $this->model;

        $query = $query->with($with)->select($select);

        foreach ($filters as $field => $value) {
            if (is_array($value) || ($value instanceof Collection)) {
                $query = $query->whereIn($field, $value);
            }
            else {
                if (is_null($value)) {
                    $query = $query->whereNull($field);
                } elseif ($value === 'not_null')
                {
                    $query = $query->whereNotNull($field);
                }
                else {
                    $query = $query->where($field, $value);
                }
            }
        }

        foreach ($orderBy as $column => $direction) {
            $query = $query->orderBy($column, $direction);
        }

        if (!empty($limit) && !empty($offset)) {
            $query = $query->when($offset, function ($query, $offset) use ($limit) {
                $query->forPage($offset, $limit);
            });
        }

        return $query;
    }

    public function delete(string|Model $model): ?bool
    {
        $model = $this->getModel($model);
        return $model?->forceDelete();
    }

    public function create(array $params): Model
    {
        return $this->model->newQuery()->create($params);
    }

    public function insert(array $params): bool
    {
        return $this->model->newQuery()->insert($params);
    }

    public function update(string|Model $model, array $params): bool|Model
    {
        $model = $this->getModel($model);

        if (!empty($model)) {
            $model->fill($params);
            if ($model->save()) {
                return $model;
            }
            return false;
        }
        return false;
    }

    /**Возвращает модель по id. Если передать null или объект, то вернет обратно. Метод учитывает кэширование
     * @param  string|Model|null  $model
     * @return Model|null
     */
    public function getModel(string|Model|null $model): ?Model
    {
        if (empty($model)) {
            return null;
        }
        if (!($model instanceof Model)) {
            $model = $this->find(['id' => $model]);
        }
        return $model;
    }
}
