-- Crear la base de datos (si aún no existe)
CREATE DATABASE aerolinea;

-- Conectarse a la base de datos
\c aerolinea

-- Crear la tabla Vuelos con la columna codigo_vuelo
CREATE TABLE Vuelos (
    id SERIAL PRIMARY KEY,
    codigo_vuelo VARCHAR(10) NOT NULL,
    origen VARCHAR(100) NOT NULL,
    destino VARCHAR(100) NOT NULL,
    fecha_partida TIMESTAMP NOT NULL,
    fecha_llegada TIMESTAMP NOT NULL,
    precio_economico DECIMAL(10, 2) NOT NULL,
    precio_normal DECIMAL(10, 2) NOT NULL,
    precio_vip DECIMAL(10, 2) NOT NULL,
    tipo_vuelo VARCHAR(10) NOT NULL
);

-- Insertar más datos de ejemplo con precios para cada clase
INSERT INTO Vuelos (codigo_vuelo, origen, destino, fecha_partida, fecha_llegada, precio_economico, precio_normal, precio_vip, tipo_vuelo) VALUES
-- Vuelos para el 3 de junio de 2024
('VUE1007', 'Santa Cruz', 'Cochabamba', '2024-06-03 08:00:00', '2024-06-03 09:00:00', 50.00, 90.00, 150.00, 'ida_vuelta'),
('VUE1008', 'Cochabamba', 'Santa Cruz', '2024-06-03 17:00:00', '2024-06-03 18:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),

-- Vuelos para el 4 de junio de 2024
('VUE1009', 'La Paz', 'Santa Cruz', '2024-06-04 10:00:00', '2024-06-04 13:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),
('VUE1010', 'La Paz', 'Cochabamba', '2024-06-04 14:00:00', '2024-06-04 15:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),
('VUE1011', 'Santa Cruz', 'La Paz', '2024-06-04 09:00:00', '2024-06-04 11:00:00', 70.00, 110.00, 170.00, 'ida'),

-- Vuelos para el 5 de junio de 2024
('VUE1012', 'Cochabamba', 'La Paz', '2024-06-05 07:00:00', '2024-06-05 08:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1013', 'La Paz', 'Santa Cruz', '2024-06-05 12:00:00', '2024-06-05 14:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),
('VUE1014', 'Cochabamba', 'Santa Cruz', '2024-06-05 19:00:00', '2024-06-05 20:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),

-- Vuelos para el 6 de junio de 2024
('VUE1015', 'Santa Cruz', 'Cochabamba', '2024-06-06 08:00:00', '2024-06-06 09:00:00', 50.00, 90.00, 150.00, 'ida_vuelta'),
('VUE1016', 'Cochabamba', 'La Paz', '2024-06-06 14:00:00', '2024-06-06 15:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),
('VUE1017', 'La Paz', 'Santa Cruz', '2024-06-06 20:00:00', '2024-06-06 22:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),

-- Vuelos para el 7 de junio de 2024
('VUE1018', 'La Paz', 'Cochabamba', '2024-06-07 07:00:00', '2024-06-07 08:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),
('VUE1019', 'Cochabamba', 'Santa Cruz', '2024-06-07 12:00:00', '2024-06-07 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1020', 'Santa Cruz', 'La Paz', '2024-06-07 18:00:00', '2024-06-07 20:00:00', 70.00, 110.00, 170.00, 'ida'),

-- Vuelos para el 8 de junio de 2024
('VUE1021', 'Cochabamba', 'La Paz', '2024-06-08 08:00:00', '2024-06-08 09:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1022', 'Santa Cruz', 'Cochabamba', '2024-06-08 13:00:00', '2024-06-08 14:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1023', 'La Paz', 'Santa Cruz', '2024-06-08 19:00:00', '2024-06-08 21:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),

-- Vuelos para el 9 de junio de 2024
('VUE1024', 'Santa Cruz', 'La Paz', '2024-06-09 07:00:00', '2024-06-09 09:00:00', 70.00, 110.00, 170.00, 'ida'),
('VUE1025', 'Cochabamba', 'Santa Cruz', '2024-06-09 12:00:00', '2024-06-09 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1026', 'La Paz', 'Cochabamba', '2024-06-09 18:00:00', '2024-06-09 19:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),

-- Vuelos para el 10 de junio de 2024
('VUE1027', 'La Paz', 'Santa Cruz', '2024-06-10 08:00:00', '2024-06-10 10:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),
('VUE1028', 'Santa Cruz', 'La Paz', '2024-06-10 14:00:00', '2024-06-10 16:00:00', 70.00, 110.00, 170.00, 'ida_vuelta'),
('VUE1029', 'Cochabamba', 'La Paz', '2024-06-10 20:00:00', '2024-06-10 21:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),

-- Vuelos para el 11 de junio de 2024
('VUE1030', 'Santa Cruz', 'Cochabamba', '2024-06-11 07:00:00', '2024-06-11 08:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1031', 'Cochabamba', 'Santa Cruz', '2024-06-11 12:00:00', '2024-06-11 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1032', 'La Paz', 'Santa Cruz', '2024-06-11 18:00:00', '2024-06-11 20:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),

-- Vuelos para el 12 de junio de 2024
('VUE1033', 'Cochabamba', 'La Paz', '2024-06-12 08:00:00', '2024-06-12 09:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1034', 'Santa Cruz', 'Cochabamba', '2024-06-12 13:00:00', '2024-06-12 14:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1035', 'La Paz', 'Santa Cruz', '2024-06-12 19:00:00', '2024-06-12 21:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),

-- Vuelos para el 13 de junio de 2024
('VUE1036', 'Santa Cruz', 'La Paz', '2024-06-13 07:00:00', '2024-06-13 09:00:00', 70.00, 110.00, 170.00, 'ida'),
('VUE1037', 'Cochabamba', 'Santa Cruz', '2024-06-13 12:00:00', '2024-06-13 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1038', 'La Paz', 'Cochabamba', '2024-06-13 18:00:00', '2024-06-13 19:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),

-- Vuelos para el 14 de junio de 2024
('VUE1039', 'La Paz', 'Santa Cruz', '2024-06-14 08:00:00', '2024-06-14 10:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),
('VUE1040', 'Santa Cruz', 'Cochabamba', '2024-06-14 14:00:00', '2024-06-14 16:00:00', 70.00, 110.00, 170.00, 'ida_vuelta'),
('VUE1041', 'Cochabamba', 'Santa Cruz', '2024-06-14 20:00:00', '2024-06-14 21:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),

-- Vuelos para el 15 de junio de 2024
('VUE1042', 'Santa Cruz', 'La Paz', '2024-06-15 07:00:00', '2024-06-15 08:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1043', 'Cochabamba', 'La Paz', '2024-06-15 12:00:00', '2024-06-15 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1044', 'La Paz', 'Cochabamba', '2024-06-15 18:00:00', '2024-06-15 20:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),

-- Vuelos para el 16 de junio de 2024
('VUE1045', 'Cochabamba', 'Santa Cruz', '2024-06-16 08:00:00', '2024-06-16 09:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1046', 'La Paz', 'Santa Cruz', '2024-06-16 14:00:00', '2024-06-16 16:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),
('VUE1047', 'Santa Cruz', 'Cochabamba', '2024-06-16 20:00:00', '2024-06-16 21:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),

-- Vuelos para el 17 de junio de 2024
('VUE1048', 'La Paz', 'Cochabamba', '2024-06-17 07:00:00', '2024-06-17 08:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),
('VUE1049', 'Cochabamba', 'Santa Cruz', '2024-06-17 12:00:00', '2024-06-17 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1050', 'Santa Cruz', 'La Paz', '2024-06-17 18:00:00', '2024-06-17 20:00:00', 70.00, 110.00, 170.00, 'ida'),

-- Vuelos para el 18 de junio de 2024
('VUE1051', 'Cochabamba', 'La Paz', '2024-06-18 08:00:00', '2024-06-18 09:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1052', 'Santa Cruz', 'Cochabamba', '2024-06-18 13:00:00', '2024-06-18 14:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1053', 'La Paz', 'Santa Cruz', '2024-06-18 19:00:00', '2024-06-18 21:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),

-- Vuelos para el 19 de junio de 2024
('VUE1054', 'Santa Cruz', 'La Paz', '2024-06-19 07:00:00', '2024-06-19 09:00:00', 70.00, 110.00, 170.00, 'ida'),
('VUE1055', 'Cochabamba', 'Santa Cruz', '2024-06-19 12:00:00', '2024-06-19 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1056', 'La Paz', 'Cochabamba', '2024-06-19 18:00:00', '2024-06-19 19:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),

-- Vuelos para el 20 de junio de 2024
('VUE1057', 'La Paz', 'Santa Cruz', '2024-06-20 08:00:00', '2024-06-20 10:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),
('VUE1058', 'Santa Cruz', 'Cochabamba', '2024-06-20 14:00:00', '2024-06-20 16:00:00', 70.00, 110.00, 170.00, 'ida_vuelta'),
('VUE1059', 'Cochabamba', 'Santa Cruz', '2024-06-20 20:00:00', '2024-06-20 21:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),

-- Vuelos para el 21 de junio de 2024
('VUE1060', 'Santa Cruz', 'La Paz', '2024-06-21 07:00:00', '2024-06-21 08:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1061', 'Cochabamba', 'La Paz', '2024-06-21 12:00:00', '2024-06-21 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1062', 'La Paz', 'Cochabamba', '2024-06-21 18:00:00', '2024-06-21 20:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),

-- Vuelos para el 22 de junio de 2024
('VUE1063', 'Cochabamba', 'Santa Cruz', '2024-06-22 08:00:00', '2024-06-22 09:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1064', 'La Paz', 'Santa Cruz', '2024-06-22 14:00:00', '2024-06-22 16:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),
('VUE1065', 'Santa Cruz', 'Cochabamba', '2024-06-22 20:00:00', '2024-06-22 21:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),

-- Vuelos para el 23 de junio de 2024
('VUE1066', 'La Paz', 'Cochabamba', '2024-06-23 07:00:00', '2024-06-23 08:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),
('VUE1067', 'Cochabamba', 'Santa Cruz', '2024-06-23 12:00:00', '2024-06-23 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1068', 'Santa Cruz', 'La Paz', '2024-06-23 18:00:00', '2024-06-23 20:00:00', 70.00, 110.00, 170.00, 'ida'),

-- Vuelos para el 24 de junio de 2024
('VUE1069', 'Cochabamba', 'La Paz', '2024-06-24 08:00:00', '2024-06-24 09:00:00', 50.00, 90.00, 150.00, 'ida'),
('VUE1070', 'Santa Cruz', 'Cochabamba', '2024-06-24 13:00:00', '2024-06-24 14:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1071', 'La Paz', 'Santa Cruz', '2024-06-24 19:00:00', '2024-06-24 21:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),

-- Vuelos para el 25 de junio de 2024
('VUE1072', 'Santa Cruz', 'La Paz', '2024-06-25 07:00:00', '2024-06-25 09:00:00', 70.00, 110.00, 170.00, 'ida'),
('VUE1073', 'Cochabamba', 'Santa Cruz', '2024-06-25 12:00:00', '2024-06-25 13:00:00', 55.00, 95.00, 155.00, 'ida_vuelta'),
('VUE1074', 'La Paz', 'Cochabamba', '2024-06-25 18:00:00', '2024-06-25 19:00:00', 45.00, 85.00, 145.00, 'ida_vuelta'),

-- Vuelos para el 26 de junio de 2024
('VUE1075', 'La Paz', 'Santa Cruz', '2024-06-26 08:00:00', '2024-06-26 10:00:00', 60.00, 100.00, 160.00, 'ida_vuelta'),
('VUE1076', 'Santa Cruz', 'Cochabamba', '2024-06-26 14:00:00', '2024-06-26 16:00:00', 70.00, 110.00, 170.00, 'ida_vuelta'),
('VUE1077', 'Cochabamba', 'La Paz', '2024-06-26 20:00:00', '2024-06-26 21:00:00', 55.00, 95.00, 155.00, 'ida_vuelta');

--respaldo para vuelos
-- Conectarse a la base de datos
\c ae

CREATE TABLE Vuelos (
    codigo_vuelo SERIAL PRIMARY KEY,
    origen VARCHAR(100),
    destino VARCHAR(100),
    duracion VARCHAR(50),
    precio_economico DECIMAL(10, 2),
    precio_normal DECIMAL(10, 2),
    precio_vip DECIMAL(10, 2)
);
INSERT INTO Vuelos (origen, destino, duracion, precio_economico, precio_normal, precio_vip) VALUES
('Santa Cruz', 'La Paz', '2 horas', 150.00, 200.00, 300.00),
('Cochabamba', 'Sucre', '1.5 horas', 120.00, 180.00, 280.00),
('La Paz', 'Tarija', '3 horas', 220.00, 280.00, 380.00),
('Sucre', 'Cochabamba', '1.5 horas', 120.00, 180.00, 280.00),
('Tarija', 'Santa Cruz', '2.5 horas', 180.00, 250.00, 350.00);
