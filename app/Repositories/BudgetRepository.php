<?php


namespace App\Repositories;


use App\Budget;
use App\Interfaces\BudgetRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BudgetRepository extends BaseRepository implements BudgetRepositoryInterface
{

    public function __construct(Budget $model)
    {
        parent::__construct($model);
    }

    public function save($data) : Model
    {
        $result = $this->model->create($data);
        return $result;
    }

    public function unlogged() : Collection
    {
        return $this->model->where('logged_as_expense', 0)->get();
    }
}
