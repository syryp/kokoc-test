<?php


namespace App\Http\Presenters;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

abstract class AbstractPresenter implements Arrayable, Jsonable, \JsonSerializable, Responsable
{
    protected $data = null;

    protected $resource;

    protected $managerPermissions = [];

    protected bool $isManager;

    abstract protected function resolve();

    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    public function getData()
    {
        if (!$this->data) {
            $this->data = $this->resolve();
        }
        return $this->data;
    }

    public function toResponse($request)
    {
        return new JsonResponse($this->toArray(), $this->resource['http_code'] ?? 200);
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }

    public function toArray()
    {
        if ($this->getData() instanceof Arrayable) {
            return $this->getData()->toArray();
        }
        else {
            return $this->getData();
        }
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
