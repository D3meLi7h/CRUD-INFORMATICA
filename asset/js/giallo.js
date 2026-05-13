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

//INDIETRO
const Indietro = document.getElementById("indietro");
Indietro.addEventListener('click', () =>
{
    window.location.href = "/include/generi.html";
});