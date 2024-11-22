<?php
session_start();
require_once 'db.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden acceder a esta página.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow-md p-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Panel de Administración</h2>
        <form action="logout.php" method="post">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Cerrar Sesión</button>
        </form>
    </div>

    <div class="container mx-auto mt-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Panel para ir a registro.php -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Registrar Usuario</h2>
                <a href="registro.php" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 block text-center">Registrar Usuario</a>
            </div>

            <!-- Panel para ir a cajero.php -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Ir a Cajero</h2>
                <a href="cajero.php" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 block text-center">Ir a Cajero</a>
            </div>

            <!-- Panel para ir a mesero.php -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Ir a Mesero</h2>
                <a href="mesero.php" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 block text-center">Ir a Mesero</a>
            </div>

            <!-- Panel para ir a cocinero.php -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Ir a Cocinero</h2>
                <a href="cocinero.php" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 block text-center">Ir a Cocinero</a>
            </div>

            <!-- Panel para gestionar usuarios -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold mb-4">Gestionar Usuarios</h2>
                <a href="gestionar_usuarios.php" class="w-full bg-yellow-600 text-white py-2 px-4 rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 block text-center">Gestionar Usuarios</a>
            </div>
        </div>
    </div>
</body>
</html>