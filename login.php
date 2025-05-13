<?php
session_start();

// Inicializar el arreglo de usuarios si no existe
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = array(
        array(
            'usuario' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'nombre' => 'Administrador'
        )
    );
}

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_usuario = $_POST['usuario'];
    $nueva_password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];
    $nombre = $_POST['nombre'];

    // Verificar si el usuario ya existe
    $usuario_existe = false;
    foreach ($_SESSION['usuarios'] as $user) {
        if ($user['usuario'] === $nuevo_usuario) {
            $usuario_existe = true;
            break;
        }
    }

    if ($usuario_existe) {
        $mensaje = 'El nombre de usuario ya está en uso';
        $tipo_mensaje = 'error';
    } elseif ($nueva_password !== $confirmar_password) {
        $mensaje = 'Las contraseñas no coinciden';
        $tipo_mensaje = 'error';
    } else {
        // Agregar nuevo usuario
        $_SESSION['usuarios'][] = array(
            'usuario' => $nuevo_usuario,
            'password' => password_hash($nueva_password, PASSWORD_DEFAULT),
            'nombre' => $nombre
        );
        $mensaje = 'Usuario registrado exitosamente';
        $tipo_mensaje = 'exito';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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

        .registro-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }

        input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 1rem;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
            margin-bottom: 1rem;
        }

        button:hover {
            background: #45a049;
        }

        .mensaje {
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 4px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .exito {
            background: #d4edda;
            color: #155724;
        }

        .login-link {
            text-align: center;
        }

        .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="registro-container">
        <h1>Registro de Usuario</h1>

        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre completo:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="usuario">Nombre de usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirmar_password">Confirmar contraseña:</label>
                <input type="password" id="confirmar_password" name="confirmar_password" required>
            </div>

            <button type="submit">Registrarse</button>
        </form>

        <div class="login-link">
            <a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí</a>
        </div>
    </div>
</body>
</html>