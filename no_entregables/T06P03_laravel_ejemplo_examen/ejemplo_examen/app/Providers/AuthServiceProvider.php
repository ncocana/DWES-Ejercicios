<?php

namespace App\Providers;

use App\Models\Post;
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

        // Devuelve true si el autor del post es el usuario autenticado
        Gate::define('show-user-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });

        // Devuelve true si el autor del post es el usuario autenticado
        Gate::define('update-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });

        // Devuelve true si el autor del post es el usuario autenticado
        Gate::define('delete-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });
    }
}
