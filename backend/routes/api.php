<?php

use App\Http\Controllers\ChatNodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/chat/start', [ChatNodeController::class, 'start']);

Route::post('/chat/next', [ChatNodeController::class, 'next']);

