<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function access_module()
    {
        return $this->hasMany(AccessModule::class);
    }
}
