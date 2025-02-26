<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
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
        .container-posts {
            margin-top: 80px; /* Espacio para que los posts no queden ocultos detrás del header */
            max-width: 600px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            background-color:rgb(155, 195, 238);
            border: none;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }
        .card-footer {
            display: flex;
            flex-direction: row; /* Alineación horizontal */
            gap: 10px; /* Espacio entre los botones */
            align-items: center; /* Alineación vertical centrada */
        }
        /* Estilos para las imágenes */
        .card-body img {
            width: 100%; /* La imagen ocupará el 100% del ancho del contenedor */
            height: 300px; /* Establecer una altura fija */
            object-fit: cover; /* Asegura que la imagen se recorte de forma adecuada */
            border-radius: 8px; /* Esquinas redondeadas opcionales */
        }

        /* Estilo para el botón "Eliminar Usuario" */
        .delete-user-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
        }
    </style>
</head>
<body>

    <!-- Header fijo -->
    <div class="header">
        <h1 class="m-0">{{ auth()->user()->name }}</h1>
        <div>
            <a href="{{ route('post.showCreatePost', ['id' => $user->id]) }}" class="btn btn-primary btn-sm">Crear Post</a>
            <a href="{{ route('user.doLogout') }}" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
        </div>
    </div>

    <!-- Contenedor de Posts -->
    <div class="container mt-4 d-flex justify-content-center">
        <div class="container-posts">
            @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="card-title">{{ $post->title }}</h2>
                    @if ($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" alt="Imagen del post">
                    @endif
                    <p class="card-text">{{ $post->description }}</p>
                    
                </div>

                <!-- Sección de interacciones -->
                <div class="card-footer">

                    <!-- Número de likes -->
                    <p>{{ $post->n_likes }} Likes</p>

                    <!-- Botón para dar like -->
                    <form action="{{ route('post.iLikeThisPost', ['id' => $post->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Dar Like</button>
                    </form>

                    <!-- Botón para ver comentarios -->
                    <form action="{{ route('post.comments', ['id' => $post->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">{{ $post->comments_count }} comentarios </button>
                    </form>

                    <!-- Botón para eliminar si es el dueño -->
                    @if (auth()->id() == $post->belongs_to)
                        <form action="{{ route('post.delete', ['id' => $post->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este post?')">
                                Eliminar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Botón Eliminar Usuario -->
    <form action="{{ route('user.delete', ['id' => auth()->id()]) }}" method="POST" class="delete-user-btn">
        @csrf
        @method('DELETE')  <!-- Esto simula una solicitud DELETE -->
        <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('¿Estás seguro de eliminar tu cuenta?')">Eliminar Usuario</button>
    </form>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
