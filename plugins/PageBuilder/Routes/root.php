<?php


use Illuminate\Support\Facades\Route;
use Plugin\PageBuilder\Controllers\Front\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
