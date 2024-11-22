<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Redirigir según el rol del usuario
switch ($_SESSION['rol']) {
    case 'admin':
        header("Location: admin.php");
        break;
    case 'mesero':
        header("Location: mesero.php");
        break;
    case 'cajero':
        header("Location: cajero.php");
        break;
    case 'cocinero':
        header("Location: cocinero.php");
        break;
    default:
        header("Location: login.php");
        break;
}
exit();
?>