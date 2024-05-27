sudo -u postgres psql
CREATE DATABASE aerolinea;
\c aerolinea

-- Crear la tabla vuelos
CREATE TABLE vuelos (
    cvuelo SERIAL PRIMARY KEY,
    fecha_vuelo timestamp NOT NULL,
    costo money NOT NULL,
    origen varchar(100) NOT NULL,
    destino varchar(100) NOT NULL
);

-- Crear la tabla asientos
CREATE TABLE asientos (
    casiento varchar(100) NOT NULL,
    cavion int NOT NULL,
    tipo_asiento varchar(100) NOT NULL,
    CONSTRAINT asientos_pk PRIMARY KEY (casiento, cavion)
);

-- Crear la tabla asientos_vuelo
CREATE TABLE asientos_vuelo (
    cvuelo int NOT NULL,
    casiento varchar(100) NOT NULL,
    cavion int NOT NULL,
    CONSTRAINT asientos_vuelo_pk PRIMARY KEY (cvuelo, casiento)
);

-- Insertar datos en la tabla vuelos
INSERT INTO vuelos (fecha_vuelo, costo, origen, destino) 
VALUES 
    ('2024-05-28 08:00:00', 500, 'La Paz', 'Cochabamba'),
    ('2024-05-29 09:30:00', 600, 'Tarija', 'Sucre'),
    ('2024-05-30 12:00:00', 700, 'Santa Cruz', 'Potosi'),
    ('2024-06-01 14:00:00', 800, 'Oruro', 'La Paz'),
    ('2024-06-02 15:30:00', 550, 'Cochabamba', 'Santa Cruz'),
    ('2024-06-03 10:00:00', 650, 'Sucre', 'Tarija'),
    ('2024-06-04 11:45:00', 750, 'Potosi', 'Santa Cruz'),
    ('2024-06-05 13:20:00', 620, 'La Paz', 'Oruro');

-- Insertar datos en la tabla asientos
INSERT INTO asientos (casiento, cavion, tipo_asiento) 
VALUES 
    ('A1', 1, 'Económico'),
    ('A2', 1, 'Normal'),
    ('A3', 1, 'VIP'),
    ('A4', 2, 'Económico'),
    ('A5', 2, 'Normal'),
    ('A6', 2, 'VIP'),
    ('A7', 3, 'Económico'),
    ('A8', 3, 'Normal'),
    ('A9', 3, 'VIP'),
    ('B1', 4, 'Económico'),
    ('B2', 4, 'Normal'),
    ('B3', 4, 'VIP'),
    ('B4', 5, 'Económico'),
    ('B5', 5, 'Normal'),
    ('B6', 5, 'VIP'),
    ('B7', 6, 'Económico'),
    ('B8', 6, 'Normal'),
    ('B9', 6, 'VIP'),
    ('C1', 7, 'Económico'),
    ('C2', 7, 'Normal'),
    ('C3', 7, 'VIP'),
    ('C4', 8, 'Económico'),
    ('C5', 8, 'Normal'),
    ('C6', 8, 'VIP');

-- Insertar datos en la tabla asientos_vuelo
INSERT INTO asientos_vuelo (cvuelo, casiento, cavion)
VALUES 
    (1, 'A1', 1),
    (1, 'A2', 1),
    (1, 'A3', 1),
    (2, 'A4', 2),
    (2, 'A5', 2),
    (2, 'A6', 2),
    (3, 'A7', 3),
    (3, 'A8', 3),
    (3, 'A9', 3),
    (4, 'B1', 4),
    (4, 'B2', 4),
    (4, 'B3', 4),
    (5, 'B4', 5),
    (5, 'B5', 5),
    (5, 'B6', 5),
    (6, 'B7', 6),
    (6, 'B8', 6),
    (6, 'B9', 6),
    (7, 'C1', 7),
    (7, 'C2', 7),
    (7, 'C3', 7),
    (8, 'C4', 8),
    (8, 'C5', 8),
    (8, 'C6', 8);

CREATE OR REPLACE VIEW vuelos_filtrados AS
SELECT
    v.cvuelo AS "Vuelo",
    v.origen AS "Origen",
    v.destino AS "Destino",
    CONCAT(
        EXTRACT(HOUR FROM v.fecha_vuelo + interval '5 minute' * (SELECT COUNT(*) FROM asientos_vuelo av WHERE av.cvuelo = v.cvuelo)),
        'hrs ',
        EXTRACT(MINUTE FROM v.fecha_vuelo + interval '5 minute' * (SELECT COUNT(*) FROM asientos_vuelo av WHERE av.cvuelo = v.cvuelo)),
        'min'
    ) AS "Duración",
    v.costo * 7 AS "Económico",  -- Precio en bolivianos (Bs)
    v.costo * 1.8 * 7 AS "Normal",  -- Precio en bolivianos (Bs)
    v.costo * 3 * 7 AS "VIP"  -- Precio en bolivianos (Bs)
FROM
    vuelos v
    JOIN asientos_vuelo av ON v.cvuelo = av.cvuelo
GROUP BY
    v.cvuelo, v.origen, v.destino, v.fecha_vuelo, v.costo;

-- Seleccionar todos los datos de la vista vuelos_filtrados
SELECT * FROM vuelos_filtrados;


--DROP VIEW IF EXISTS vuelos_filtrados;

