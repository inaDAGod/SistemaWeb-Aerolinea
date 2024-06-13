document.addEventListener('DOMContentLoaded', function() {
    fetchOpiniones();
});

function fetchOpiniones() {
    fetch('http://localhost/SistemaWeb-Aerolinea/backend/fetch_opiniones.php')
        .then(response => response.json())
        .then(data => {
            renderOpiniones(data);
        })
        .catch(error => console.error('Error:', error));
}

function renderOpiniones(opiniones) {
    const container = document.getElementById('opiniones-container');
    container.innerHTML = ''; // Limpiar el contenedor

    opiniones.forEach(opinion => {
        const opinionDiv = document.createElement('div');
        opinionDiv.className = 'col-md-6 mb-4';

        opinionDiv.innerHTML = `
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">${opinion.nombres_usuario} ${opinion.apellidos_usuario}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">${new Date(opinion.fecha_opinion).toLocaleDateString()}</h6>
                    <p class="card-text">${opinion.comentario}</p>
                    <div class="stars">
                        ${renderStars(opinion.estrellas)}
                    </div>
                </div>
            </div>
        `;

        container.appendChild(opinionDiv);
    });
}

function renderStars(estrellas) {
    let starsHtml = '';
    for (let i = 0; i < 5; i++) {
        if (i < estrellas) {
            starsHtml += '<i class="fas fa-star text-warning"></i>';
        } else {
            starsHtml += '<i class="far fa-star text-warning"></i>';
        }
    }
    return starsHtml;
}
