<?php


namespace App\Repositories;


use App\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find($id) {
        return $this->model->find($id);
    }

    public function getAll() : Collection
    {
        return $this->model->all();
    }
}
