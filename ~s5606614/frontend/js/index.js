const main = document.getElementById("main");

document.addEventListener("DOMContentLoaded", () => {
    fetch("/~s5606614/backend/api/parks.php", {
        method: "GET"
    }).then(async response => {
        const data = await response.json();

        if(response.ok) {
            data.data.forEach((parco) => {
                main.innerHTML += `<div class="col">
                    <div class="card parchi m-5 rounded-5">
                        <img src="/~s5606614/frontend/images/parchi/${parco.immagine}"
                             class="card-img-top rounded-5 rounded-bottom-0" alt="Parco calistenico ${parco.titolo}">
                            <div class="card-body text-white">
                                <h5 class="card-title mb-3">${parco.titolo}</h5>
                                <a href="/~s5606614/frontend/pages/park.php?titolo=${parco.titolo}" class="btn btn-primary">visita</a>
                            </div>
                    </div>
                </div>`;
            })
        } else {
            main.classList.remove("row-cols-lg-3", "row-cols-md-2", "row-cols-1")
            main.innerHTML = `<h2 class="alert alert-danger">${data.message}</h2>`;
        }
    }).catch(error => console.log(error));
})