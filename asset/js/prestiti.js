
// LOGOUT
// Seleziona il bottone logout tramite ID
const btnLogout = document.querySelector('#logout');

// Quando l’utente clicca sul bottone logout
btnLogout.addEventListener('click', () => {
    // Torna alla pagina di login
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

// Libri di esempio — sostituisci con una fetch al tuo backend
const libri = [
    { id: 1, titolo: "Il Barone Rampante", isbn: "ISBN001" },
    { id: 2, titolo: "1984",               isbn: "ISBN002" },
    { id: 3, titolo: "Lezioni Americane",  isbn: "ISBN003" },
    { id: 4, titolo: "I Promessi Sposi",   isbn: "ISBN004" },
    { id: 5, titolo: "Il Nome della Rosa", isbn: "ISBN005" },
    { id: 6, titolo: "La Storia",          isbn: "ISBN006" },
];

let libroScelto = null;

const input         = document.getElementById("ricercaLibro");
const lista         = document.getElementById("listaRisultati");
const boxScelto     = document.getElementById("libroSelezionatoBox");
const labelScelto   = document.getElementById("libroSelezionatoLabel");
const btnRimuovi    = document.getElementById("btnRimuoviLibro");
const btnConferma   = document.getElementById("btnConferma");

// Ricerca live
input.addEventListener("input", () => {
    const q = input.value.trim().toLowerCase();
    lista.innerHTML = "";

    if (!q) { lista.style.display = "none"; return; }

    const trovati = libri.filter(l =>
        l.titolo.toLowerCase().includes(q) || l.isbn.toLowerCase().includes(q)
    );

    if (trovati.length === 0) {
        lista.innerHTML = `<li style="opacity:0.5;">Nessun risultato</li>`;
    } else {
        trovati.forEach(l => {
            const li = document.createElement("li");
            li.textContent = `${l.titolo} — ${l.isbn}`;
            li.addEventListener("click", () => selezionaLibro(l));
            lista.appendChild(li);
        });
    }

    lista.style.display = "block";
});

// Chiudi lista cliccando fuori
document.addEventListener("click", e => {
    if (!e.target.closest(".campo")) lista.style.display = "none";
});

function selezionaLibro(libro) {
    libroScelto = libro;
    labelScelto.textContent = `📖 ${libro.titolo} (${libro.isbn})`;
    boxScelto.style.display = "flex";
    input.value = "";
    lista.style.display = "none";
    input.closest(".campo").style.display = "none";
}

btnRimuovi.addEventListener("click", () => {
    libroScelto = null;
    boxScelto.style.display = "none";
    input.closest(".campo").style.display = "flex";
});

// Conferma prestito
btnConferma.addEventListener("click", () => {
    if (!libroScelto) {
        alert("Seleziona un libro prima di confermare.");
        return;
    }

    const dataRestituzione = document.getElementById("dataRestituzione").value;

    // Chiamata al backend (fetch POST)
    console.log("Prestito richiesto:", {
        id_libro: libroScelto.id,
        data_restituzione: dataRestituzione || null,
    });

    alert(`Prestito di "${libroScelto.titolo}" richiesto con successo!`);
});