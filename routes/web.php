<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Manage Roles with traditional Livewire
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', \App\Livewire\Roles\RoleIndex::class)->name('index');
        Route::get('create', \App\Livewire\Roles\RoleCreate::class)->name('create');
        Route::get('{id}/edit', \App\Livewire\Roles\RoleEdit::class)->name('edit');
        Route::get('{id}', \App\Livewire\Roles\RoleShow::class)->name('show');
    });

    // Manage Users with traditional Livewire
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', \App\Livewire\Users\UserIndex::class)->name('index');
        Route::get('create', \App\Livewire\Users\UserCreate::class)->name('create');
        Route::get('{id}/edit', \App\Livewire\Users\UserEdit::class)->name('edit');
        Route::get('{id}', \App\Livewire\Users\UserShow::class)->name('show');
    });

    // Manage Buildings with traditional Livewire
    Route::prefix('buildings')->name('buildings.')->group(function () {
        Route::get('/', \App\Livewire\Buildings\BuildingIndex::class)->name('index');
        Route::get('create', \App\Livewire\Buildings\BuildingCreate::class)->name('create');
        Route::get('{id}/edit', \App\Livewire\Buildings\BuildingEdit::class)->name('edit');
        Route::get('{id}', \App\Livewire\Buildings\BuildingShow::class)->name('show');
    });

    // Settings with Volt
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
