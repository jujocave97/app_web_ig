<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// RUTA PARA ENRUTAR /user/

Route::middleware(['auth'])->group(function(){

    Route::get('/{id}/comments', [PostController::class, 'showComments'])->name('post.comments');
    Route::post('/{id}/comments', [PostController::class, 'createComments'])->name('post.createComment');
    
    Route::delete('/{id}', [PostController::class, 'deletePost'])->name('post.delete');
    Route::get('/create/{id}', [PostController::class, 'showCreatePost'])->name('post.showCreatePost');
    Route::post('/create/{id}', [PostController::class, 'createPost'])->name('post.createPost');

    Route::post('/like/{id}', [PostController::class, 'iLikeThisPost'])->name('post.iLikeThisPost');


});