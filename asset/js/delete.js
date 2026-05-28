const btnDelete = document.getElementById("btnDelete");

if (btnDelete) {
    btnDelete.addEventListener("click", () => {

        if (!datiLibroCorrente.id) {
            alert("Libro non valido");
            return;
        }

        if (!confirm("Vuoi davvero eliminare questo libro?")) return;

        fetch("../php/elimina_libro.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "id_libro=" + encodeURIComponent(datiLibroCorrente.id)
        })
        .then(res => res.text())
        .then(data => {
            alert(data);
            window.location.reload();
        })
        .catch(err => console.error(err));
    });
}