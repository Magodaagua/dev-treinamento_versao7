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
       $dep = $row_usuario['Dep'];
       $nome_usuario = $row_usuario['Nome'];
       //Verificar se está sendo passado na URL a página atual, senao é atribuido a pagina 

       //Selecionar os cursos a serem apresentado na página
       $result_inscricao = "SELECT * FROM inscricao WHERE id_usuario = '$id_user'";
       $resultado_inscricao = mysqli_query($conn, $result_inscricao);
       $total_inscricao = mysqli_num_rows($resultado_inscricao);

       $result_cursos2 = "  SELECT c.ID_curso, c.Nome, c.Categoria, c.Subcategoria, c.Descricao, c.Datadecriacao, c.Carga_horaria, c.inscritos, c.imagem, i.progresso
                           FROM curso c
                           INNER JOIN inscricao i ON c.ID_curso = i.id_curso
                           WHERE i.id_usuario = '$id_user'";

       $resultado_cursos2 = mysqli_query($conn, $result_cursos2);
       $total_cursos2 = mysqli_num_rows($resultado_cursos2);

       // Contar o total de cursos na categoria
       $result_contagem = "SELECT COUNT(*) AS total FROM inscricao WHERE id_usuario = '$id_user'";
       $contagem_resultado = mysqli_query($conn, $result_contagem);
       $contagem = mysqli_fetch_assoc($contagem_resultado);
       $total_meus_cursos = $contagem['total'];

	?>
    <head>
    <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">

        <title>Portal de Cursos - Meus Certificados</title>
        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../COMUM/img/Icons/Vermelho/copi.png">
        <!--CSS -->
        <link rel="stylesheet" type="text/css" href="css/titulo.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!--<link href="css/curso.css" rel="stylesheet">-->

    </head>
    <body>
        <?php require 'titulo.php'; ?>
            <?php }?> 
            <main>
                <h1><br><br><br><br>
                    <center>
                        Meus Certificados
                    </center>
                </h1><br>
                <div class="container theme-showcase">
                    <?php
                        while ($row_curso = mysqli_fetch_assoc($resultado_cursos2)) {
                            $data_atualizada = intval($row_curso["Datadecriacao"]);
                            date_default_timezone_set('America/Sao_Paulo'); // Defina o fuso horário para São Paulo, por exemplo
                            $meses = array(
                                1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                            );
                            
                            $data_legivel = date('d \d\e ', $data_atualizada) . $meses[date('n', $data_atualizada)] . date(' \d\e Y', $data_atualizada);
                            //echo date('d \d\e F \d\e Y', $data_atualizada); // Verifique o valor da data formatada
                            //$data_legivel = date('d \d\e F \d\e Y', $data_atualizada);

                            echo '<div class="certificado d-flex align-items-center justify-content-between mb-4">';
                            
                            echo '<div class="certificado-info d-flex align-items-center">';
                            echo '<img class="imagemdocertificado" src="../COMUM/img/treinamento/certificado.png" alt="Diploma" class="diploma-img">';
                            echo '<h2 class="titulo-curso">' . $row_curso['Nome'] . '</h2>';
                            echo '</div>';
                            
                            echo '<div class="info-curso flex-grow-1 mx-3">';
                            echo '<div class="progress-bar-container">';
                            echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width:' . $row_curso['progresso'] . '%; background-color: #28a745;">';
                            echo '<span class="progress-text">'. $row_curso['progresso'] .'%</span>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                            
                            echo '<div class="text-right">';
                            // Lógica para habilitar/desabilitar o botão de download
                            $isDownloadEnabled = ($row_curso['progresso'] == 100);
                            $buttonClass = $isDownloadEnabled ? 'btn btn-primary' : 'btn btn-secondary';
                            $buttonDisabled = $isDownloadEnabled ? '' : 'disabled';

                            //$fileName = 'certificado_' . $row_curso['Nome'] . '.png'; // Nome do arquivo de teste (ajuste conforme necessário)

                            //echo '<a href="#" class="' . $buttonClass . ' btn-download" ' . $buttonDisabled . ' download="' . $fileName . '">Download</a>';
                            //echo '<a href="certificados.php" id="downloadButton_' . $row_curso['ID_curso'] . '" class="' . $buttonClass . ' btn-download" ' . $buttonDisabled . ' download="' . $fileName . '">Download</a>';
                            echo '<a href="certificados.php?Nome_curso=' . $row_curso['Nome'] . '&carga_horaria='. $row_curso['Carga_horaria'] .'&Nome_usuario=' . $nome_usuario . '&data='.$data_legivel.'" id="downloadButton_' . $row_curso['ID_curso'] . '" class="' . $buttonClass . ' btn-download" ' . $buttonDisabled . '">Download</a>';
                            echo '</div>';
                            
                            echo '</div>';
                        }
                    ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const downloadButtons = document.querySelectorAll('.btn-download');

                            downloadButtons.forEach(button => {
                                button.addEventListener('click', function(event) {
                                    if (this.hasAttribute('disabled')) {
                                        event.preventDefault(); // Impede o clique se o botão estiver desabilitado
                                    }
                                });
                            });
                        });
                    </script>

                </div>
            </main>
        <!--inicio Botão de voltar ao topo-->
        <button id="myBtn" title="Go to top">Subir</button>
        <script>window.jQuery || document.write('<script src="javascript/jquery.slim.min.js"><\/script>')</script><script src="javascript/bootstrap.bundle.min.js"></script>  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="javascript/subir.js"></script> 
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script src="javascript/darkmode.js"></script>
    </body>
</html>