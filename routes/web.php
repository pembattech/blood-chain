<?php

use Illuminate\Support\Facades\Route;

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
