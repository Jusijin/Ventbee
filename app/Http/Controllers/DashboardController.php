<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function indexs(){
        $user = auth()->user();

        $events = $user->events()->with('category')->latest()->get();
        $totalEvent = $user->events()->count();
        $onProgress = $user->events()->wherePivot('status', 'on progress')->count();
        $finished = $user->events()->wherePivot('status', 'registered_success')->count();

        return view('page.user.dashboard', compact('events', 'totalEvent', 'onProgress', 'finished'));
    }

    public function history()
    {
        $user = auth()->user();

        // Ambil event yang diikuti user, TAPI hanya yang sudah selesai/lewat
        $events = $user->events()
            ->with('category')
            ->where(function($query) {
                $query->where('events.status', 'finished') // Status event 'finished'
                      ->orWhere('events.date', '<', now()); // ATAU tanggalnya sudah lewat
            })
            ->orderBy('events.date', 'desc') // Urutkan dari yang terbaru
            ->paginate(10);

        return view('page.user.history', compact('events'));
    }
}
