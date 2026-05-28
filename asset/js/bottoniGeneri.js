
// LOGOUT

const btnLogout = document.querySelector('#logout');

if (btnLogout) {
    btnLogout.addEventListener('click', () => {
        window.location.href = "../index.html";
    });
}



// NICKNAME LOCALSTORAGE

const nickname = localStorage.getItem("nickname");
const nomeSpan = document.querySelector('.nickname');

if (nickname && nomeSpan) {
    nomeSpan.textContent = nickname;
}



// BOTTONE INDIETRO

const btnIndietro = document.getElementById("indietro");

if (btnIndietro) {
    btnIndietro.addEventListener('click', () => {
        window.location.href = "../include/generi.html";
    });
}



// LIBRO CORRENTE

let datiLibroCorrente = {};



// APRI POPUP

function apriPopup(card) {
    const d = card.dataset;
    datiLibroCorrente = d;

    //el=elemento di html, val=valore da inserire, se val è vuoto o null inserisce '—'
    const set = (el, val) => {
        if (el) el.textContent = val || '—';
    };

    set(document.getElementById('det-titolo'), d.titolo);
    set(document.getElementById('autore'), d.autore);
    set(document.getElementById('det-descrizione'), d.descrizione);
    set(document.getElementById('det-anno'), d.anno);
    set(document.getElementById('det-lingua'), d.lingua);
    set(document.getElementById('det-pagine'), d.pagine);
    set(document.getElementById('det-posizione'), d.posizione);
    set(document.getElementById('det-isbn'), d.isbn);

    const copie = parseInt(d.copie || "0", 10);
    const detCopie = document.getElementById('det-copie');

    if (detCopie) {
        detCopie.textContent = copie > 0
            ? copie + ' copie disponibili'
            : 'Non disponibile';
    }

    const detStelle = document.getElementById('det-stelle');

    //evita crash se funzione non esiste
    if (detStelle) {
        if (typeof creaStelle === "function") {
            detStelle.innerHTML = creaStelle(d.voto);
        } else {
            detStelle.textContent = d.voto || '—';
        }
    }

    const detNumrec = document.getElementById('det-numrec');
    if (detNumrec) {
        const n = parseInt(d.numrec || "0", 10);
        detNumrec.textContent = n === 0
            ? 'Nessuna recensione'
            : `(${n} recension${n === 1 ? 'e' : 'i'})`;
    }

    document.getElementById('popup')?.classList.add('aperto');
    document.body.style.overflow = 'hidden';
}



// CHIUDI POPUP

const btnChiudi = document.getElementById('btnChiudi');

if (btnChiudi) {
    btnChiudi.addEventListener('click', () => {
        document.getElementById('popup')?.classList.remove('aperto');
        document.body.style.overflow = '';
    });
}



// CLICK CARD LIBRI

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card-libro').forEach(card => {
        card.addEventListener('click', () => {
            apriPopup(card);
        });
    });
});



// MODIFICA LIBRO
const btnImp = document.getElementById('btnImp');

if (btnImp) {
    btnImp.addEventListener('click', () => {
        const id = datiLibroCorrente.id;
        if (!id) {
            alert("Nessun libro selezionato");
            return;
        }
        window.location.href = '../include/crea_libro.php?id=' + encodeURIComponent(id);
    });
}



// AGGIUNGI NUOVO LIBRO

const btnAggiungi = document.getElementById('aggiungi');

if (btnAggiungi) {
    btnAggiungi.addEventListener('click', () => {
        localStorage.removeItem('libroModifica');
        window.location.href = '../include/crea_libro.php';
    });
}

// ELIMINA LIBRO

const btnDelete = document.getElementById('btnDelete');

if (btnDelete) {
    btnDelete.addEventListener('click', () => {

        const id = datiLibroCorrente.id;

        if (!id) {
            alert("Nessun libro selezionato");
            return;
        }

        if (!confirm("Sei sicuro di voler eliminare questo libro?")) return;

        fetch('../php/deleteLibro.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(res => res.text())
        .then(data => {

            if (data.trim() === "OK") {

                // chiudi popup
                document.getElementById('popup')?.classList.remove('aperto');
                document.body.style.overflow = '';

                // rimuovi card dal DOM senza reload
                const card = document.querySelector(`.card-libro[data-id="${id}"]`);
                if (card) card.remove();

            } else {
                alert("Errore eliminazione: " + data);
            }
        })
        .catch(err => {
            console.error(err);
            alert("Errore di rete");
        });
    });
}