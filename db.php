<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Taqueria";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para crear un nuevo usuario
function crearUsuario($username, $password, $nombre, $apellido, $rol) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Usuarios (username, password, nombre, apellido, rol) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $username, password_hash($password, PASSWORD_DEFAULT), $nombre, $apellido, $rol);
    $stmt->execute();
    $stmt->close();
}

// Función para crear un nuevo pedido
function crearPedido($fecha, $hora) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Pedido (fecha, hora) VALUES (?, ?)");
    $stmt->bind_param("ss", $fecha, $hora);
    $stmt->execute();
    $stmt->close();
}

// Función para crear una nueva mesa
function crearMesa($num_mesa) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Mesas (num_mesa) VALUES (?)");
    $stmt->bind_param("i", $num_mesa);
    $stmt->execute();
    $stmt->close();
}

// Función para crear un nuevo producto
function crearProducto($nombre_producto, $descripcion, $precio, $tipo_producto) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Productos (nombre_producto, descripcion, precio, tipo_producto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nombre_producto, $descripcion, $precio, $tipo_producto);
    $stmt->execute();
    $stmt->close();
}

// Función para crear un nuevo complemento
function crearComplemento($nombre_complemento, $precio) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO Complementos (nombre_complemento, precio) VALUES (?, ?)");
    $stmt->bind_param("sd", $nombre_complemento, $precio);
    $stmt->execute();
    $stmt->close();
}

// Cerrar conexión
function cerrarConexion() {
    global $conn;
    $conn->close();
}
?>