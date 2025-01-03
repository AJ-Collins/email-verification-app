<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Listeners\AssignRoleToNewUser;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
     /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            AssignRoleToNewUser::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        // Additional event boot logic if needed
    }
}
