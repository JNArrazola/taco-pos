<?php
session_start();
require_once 'db.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden acceder a esta página.";
    exit();
}

// Obtener el nombre de usuario del parámetro GET
if (!isset($_GET['username'])) {
    echo "Nombre de usuario no proporcionado.";
    exit();
}

$username = $_GET['username'];

// Obtener los datos del usuario
$stmt = $conn->prepare("SELECT username, nombre, apellido, rol FROM Usuarios WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();

if (!$usuario) {
    echo "Usuario no encontrado.";
    exit();
}

// Actualizar los datos del usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $rol = $_POST['rol'];

    $stmt = $conn->prepare("UPDATE Usuarios SET nombre = ?, apellido = ?, rol = ? WHERE username = ?");
    $stmt->bind_param("ssss", $nombre, $apellido, $rol, $username);
    $stmt->execute();
    $stmt->close();

    header("Location: gestionar_usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6 text-center">Modificar Usuario</h1>
        <form action="modificar_usuario.php?username=<?php echo $username; ?>" method="post" class="space-y-4">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="apellido" class="block text-sm font-medium text-gray-700">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $usuario['apellido']; ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="rol" class="block text-sm font-medium text-gray-700">Rol:</label>
                <select id="rol" name="rol" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="admin" <?php if ($usuario['rol'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="mesero" <?php if ($usuario['rol'] == 'mesero') echo 'selected'; ?>>Mesero</option>
                    <option value="cajero" <?php if ($usuario['rol'] == 'cajero') echo 'selected'; ?>>Cajero</option>
                    <option value="cocinero" <?php if ($usuario['rol'] == 'cocinero') echo 'selected'; ?>>Cocinero</option>
                </select>
            </div>
            <div>
                <input type="submit" value="Modificar" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            </div>
        </form>
    </div>
</body>
</html>