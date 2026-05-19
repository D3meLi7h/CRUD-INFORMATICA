const riquadro = document.querySelector('.riquadro');

// apertura popup
const btnApri = document.querySelector('.btnLogin');
btnApri.addEventListener('click', () =>
{
    riquadro.classList.add('attivaPopup');
});

// chiusura popup
const btnChiudi = document.querySelector('.chiudi');
btnChiudi.addEventListener('click', () =>
{
    riquadro.classList.remove('attivaPopup');
});

//pagina home
const inputNickname = document.querySelector('.input-box input');
const btnEntra = document.querySelector('.btnEntra');

btnEntra.addEventListener('click', (event) =>
{
    event.preventDefault();
    if(inputNickname.value.trim() === "")
    {
        alert("Riempi tutti i campi.");
    }
                
    else
    {
        localStorage.setItem("nickname", inputNickname.value);
        window.location.href = "/include/generi.html";
    }
});

//pagina registrazione
const linkRegistra = document.querySelector('.linkRegistra');

linkRegistra.addEventListener('click', (event) =>
{
    window.location.href = "/include/registra.html";
});
