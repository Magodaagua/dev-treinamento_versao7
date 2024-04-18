//----------------------[ Botão zoom ]-------------------------------//
document.getElementById('botao-zoom').addEventListener('click', function() {
    var imagem = document.getElementById('botao-zoom').querySelector('img');
    if (document.fullscreenElement) {
      document.exitFullscreen();
      imagem.src = '../../COMUM/img/cursos/imagens/zoom-in.png';
    } else {
      document.documentElement.requestFullscreen();
      imagem.src = '../../COMUM/img/cursos/imagens/zoom-out.png';
    }
});
