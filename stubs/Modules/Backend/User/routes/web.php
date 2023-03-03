<?php

use App\Modules\Backend\User\Controllers\Delete;
use App\Modules\Backend\User\Controllers\Index;
use App\Modules\Backend\User\Controllers\Create;
use App\Modules\Backend\User\Controllers\Edit;

Route::get('/create', [Create::class, 'show']);
Route::get('/{user}/edit', [Edit::class, 'show']);
Route::put('/{user}', [Edit::class, 'store']);
Route::delete('/{user}', Delete::class);
Route::post('/', [Create::class, 'store']);
Route::get('/', Index::class);
