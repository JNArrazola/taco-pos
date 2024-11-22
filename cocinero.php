<?php
session_start();
require_once 'db.php';

// Verificar si el usuario ha iniciado sesión y es cocinero o administrador
if (!isset($_SESSION['username']) || ($_SESSION['rol'] !== 'cocinero' && $_SESSION['rol'] !== 'admin')) {
    echo "Acceso denegado. Solo los cocineros pueden acceder a esta página.";
    exit();
}

// Obtener todos los pedidos abiertos
$stmt = $conn->prepare("SELECT Pedido.id_pedido, Pedido.fecha, Pedido.hora, Productos.nombre_producto, Pedido_Producto.cantidad 
                        FROM Pedido 
                        JOIN Pedido_Producto ON Pedido.id_pedido = Pedido_Producto.id_pedido 
                        JOIN Productos ON Pedido_Producto.id_producto = Productos.id_producto 
                        WHERE Pedido.b_cerrado = FALSE");
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
    <title>Panel del Cocinero</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Panel del Cocinero</h1>
        <h2 class="text-2xl font-semibold mb-4">Pedidos Abiertos</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">ID Pedido</th>
                        <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Fecha</th>
                        <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Hora</th>
                        <th class="w-1/3 py-3 px-4 uppercase font-semibold text-sm">Producto</th>
                        <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Cantidad</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr class="border-b">
                            <td class="py-3 px-4"><?php echo $pedido['id_pedido']; ?></td>
                            <td class="py-3 px-4"><?php echo $pedido['fecha']; ?></td>
                            <td class="py-3 px-4"><?php echo $pedido['hora']; ?></td>
                            <td class="py-3 px-4"><?php echo $pedido['nombre_producto']; ?></td>
                            <td class="py-3 px-4"><?php echo $pedido['cantidad']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>