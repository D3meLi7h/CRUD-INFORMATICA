//LOGOUT
const btnLogout = document.querySelector('#logout');
btnLogout.addEventListener('click', () =>
{
    window.location.href = "/index.html";
});

const nickname = localStorage.getItem("nickname");
const nomeSpan = document.querySelector('.nickname');

if(nickname)
{
    nomeSpan.textContent = nickname;
};

//AUDIO
const audio = document.getElementById("audio");
const icon = document.getElementById("audioIcon");
const btnAudio = document.getElementById("btnAudio");

btnAudio.addEventListener("click", () => {
    if (audio.paused)
    {
        audio.play();
    }
    
    else
    {
        audio.pause();
    }

    icon.setAttribute
    (
        "name",
        audio.paused ? "volume-mute-outline" : "volume-high-outline"
    );
});

//BOTTONI GENERI
const generi = [
    "avventura",
    "drammatico",
    "fantascienza",
    "fantasy",
    "giallo",
    "horror",
    "rosa",
    "altro",
];

generi.forEach(genere => {
    const btn = document.getElementById(genere);

    if (btn) {
        btn.addEventListener("click", () => {
            window.location.href = `/include/${genere}.html`;
        });
    }
});