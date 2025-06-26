<?php

use App\Livewire\Buildings\BuildingCreate;
use App\Livewire\Buildings\BuildingEdit;
use App\Livewire\Buildings\BuildingIndex;
use App\Livewire\Buildings\BuildingShow;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;
use App\Livewire\Users\UserIndex;
use App\Livewire\Users\UserShow;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Manage Users with traditional Livewire
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', UserIndex::class)->name('index');
        Route::get('create', UserCreate::class)->name('create');
        Route::get('{id}/edit', UserEdit::class)->name('edit');
        Route::get('{id}', UserShow::class)->name('show');
    });
    
    Route::prefix('buildings')->name('buildings.')->group(function () {
        Route::get('/', BuildingIndex::class)->name('index');
        Route::get('create', BuildingCreate::class)->name('create');
        Route::get('{id}/edit', BuildingEdit::class)->name('edit');
        Route::get('{id}', BuildingShow::class)->name('show');
    });

    // Settings with Volt
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';