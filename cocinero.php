<?php
session_start();
require_once 'db.php';

// Check if the user is logged in and is a cocinero or admin
if (!isset($_SESSION['username']) || ($_SESSION['rol'] !== 'cocinero' && $_SESSION['rol'] !== 'admin')) {
    echo "Access denied. Only cocineros can access this page.";
    exit();
}

// Fetch all open orders
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cocinero Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Cocinero Dashboard</h1>
        <h2 class="text-2xl font-semibold mb-4">Open Orders</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Order ID</th>
                        <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Date</th>
                        <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Time</th>
                        <th class="w-1/3 py-3 px-4 uppercase font-semibold text-sm">Product</th>
                        <th class="w-1/6 py-3 px-4 uppercase font-semibold text-sm">Quantity</th>
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