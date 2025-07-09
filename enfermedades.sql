-- Crear base de datos
CREATE DATABASE IF NOT EXISTS practica DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
USE practica;

-- Tabla Enfermedades
CREATE TABLE IF NOT EXISTS Enfermedades(
    id_enfermedades INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(100) NOT NULL,
    gravedad VARCHAR(100) NOT NULL
);

INSERT INTO Enfermedades (descripcion, gravedad) VALUES
('Leucemia', 'Alta'),
('Cáncer de páncreas', 'Alta'),
('Cáncer de mamas', 'Alta'),
('Gripe', 'Baja'),
('Dengue', 'Media');

-- Tabla Pacientes con el atributo calculado para la edad
CREATE TABLE IF NOT EXISTS Pacientes (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    correo VARCHAR(100),
    fecha_nacimiento DATE,
    id_enfermedades INT,
    telefonos VARCHAR(255), -- Atributo multivalorado: varios teléfonos separados por comas
    FOREIGN KEY (id_enfermedades) REFERENCES Enfermedades(id_enfermedades)
);

INSERT INTO Pacientes (nombres, apellidos, correo, fecha_nacimiento, id_enfermedades, telefonos) VALUES
('Camila Sofia','Estrada Herrera', 'camiestra@gmail.com', '1999-05-14', 1, '987743321,987744332'),
('Ana Ines', 'Perez Aliaga', 'ana.perez@gmail.com', '1980-10-18', 2, '940012345'),
('Samnda Paola','Vergara Menor', 'samndmenor@gmail.com', '2002-05-20', 3, '900773321'),
('Paola Lorena', 'Felipe Palacios', 'paolfeli@gmail.com', '2001-10-26', 4, '940888345'),
('Miguel Angel', 'Palacios Paredes', 'miguelangelp@gmail.com', '2005-12-20', 5, '940882345'),
('Karen Karolay','Ramírez Bejarano', '202014048@gmail.com', '2002-10-15', 5, '977715661');
