<?php
session_start();
require_once 'db.php';

// Verificar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['username']) || $_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden acceder a esta página.";
    exit();
}

// Obtener todos los usuarios
$stmt = $conn->prepare("SELECT username, nombre, apellido, rol FROM Usuarios");
$stmt->execute();
$result = $stmt->get_result();
$usuarios = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">
    <div class="bg-white shadow-md p-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold">Panel de Administración</h2>
        <form action="logout.php" method="post">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Cerrar Sesión</button>
        </form>
    </div>
    <div class="container mx-auto mt-10">
        <h1 class="text-2xl font-bold mb-6 text-center">Gestionar Usuarios</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Nombre de Usuario</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Nombre</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Apellido</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Rol</th>
                    <th class="py-2 px-4 border-b border-gray-200 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200"><?php echo $usuario['username']; ?></td>
                        <td class="py-2 px-4 border-b border-gray-200"><?php echo $usuario['nombre']; ?></td>
                        <td class="py-2 px-4 border-b border-gray-200"><?php echo $usuario['apellido']; ?></td>
                        <td class="py-2 px-4 border-b border-gray-200"><?php echo $usuario['rol']; ?></td>
                        <td class="py-2 px-4 border-b border-gray-200">
                            <button class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600" onclick="modificarUsuario('<?php echo $usuario['username']; ?>')">Modificar</button>
                            <button class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600" onclick="eliminarUsuario('<?php echo $usuario['username']; ?>')">Eliminar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        function modificarUsuario(username) {
            Swal.fire({
                title: 'Modificar Usuario',
                text: "¿Deseas modificar al usuario " + username + "?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, modificar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'modificar_usuario.php?username=' + username;
                }
            });
        }

        function eliminarUsuario(username) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'eliminar_usuario.php?username=' + username;
                }
            });
        }
    </script>
</body>
</html>