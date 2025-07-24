// COSTANTI
const form = document.querySelector("form");
const firstname = form.firstname;
const lastname = form.lastname;
const email = form.email;
const pass = form.pass;
const confirm = form.confirm;
const submit = document.getElementById("submit");
const alert = document.getElementById("alert");
const div = alert.parentNode;



// GESTORI EVENTI


firstname.addEventListener('input', ()  => {
    hideElem(div);
    checkElem(firstname, name_surname_pattern);
    checkValidity([firstname,lastname,email,pass, confirm], submit);
})



lastname.addEventListener('input', ()  => {
    hideElem(div);
    checkElem(lastname, name_surname_pattern);
    checkValidity([firstname,lastname,email,pass, confirm], submit);
})



email.addEventListener('input', ()  => {
    hideElem(div);
    checkElem(email, email_pattern);
    checkValidity([firstname,lastname,email,pass, confirm], submit);
})



pass.addEventListener('input', () => {
    hideElem(div);
    checkElem(pass, pass_pattern);
    checkElem(confirm,pass)
    checkValidity([firstname,lastname,email,pass, confirm], submit);
})

confirm.addEventListener('input', () => {
    hideElem(div);
    checkElem(confirm, pass);
    checkValidity([firstname,lastname,email,pass, confirm], submit);
})



form.addEventListener('submit', (event) => {

    // annulliamo il comportamento predefinito del form
    event.preventDefault();


    // prepariamo i dati da inviare nel body della richiesta http
    const formData = new URLSearchParams();
    formData.append("firstname", firstname.value);
    formData.append("lastname", lastname.value);
    formData.append("email", email.value);
    formData.append("pass", pass.value);
    formData.append("confirm", confirm.value);


    // facciamo la richiesta in POST
    fetch("/~s5606614/backend/api/registration.php", {
        method: "POST",
        headers: {
            "Content-type": "application/x-www-form-urlencoded"
        },
        body: formData
    }).then(async response => {

        // dato che gestiamo response e data insieme dobbiamo bloccare il flusso asincrono finché
        // non viene ritornata la risposta, in questo modo possiamo gestire i dati in un secondo momento
        // equivalente a fare .then(data => ...)
        const data = await response.json();

        // mostriamo il parent div di alert
        div.classList.remove("d-none");

        // se la risposta è 200 (OK)
        if(response.ok) {

            // rimuoviamo eventuali alert di errore e diamo un alert di successo
            alert.classList.remove("alert-danger");
            alert.classList.add("alert-success");
            alert.innerHTML = '<i class="bi bi-person-fill-check me-2"></i>' + data.message;

            // dopo 1 secondo mandiamo alla pagina di login
            setTimeout(() => {
                window.location.href = "/~s5606614/frontend/pages/login.php";
            }, 1000);

        } else {

            // sfondo rosso per errore
            if(!alert.classList.contains("alert-danger")) {
                alert.classList.add("alert-danger");
            }

            // messaggio di errore
            alert.innerHTML = '<i class="bi bi-person-fill-x me-2"></i>' + data.message;

        }
    }).catch(error => console.log("Errore: ", error));
})