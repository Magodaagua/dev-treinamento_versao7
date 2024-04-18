<!DOCTYPE html>
<html lang="pt-br">
    <?php
        //conexao com o banco de dados
        include_once("php/conexao.php");

        //pega a categoria passadas pela url
        $categoria = isset($_GET['Dep']) ? $_GET['Dep'] : null;

        //faz uma busca no banco de dados para voltar todas as informações da categoria
        $result_categoria = "SELECT * FROM categoria WHERE Nome_cat = '$categoria'";
        $resultado_categoria = mysqli_query($conn, $result_categoria);

        //se o resultado da busca feita anteriormente existir vai guardar o id da categoria na variavel $id_categoria_atual
        if ($resultado_categoria) {
            $row_categoria = mysqli_fetch_assoc($resultado_categoria);
            $id_categoria_atual = $row_categoria['id'];
        } else {
            // Trate o erro, se houver algum
            echo "Erro na consulta: " . mysqli_error($conn);
        }

        //pega as informações do usuario e salva nas variaveis
        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);

        if ($row_usuario = mysqli_fetch_assoc($resultado_usuario)) {
            $id_user = $row_usuario['ID_usuario'];
            $dep = $row_usuario['Dep'];
            $nome_usuario = $row_usuario['Nome'];
            $abreviacao = $row_usuario['Abreviacao'];

            // Imprimir o primeiro nome do usuário
            //imprimirNomeUsuario($nome_usuario);
        }

    ?>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Nome do site-->
        <title>Comunidade Versão 2</title>
        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../../COMUM/img/Icons/Vermelho/imgML13.png">
        <!--CSS-->
        <link rel="stylesheet" href="css/tudo.css">
    </head>
    <body>
        <!--menu superior-->
        <?php 
            require "titulo.php"; 
        ?>
        <!-- titulo da página -->
        <div class="submenu">
            Seja bem vindo a nossa comunidade
        </div>
        <!-- botões da parte de cima -->
        <div class="comunidadepartecima">
            <div class="criarsala">
                <button onclick="toggleForm()">Criar uma Sala</button>
            </div>
            <div class="filtrosalamaisrecente">
                <select name="maisrecentes" id="maisrecentes" onchange="filtrarcomunidade()">
                    <option value="default">Selecione um filtro</option>
                </select>
            </div>
            <div class="doisbotoesdocanto">
                <div class="botaocantoum">
                    <button>
                        <img class="botaocantoumimg" src="../../COMUM/img/cursos/imagens/reload.png">
                    </button>
                </div>
                <div class="botaocantodois">
                    <button>
                        <img class="botaocantodoisimg" src="../../COMUM/img/cursos/imagens/check.png">
                    </button>
                </div>
            </div>
        </div>
        <!-- lateral esquerda baixo é onde tem algumas informações-->
        <div class="comunidadepartebaixo">
            <div class="esquerda">
                <div class="esquerdacima">
                    <ul>
                        <li class="sem-marcador">
                            <img class="esquerdacimaimg1" src="../../COMUM/img/cursos/imagens/balloon.png">&nbsp;
                            Todas as salas
                        </li>
                        <li class="sem-marcador">
                            <img class="esquerdacimaimg2" src="../../COMUM/img/cursos/imagens/star.png">&nbsp;
                            Seguindo
                        </li>
                        <li class="sem-marcador">
                            <img class="esquerdacimaimg3" src="../../COMUM/img/cursos/imagens/blocks.png">&nbsp;
                            Tags
                        </li>
                    </ul>
                </div>
                <div class="esquerdabaixo">
                    <ul>
                        <li>Geral</li>
                        <li>Informática</li>
                        <li>Impressoras</li>
                    </ul>
                </div>
            </div>
            <!-- lateral direita baixo é onde ficam as salas que você pode entrar-->
            <div class="direita">
                <?php
                    //faz uma busca para voltar todas as salas registradas no banco de dados
                    $result_grupos = "SELECT * FROM salas";
                    $resultado_grupos = mysqli_query($conn, $result_grupos);

                    $tipo ="";

                    while($row_grupo = mysqli_fetch_assoc($resultado_grupos)) {
                        if ($row_grupo['Privado']) {
                            $tipo = "Sala privada";
                        }else{
                            $tipo = "Sala pública";
                        }
                        echo '<div class="sala">';
                            echo '<div class="retangulocimasala">';
                                echo '<div class="nomeabrevisadosala">GP</div>';
                                echo '<div class="nome-sala">' . $row_grupo['Nome_grupo'] . '</div>';
                                echo '<div class="tiposala">'.$tipo.'</div>';
                                echo '<div class="salamensagens"><img src="../../COMUM/img/cursos/imagens/comment.png">10</div>';
                            echo '</div>';
                            
                            $id_grupo = $row_grupo['ID_grupo'];

                            // Verifica se o usuário está inscrito no grupo
                            $query_inscricao = "SELECT * FROM inscricao_grupo WHERE id_cliente = $id_user AND id_grupo = $id_grupo";
                            $resultado_inscricao = mysqli_query($conn, $query_inscricao);

                            if ($row_grupo['Privado']) {
                                echo '<div class="privada">'.$row_grupo['descricao'].'</div>';

                                // Se o usuário já estiver inscrito, mostra o botão de continuar, senão, mostra o botão de pedir entrada
                                if (mysqli_num_rows($resultado_inscricao) > 0) {
                                    echo '<div class="botao_continuar"><a href="salas.php?id_grupo=' . $id_grupo .'&id_user=' . $id_user . '"><button class="continuar">Continuar</button></a></div>';
                                } else {
                                    echo '<div class="botao_continuar"><button class="pedir-entrada">Pedir para Entrar</button></div>';
                                }
                            } else {
                                echo '<div class="publica">'.$row_grupo['descricao'].'</div>';

                                // Se o usuário já estiver inscrito, mostra o botão de continuar, senão, mostra o botão de entrar
                                if (mysqli_num_rows($resultado_inscricao) > 0) {
                                    echo '<div class="botao_continuar"><a href="salas.php?id_grupo=' . $id_grupo .'&id_user=' . $id_user . '"><button class="continuar">Continuar</button></a></div>';
                                } else {
                                    echo '<div class="botao_continuar"><a class="btn-entrar" href="php/inscrever_grupo.php?id_grupo=' . $id_grupo . '&id_user=' . $id_user . '"><button class="entrar">Entrar</button></a></div>';

                                }
                            }

                        echo '</div>';
                    }
                ?>
            </div>
        </div>
        <div class="overlay" onclick="fecharPopUp()"></div>
        <div id="criarSalaForm" class="popup-form">
            <form method="post" action="criar_sala.php">
                <label for="nomeSala">Nome da Sala:</label>
                <input type="text" name="nomeSala" required>

                <!--<label for="categoriaSala">Categoria:</label>-->
                <input type="hidden" name="categoriaSala"  value="<?php echo $categoriaSala1; ?>">

                <input type="hidden" name="idusuario"  value="<?php echo $id_user; ?>" >

                <label for="privacidade">Privacidade:</label>
                <select name="privacidade" required>
                    <option value="0">Público</option>
                    <option value="1">Privado</option>
                </select>

                <div class="botao_criar"><button type="submit">Criar</button></div>
            </form>
        </div>
        <!-- Adicione abaixo do botão de voltar ao topo -->
        <div class="overlay"></div>
        <div class="overlay" onclick="fecharPopUp()"></div>

        <script>
            function fecharPopUp() {
                var overlay = document.querySelector('.overlay');
                var form = document.getElementById('criarSalaForm');

                if (overlay && form) {
                    overlay.style.display = 'none';
                    form.style.display = 'none';
                }
            }

            function toggleForm() {
                //console.log('toggleForm foi chamada');
                
                var overlay = document.querySelector('.overlay');
                var form = document.getElementById('criarSalaForm');

                //console.log('overlay:', overlay);
                //console.log('form:', form);

                if (!overlay || !form) {
                    console.log('Elementos não encontrados');
                    return;
                }

                overlay.style.display = overlay.style.display === 'none' || overlay.style.display === '' ? 'block' : 'none';
                form.style.display = form.style.display === 'none' || form.style.display === '' ? 'block' : 'none';
            }
        </script>
        <?php 
            require "rodape.php"; 
        ?>
        <script src="js/darkmode.js"></script>
        <script src="js/zoom.js"></script>
    </body>
</html>