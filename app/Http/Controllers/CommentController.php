<?php

namespace App\Http\Controllers;
use App\Models\Comments;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //
    public function makeAComment($userID,$postId, Request $request){
        $comment = new Comments();
        $comment->post_id = $postId;
        $comment->comment = $request->content;
        $comment->user_id = $userID;
        $comment->save();
        // hacer return a la vista del post con el nuevo comentario
    }

    public function destroy($id) {
        $comment = Comments::find($id);
    
        if (!$comment) {
            return redirect()->back()->with('error', 'Comentario no encontrado.');
        }
    
        // Verificar si el usuario autenticado es el dueño del comentario
        if (auth()->id() !== $comment->user_id) {
            return redirect()->back()->with('error', 'No puedes eliminar este comentario.');
        }
    
        $comment->delete();
        return redirect()->back()->with('success', 'Comentario eliminado.');
    }
    
}
