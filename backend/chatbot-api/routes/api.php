<?php

use App\Http\Controllers\ChatNodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/start', [ChatNodeController::class, 'start']);

Route::get('/question/{node}/{option}', [ChatNodeController::class, 'next']);

