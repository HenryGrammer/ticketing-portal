<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function assigned()
    {
        return $this->belongsTo(User::class,'assigned_to','id');
    }
    public function created_by()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
