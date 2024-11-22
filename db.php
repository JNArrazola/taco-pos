<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Taqueria";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create a new user
function createUser($username, $password, $nombre, $apellido, $rol) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Usuarios (username, password, nombre, apellido, rol) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, password_hash($password, PASSWORD_DEFAULT), $nombre, $apellido, $rol);
    $stmt->execute();
    $stmt->close();
}

// Function to create a new pedido
function createPedido($fecha, $hora) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Pedido (fecha, hora) VALUES (?, ?)");
    $stmt->bind_param("ss", $fecha, $hora);
    $stmt->execute();
    $stmt->close();
}

// Function to create a new mesa
function createMesa($num_mesa) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Mesas (num_mesa) VALUES (?)");
    $stmt->bind_param("i", $num_mesa);
    $stmt->execute();
    $stmt->close();
}

// Function to create a new producto
function createProducto($nombre_producto, $descripcion, $precio, $tipo_producto) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Productos (nombre_producto, descripcion, precio, tipo_producto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nombre_producto, $descripcion, $precio, $tipo_producto);
    $stmt->execute();
    $stmt->close();
}

// Function to create a new complemento
function createComplemento($nombre_complemento, $precio) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Complementos (nombre_complemento, precio) VALUES (?, ?)");
    $stmt->bind_param("sd", $nombre_complemento, $precio);
    $stmt->execute();
    $stmt->close();
}

// Close connection
function closeConnection() {
    global $conn;
    $conn->close();
}
?>