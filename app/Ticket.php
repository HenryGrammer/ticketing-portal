<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function assignTo()
    {
        return $this->belongsTo(User::class,'assigned_to','id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function ticketing_thread()
    {
        return $this->hasMany(TicketingThread::class);
    }
}
