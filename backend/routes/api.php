<?php

use App\Http\Controllers\ChatNodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/chat/start', [ChatNodeController::class, 'start']);
Route::post('/chat/next', [ChatNodeController::class, 'next']);

Route::get('/nodes/all', [ChatNodeController::class, 'index']);
Route::get('/nodes/{id}', [ChatNodeController::class, 'show']);

Route::post('/nodes/create', [ChatNodeController::class, 'store']);
Route::put('/nodes/update/{id}', [ChatNodeController::class, 'update']);
Route::delete('/nodes/delete/{id}', [ChatNodeController::class, 'destroy']);

Route::post('nodes/update/position/{id}', [ChatNodeController::class, 'update_position']);
