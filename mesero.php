<?php
session_start();
require_once 'db.php';

// Verificar si el usuario ha iniciado sesión y es mesero o administrador
if (!isset($_SESSION['username']) || ($_SESSION['rol'] !== 'mesero' && $_SESSION['rol'] !== 'admin')) {
    echo "Acceso denegado. Solo los meseros o administradores pueden acceder a esta página.";
    exit();
}

// Obtener todas las órdenes abiertas
$stmt = $conn->prepare("SELECT * FROM Pedido WHERE b_cerrado = FALSE");
$stmt->execute();
$result = $stmt->get_result();
$pedidos = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Mesero</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Panel de Mesero</h1>
        <h2 class="text-2xl font-semibold mb-2">Órdenes Abiertas</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">ID de Orden</th>
                        <th class="px-4 py-2 border-b">Fecha</th>
                        <th class="px-4 py-2 border-b">Hora</th>
                        <th class="px-4 py-2 border-b">Cerrado</th>
                        <th class="px-4 py-2 border-b">Pagado</th>
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
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>