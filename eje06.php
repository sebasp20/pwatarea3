<?php
session_start();

// Arreglo de usuarios (simulando una base de datos)
$usuarios = isset($_SESSION['usuarios']) ? $_SESSION['usuarios'] : array(
    array(
        'usuario' => 'admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
        'nombre' => 'Administrador'
    )
);

// Guardar el arreglo de usuarios en la sesión si no existe
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = $usuarios;
}

// Función para validar el login
function validarLogin($usuario, $password) {
    foreach ($_SESSION['usuarios'] as $user) {
        if ($user['usuario'] === $usuario && password_verify($password, $user['password'])) {
            return $user;
        }
    }
    return false;
}

// Procesar el formulario de login
$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $usuario_validado = validarLogin($usuario, $password);

    if ($usuario_validado) {
        $_SESSION['usuario_actual'] = $usuario_validado;
        header('Location: dashboard.php');
        exit;
    } else {
        $mensaje = 'Usuario o contraseña incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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

        .login-container {
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

        .error {
            color: #dc3545;
            text-align: center;
            margin-bottom: 1rem;
        }

        .registro-link {
            text-align: center;
        }

        .registro-link a {
            color: #4CAF50;
            text-decoration: none;
        }

        .registro-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar Sesión</h1>
        
        <?php if ($mensaje): ?>
            <div class="error"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Iniciar Sesión </button>
             
        </form>

        <div class="registro-link">
            <a href="registro.php">¿No tienes cuenta? Regístrate aquí</a>
        </div>
    </div>
</body>
</html>