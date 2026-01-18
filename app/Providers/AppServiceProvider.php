<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <--- TAMBAHKAN BARIS INI (PENTING!)
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Pagination\Paginator;

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

        Paginator::useBootstrapFive();

        View::composer('layout.header', function ($view) {
        $user = auth()->user();
        
        if ($user) {
            // Kita ambil dari relasi notifications(), lalu filter manual
            $dbNotifications = $user->notifications()
                                    ->whereNull('read_at')
                                    ->latest()
                                    ->get();

            // 2. Cek Event yang Mulai HARI INI
            $todayEvents = \App\Models\Event::whereDate('date', now())
                ->whereHas('participants', function($q) use ($user) {
                    $q->where('user_id', $user->id);
                })->get();

            $view->with('notif_db', $dbNotifications)
                 ->with('notif_today', $todayEvents);
        }
    });
    }
}
