<header class="top-menu">
<!--<link href="https://fonts.cdnfonts.com/css/community" rel="stylesheet">-->
    <div class="logomenu">
        <img id="logoImg" src="../COMUM/img/Copimaq/Logos/LogoLadoPreto.png" alt="Logo do site">
    </div>
    <!--<div class="nome-empresa">
        COPIMAQ
    </div>-->
    <div class="search-bar">
        <input type="text" placeholder="Pesquisar...">
        <button>Buscar</button>
    </div>
   
    <div class="user-info" id="user-info" onmouseenter="togglePopup(document.getElementById('popup'))" onmouseleave="hidePopup(document.getElementById('popup'))"> 
    <span>Bem-vindo, <?php echo $nome_usuario?>
</span>
        <img id="userImg" src="../COMUM/img/Icons/CinzaClaro/user.png" alt="Imagem do usuário">
    </div>
    
</header>

<!-- Popup de opções do usuário -->
<div class="popupContaUser" id="popup" onmouseenter="keepPopup()" onmouseleave="hidePopup(this)">
    <div class="divUlPopupContaUser"><ul>
        <li><a href="../COMUM/php/meusDados.php">Minha Conta</a></li>
        <!--<li><a href="../COMUM/php/alterarSenha-BE.php">Mudar senha</a></li>-->
        <li><a href="../COMUM/php/logout.php">Sair</a></li>
    </ul></div>
</div>

<nav class="bottom-menu">

    <ul>
    <hr class="hrrr">
        <li><a href="menu.php">Home</a></li>
        <li><a href="../PORTAL/php/pages/home.php?Usuario=">Portal Copimaq</a></li>
        <li>
            <a href="#">
                <span id="cursosBtn" onmouseenter="togglePopup(document.getElementById('cursosPopup'))" onmouseleave="hidePopup(document.getElementById('cursosPopup'))">
                Cursos <!--<i class="arrow-down" id=arrow-downCurso></i>-->
                </span>
        </a></li>
        <li><a href="#"><span id="gruposBtn" onmouseenter="togglePopup(document.getElementById('gruposPopup'))" onmouseleave="hidePopup(document.getElementById('gruposPopup'))">Grupos</span></a></li>
        <li><a href="suporte.php">Central de Ajuda</a></li>
    </ul>
    
</nav>

<div class="popup" id="cursosPopup" onmouseenter="keepPopup()" onmouseleave="hidePopup(this)"> <!-- Identificador único para o popup de Cursos -->
    <i class="arrowdown" id="arrow-downCurso"></i>
    <ul>
        <li><a href="curso.php?Nome_cat=<?php echo $row_usuario['Dep']?>">Todos os Cursos</a></li>
        <li><a href="biblioteca.php">Meus Cursos</a></li>
        <li><a href="certificadoscopimaq.php">Certificados</a></li>
    </ul>
</div>

<div class="popup" id="gruposPopup" onmouseenter="keepPopup()" onmouseleave="hidePopup(this)"> <!-- Identificador único para o popup de Grupos -->
    <i class="arrowdown" id="arrow-downGrupo"></i>
    <ul>
        <li><a href="grupo.php">Procurar Grupos</a></li>
        <li><a href="#">Meus Grupos</a></li>
    </ul>
</div>

<script>
    let popupAberto = false;
    let popupTimeout;

// Função para exibir ou ocultar um popup
function togglePopup(popup) {
    if (!popupAberto) {
        clearTimeout(popupTimeout);
        popup.style.display = 'block';
        popupAberto = true;
    }
}

// Função para ocultar um popup
function hidePopup(popup) {
    if (popupAberto) {
        popupTimeout = setTimeout(function() {
            popup.style.display = 'none';
            popupAberto = false;
        }, 200);
    }
}


    // Função para manter um popup aberto enquanto o mouse estiver sobre ele
    function keepPopup() {
        clearTimeout(popupTimeout);
    }
</script>
<div id="darkModeButton" onclick="toggleDarkMode()">
    <img id="darkModeIcon" src="../COMUM/img/darkmode/lua.png" alt="Modo Escuro">
</div>