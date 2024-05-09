// Función para cargar la lista de personas al cargar la página
window.onload = function() {
    console.log("Cargando personas...");
    cargarPersonas();
};

function cargarPersonas() {
    fetch("http://localhost/SistemaWeb-Aerolinea/backend/listar_pasajeros.php")
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al obtener la lista de personas');
        }
        return response.json();
    })
    .then(data => {
        console.log("Datos de personas recibidos:", data);
        mostrarPersonas(data);
    })
    .catch(error => {
        console.error('Error al cargar personas:', error);
    });
}

function mostrarPersonas(personas) {
    console.log("Mostrando personas:", personas);
    const personasContainer = document.getElementById("personas-container");
    personasContainer.innerHTML = ""; // Limpiamos el contenido anterior

    // Crear una tabla para mostrar las personas
    const table = document.createElement("table");
    table.innerHTML = `
        <tr>
            <th>Cédula</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Fecha de Nacimiento</th>
            <th>Sexo</th>
            <th>País de Origen</th>
        </tr>
    `;

    // Agregar cada persona como una fila en la tabla
    personas.forEach(persona => {
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${persona.ci_persona}</td>
            <td>${persona.nombres}</td>
            <td>${persona.apellidos}</td>
            <td>${persona.fecha_nacimiento}</td>
            <td>${persona.sexo}</td>
            <td>${persona.pais_origen}</td>
        `;
        table.appendChild(row);
    });

    // Agregar la tabla al contenedor de personas
    personasContainer.appendChild(table);
}
