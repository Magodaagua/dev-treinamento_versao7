// Verifica se o modo escuro está ativado no localStorage ao carregar a página
document.addEventListener("DOMContentLoaded", function () {
    const darkModeEnabled = localStorage.getItem('darkModeEnabled') === 'true';
    if (darkModeEnabled) {
        enableDarkMode();
    }
});

function toggleDarkMode() {
    const darkModeEnabled = localStorage.getItem('darkModeEnabled') === 'true';
    if (darkModeEnabled) {
        disableDarkMode();
    } else {
        enableDarkMode();
    }
}

function enableDarkMode() {
    const body = document.body;
    const darkModeIcon = document.getElementById('darkModeIcon');
    const darkModeButton = document.getElementById('darkModeButton');
    const topMenu = document.querySelector('.top-menu'); // Seleciona o menu superior
    const bottomMenu = document.querySelector('.bottom-menu'); // Seleciona o menu inferior
    const userinfo = document.querySelector('.user-info'); // Seleciona informação do usuário

    body.classList.add('dark-mode');
    topMenu.classList.add('dark-mode'); // Adiciona a classe 'dark-mode' ao menu superior
    bottomMenu.classList.add('dark-mode');
    userinfo.classList.add('dark-mode');
    darkModeIcon.src = '../../COMUM/img/darkmode/sol.png';
    darkModeButton.style.backgroundColor = '#f0f0f0'; /* Cor de fundo para o modo escuro */

    // Altera a imagem do usuário para usuario.png quando o modo escuro é ativado
    document.getElementById('userImg').src = '../COMUM/img/darkmode/usuario.png';
    document.getElementById('logoImg').src = '../COMUM/img/Copimaq/Logos/LogoBrancoHorizontal.png';

    // Salva o estado do modo escuro no localStorage
    localStorage.setItem('darkModeEnabled', 'true');
}

function disableDarkMode() {
    const body = document.body;
    const darkModeIcon = document.getElementById('darkModeIcon');
    const darkModeButton = document.getElementById('darkModeButton');
    const topMenu = document.querySelector('.top-menu'); // Seleciona o menu superior
    const bottomMenu = document.querySelector('.bottom-menu'); // Seleciona o menu inferior
    const userinfo = document.querySelector('.user-info'); // Seleciona informação do usuário

    body.classList.remove('dark-mode');
    topMenu.classList.remove('dark-mode'); // Remove a classe 'dark-mode' do menu superior
    bottomMenu.classList.remove('dark-mode');
    userinfo.classList.remove('dark-mode');
    darkModeIcon.src = '../../COMUM/img/darkmode/lua.png';
    darkModeButton.style.backgroundColor = '#333'; /* Cor de fundo para o modo claro */

    // Altera a imagem do usuário para user.png quando o modo escuro é desativado
    document.getElementById('userImg').src = '../COMUM/img/Icons/CinzaClaro/user.png';
    document.getElementById('logoImg').src = '../COMUM/img/Copimaq/Logos/LogoLadoPreto.png';

    // Salva o estado do modo escuro no localStorage
    localStorage.setItem('darkModeEnabled', 'false');
}
