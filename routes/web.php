<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/lang/{locale}', function($locale){
    if(!in_array($locale, ['en', 'id'])){
        abort(400);
    }
    
    // session()->put('locale', $locale);
    session(['locale'=> $locale]);

    if(auth()->check()){
        auth()->user()->update(['locale'=> $locale]);
    }

    return redirect()->back();
})->name('lang.switch');

Route::middleware('guest')->prefix('user')->group(function(){
    Route::get('/register', [AuthController::class, 'register'])
    ->name('user.register');

    Route::post('/register', [AuthController::class, 'createUser'])
    ->name('user.register.input');

    Route::get('/login', [AuthController::class, 'login'])
    ->name('user.login');

    Route::post('/login', [AuthController::class, 'signin'])
    ->name('user.login.input');

    Route::get('/password', [AuthController::class, 'forgotPassword'])
    ->name('user.password');

    Route::post('/password', [AuthController::class, 'checkEmail'])
    ->name('user.password.check');

    Route::get('/resetpassword/{user}', [AuthController::class, 'resetPassword'])
    ->name('user.password.reset');

    Route::post('/resetpassword/{user}', [AuthController::class, 'updatePassword'])
    ->name('user.password.update');
});

Route::middleware('auth')->prefix('user')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'indexs'])
    ->name('user.dashboard');

    Route::get('/events', [EventController::class, 'index'])
    ->name('user.events.index');

    Route::get('/events/{event}', [EventController::class, 'show'])
    ->name('user.events.detail');

    Route::post('/events/{event}/register', [EventController::class, 'register'])
    ->name('user.events.register');

    // Route::get('/events/create', [EventController::class, 'create'])
    // ->name('events.create');

    // Route::get('/events/{event}/edit', [EventController::class, 'edit'])
    // ->name('events.edit');

    // Route::put('/events/{event}', [EventController::class, 'update'])
    // ->name('events.update');

    // Route::delete('/events/{event}', [EventController::class, 'destroy'])
    // ->name('events.destroy');

    Route::get('/profile', [ProfileController::class, 'profile'])
    ->name('user.profile');

    Route::post('/profile/update', [ProfileController::class, 'updateData'])
    ->name('user.profile.update');

    Route::get('/profile-edit', [ProfileController::class, 'edit'])
    ->name('user.profile.edit');

    Route::post('/logout', [AuthController::class, 'logout'])
    ->name('user.logout');

    Route::post('/events/{event}/join', [EventController::class, 'join'])
    ->name('events.join');
    
    Route::get('/history-event', [DashboardController::class, 'history'])
    ->name('history.index');
});

Route::get('/notifications/{id}/read', function ($id) {
    $notification = auth()->user()->notifications()->find($id);
    if($notification) {
        $notification->markAsRead();
    }
    return back(); // Kembali ke halaman sebelumnya
})->name('notifications.read');

Route::middleware(['auth'])->prefix('admin')->group(function(){
    
    // 1. Dashboard & CRUD Event
    Route::get('/dashboard', [AdminController::class, 'index'])
    ->name('admin.dashboard');

    Route::get('/create', [AdminController::class, 'create'])
    ->name('admin.create');

    Route::post('/store', [AdminController::class, 'store'])
    ->name('admin.store');

    Route::get('/edit/{id}', [AdminController::class, 'edit'])
    ->name('admin.edit');

    Route::put('/update/{id}', [AdminController::class, 'update'])
    ->name('admin.update');

    Route::delete('/delete/{id}', [AdminController::class, 'destroy'])
    ->name('admin.delete');

    Route::get('/event/{id}/participants', [AdminController::class, 'participants'])
    ->name('admin.participants');

    Route::post('/logout', [AuthController::class, 'logout'])
    ->name('admin.logout');

    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('admin.profile');

    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('admin.profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('admin.profile.destroy');
});