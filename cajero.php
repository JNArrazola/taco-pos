<?php
session_start();
require_once 'db.php';

// Check if the user is logged in and is a cajero or admin
if (!isset($_SESSION['username']) || ($_SESSION['rol'] !== 'cajero' && $_SESSION['rol'] !== 'admin')) {
    echo "Access denied. Only cajeros can access this page.";
    exit();
}

// Fetch all unpaid orders
$stmt = $conn->prepare("SELECT * FROM Pedido WHERE b_pagado = FALSE");
$stmt->execute();
$result = $stmt->get_result();
$pedidos = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Function to mark an order as paid
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cajero Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Cajero Dashboard</h1>
        <h2 class="text-2xl mb-4">Unpaid Orders</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">Order ID</th>
                        <th class="px-4 py-2 border-b">Date</th>
                        <th class="px-4 py-2 border-b">Time</th>
                        <th class="px-4 py-2 border-b">Closed</th>
                        <th class="px-4 py-2 border-b">Paid</th>
                        <th class="px-4 py-2 border-b">Action</th>
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
                            <td class="px-4 py-2 border-b">
                                <form action="cajero.php" method="post">
                                    <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                    <input type="submit" value="Mark as Paid" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
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