<?php

namespace App\Providers;

use App\Models\HouseholdTask;
use App\Models\TaskCategory;
use App\Models\Project;
use App\Policies\HouseholdTaskPolicy;
use App\Policies\TaskCategoryPolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Registrar policies
        Gate::policy(TaskCategory::class, TaskCategoryPolicy::class);
        Gate::policy(HouseholdTask::class, HouseholdTaskPolicy::class);
        Gate::policy(Project::class, ProjectPolicy::class);

        // Gate para admin
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}
