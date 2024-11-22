<?php
session_start();
require_once 'db.php';

// Verificar si el usuario es un administrador
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden registrar nuevos usuarios.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $rol = $_POST['rol'];

    // Verificar si el nombre de usuario ya existe
    $stmt = $conn->prepare("SELECT username FROM Usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "El nombre de usuario ya existe.";
    } else {
        // Crear el nuevo usuario
        createUser($username, $password, $nombre, $apellido, $rol);
        $success = "Usuario registrado exitosamente.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justificar-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Registrar un Nuevo Usuario</h1>
            <?php if (isset($error)): ?>
                <p class="text-red-500 mb-4"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if (isset($success)): ?>
                <p class="text-green-500 mb-4"><?php echo $success; ?></p>
            <?php endif; ?>
            <form action="registro.php" method="post" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña:</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="rol" class="block text-sm font-medium text-gray-700">Rol:</label>
                    <select id="rol" name="rol" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="admin">Admin</option>
                        <option value="mesero">Mesero</option>
                        <option value="cajero">Cajero</option>
                        <option value="cocinero">Cocinero</option>
                    </select>
                </div>
                <div>
                    <input type="submit" value="Registrar" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                </div>
            </form>
        </div>
    </div>
</body>
</html>