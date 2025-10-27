<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
