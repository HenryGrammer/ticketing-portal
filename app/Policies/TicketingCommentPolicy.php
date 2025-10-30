<?php

namespace App\Policies;

use App\User;
use App\TicketingComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketingCommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticketing comment.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingComment  $ticketingComment
     * @return mixed
     */
    public function view(User $user)
    {
        $permissions = $user->role->access_module->pluck('permissions')->toArray();
        if(in_array('Ticket comment', $permissions))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create ticketing comments.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        $permissions = $user->role->access_module->pluck('permissions')->toArray();
        if(in_array('Create ticket comment', $permissions))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the ticketing comment.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingComment  $ticketingComment
     * @return mixed
     */
    public function update(User $user)
    {
        $permissions = $user->role->access_module->pluck('permissions')->toArray();
        if(in_array('Edit ticket comment', $permissions))
        {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the ticketing comment.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingComment  $ticketingComment
     * @return mixed
     */
    public function delete(User $user, TicketingComment $ticketingComment)
    {
        //
    }

    /**
     * Determine whether the user can restore the ticketing comment.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingComment  $ticketingComment
     * @return mixed
     */
    public function restore(User $user, TicketingComment $ticketingComment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ticketing comment.
     *
     * @param  \App\User  $user
     * @param  \App\TicketingComment  $ticketingComment
     * @return mixed
     */
    public function forceDelete(User $user, TicketingComment $ticketingComment)
    {
        //
    }
}
