-- Creación de la tabla admins
CREATE TABLE IF NOT EXISTS admins (
    ID_Admin INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(50) NOT NULL
);

-- Creación de la tabla pagos
CREATE TABLE IF NOT EXISTS pagos (
    id_pagos INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_admin INT NOT NULL,
    tipo_subscripcion VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    duracion INT NOT NULL,
    estado ENUM('activo', 'inactivo') NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES usuarios(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_admin) REFERENCES admins(ID_Admin) ON DELETE SET NULL
);

-- Creación de la tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    genero ENUM('masculino', 'femenino') NOT NULL,
    f_registro DATE NOT NULL,
    estado ENUM('activo', 'inactivo') NOT NULL
);
