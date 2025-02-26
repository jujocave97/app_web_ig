
<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// RUTA PARA ENRUTAR /user/

Route::middleware(['auth'])->group(function(){
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');   
});