<?php

namespace App\Policies;

use App\User;
use App\TicketingType;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketingTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticketing type.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingType  $ticketingType
     * @return mixed
     */
    public function view(User $user)
    {
        $permissions = $user->role->access_module->pluck('permissions')->toArray();
        if(in_array('Ticket type', $permissions))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create ticketing types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permissions = $user->role->access_module->pluck('permissions')->toArray();
        if(in_array('Create ticket type', $permissions))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the ticketing type.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingType  $ticketingType
     * @return mixed
     */
    public function update(User $user)
    {
        $permissions = $user->role->access_module->pluck('permissions')->toArray();
        if(in_array('Edit ticket type', $permissions))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the ticketing type.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingType  $ticketingType
     * @return mixed
     */
    public function delete(User $user, TicketingType $ticketingType)
    {
        //
    }

    /**
     * Determine whether the user can restore the ticketing type.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingType  $ticketingType
     * @return mixed
     */
    public function restore(User $user, TicketingType $ticketingType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ticketing type.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingType  $ticketingType
     * @return mixed
     */
    public function forceDelete(User $user, TicketingType $ticketingType)
    {
        //
    }
}
