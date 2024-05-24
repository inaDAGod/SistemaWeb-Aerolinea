document.addEventListener('DOMContentLoaded', function () {
    fetch('http://localhost/SistemaWeb-Aerolinea/backend/fetch_awards.php')
        .then(response => response.json())
        .then(data => {
            const cardsContainer = document.querySelector('.cards');
            cardsContainer.innerHTML = ''; // Limpiar cualquier contenido previo

            data.forEach(award => {
                const col = document.createElement('div');
                col.className = 'col-12 col-sm-6 col-md-4 col-lg-3 mb-4';

                const card = document.createElement('div');
                card.className = 'card h-100';

                const img = document.createElement('img');
                img.src = award.src_foto;
                img.className = 'card-img-top';
                img.alt = award.premio;

                const cardBody = document.createElement('div');
                cardBody.className = 'card-body';

                const cardTitle = document.createElement('h5');
                cardTitle.className = 'card-title';
                cardTitle.textContent = award.premio;

                const tipoPremio = document.createElement('span');
                tipoPremio.className = 'badge badge-pill badge-orange';
                tipoPremio.textContent = award.tipo_premio;

                const cardText = document.createElement('p');
                cardText.className = 'card-text';
                cardText.textContent = `Millas: ${award.millas}`;

                cardBody.appendChild(cardTitle);
                cardBody.appendChild(cardText);
                cardBody.appendChild(tipoPremio);

                if (award.producto_destacado === 't') {
                    const destacado = document.createElement('span');
                    destacado.className = 'bi bi-star-fill star';
                    cardBody.appendChild(destacado);
                }

                

                card.appendChild(img);
                card.appendChild(cardBody);

                col.appendChild(card);
                cardsContainer.appendChild(col);
            });
        })
        .catch(error => console.error('Error:', error));
});
