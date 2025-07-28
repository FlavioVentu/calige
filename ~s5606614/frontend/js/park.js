const main = document.getElementById("parco");
const heading = document.getElementById("titolo"); // titolo parco
const descrizione = document.getElementById("descrizione");
const city = document.getElementById("city");
const valutazione = document.getElementById("valutazione");
const recensioni = document.getElementById("recensioni");
const titolo = (new URLSearchParams(window.location.search)).get("titolo");


// settiamo lo sfondo della pagina
main.style.backgroundRepeat = "no-repeat";
main.style.backgroundSize = "cover";
main.style.backgroundPosition = "center center";

// al caricamento della pagina facciamo una chiamata all'api passando il parametro get trovato nell'url
document.addEventListener("DOMContentLoaded", () => {

    fetch(`/~s5606614/backend/api/get_park.php?titolo=${titolo}`, {
        method: "GET"
    }).then(async response => {

        const data = await response.json();

        if (response.ok) {

            // caso CaliSuaro => logo, altrimenti carico l'immagine del parco sullo sfondo
            if (titolo === "CaliSauro") {
                main.style.backgroundImage = `url(../images/CaliSauro.jpg)`;
            } else {
                main.style.backgroundImage = `url(../images/parchi/${data.properties.immagine})`;
            }

            // salviamo la latitudine e longitudine dal GeoJson
            const lat = parseFloat(data.geometry.coordinates[1]);
            const lon = parseFloat(data.geometry.coordinates[0]);

            // costruiamo la mappa centrata sulle coordinate
            const map = L.map('map').setView([lon, lat], 15);

            // creazione del tile
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // icona sulla mappa che punta alle coordinate del parco (con popup del titolo e città)
            L.marker([lon, lat])
                .addTo(map)
                .bindPopup(`<strong>${titolo}</strong><br>${data.properties.città}`)
                .openPopup();

            // scriviamo dentro gli elementi che fanno da contenitore per titolo e descrizione
            heading.innerText = titolo;
            descrizione.innerText = data.properties.descrizione;
            city.innerHTML += data.properties.città;
            if (data.properties.valutazione) {
                valutazione.innerHTML += data.properties.valutazione + '/5 su ' + data.properties.num + ' recensioni';
            } else {
                valutazione.innerHTML += data.properties.num + ' recensioni';
                recensioni.classList.add("disabled");
            }

        } else {

            // carichiamo come sfondo una immagine default e stampiamo un messaggio di errore
            main.style.backgroundImage = `url(../images/parco.jpg`;
            main.innerHTML = `<h2 class="alert alert-danger">${data.message}</h2>`;

            // dopo 1 secondo mandiamo alla home page
            setTimeout(() => {
                window.location.href = "/~s5606614/";
            }, 1000);
        }
    }).catch(error => console.log(error));
});


recensioni.addEventListener("click", () => {

    fetch(`/~s5606614/backend/api/get_reviews.php?titolo=${titolo}`, {
        method: "GET"
    }).then(async response => {

        const data = await response.json();

        if (response.ok) {

            data.data.forEach((recensione) => {
                main.innerHTML += `<div class="row col-10 col-lg-5 justify-content-center py-2">
            <div class="py-3 px-3 cali_color border rounded-4 shadow-lg">
                <div class="card cali_color text-white p-3">
                    <div class="card-body">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0"><i class="bi bi-person-fill me-3"></i>${recensione.autore}</h3>
                            <p class="card-text d-sm-inline lh-lg"><b>${recensione.punteggio}<i class="bi bi-star-fill text-warning ms-2"></i></b></p>
                        </div>
                        <hr>
                        <p class="card-text lh-lg" id="testo">${recensione.testo}</p>
                        <hr>
                        <p class="card-text lh-lg" id="data"><b><i class="bi bi-calendar-fill me-2"></i>${recensione.data}</b></p>

                    </div>
                </div>
            </div>
        </div>`
            });
        } else {

            main.innerHTML += `<h2 class="alert alert-danger">${data.message}</h2>`;

        }
    }).catch(error => console.log(error));
});

// PARTE INVIO RECENSIONE
const form = document.querySelector("form");
const text = form.testo;

form.addEventListener('submit', (event) => {

    // annulliamo il comportamento predefinito del form
    event.preventDefault();


    // prepariamo i dati da inviare nel body della richiesta http
    const formData = new URLSearchParams();
    formData.append("punteggio", form.stars.value);

    if ((text.value.trim()) !== 0) {
        formData.append("testo", text.value);
    }

    fetch(`/~s5606614/backend/api/add_review.php?titolo=${titolo}`, {
        method: "POST",
        headers: {
            "Content-type": "application/x-www-form-urlencoded"
        },
        body: formData
    }).then(async response => {

        const data = await response.json();

        if (response.ok) {
            location.reload(true);
        } else {
            form.innerHTML += `<h2>${data.message}</h2>`;
        }
    }).catch(error => console.log(error))
});

const rangeInput = document.getElementById('stars');
const rangeOutput = document.getElementById('range');

rangeOutput.textContent = rangeInput.value;

rangeInput.addEventListener('input', function () {
    rangeOutput.innerHTML = this.value + `<i class="bi bi-star-fill text-warning ms-2"></i>`;
});