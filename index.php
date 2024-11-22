<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Verificar si el usuario es un administrador
if ($_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden registrar nuevos usuarios.";
    exit();
}

// Si el usuario es un administrador, mostrar el formulario de registro
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold mb-6 text-center">Registrar un Nuevo Usuario</h1>
            <form action="registro.php" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Contraseña:</label>
                    <input type="password" id="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="apellido" class="block text-gray-700">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="rol" class="block text-gray-700">Rol:</label>
                    <select id="rol" name="rol" required class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="admin">Admin</option>
                        <option value="mesero">Mesero</option>
                        <option value="cajero">Cajero</option>
                        <option value="cocinero">Cocinero</option>
                    </select>
                </div>
                <div class="text-center">
                    <input type="submit" value="Registrar" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </form>
        </div>
    </div>
</body>
</html>