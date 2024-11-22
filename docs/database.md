# Database Script

``` 
-- Crear la base de datos
CREATE DATABASE Taqueria;
USE Taqueria;

-- Tabla de Usuarios
CREATE TABLE Usuarios (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    rol ENUM('admin', 'mesero', 'cajero', 'cocinero') NOT NULL
);

-- Tabla de Pedido
CREATE TABLE Pedido (
    id_pedido INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    b_cerrado BOOLEAN DEFAULT FALSE,
    b_pagado BOOLEAN DEFAULT FALSE
);

-- Tabla de Mesas
CREATE TABLE Mesas (
    num_mesa INT PRIMARY KEY,
    id_pedido INT NULL,
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido) ON DELETE SET NULL
);

-- Tabla de Historial de Pedido
CREATE TABLE Historial_Pedido (
    id_mesa INT NOT NULL,
    id_pedido INT NOT NULL,
    fecha DATE NOT NULL,
    PRIMARY KEY (id_mesa, id_pedido),
    FOREIGN KEY (id_mesa) REFERENCES Mesas(num_mesa),
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);

-- Tabla de Productos
CREATE TABLE Productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_producto VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    tipo_producto ENUM('bebida', 'taco', 'gringa', 'volcan', 'otro') NOT NULL
);

-- Tabla de Complementos
CREATE TABLE Complementos (
    id_complemento INT AUTO_INCREMENT PRIMARY KEY,
    nombre_complemento VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
);

-- Tabla de relación entre Productos y Complementos
CREATE TABLE Producto_Complemento (
    id_producto INT NOT NULL,
    id_complemento INT NOT NULL,
    PRIMARY KEY (id_producto, id_complemento),
    FOREIGN KEY (id_producto) REFERENCES Productos(id_producto) ON DELETE CASCADE,
    FOREIGN KEY (id_complemento) REFERENCES Complementos(id_complemento) ON DELETE CASCADE
);

-- Tabla de relación entre Pedido y Productos
CREATE TABLE Pedido_Producto (
    id_pedido INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL DEFAULT 1,
    complementos JSON,
    PRIMARY KEY (id_pedido, id_producto),
    FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES Productos(id_producto) ON DELETE CASCADE
);
```
