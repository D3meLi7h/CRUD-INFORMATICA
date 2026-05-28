// INDIETRO
const indietro = document.getElementById("indietro");
if (indietro) {
    indietro.addEventListener("click", () => {
        localStorage.removeItem("libroModifica");
        window.location.href = "../include/generi.html";
    });
}

// CONTROLLA SE SIAMO IN MODIFICA
const libroModifica = JSON.parse(localStorage.getItem("libroModifica"));

if (libroModifica) {
    document.querySelector(".titolo").textContent = "Modifica libro";

    document.getElementById("titolo").value      = libroModifica.titolo || "";
    document.getElementById("posizione").value   = libroModifica.posizione || "";
    document.getElementById("isbn").value        = libroModifica.isbn || "";
    document.getElementById("anno").value        = libroModifica.anno || "";
    document.getElementById("pagine").value      = libroModifica.pagine || "";
    document.getElementById("lingua").value      = libroModifica.lingua || "";
    document.getElementById("copie").value       = libroModifica.copie ?? 1;
    document.getElementById("descrizione").value = libroModifica.descrizione || "";

    // Per l'autore (select), devi settare il valore dell'ID
    const selectAutore = document.getElementById("id_autore");
    if (selectAutore && libroModifica.id_autore) {
        selectAutore.value = libroModifica.id_autore;
    }

    // Per il genere (select)
    const selectGenere = document.getElementById("genere");
    if (selectGenere && libroModifica.genere) {
        selectGenere.value = libroModifica.genere;
    }
}
