<?php
// Directorio donde se almacenarán las imágenes
$directorio_imagenes = 'imagenes/';

// Crear el directorio si no existe
if (!file_exists($directorio_imagenes)) {
    mkdir($directorio_imagenes, 0777, true);
}

// Obtener todas las imágenes del directorio
$imagenes = glob($directorio_imagenes . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Imágenes</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .galeria-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .galeria {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .imagen-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .imagen-card:hover {
            transform: translateY(-5px);
        }

        .imagen-container {
            position: relative;
            padding-bottom: 75%;
            overflow: hidden;
        }

        .imagen-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .imagen-info {
            padding: 15px;
        }

        .imagen-titulo {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 5px;
        }

        .mensaje-vacio {
            text-align: center;
            padding: 50px;
            color: #666;
            font-size: 1.2em;
        }

        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 1000;
            cursor: pointer;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 90vh;
            margin: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
<body>
    <div class="galeria-container">
        <h1>Galería de Imágenes</h1>
        
        <div class="galeria">
            <?php if (empty($imagenes)): ?>
                <div class="mensaje-vacio">
                    <p>Coloca tus imágenes en la carpeta 'imagenes/'</p>
                </div>
            <?php else: ?>
                <?php foreach ($imagenes as $imagen): ?>
                    <?php
                    $nombre = basename($imagen);
                    $nombre_sin_extension = pathinfo($nombre, PATHINFO_FILENAME);
                    ?>
                    <div class="imagen-card">
                        <div class="imagen-container">
                            <img src="<?php echo $imagen; ?>" alt="<?php echo $nombre_sin_extension; ?>" 
                                 onclick="mostrarImagen(this.src)">
                        </div>
                        <div class="imagen-info">
                            <div class="imagen-titulo"><?php echo $nombre_sin_extension; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="lightbox" id="lightbox" onclick="cerrarLightbox()">
        <img src="" id="lightbox-img" alt="Imagen ampliada">
    </div>

    <script>
        function mostrarImagen(src) {
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            lightboxImg.src = src;
            lightbox.style.display = 'block';
        }

        function cerrarLightbox() {
            document.getElementById('lightbox').style.display = 'none';
        }
    </script>
</body>
</html>