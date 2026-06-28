<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/queue/public', [App\Http\Controllers\QueueController::class, 'publicQueue']);
