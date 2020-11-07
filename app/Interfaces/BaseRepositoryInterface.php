<?php


namespace App\Interfaces;


interface BaseRepositoryInterface
{

    /**
     * Get all budgets
     * @return mixed
     */
    public function all();

    public function find($id);

}
