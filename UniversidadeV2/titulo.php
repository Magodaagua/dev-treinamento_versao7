    <!--Menu Superior-->
    <div class="menusuperior">
        <!--Titulo Copimaq-->
        <div class="titulocopimaq">
            Copimaq
        </div>
        <!-- Opções do meio do menu HOME, PORTAL COPIMAQ, CURSOS... -->
        <div class="opcoestitulo">
            <a href="menu.php">HOME</a>&nbsp;&nbsp;
            <a href="../../PORTAL/php/pages/home.php?Usuario=<?php echo $usuario;?>">PORTAL COPIMAQ</a>&nbsp;&nbsp;
            <a href="curso.php?Usuario=<?php echo $usuario;?>&Dep=<?php echo $dep;?>">CURSOS</a>&nbsp;&nbsp;
            <a href="comunidade.php?Usuario=<?php echo $usuario;?>&Dep=<?php echo $dep;?>">COMUNIDADE</a>&nbsp;&nbsp;
            <a href="suporte.php?Usuario=<?php echo $usuario;?>">CENTRAL DE AJUDA</a>&nbsp;&nbsp;
        </div>
        <!-- OPções da lateral direita ZOOM, MODO ESCURO...-->
        <div class="maisopcoes">
            <button id="botao-zoom">
                <img src="../../COMUM/img/cursos/imagens/zoom-in.png">
            </button>
            <button id="botao-modo-escuro">
                <img id="icone-modo-escuro" src="../../COMUM/img/cursos/imagens/moon.png" alt="Lua">
            </button>
            <button class="nome_abreviado" id="user-info" onmouseenter="togglePopup(document.getElementById('popup'))" onmouseleave="hidePopup(document.getElementById('popup'))">
                <?php echo $abreviacao; ?>
            </button>
        </div>
    </div>

    <!-- Popup de opções do usuário -->
    <div class="popupContaUser" id="popup" onmouseenter="keepPopup()" onmouseleave="hidePopup(this)">
        <div class="divUlPopupContaUser">
            <ul>
                <li>
                    <a href="certificadoscopimaq.php?Usuario=<?php echo $usuario;?>">
                        Meus certificados
                    </a>
                </li>
                <!--<li><a href="../COMUM/php/alterarSenha-BE.php">Mudar senha</a></li>-->
                <li>
                    <a href="../../COMUM/php/logout.php">
                        Sair
                    </a>
                </li>
            </ul>
        </div>
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
