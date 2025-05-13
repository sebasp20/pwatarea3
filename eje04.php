<?php
session_start();

// Inicializar el número aleatorio si no existe
if (!isset($_SESSION['numero_secreto'])) {
    $_SESSION['numero_secreto'] = rand(1, 100);
    $_SESSION['intentos'] = 0;
}

// Procesar el intento si se envió un número
$mensaje = '';
$clase_mensaje = '';
if (isset($_POST['intento'])) {
    $_SESSION['intentos']++;
    $intento = (int)$_POST['intento'];
    
    if ($intento == $_SESSION['numero_secreto']) {
        $mensaje = "¡Felicitaciones! Has adivinado el número en {$_SESSION['intentos']} intentos.";
        $clase_mensaje = 'exito';
        // Reiniciar el juego
        $_SESSION['numero_secreto'] = rand(1, 100);
        $_SESSION['intentos'] = 0;
    } else {
        $pista = ($intento < $_SESSION['numero_secreto']) ? 'mayor' : 'menor';
        $mensaje = "Incorrecto. El número es $pista que tu intento.";
        $clase_mensaje = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Adivinanzas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contenedor {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .instrucciones {
            color: #666;
            margin-bottom: 2rem;
        }

        input[type="number"] {
            width: 100px;
            padding: 10px;
            font-size: 1.2rem;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
            text-align: center;
        }

        button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background: #45a049;
        }

        .mensaje {
            margin-top: 1.5rem;
            padding: 1rem;
            border-radius: 5px;
        }

        .exito {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        #intentos {
            margin-top: 1rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Juego de Adivinanzas</h1>
        <p class="instrucciones">Adivina el número entre 1 y 100</p>

        <form method="POST" onsubmit="return validarIntento()">
            <input type="number" name="intento" id="intento" min="1" max="100" required>
            <button type="submit">Adivinar</button>
        </form>

        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo $clase_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <div id="intentos">
            Intentos: <?php echo $_SESSION['intentos']; ?>
        </div>
    </div>

    <script>
        function validarIntento() {
            const intento = document.getElementById('intento').value;
            if (intento < 1 || intento > 100) {
                alert('Por favor, ingresa un número entre 1 y 100');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>