<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('donor', function(){
    return view('donor');
});

Route::get('notifications', function(){
    return view('notificatons');
});

Route::get('profile', function(){
    return view('profile');
});

Route::get('requests', function(){
    return view('requests');
});
