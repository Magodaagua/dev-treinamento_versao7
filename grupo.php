<!doctype html>
<html lang="pt-br">
    <!-- Conexão com o banco de dados -->
	<?php
        include_once("php/conexao.php");

        $result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
        $resultado_usuario = mysqli_query($conn, $result_usuario);
        while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
            $row_usuario['ID_usuario']."<br>";		
            $row_usuario['Senha']."<br>"; 

        $id_user = $row_usuario['ID_usuario'];
        $categoriaSala = $row_usuario['Dep'];
        $nome = $row_usuario['Nome'];
        $dep = $row_usuario['Dep'];
        $nome_usuario = $row_usuario['Nome'];

        $result_categoria = "SELECT * FROM categoria WHERE Nome_cat = '$categoriaSala'";
        $resultado_categoria = mysqli_query($conn, $result_categoria);
        while($row_categoria = mysqli_fetch_assoc($resultado_categoria)){
            $row_categoria['id']."<br>";		

            $categoriaSala1 = $row_categoria['id'];
        }

	?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Grupo de Estudos</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../COMUM/img/Icons/Vermelho/copi.png">

        <!--CSS -->
        <link rel="stylesheet" type="text/css" href="css/titulo.css">
        <link href="css/curso.css" rel="stylesheet">

        <style>
            /* Adicione no seu CSS existente ou crie um arquivo separado */

            .acoes {
                position: absolute;
                top: 14%;
                right: 15px;   
            }

            .btn-criar-sala {
                margin-top: 40%;
                padding: 10px;
                background-color: #28a745;
                margin-right: 0;
                border: 3px solid black;
                color: #fff;
                border: none;
                cursor: pointer;
                border-radius: 5px; /* Borda arredondada */
            }

            .lista-salas {
                margin-top: 20px;
                overflow-y: auto; /* Adiciona uma barra de rolagem vertical quando necessário */
                max-height: 360px; /* Define uma altura máxima para a lista, ajuste conforme necessário */
                 /*border: 3px solid green;*/
            }


            .sala {
                border: 2px solid #ccc;
                padding-left: 10px;
                margin-bottom: 10px;
                display: flex;
                justify-content: left;
                align-items: center;
            }

            .nome-sala {
                font-weight: bold;
                 /*border: 3px solid green;*/
                width: 400px;
            }

            .privada {
                color: #dc3545;
                 /*border: 3px solid green;*/
                width: 300px;
            }

            .publica{
                color: #28a745;
                /*border: 3px solid green;*/
                width: 300px;
            }

            .entrar,
            .pedir-entrada,
            .continuar {
                margin-top: 5px;
                width: 150px;
                cursor: pointer;
                 /*border: 3px solid green;*/
            }

            .pedir-entrada:hover{
                background-color: #dc3545;
            }

            .botao_continuar{
                width: calc(100% - 700px);
                text-align: right;
                /*border: 3px solid green;*/
                margin: 0;
                padding-bottom: 5px;
                margin-right: 10px;
                align-items: right;
                vertical-align: center;
            }


            /* Adicione no seu CSS existente ou crie um arquivo separado */

            body {
                overflow: hidden; /* Evita a rolagem quando o pop-up está aberto */
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5); /* Fundo escuro semi-transparente */
                z-index: 998; /* Z-index menor que o pop-up para garantir que esteja por trás */
            }

            .popup-form {
                display: none;
                position: fixed;
                top: 50%;
                width:500px;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff; /* Fundo branco */
                padding: 20px;
                border: 1px solid #555; /* Cor da borda */
                border-radius: 5px; /* Borda arredondada */
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); /* Sombra */
                z-index: 999;
                color: #000; /* Cor do texto dentro do pop-up */
            }

            .popup-form form {
                max-width: 400px;
                margin: 0 auto;
            }

            .popup-form label,
            .popup-form input,
            .popup-form select,
            .popup-form button {
                display: block;
                margin-bottom: 10px;
                height: 30px;
                width: 400px;
                color: #000; /* Cor do texto dentro do formulário */
                /*text-align: center;*/
                
            }

            .popup-form button {
                width: 40%;
                display: block;
                margin: 0 auto; /* Adiciona margem automática para centralizar horizontalmente */
                border-radius: 5px; /* Borda arredondada */
                border:none;
                box-shadow: 1px 1px 5px 5px #cfcfcf;
            }

            .botao_criar{
                margin-top: 50px;
            }

            .popup-form button:hover{
                background-color: #28a745;
                color: white;
                border:none;
            }

        </style>
    </head>
    <body>
    <?php require "titulo.php"; ?>
        <?php }?> 
        <main>
            <br><br><BR><BR><br><br><br><h1>
                <center>Grupo de Estudos</center>
            </h1><br>
            <!-- Adicione abaixo do h1 -->
            <div class="acoes">
                <button class="btn-criar-sala" onclick="toggleForm()">Criar Sala de Chat</button>
            </div>

            <!-- Adicione abaixo do botão de voltar ao topo -->
            <h2>Salas de Chat</h2><br><br>
            <div class="lista-salas">

            <?php
                $result_grupos = "SELECT * FROM salas";
                $resultado_grupos = mysqli_query($conn, $result_grupos);

                while($row_grupo = mysqli_fetch_assoc($resultado_grupos)) {
                    echo '<div class="sala">';
                        echo '<span class="nome-sala">' . $row_grupo['Nome_grupo'] . '</span>';
                        
                        $id_grupo = $row_grupo['ID_grupo'];

                        // Verifica se o usuário está inscrito no grupo
                        $query_inscricao = "SELECT * FROM inscricao_grupo WHERE id_cliente = $id_user AND id_grupo = $id_grupo";
                        $resultado_inscricao = mysqli_query($conn, $query_inscricao);

                        if ($row_grupo['Privado']) {
                            echo '<span class="privada">Esta sala é privada</span>';

                            // Se o usuário já estiver inscrito, mostra o botão de continuar, senão, mostra o botão de pedir entrada
                            if (mysqli_num_rows($resultado_inscricao) > 0) {
                                echo '<div class="botao_continuar"><a href="salas.php?id_grupo=' . $id_grupo .'"><button class="btn btn-sm btn-outline-info continuar">Continuar</button></a></div>';
                            } else {
                                echo '<div class="botao_continuar"><button class="btn btn-sm btn-outline-danger pedir-entrada">Pedir para Entrar</button></div>';
                            }
                        } else {
                            echo '<span class="publica">Esta sala é pública</span>';

                            // Se o usuário já estiver inscrito, mostra o botão de continuar, senão, mostra o botão de entrar
                            if (mysqli_num_rows($resultado_inscricao) > 0) {
                                echo '<div class="botao_continuar"><a href="salas.php?id_grupo=' . $id_grupo .'"><button class="btn btn-sm btn-outline-info continuar">Continuar</button></a></div>';
                            } else {
                                echo '<div class="botao_continuar"><a class="btn-entrar" href="php/inscrever_grupo.php?id_grupo=' . $id_grupo . '&id_user=' . $id_user . '"><button class="btn btn-sm btn-outline-primary entrar">Entrar</button></a></div>';

                            }
                        }

                    echo '</div>';
                }
            ?>
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

            <!--inicio Botão de voltar ao topo-->
            <button id="myBtn" title="Go to top">Subir</button>
        </main>
        <script src="javascript/subir.js"></script> 
        <script src="javascript/darkmode.js"></script>
    </body>
</html>