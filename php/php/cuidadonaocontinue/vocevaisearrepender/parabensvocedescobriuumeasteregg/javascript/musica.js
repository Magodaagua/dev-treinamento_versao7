const musicas = [
    "caminho/para/musica1.mp3",
    "caminho/para/musica2.mp3",
    "caminho/para/musica3.mp3",
    // Adicione mais músicas conforme necessário
];

let indiceMusicaAtual = 0;

const player = document.getElementById("audioPlayer");

function proximaMusica() {
    indiceMusicaAtual = (indiceMusicaAtual + 1) % musicas.length;
    player.src = musicas[indiceMusicaAtual];
    player.play();
}

// Controle de volume
function ajustarVolume(volume) {
    player.volume = volume;
}

// Atualizar a origem da música no player de áudio
player.src = musicas[indiceMusicaAtual];

// Selecionar uma nova música quando a música atual terminar
player.addEventListener("ended", function() {
    proximaMusica();
});

// Avançar para a próxima música quando o botão for clicado
document.getElementById("botaoProxima").addEventListener("click", function() {
    proximaMusica();
});
