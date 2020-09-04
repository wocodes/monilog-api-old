<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = ['amount', 'title', 'date_logged', 'description', 'user_id'];
}
