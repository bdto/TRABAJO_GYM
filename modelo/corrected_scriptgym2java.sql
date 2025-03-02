-- Creación de la tabla admins
CREATE TABLE IF NOT EXISTS admins (
    ID_Admin INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(50) NOT NULL
);

-- Creación de la tabla usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    genero ENUM('masculino', 'femenino', 'otro') NOT NULL,
    f_registro DATE NOT NULL,
    estado ENUM('activo', 'inactivo') NOT NULL,
    direccion VARCHAR(255),
    email VARCHAR(100)
);

-- Creación de la tabla pagos
CREATE TABLE IF NOT EXISTS pagos (
    id_pagos INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    id_admin INT NOT NULL,
    tipo_subscripcion VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    duracion INT NOT NULL,
    estado ENUM('pagado', 'pendiente') NOT NULL,
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    medio_pago VARCHAR(50) NOT NULL,
    id_cliente_adicional INT,
    FOREIGN KEY (id_cliente) REFERENCES usuarios(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_admin) REFERENCES admins(ID_Admin) ON DELETE RESTRICT,
    FOREIGN KEY (id_cliente_adicional) REFERENCES usuarios(id_cliente) ON DELETE SET NULL
);

-- Añadir índices para mejorar el rendimiento
CREATE INDEX idx_usuarios_estado ON usuarios(estado);
CREATE INDEX idx_pagos_fecha ON pagos(fecha_pago);
CREATE INDEX idx_pagos_cliente_admin ON pagos(id_cliente, id_admin);
CREATE INDEX idx_pagos_tipo_subscripcion ON pagos(tipo_subscripcion);
CREATE INDEX idx_pagos_estado ON pagos(estado);