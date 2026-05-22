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

// INPUT
const inputNickname = document.querySelector('#nickname');
const inputPassword = document.querySelector('#password');
const btnEntra = document.querySelector('.btnEntra');

// login
btnEntra.addEventListener('click', (event) =>
{
    event.preventDefault();

    const nickname = inputNickname.value.trim();
    const password = inputPassword.value.trim();

    // controllo campi vuoti
    if (nickname === "" || password === "")
    {
        alert("Riempi tutti i campi.");
        return;
    }

    // controllo password minima
    if (password.length < 8)
    {
        alert("La password deve avere almeno 8 caratteri.");
        return;
    }

    // salvataggio nickname
    localStorage.setItem("nickname", nickname);

    // redirect
    window.location.href = "include/generi.html";
});

// registrazione
const linkRegistra = document.querySelector('.linkRegistra');

linkRegistra.addEventListener('click', (event) =>
{
    event.preventDefault();
    window.location.href = "include/registra.html";
});
