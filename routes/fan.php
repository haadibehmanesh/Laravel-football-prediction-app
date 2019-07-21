<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('fan')->user();

    //dd($users);

    return view('fan.home');
})->name('home');

