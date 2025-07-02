<?php

use App\Http\Livewire\Structures\StructureManage;
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

    Route::get('permissions', \App\Livewire\Permissions\PermissionIndex::class)->middleware('permission:permission.list')->name('permissions.index');
    Route::get('users', \App\Livewire\Users\UserManage::class)->middleware('permission:user.list')->name('users.index');
    Route::get('contracts', \App\Livewire\Contracts\ContractManage::class)->middleware('permission:contract.list')->name('contracts.index');
    Route::get('structures', \App\Livewire\Structures\StructureManage::class)->middleware('permission:structure.list')->name('structures.index');
    Route::get('responsibility', \App\Livewire\Structures\ResponsiblePeopleManage::class)->middleware('permission:responsibility.list')->name('responsibility.index');
    Route::get('equipment-types', \App\Livewire\EquipmentTypes\EquipmentTypeManage::class)->middleware('permission:equipment-type.list')->name('equipment-types.index');
    Route::get('brands', \App\Livewire\Brands\BrandManage::class)->middleware('permission:brand.list')->name('brands.index');

    // Manage Roles with traditional Livewire
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', \App\Livewire\Roles\RoleIndex::class)->name('index');
        Route::get('create', \App\Livewire\Roles\RoleCreate::class)->name('create');
        Route::get('{id}/edit', \App\Livewire\Roles\RoleEdit::class)->name('edit');
        Route::get('{id}', \App\Livewire\Roles\RoleShow::class)->name('show');
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
