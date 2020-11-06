<?php


namespace App\Interfaces;


interface BaseRepositoryInterface
{

    /**
     * Get all budgets
     * @return mixed
     */
    public function getAll();

    public function find($id);

}
