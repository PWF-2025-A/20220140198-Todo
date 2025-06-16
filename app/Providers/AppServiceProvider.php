<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken; // Ensure this is imported
use Laravel\Sanctum\Sanctum; // Ensure this is imported
use Illuminate\Routing\Route; // Added for Scramble config
use Dedoc\Scramble\Scramble; // Added for Scramble config
use Illuminate\Support\Str; // Added for Scramble config

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Tailwind CSS for pagination styling
        Paginator::useTailwind();

        // Define a Gate named 'admin' to check if a user is an administrator
        Gate::define('admin', function ($user) {
            // Assumes there's an 'is_admin' boolean column on the User model
            return $user->is_admin === true;
        });

        // Configure Sanctum to use a custom PersonalAccessToken model if needed.
        // Note: The image shows 'PersonalAccesToken', which seems like a typo.
        // It should be 'PersonalAccessToken' (correct capitalization).
        // If you have a custom model, ensure its namespace and class name are correct.
        Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

        // Configure Scramble to document only API routes that start with '/api/'
        Scramble::configure()->routes(function (Route $route) {
            return Str::startsWith($route->uri(), 'api/');
        });
    }
}
