<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketingComment extends Model
{
    public function ticketing_type()
    {
        return $this->belongsTo(TicketingType::class);
    }
}
