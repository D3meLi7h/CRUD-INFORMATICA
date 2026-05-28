//LOGOUT
const btnLogout = document.querySelector('#logout');
btnLogout.addEventListener('click', () =>
{
    window.location.href = "../index.html";
});

const nickname = localStorage.getItem("nickname");
const nomeSpan = document.querySelector('.nickname');

if(nickname)
{
    nomeSpan.textContent = nickname;
};

//BOTTONI GENERI
const generi = [
    "storico",
    "drammatico",
    "fantascienza",
    "saggio",
    "giallo",
    "horror",
    "manuale",
    "altro",
];

generi.forEach(genere => {
    const btn = document.getElementById(genere);

    if (btn) {
        btn.addEventListener("click", () => {
            window.location.href = `../include/${genere}.php`;
        });
    }
});