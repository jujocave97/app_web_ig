<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Header fijo */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color:rgb(155, 195, 238);
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            
        }

        /* Contenedor principal de comentarios */
        .comments-container {
            margin-top: 80px;
            text-align: center;
            
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            
        }

        /* Estilo para la imagen, asegurando que nunca sea más grande que el contenedor */
        .post-image {
            width: 60%; /* 60% del contenedor, puedes ajustar el valor */
            height: auto; /* Mantiene la proporción de la imagen */
            max-width: 400px; /* Tamaño máximo para que no sea demasiado grande */
            max-height: 500px; /* Tamaño máximo de la altura */
            object-fit: cover; /* Mantiene la proporción y cubre el contenedor */
            border-radius: 8px;
            display: block;
            margin: 0 auto;
            margin-bottom: 2%;
        }

        /* Card para comentarios */
        .comment-card {
            background-color:rgb(155, 195, 238); /* Azul celeste */
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        textarea {
            width: 100%; /* Para que ocupe todo el ancho disponible */
            max-width: 400px; /* Máximo ancho que puede tener el textarea */
            height: 120px; /* Altura específica para el textarea */
            resize: none; /* Impide que el usuario pueda redimensionar el textarea */
            margin: 0 auto; /* Centra el textarea en su contenedor */
            display: block; /* Impide que el usuario pueda redimensionar el textarea */
        }

        .comment-card p {
            margin: 0;
        }

        /* Formulario de comentario */
        .comment-form {
            background-color:rgb(155, 195, 238); /* Azul celeste */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <!-- Header fijo -->
    <div class="header">
        <h1 class="m-0">{{ $post->title }}</h1>
        <?php
            $idName = $post->belongs_to;
        ?>
        <a href="{{ route('user.showIndex', ['id' => $idName]) }}" class="btn btn-outline-secondary btn-sm">Volver</a>
    </div>

    <!-- Contenedor principal -->
    <div class="container comments-container">
        <div class="form-container">
            <h3>{{ $post->description }}</h3>
            @if ($post->image_path)
                <img src="{{ asset('storage/' . $post->image_path) }}" alt="Imagen del post" class="post-image">
            @endif
            <div class="comment-form">
                <h3>Comentar</h3>
                <form action="{{ route('post.createComment', ['id' => $post->id]) }}" method="POST">
                    @csrf
                    <textarea name="content" id="content" class="form-control" cols="30" rows="5" placeholder="Escribe tu comentario"></textarea>
                    <button type="submit" class="btn btn-primary mt-3 w-100">Comentar</button>
                </form>
            </div>
        </div>

        <!-- Mostrar comentarios -->
        <div class="form-container">
            @foreach ($comments as $comment)
            <div class="comment-card">
                <?php
                    $idName = $comment->user_id;
                    $user = DB::table('users')->where('id', $idName)->first();
                ?>
                <p><strong>{{ $user->name }}</strong></p>
                <p>{{ $comment->comment }}</p>
                <p><small>{{ $comment->created_at }}</small></p>

                @if (auth()->id() == $comment->user_id)
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este comentario?')">Eliminar</button>
                    </form>
                @endif
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
