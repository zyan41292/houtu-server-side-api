<?php

namespace App\Services;

use BadMethodCallException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseService
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function __call($method, $arguments)
    {
        // 先尝试模型实例方法
        if (method_exists($this->model, $method)) {
            return $this->model->$method(...$arguments);
        }

        // 再尝试 Builder 方法
        $query = $this->model->newQuery();
        if (method_exists($query, $method)) {
            $result = $query->$method(...$arguments);

            if ($result instanceof Builder) {
                $this->model = $query->getModel();
                return $this;
            }

            return $result;
        }

        throw new BadMethodCallException("Method {$method} does not exist on model or query builder.");
    }
}
