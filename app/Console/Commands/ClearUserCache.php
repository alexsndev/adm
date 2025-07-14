<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\DashboardService;
use App\Services\TransactionService;
use Illuminate\Console\Command;

class ClearUserCache extends Command
{
    protected $signature = 'cache:clear-user {user_id?} {--all : Clear cache for all users}';
    protected $description = 'Clear cache for specific user or all users';

    public function handle(DashboardService $dashboardService, TransactionService $transactionService): int
    {
        if ($this->option('all')) {
            $this->info('Clearing cache for all users...');
            $users = User::all();
            
            foreach ($users as $user) {
                $this->clearUserCache($user->id, $dashboardService, $transactionService);
            }
            
            $this->info('Cache cleared for all users!');
            return 0;
        }

        $userId = $this->argument('user_id');
        
        if (!$userId) {
            $this->error('Please provide a user ID or use --all option');
            return 1;
        }

        $user = User::find($userId);
        
        if (!$user) {
            $this->error("User with ID {$userId} not found");
            return 1;
        }

        $this->clearUserCache($userId, $dashboardService, $transactionService);
        $this->info("Cache cleared for user: {$user->name} (ID: {$userId})");
        
        return 0;
    }

    private function clearUserCache(int $userId, DashboardService $dashboardService, TransactionService $transactionService): void
    {
        $dashboardService->clearUserCache($userId);
        $transactionService->clearUserCache($userId);
    }
} 