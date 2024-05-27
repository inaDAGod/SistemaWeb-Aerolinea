sudo -u postgres psql
CREATE DATABASE aerolinea;
\c aerolinea

CREATE TABLE vuelos (
    cvuelo SERIAL PRIMARY KEY,
    fecha_vuelo timestamp NOT NULL,
    costo money NOT NULL,
    origen varchar(100) NOT NULL,
    destino varchar(100) NOT NULL
);

CREATE TABLE asientos (
    casiento varchar(100) NOT NULL,
    cavion int NOT NULL,
    tipo_asiento varchar(100) NOT NULL,
    CONSTRAINT asientos_pk PRIMARY KEY (casiento,cavion)
);

CREATE TABLE asientos_vuelo (
    cvuelo int NOT NULL,
    casiento varchar(100) NOT NULL,
    cavion int NOT NULL,
    CONSTRAINT asientos_vuelo_pk PRIMARY KEY (cvuelo,casiento)
);

INSERT INTO vuelos (fecha_vuelo, costo, origen, destino) 
VALUES 
    ('2024-05-28 08:00:00', 500, 'La Paz', 'Cochabamba'),
    ('2024-05-29 09:30:00', 600, 'Tarija', 'Sucre'),
    ('2024-05-30 12:00:00', 700, 'Santa Cruz', 'Potosi');

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
    ('A9', 3, 'VIP');

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
    (3, 'A9', 3);

CREATE OR REPLACE VIEW vuelos_filtrados AS
SELECT
    v.cvuelo AS "Vuelo",
    v.origen AS "Origen",
    v.destino AS "Destino",
    EXTRACT(EPOCH FROM (v.fecha_vuelo + interval '1 hour' * (SELECT COUNT(*) FROM asientos_vuelo av WHERE av.cvuelo = v.cvuelo))) / 3600 AS "Duración (horas)",
    v.costo AS "Económico",
    v.costo * 1.8 AS "Normal",
    v.costo * 3 AS "VIP"
FROM
    vuelos v
    JOIN asientos_vuelo av ON v.cvuelo = av.cvuelo
GROUP BY
    v.cvuelo, v.origen, v.destino, v.fecha_vuelo, v.costo;

SELECT * FROM vuelos_filtrados;


