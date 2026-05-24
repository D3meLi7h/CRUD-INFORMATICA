// INDIETRO
const indietro = document.getElementById("indietro");
if (indietro) {
    indietro.addEventListener("click", () => {
        localStorage.removeItem("libroInModifica");
        window.location.href = "../../generi/generi.html";
    });
}

// CONTROLLA SE SIAMO IN MODIFICA
const libroInModifica = JSON.parse(localStorage.getItem("libroInModifica"));

if (libroInModifica) {
    document.querySelector(".titolo").textContent = "Modifica libro";

    document.getElementById("titolo").value = libroInModifica.titolo || "";
    document.getElementById("autore").value = libroInModifica.autore || "";
    document.getElementById("posizione").value = libroInModifica.posizione || "";
    document.getElementById("isbn").value = libroInModifica.isbn || "";
    document.getElementById("anno").value = libroInModifica.anno || "";
    document.getElementById("pagine").value = libroInModifica.numeroPagine || "";
    document.getElementById("lingua").value = libroInModifica.lingua || "";
    document.getElementById("copie").value = libroInModifica.copieDisponibili ?? 1;
    document.getElementById("genere").value = libroInModifica.genere || "";
    document.getElementById("descrizione").value = libroInModifica.descrizione || "";
}

// INVIO LIBRO
const invio = document.getElementById("invio");
if (invio) {
    invio.addEventListener("click", aggiungiLibro);
}

function aggiungiLibro() {
    const titolo = document.getElementById("titolo").value.trim();
    const autore = document.getElementById("autore").value.trim();
    const posizione = document.getElementById("posizione").value.trim();
    const isbn = document.getElementById("isbn").value.trim();
    const anno = document.getElementById("anno").value.trim();
    const pagine = document.getElementById("pagine").value.trim();
    const lingua = document.getElementById("lingua").value.trim();
    const copie = document.getElementById("copie").value.trim();
    const genere = document.getElementById("genere").value;
    const descrizione = document.getElementById("descrizione").value.trim();

    // Campi obbligatori
    if (!titolo || !autore || !posizione || !isbn || !anno || !pagine || !lingua || !genere) {
        alert("Compila tutti i campi obbligatori (*)");
        return;
    }

    const libri = JSON.parse(localStorage.getItem("libri")) || [];

    const datiLibro = {
        titolo,
        autore,
        posizione,
        isbn,
        anno: parseInt(anno),
        numeroPagine: parseInt(pagine),
        lingua,
        copieDisponibili: copie !== "" ? parseInt(copie) : 1,
        genere,
        descrizione
    };

    if (libroInModifica) {
        const index = libri.findIndex(l => l.isbn === libroInModifica.isbn);
        if (index !== -1) {
            libri[index] = { ...libri[index], ...datiLibro };
        }
        localStorage.removeItem("libroInModifica");
        alert("Libro modificato!");
    } else {
        const nuovoId = libri.length > 0
            ? Math.max(...libri.map(l => l.id || 0)) + 1
            : 1;

        libri.push({ id: nuovoId, ...datiLibro });
        alert("Libro aggiunto!");
    }

    localStorage.setItem("libri", JSON.stringify(libri));
    window.location.href = "../../generi/generi.html";
}