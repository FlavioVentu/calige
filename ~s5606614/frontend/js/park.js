const main = document.getElementById("parco");
const heading = document.getElementById("titolo");
const descrizione = document.getElementById("descrizione");

main.style.backgroundRepeat = "no-repeat";
main.style.backgroundSize = "cover";
main.style.backgroundPosition = "center center";

document.addEventListener("DOMContentLoaded", () => {

    const titolo = (new URLSearchParams(window.location.search)).get("titolo");


    fetch(`/~s5606614/backend/api/get_park.php?titolo=${titolo}`, {
        method: "GET"
    }).then(async response => {

        const data = await response.json();

        if(response.ok) {
            if(titolo === "CaliSauro") {
                main.style.backgroundImage = `url(../images/CaliSauro.jpg)`;
            } else {
                main.style.backgroundImage = `url(../images/parchi/${data.properties.immagine})`;
            }
            const lat = parseFloat(data.geometry.coordinates[1]);
            const lon = parseFloat(data.geometry.coordinates[0]);

            const map = L.map('map').setView([lon ,lat ], 15);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([lon, lat])
                .addTo(map)
                .bindPopup(`<strong>${data.properties.titolo}</strong><br>${data.properties.città}`)
                .openPopup();

            heading.innerText = titolo;
            descrizione.innerText = data.properties.descrizione;

        } else {
            main.style.backgroundImage = `url(../images/parco.jpg`;
            main.innerHTML = `<h2 class="alert alert-danger">${data.message}</h2>`;

            // dopo 1 secondo mandiamo alla home page
            setTimeout(() => {
                window.location.href = "/~s5606614/";
            }, 1000);
        }
    })
})