
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



// AUDIO
// Prende l’elemento audio della pagina
const audio = document.getElementById("audio");

// Prende l’icona del volume
const icon = document.getElementById("audioIcon");

// Prende il bottone per controllare l’audio
const btnAudio = document.getElementById("btnAudio");

// Audio alternatp
btnAudio.addEventListener("click", () => {

    if (audio.paused) {
        audio.play();
    }

    else {
        audio.pause();
    }

    // Icona alternata
    icon.setAttribute(
        "name",
        audio.paused 
            ? "volume-mute-outline"
            : "volume-high-outline"
    );
});



// BOTTONE INDIETRO
// Seleziona il bottone "indietro"
const Indietro = document.getElementById("indietro");

// on click
Indietro.addEventListener('click', () => {

    window.location.href = "../include/generi.html";
});