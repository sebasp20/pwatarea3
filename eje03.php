<?php
session_start();

// Función para leer el contador desde el archivo
function leerContador() {
    $archivo = 'contador.txt';
    if (file_exists($archivo)) {
        return (int)file_get_contents($archivo);
    }
    return 0;
}

// Función para guardar el contador en el archivo
function guardarContador($contador) {
    $archivo = 'contador.txt';
    file_put_contents($archivo, $contador);
}

// Obtener el valor actual del contador
$contador = leerContador();

// Verificar si es una nueva visita
if (!isset($_SESSION['visitado'])) {
    $contador++;
    guardarContador($contador);
    $_SESSION['visitado'] = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador de Visitas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }

        .contador-container {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .numero {
            font-size: 4rem;
            color: #2ecc71;
            font-weight: bold;
            margin: 20px 0;
        }

        .texto {
            color: #666;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="contador-container">
        <h1>Contador de Visitas</h1>
        <div class="numero"><?php echo $contador; ?></div>
        <p class="texto">visitas totales</p>
    </div>
</body>
</html>