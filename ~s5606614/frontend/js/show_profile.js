const username = document.getElementById("username");
const firstname = document.getElementById("firstname");
const lastname = document.getElementById("lastname");
const email = document.getElementById("email");
const alert = document.getElementById("alert");
const div = alert.parentNode;
const update = document.getElementById("update");

document.addEventListener("DOMContentLoaded", () => {
    fetch("/~s5606614/backend/api/show_profile.php", {
        method: "GET"
    }).then(async response => {
        const data = await response.json();

        if(response.ok) {
            username.innerText = data.data.username;
            firstname.value = data.data.firstname;
            lastname.value = data.data.lastname;
            email.value = data.data.email;
        } else {
            // mostriamo il parent div di alert
            div.classList.remove("d-none");

            // sfondo rosso per errore
            if(!alert.classList.contains("alert-danger")) {
                alert.classList.add("alert-danger");
            }

            // messaggio di errore
            alert.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + data.message;
        }
    })
})

update.addEventListener("click", () => {

    // prepariamo i dati da inviare nel body della richiesta http
    const formData = new URLSearchParams();
    formData.append("firstname", firstname.value);
    formData.append("lastname", lastname.value);
    formData.append("email", email.value);

    fetch("/~s5606614/backend/api/update_profile.php", {
        method: "POST",
        headers: {
            "Content-type": "application/x-www-form-urlencoded"
        },
        body: formData
    }).then(async response => {
        const data = await response.json();

        // mostriamo il parent div di alert
        div.classList.remove("d-none");

        if(response.ok) {


            // rimuoviamo eventuali alert di errore e diamo un alert di successo
            alert.classList.remove("alert-danger");
            if(!alert.classList.contains("alert-success")) {
                alert.classList.add("alert-success");
            }
            alert.innerHTML = '<i class="bi bi-person-fill-check me-2"></i>' + data.message;

            // dopo 1 secondo aggiorniamo la pagina
            setTimeout(() => {
                location.reload(true);
            }, 1000);

        } else {

            // sfondo rosso per errore
            alert.classList.remove("alert-success");
            if(!alert.classList.contains("alert-danger")) {
                alert.classList.add("alert-danger");
            }

            // messaggio di errore
            alert.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i>' + data.message;
        }
    }).catch(error => console.log("Errore: ", error));
})

firstname.addEventListener('input', ()  => {
    update.classList.remove('disabled');
    hideElem(div);
})



lastname.addEventListener('input', ()  => {
    update.classList.remove('disabled');
    hideElem(div);
})



email.addEventListener('input', ()  => {
    update.classList.remove('disabled');
    hideElem(div);
})