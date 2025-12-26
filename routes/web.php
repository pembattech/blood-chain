<?php

use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('login', function(){
    return view('auth.login');
})->name("login");

Route::get('register', function(){
    return view('auth.register');
})->name("register");

Route::get('logout', function(){
    // Logic for logging out the user can be added here
    return redirect()->route('login');
})->name("logout");

Route::get('donor-registration', function(){
    return view('auth.donor-registration');
})->name("donor-registration");

Route::get('/', function () {
    return view('dashboard');
})->name("dashboard");

Route::get('donors', function(){
    return view('donors');
})->name("donors");

Route::get('notifications', function(){
    return view('notifications');
})->name("notifications");

Route::get('profile', function(){
    return view('profile');
})->name("profile");

Route::get('requests', function(){
    return view('requests');
})->name("requests");

Route::get('create-request', function(){
    return view('create-request');
})->name("create-request");
