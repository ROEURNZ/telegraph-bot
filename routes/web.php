<?php

use Illuminate\Support\Facades\Route;
use DefStudio\Telegraph\Facades\Telegraph;
use App\Http\Controllers\TelegramController;

Route::get('/', function () {
    return view('welcome');
});
