
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

//----------------------[ Animação de Cor dos botões ]-------------------------------//

const botoesCurso = document.querySelectorAll('.botoescomopcoes button');

botoesCurso.forEach(botao => {
  botao.addEventListener('click', function() {
    // Remove a classe 'dourado' de todos os botões de curso
    botoesCurso.forEach(b => b.classList.remove('dourado'));
    // Adiciona a classe 'dourado' apenas ao botão clicado
    this.classList.add('dourado');
  });
});

// Obtém referências para os botões
const btnProfissoesDigitais = document.getElementById('btn_profissoes_digitais');
const btnInsights = document.getElementById('btn_insights');
const btnCaixaDeFerramentas = document.getElementById('btn_caixa_de_ferramentas');

// Adiciona ouvinte de evento de clique aos botões
btnProfissoesDigitais.addEventListener('click', function() {
    // Remove a classe ativo de todos os botões
    btnInsights.classList.remove('ativo');
    btnCaixaDeFerramentas.classList.remove('ativo');
    // Adiciona a classe ativo ao botão clicado
    btnProfissoesDigitais.classList.add('ativo');
});

btnInsights.addEventListener('click', function() {
    // Remove a classe ativo de todos os botões
    btnProfissoesDigitais.classList.remove('ativo');
    btnCaixaDeFerramentas.classList.remove('ativo');
    // Adiciona a classe ativo ao botão clicado
    btnInsights.classList.add('ativo');
});

btnCaixaDeFerramentas.addEventListener('click', function() {
    // Remove a classe ativo de todos os botões
    btnProfissoesDigitais.classList.remove('ativo');
    btnInsights.classList.remove('ativo');
    // Adiciona a classe ativo ao botão clicado
    btnCaixaDeFerramentas.classList.add('ativo');
});

//-----------------------------ORB MENU PRINCIPAL-----------------------//

//let orbs = document.querySelectorAll('.orb');

//orbs.forEach(orb => {
  //  orb.addEventListener('click', function() {
    //    if (this.classList.contains('orb-cheia')) {
      //      return; // Se a orb clicada já estiver cheia, não faz nada
        //}
        
        //orbs.forEach(o => o.classList.remove('orb-cheia')); // Remove a classe orb-cheia de todas as orbs
        //this.classList.add('orb-cheia'); // Adiciona a classe orb-cheia à orb clicada
    //});
//});
