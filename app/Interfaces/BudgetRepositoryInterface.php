<?php


namespace App\Interfaces;


interface BudgetRepositoryInterface
{
    /**
     * Save method for interface
     * @param $data
     * @return mixed
     */
    public function save($data);

    /**
     * Get all Budgets
     * @return mixed
     */
    public function getAll();

    /**
     * @return mixed
     */
    public function unlogged();
}
