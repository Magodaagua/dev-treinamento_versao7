//----------------------[ Botão modo escuro ]-------------------------------//
const botaoModoEscuro = document.getElementById('botao-modo-escuro');
const iconeModoEscuro = document.getElementById('icone-modo-escuro');

let modoEscuroAtivado = localStorage.getItem('modoEscuroAtivado') === 'true' || false;

botaoModoEscuro.addEventListener('click', function() {
  modoEscuroAtivado = !modoEscuroAtivado;

  if (modoEscuroAtivado) {
    iconeModoEscuro.src = '../../COMUM/img/cursos/imagens/sun.png';
    document.body.classList.add('modo-escuro');
    botaoModoEscuro.style.backgroundColor = ''; // Preto transparente
    document.body.style.backgroundColor = 'rgb(13, 13, 22)'; // Altera a cor de fundo do site para preto
    
    // Verifica se existem elementos com a classe 'quadradodois' e aplica os estilos a eles
    const quadradodois = document.querySelectorAll('.quadradodois');
    quadradodois.forEach(elemento => {
      elemento.style.backgroundColor = 'rgb(13, 13, 22)';
    });
} else {
    iconeModoEscuro.src = '../../COMUM/img/cursos/imagens/moon.png';
    botaoModoEscuro.style.backgroundColor = 'rgba(0, 0, 0, 0.5)'; // Volta ao padrão de cor do CSS
    document.body.classList.remove('modo-escuro');
    document.body.style.backgroundColor = 'white'; // Altera a cor de fundo do site para branco
    
    // Verifica se existem elementos com a classe 'quadradodois' e aplica os estilos a eles
    const quadradodois = document.querySelectorAll('.quadradodois');
    quadradodois.forEach(elemento => {
      elemento.style.backgroundColor = 'white';
    });
  }

  localStorage.setItem('modoEscuroAtivado', modoEscuroAtivado);
  atualizarModoEscuro();
});

botaoModoEscuro.addEventListener('mouseenter', function() {
  if (!modoEscuroAtivado) {
    botaoModoEscuro.style.backgroundColor = 'rgba(255, 255, 255, 0.5)'; // Branco transparente
  }
});

botaoModoEscuro.addEventListener('mouseleave', function() {
  if (!modoEscuroAtivado) {
    botaoModoEscuro.style.backgroundColor = 'rgba(0, 0, 0, 0.5)'; // Preto transparente
  }
});

function atualizarModoEscuro() {
  if (modoEscuroAtivado) {
    iconeModoEscuro.src = '../../COMUM/img/cursos/imagens/sun.png';
    document.body.classList.add('modo-escuro');
    botaoModoEscuro.style.backgroundColor = ''; // Preto transparente
    document.body.style.backgroundColor = 'rgb(13, 13, 22)'; // Altera a cor de fundo do site para preto
    
    // Verifica se existem elementos com a classe 'quadradodois' e aplica os estilos a eles
    const quadradodois = document.querySelectorAll('.quadradodois');
    quadradodois.forEach(elemento => {
      elemento.style.backgroundColor = 'rgb(13, 13, 22)';
    });
  } else {
    iconeModoEscuro.src = '../../COMUM/img/cursos/imagens/moon.png';
    botaoModoEscuro.style.backgroundColor = 'rgba(0, 0, 0, 0.5)'; // Volta ao padrão de cor do CSS
    document.body.classList.remove('modo-escuro');
    document.body.style.backgroundColor = 'white'; // Altera a cor de fundo do site para branco
    
    // Verifica se existem elementos com a classe 'quadradodois' e aplica os estilos a eles
    const quadradodois = document.querySelectorAll('.quadradodois');
    quadradodois.forEach(elemento => {
      elemento.style.backgroundColor = 'white';
    });
  }
}

atualizarModoEscuro();

