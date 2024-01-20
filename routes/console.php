<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create-roles', function() {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'client']);
});

Artisan::command('create-admin', function() {
    $admin = User::create([
        "name" => "Admin",
        "email" => "admin@gmail.com",
        "password" => "internet",
        "password_confirmation" => "internet",
    ]);
    $admin->assignRole("admin");

});
