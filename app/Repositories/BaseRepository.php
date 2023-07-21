<?php

namespace App\Repositories;

class BaseRepository
{
    protected $model;

    protected function __construct(object $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function query()
    {
        return $this->model->query();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function whereIn(string $column, array $parameters)
    {
        return $this->model->whereIn($column, $parameters);
    }


    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByColumn(string $column, $value, array $relations = [])
    {
        if($relations)
        {
            return $this->model->with($relations)->where($column, $value)->get();
        }
        return $this->model->where($column, $value)->get();
    }

    public function findByColumnLike(string $column, $value, array $relations = [])
    {
        if($relations)
        {
            return $this->model->with($relations)->where($column, 'like', '%'. $value. '%')->get();
        }
        return $this->model->where($column, 'like', '%'. $value. '%')->get();
    }

    public function save(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes)
    {
        return $this->model->find($id)->update($attributes);
    }

    public function updateByColumn(string $column, string $value, array $attributes)
    {
        return $this->model->where($column, $value)->update($attributes);
    }

    public function delete(int $id)
    {
        return $this->model->delete($id);
    }

    public function updateOrCreate(array $attributes)
    {
        return $this->model->updateOrCreate($attributes);
    }

    public function updateOrCreateValidate(array $args, array $attributes)
    {
        return $this->model->updateOrCreate($args,$attributes);
    }

    public function getFilterColumns(array $columns)
    {
        return $this->model->get($columns);
    }

    public function relationships(array $relations)
    {
        return $this->model->with($relations);
    }

    public function withTrashed()
    {
        return $this->model->withTrashed();
    }

    public function onlyTrashed()
    {
        return $this->model->onlyTrashed();
    }

    public function getObject()
    {
        return $this->model;
    }
}
