--añadir una coluna a la tabla check_in sobre el estado del mismo

--está con varchar pero los datos que debe tener son solo PENDIENTE Y REALIZADO
alter table check_in
add column estado_checkin


--si tienen datos previos en sus bds y quieren añadir el estado del check-in para probarlo
--pueden usar

UPDATE check_in
SET estado_checkin = 'pendiente'
WHERE fecha_check_in BETWEEN '2024-06-015' AND '2024-06-20';

--o usar 
-- Marcar el check-in como "Realizado" para los pasajeros que han completado el check-in dentro del rango de fechas
UPDATE check_in
SET estado_checkin = 'Realizado'
WHERE fecha_check_in BETWEEN '2024-06-01' AND '2024-06-14';
