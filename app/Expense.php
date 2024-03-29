<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['title', 'amount', 'user_id', 'category', 'date_logged', 'description', "budget_id"];

    public function budget() {
        return $this->belongsTo(Budget::class);
    }
}
