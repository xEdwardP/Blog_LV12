<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return 'Hello Admin';
})->name('dashboard');

Route::get('/cursos', function(){
    return 'Cursos';
})->name('cursos');