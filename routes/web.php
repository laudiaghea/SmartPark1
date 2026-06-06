<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', function () {
    return view('login');
});

Route::get('dashboard', function() {
    return view('dashboard');
});

Route::get('/parkir', function () {
    return view('parkir.index');
});

Route::get('/parkir/tambah', function () {
    return view('parkir.create');
});

Route::get('/parkir/keluar', function () {
    return view('parkir.keluar');
});

Route::get('/tarif', function () {
    return view('tarif.index');
});

Route::get('/tarif/create', function () {
    return view('tarif.create');
});

Route::get('/tarif/edit/{id}', function () {
    return view('tarif.edit');
});
