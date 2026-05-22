
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
