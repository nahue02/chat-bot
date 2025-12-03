<?php

use App\Http\Controllers\ChatNodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/chat/start', [ChatNodeController::class, 'start']);
Route::post('/chat/next', [ChatNodeController::class, 'next']);

Route::get('/nodes/all', [ChatNodeController::class, 'get_all_nodes']);
Route::get('/nodes/{id}', [ChatNodeController::class, 'get_node_by_id']);

Route::post('/nodes/create', [ChatNodeController::class, 'insert']);
Route::put('/nodes/update/{id}', [ChatNodeController::class, 'update']);
Route::delete('/nodes/delete', [ChatNodeController::class, 'destroy']);
