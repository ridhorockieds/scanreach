<?php

namespace App\Providers;

use App\Models\Chat;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Membagikan data ke semua view
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $totalChats = Chat::where(['user_id' => auth()->id(), 'read' => 0])->count();
                $view->with('totalChats', $totalChats);
            }
        });
    }
}
