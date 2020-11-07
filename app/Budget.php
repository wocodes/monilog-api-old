<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = ["user_id", "title", "description", "for", "amount"];
}
