<?php
session_start();
require_once 'db.php';

// Verificar si el usuario ha iniciado sesión y es cajero o administrador
if (!isset($_SESSION['username']) || ($_SESSION['rol'] !== 'cajero' && $_SESSION['rol'] !== 'admin')) {
    echo "Acceso denegado. Solo los cajeros pueden acceder a esta página.";
    exit();
}

// Obtener todos los pedidos no pagados
$stmt = $conn->prepare("SELECT * FROM Pedido WHERE b_pagado = FALSE");
$stmt->execute();
$result = $stmt->get_result();
$pedidos = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Función para marcar un pedido como pagado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pedido'])) {
    $id_pedido = $_POST['id_pedido'];
    $stmt = $conn->prepare("UPDATE Pedido SET b_pagado = TRUE WHERE id_pedido = ?");
    $stmt->bind_param("i", $id_pedido);
    $stmt->execute();
    $stmt->close();
    header("Location: cajero.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Cajero</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Panel del Cajero</h1>
        <h2 class="text-2xl mb-4">Pedidos No Pagados</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">ID del Pedido</th>
                        <th class="px-4 py-2 border-b">Fecha</th>
                        <th class="px-4 py-2 border-b">Hora</th>
                        <th class="px-4 py-2 border-b">Cerrado</th>
                        <th class="px-4 py-2 border-b">Pagado</th>
                        <th class="px-4 py-2 border-b">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b"><?php echo $pedido['id_pedido']; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo $pedido['fecha']; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo $pedido['hora']; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo $pedido['b_cerrado'] ? 'Sí' : 'No'; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo $pedido['b_pagado'] ? 'Sí' : 'No'; ?></td>
                            <td class="px-4 py-2 border-b">
                                <form action="cajero.php" method="post">
                                    <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                    <input type="submit" value="Marcar como Pagado" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>