<?php

namespace App\Providers;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-chirp', function (User $user) {
            return $user->role_name !== "Invitado";
        });

        Gate::define('edit-chirp', function (User $user, Chirp $chirp) {
            return $user->role_name !== "Invitado" || ($user->role_name === "Admin" && $chirp->user_id == $user->id);
        });

        Gate::define('delete-chirp', function (User $user, Chirp $chirp) {
            return $user->role_name !== "Invitado" || ($user->role_name === "Admin" && $chirp->user_id == $user->id);
        });
    }
}
