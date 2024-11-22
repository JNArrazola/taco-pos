<?php
session_start();
require_once 'db.php';

// Check if the user is logged in and is a mesero or an admin
if (!isset($_SESSION['username']) || ($_SESSION['rol'] !== 'mesero' && $_SESSION['rol'] !== 'admin')) {
    echo "Access denied. Only meseros or admin can access this page.";
    exit();
}

// Fetch all open orders
$stmt = $conn->prepare("SELECT * FROM Pedido WHERE b_cerrado = FALSE");
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
    <title>Mesero Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Mesero Dashboard</h1>
        <h2 class="text-2xl font-semibold mb-2">Open Orders</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">Order ID</th>
                        <th class="px-4 py-2 border-b">Date</th>
                        <th class="px-4 py-2 border-b">Time</th>
                        <th class="px-4 py-2 border-b">Closed</th>
                        <th class="px-4 py-2 border-b">Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border-b"><?php echo $pedido['id_pedido']; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo $pedido['fecha']; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo $pedido['hora']; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo $pedido['b_cerrado'] ? 'Yes' : 'No'; ?></td>
                            <td class="px-4 py-2 border-b"><?php echo $pedido['b_pagado'] ? 'Yes' : 'No'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>