<?php

namespace App\Providers;

use App\Company;
use App\Department;
use App\Policies\CompanyPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\RolePolicy;
use App\Policies\TicketingCommentPolicy;
use App\Policies\TicketingPolicy;
use App\Policies\TicketingTypePolicy;
use App\Policies\UserPolicy;
use App\Role;
use App\Ticket;
use App\TicketingComment;
use App\TicketingType;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Company::class => CompanyPolicy::class,
        Department::class => DepartmentPolicy::class,
        Role::class => RolePolicy::class,
        TicketingComment::class => TicketingCommentPolicy::class,
        TicketingType::class => TicketingTypePolicy::class,
        User::class => UserPolicy::class,
        Ticket::class => TicketingPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
