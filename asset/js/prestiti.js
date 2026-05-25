
// LOGOUT
const btnLogout = document.querySelector('#logout');

btnLogout.addEventListener('click', () => {
    window.location.href = "../index.html";
});



// NICKNAME DA LOCALSTORAGE
// Recupera il nickname salvato nel browser
const nickname = localStorage.getItem("nickname");

// Seleziona lo span dove mostrare il nickname
const nomeSpan = document.querySelector('.nickname');

// Se esiste un nickname salvato
if (nickname) {
    // Inserisce il nickname nella pagina
    nomeSpan.textContent = nickname;
}

// BOTTONE INDIETRO
// Seleziona il bottone "indietro"
const Indietro = document.getElementById("indietro");

// on click
Indietro.addEventListener('click', () => {

    window.location.href = "../include/generi.html";
});

// Ricerca
input.addEventListener("input", () => {
    const q = input.value.trim().toLowerCase();
    lista.innerHTML = "";

    if (!q) { lista.style.display = "none"; return; }

    const trovati = libri.filter(l =>
        l.titolo.toLowerCase().includes(q) || l.isbn.toLowerCase().includes(q)
    );

});

// Chiudi lista cliccando fuori
document.addEventListener("click", e => {
    if (!e.target.closest(".campo")) lista.style.display = "none";
});

function selezionaLibro(libro) {
    libroScelto = libro;
    labelScelto.textContent = ` ${libro.titolo} (${libro.isbn})`;
    boxScelto.style.display = "flex";
    input.value = "";
    lista.style.display = "none";
    input.closest(".campo").style.display = "none";
}

// Conferma prestito
btnConferma.addEventListener("click", () => {
    if (!libroScelto) {
        alert("Seleziona un libro prima di confermare.");
        return;
    }

    const dataPrestito = document.getElementById("dataPrestito").value;
    const dataRestituzione = document.getElementById("dataRestituzione").value;

    // Chiamata al backend (fetch POST)
    console.log("Prestito richiesto:", {
        id_libro: libroScelto.id,
        data_prestito: dataPrestito,
        data_restituzione: dataRestituzione || null,
    });

    alert(`Prestito di "${libroScelto.titolo}" richiesto con successo!`);
});
