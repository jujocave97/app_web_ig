<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Models\Comments;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function showPosts(){
        $posts = Post::all();
        return view('post_views.posts', compact('posts'));
    }

    public function showCreatePost($id){
        $user = User::findOrFail($id); // Obtiene el usuario por ID
        return view('post_views.create_post', compact('user'));
    }

    public function createPost($id, Request $request){ // crea un post y te devuelve al inicio

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        
        $datosPost = $request->all();
        $post = new Post();
        $post->title = $datosPost['title'];
        $post->description = $datosPost['description'];
        $post->belongs_to = $id;
        $post->n_likes = 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            //dd($imagePath); // Esto te mostrará la ruta completa de la imagen
            $post->image_path = $imagePath;
        }
        

        $post->save();
        
        $user = User::findOrFail($id);
        $posts = Post::all();
        return redirect()->route('user.showIndex', ['id' => $user->id]);

    }

    public function showOnePost($id){ // esta funcion muestra el post seleccionado y todos sus comentarios
        $post = Post::find($id);
        $comments = $post->comments;
        //return view('post_views.post', compact('post', 'comments'));
    }

    public function deletePost($ids){
        $post = Post::find($ids);

            $comments = $post->comments;
            foreach($comments as $comment){
                $comment->delete();
            }
            $post->delete();
            return back()->with('message', 'Se ha eliminado el post.');
    }

    public function iLikeThisPost($id)
    {    
        $post = Post::find($id);
        if ($post) {
            $post->n_likes = $post->n_likes + 1;
            $post->save();
            return back()->with('message', 'Te ha gustado el post.');
        }
    
        return back()->with('error', 'Post no encontrado.');
    }
    
    
    

    public function showComments($id){  // hacer vista
        $post = Post::find($id);
        $comments = $post->comments ?? collect(); 
        return view('post_views.comments', compact('comments', 'post'));
    }

    public function createComments($id, Request $request){
            // Validar la entrada
            $request->validate([
                'content' => 'required|string|max:500'
            ]);
        
            // Buscar el post
            $post = Post::find($id);
        
            // Si el post no existe, retornar error
            if (!$post) {
                return redirect()->back()->with('error', 'El post no existe.');
            }
        
            // Crear el comentario
            $comment = new Comments();
            $comment->post_id = $id;
            $comment->comment = $request->content;
            $comment->user_id = auth()->user()->id; 
            $comment->save();
        
            // Obtener los comentarios actualizados
            $comments = $post->comments ?? collect(); // Evitar null
        
            return view('post_views.comments', compact('comments', 'post'));
        }
        
}

