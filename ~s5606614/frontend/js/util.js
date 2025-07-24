// pattern per Nome e Cognome (accettiamo da 2 a 30 caratteri compresi di spazi, apici, trattini e lettere accentate)
const name_surname_pattern = /^[A-Za-zà-ù][A-Za-zà-ù' -]{2,29}$/;

// pattern per mail secondo RFC
const email_pattern = /^[\w][A-Za-z\d]+(?:[.-_][A-Za-z\d]+)*@[A-Za-z\d]+(?:[.-][A-Za-z\d]+)*\.[A-Za-z\d]+$/;

// la password deve essere lunga almeno 8 caratteri e non contenere spazi
const pass_pattern = /^\S{8,}$/;



// funzione per controllare che una stringa soddisfi un espressione regolare
function checkRegExp(value, exp) {
    return exp.test(value);
}

// funzione per gestire la validazione dei campi del form
function checkElem(elem, exp) {
    const value = elem.value.trim();
    let valid;
    if(exp instanceof HTMLElement) {
        valid = elem.value === exp.value; // caso confronto password
    } else {
        valid = checkRegExp(value,exp); // caso confronto con espressione regolare (RegExp)
    }
    if(valid) {
        (elem.classList.contains('is-invalid')) ?
            elem.classList.replace('is-invalid','is-valid') :
            elem.classList.add('is-valid');
    } else {
        (elem.classList.contains('is-valid')) ?
            elem.classList.replace('is-valid','is-invalid') :
            elem.classList.add('is-invalid');
    }
}

// funzione per gestire il bottone di submit in base alla validità degli elementi del form
function checkValidity(elems, button) {
    if(!button.classList.contains('disabled')) {
        button.classList.add('disabled')
    }
    for(let elem of elems) {
        if(!elem.classList.contains('is-valid')) {
            return
        }
    }
    button.classList.remove("disabled");
}

// funzione per nascondere un elemento dalla pagina
function hideElem(elem) {
    if(!elem.classList.contains("d-none")) {
        elem.classList.add("d-none");
    }
}