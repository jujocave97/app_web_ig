<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postear</title>
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
        /* Contenedor del formulario */
        .form-container {
            margin-top: 80px; /* Espacio para que el formulario no quede detrás del header */
            display: flex;
            justify-content: center;
        }
        .form-card {
            width: 400px;
            padding: 20px;
            background-color:rgb(155, 195, 238);
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);

            margin-top: 5%;
        }
    </style>
</head>
<body>

    <!-- Header fijo -->
    <div class="header">
        <h1 class="m-0">Crear Post</h1>
        <a href="{{ route('user.doLogout') }}" class="btn btn-outline-danger btn-sm">Cerrar sesión</a>
    </div>

    <!-- Formulario de creación de post -->
    <div class="form-container">
        <div class="form-card">
            <form action="{{ route('post.createPost', ['id' => auth()->id()]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h3 class="text-center mb-4">Crear un nuevo post</h3>

                <!-- Campo Título -->
                <div class="mb-3">
                    <label for="title" class="form-label">Título:</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Escribe el título">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descripción:</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Escribe el contenido"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Imagen:</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Botón Enviar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">Publicar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
