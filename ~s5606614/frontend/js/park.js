const main = document.getElementById("parco");
const heading = document.getElementById("titolo"); // titolo parco
const descrizione = document.getElementById("descrizione");
const city = document.getElementById("city");

// settiamo lo sfondo della pagina
main.style.backgroundRepeat = "no-repeat";
main.style.backgroundSize = "cover";
main.style.backgroundPosition = "center center";

// al caricamento della pagina facciamo una chiamata all'api passando il parametro get trovato nell'url
document.addEventListener("DOMContentLoaded", () => {

    const titolo = (new URLSearchParams(window.location.search)).get("titolo");


    fetch(`/~s5606614/backend/api/get_park.php?titolo=${titolo}`, {
        method: "GET"
    }).then(async response => {

        const data = await response.json();

        if(response.ok) {

            // caso CaliSuaro => logo, altrimenti carico l'immagine del parco sullo sfondo
            if(titolo === "CaliSauro") {
                main.style.backgroundImage = `url(../images/CaliSauro.jpg)`;
            } else {
                main.style.backgroundImage = `url(../images/parchi/${data.properties.immagine})`;
            }

            // salviamo la latitudine e longitudine dal GeoJson
            const lat = parseFloat(data.geometry.coordinates[1]);
            const lon = parseFloat(data.geometry.coordinates[0]);

            // costruiamo la mappa centrata sulle coordinate
            const map = L.map('map').setView([lon ,lat ], 15);

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

        } else {

            // carichiamo come sfondo una immagine default e stampiamo un messaggio di errore
            main.style.backgroundImage = `url(../images/parco.jpg`;
            main.innerHTML = `<h2 class="alert alert-danger">${data.message}</h2>`;

            // dopo 1 secondo mandiamo alla home page
            setTimeout(() => {
                window.location.href = "/~s5606614/";
            }, 1000);
        }
    })
})