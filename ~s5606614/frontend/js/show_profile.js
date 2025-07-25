const username = document.getElementById("username");
const firstname = document.getElementById("firstname");
const lastname = document.getElementById("lastname");
const email = document.getElementById("email");
const alert = document.getElementById("alert");
const div = alert.parentNode;

document.addEventListener("DOMContentLoaded", () => {
    fetch("/~s5606614/backend/api/show_profile.php", {
        method: "GET"
    }).then(async response => {
        const data = await response.json();

        if(response.ok) {
            username.innerText = data.data.username;
            firstname.innerText = data.data.firstname;
            lastname.innerText = data.data.lastname;
            email.innerText = data.data.email;
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