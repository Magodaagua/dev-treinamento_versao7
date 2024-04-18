<?php 
	require_once("php/conexao.php");
	$result_usuario = "SELECT * FROM usuario WHERE Usuario = '$usuario' ";
	$resultado_usuario = mysqli_query($conn, $result_usuario);
	while($row_usuario = mysqli_fetch_assoc($resultado_usuario)){
		$row_usuario['ID_usuario']."<br>";		
		$row_usuario['Senha']."<br>";
    $id_user = $row_usuario['ID_usuario'];
    $dep = $row_usuario['Dep'];
    $nome_usuario = $row_usuario['Nome'];

	$id_curso = $_GET['ID_curso'];

    $result_curso = "SELECT * FROM curso WHERE ID_curso = '$id_curso' ";
	$resultado_curso = mysqli_query($conn, $result_curso);
	while($row_cursos = mysqli_fetch_assoc($resultado_curso)){

  	// Obtém a data do curso e a formata
	//$data_atualizada = $row_cursos["Datadecriacao"];
    //echo $data_atualizada; // Verifique o valor da data
    $data_atualizada = intval($row_cursos["Datadecriacao"]);
    date_default_timezone_set('America/Sao_Paulo'); // Defina o fuso horário para São Paulo, por exemplo
    
    $meses = array(
        1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    );
    
    $data_legivel = date('d \d\e ', $data_atualizada) . $meses[date('n', $data_atualizada)] . date(' \d\e Y', $data_atualizada);
    //echo date('d \d\e F \d\e Y', $data_atualizada); // Verifique o valor da data formatada
    //$data_legivel = date('d \d\e F \d\e Y', $data_atualizada);
	//$data_legivel = date('d \d\e F \d\e Y', $data_atualizada); // Formata a data
    //$data_legivel = date('Y-m-d', $data_atualizada); // Formato simples para teste

	// Verifica se ID_curso e progresso estão definidos na URL
	if(isset($_GET['ID_curso']) && isset($_GET['progresso'])) {
		// Obtém o ID do curso e o progresso da URL
		$id_curso = $_GET['ID_curso'];
		$progresso = $_GET['progresso'];

		// Verifica se o progresso é igual a 2
		if($progresso == 2){
			// Insere os dados da inscrição no banco de dados
            echo $progresso;
			$result_inscricao2 = "INSERT INTO inscricao (id_curso, id_usuario, progresso, certificado) VALUES ($id_curso, $id_user, $progresso, 'sim')";
			$resultado_inscricao2 = mysqli_query($conn, $result_inscricao2);
			
			// Verifica se a inserção foi bem-sucedida
			if($resultado_inscricao2) {
				//echo "Inscrição realizada com sucesso!";
			} else {
				//echo "Erro ao realizar a inscrição.";
			}
		} else {
			//echo "Progresso inválido.";
		}
	} else {
		//echo "ID_curso e/ou progresso não definidos.";
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
	 <!-- Conexão com o banco de dados -->
	 <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <title>Site de Treinamento - Detalhes do Curso</title>
        <!--coloca o icone na aba da tela-->
        <link rel="icon" type="png" href="../COMUM/img/Icons/Vermelho/copi.png">
        <!--CSS -->
        <link rel="stylesheet" type="text/css" href="css/titulo.css">
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/detalhes.css" rel="stylesheet">
        <!--JS-->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    </head>
	<body>
        <?php require "titulo.php"; ?>
            <br><br><br>
            <div class="container my-5">
                <div class="p-5 text-center bg-body-tertiary rounded-3">
                    <div class="informativo">
                        <div class="informativo-imagem">
                            <img src="../COMUM/img/cursos/capa_dos_cursos/<?php echo $row_cursos['imagem'];?>" class="bi mt-4 mb-3" style="color: var(--bs-indigo);" width="200px" height="200px">
                        </div>
                        <div class="informativo-texto">
                        <div class="position-relative p-5 text-center text-muted bg-body border border-dashed rounded-5">
                            <h1 class="text-body-emphasis"><?php echo $row_cursos['Nome']; ?></h1>                
                            <?php

                                $porcentagens_por_modulo = array(); // Adicione esta linha para garantir que o array esteja inicializado

                                // Consulta SQL para obter a porcentagem de aulas concluídas
                                $query_porcentagem = "
                                SELECT ((COUNT(pa.id_aula_concluida) / COUNT(DISTINCT a.id)) * 100) AS porcentagem_concluida
                                FROM aulas a
                                LEFT JOIN modulos m ON a.modulo_id = m.id
                                LEFT JOIN (
                                    SELECT id_aula, 1 AS id_aula_concluida
                                    FROM progresso_aula
                                    WHERE id_usuario = :id_usuario
                                    AND id_curso = :id_curso
                                    AND concluida = 1
                                ) pa ON a.id = pa.id_aula
                                WHERE m.curso_id = :id_curso";
                                $stmt_porcentagem = $con->prepare($query_porcentagem);
                                $stmt_porcentagem->bindParam(':id_usuario', $id_user);
                                $stmt_porcentagem->bindParam(':id_curso', $id_curso);
                                $stmt_porcentagem->execute();

                                $query_inscricao = "SELECT progresso FROM inscricao WHERE id_usuario = :id_user AND id_curso = :id_curso";
                                $stmt_inscricao = $con->prepare($query_inscricao);
                                $stmt_inscricao->bindParam(':id_user', $id_user);
                                $stmt_inscricao->bindParam(':id_curso', $id_curso);
                                $stmt_inscricao->execute();

                                if ($stmt_porcentagem) {
                                    $row_porcentagem = $stmt_porcentagem->fetch(PDO::FETCH_ASSOC);
                                    $porcentagemConclusao = isset($row_porcentagem['porcentagem_concluida']) ? $row_porcentagem['porcentagem_concluida'] : 0;
                                

                                    // Arredonda para no máximo 2 casas decimais
                                    $porcentagemConclusao = number_format($porcentagemConclusao, 2);

                                    // Restante do seu código...
                                } else {
                                    echo "<p style='color: #f00;'>Erro: Falha ao executar a consulta de porcentagem!</p>";
                                }

                                // Forçar o update na tabela 'inscricao'
                                $query_forcar_update = "UPDATE inscricao SET progresso = :progresso WHERE id_usuario = :id_user AND id_curso = :id_curso";
                                
                                // Preparar e executar a query
                                try {
                                    $stmt_forcar_update = $con->prepare($query_forcar_update);
                                    $stmt_forcar_update->bindParam(':progresso', $porcentagemConclusao);
                                    $stmt_forcar_update->bindParam(':id_user', $id_user);
                                    $stmt_forcar_update->bindParam(':id_curso', $id_curso);
                                    $stmt_forcar_update->execute();
                                
                                    //echo "Update forçado realizado com sucesso!";
                                } catch (PDOException $e) {
                                    echo "Erro ao forçar o update: " . $e->getMessage();
                                }
                                
                            ?>
                                <!--circulo de conclusão-->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <span class="ml-2">Progresso:</span>
                                    </div>
                                    <div class="progress" style="width: 70%; margin: 0 20px;">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?php echo "$porcentagemConclusao"; ?>%" aria-valuenow="<?php echo $porcentagemConclusao; ?>" aria-valuemin="0" aria-valuemax="1000"></div>
                                    </div>
                                    <span class="mr-4"><?php echo $porcentagemConclusao;?>%</span>
                                </div><br>
                                    <script>
                                        document.getElementById('downloadButton').addEventListener('click', function(event) {
                                            // Impede o comportamento padrão do botão
                                            event.preventDefault();

                                            // Verifica se o botão não está desativado e a porcentagem é 100%
                                            if (!this.hasAttribute('disabled') && <?php echo $porcentagemConclusao; ?> == 100) {
                                                // Cria um link temporário e simula o clique para iniciar o download
                                                var link = document.createElement('a');
                                                link.href = 'admin/pdf/32/sites.txt';
                                                link.download = 'sites.txt';
                                                link.target = '_blank'; // Abre o link em uma nova guia
                                                document.body.appendChild(link);
                                                link.click();
                                                document.body.removeChild(link);
                                            }
                                        });

                                            // Função para atualizar dinamicamente o progresso
                                            function atualizarProgresso() {
                                                $.ajax({
                                                    url: 'php/atualizar_progresso.php', // Caminho para o script PHP de atualização
                                                    method: 'GET',
                                                    data: { id_user: <?php echo $id_user; ?>, id_curso: <?php echo $id_curso; ?> },
                                                    success: function(data) {
                                                        // Atualiza a barra de progresso com os dados recebidos do servidor
                                                        $('#progress-container .progress-bar').css('width', data.progresso + '%');
                                                        $('#progress-container #progress-text').text(data.progresso + '%');
                                                    },
                                                    error: function() {
                                                        console.error('Erro ao atualizar o progresso.');
                                                    }
                                                });
                                            }

                                            // Chame a função de atualização periodicamente (por exemplo, a cada 30 segundos)
                                            setInterval(atualizarProgresso, 30000);
                                    </script>
                                </p>
                                <Style>
                                    .descricao{
                                        text-align:left; 
                                    }

                                    .data-t{
                                        width: 100%;
                                        /*border: 1px solid black;*/
                                        text-align:right;
                                        opacity: 0.8;
                                    }

                                </style>
                                <h5 class="descricao">Nome do instrutor:</h5>
                                <h6 class="descricao"><?php echo $row_cursos['Autor']; ?></h6>
                                <h5 class="descricao">Descrição:</h5>
                                <h6 class="descricao"><?php echo $row_cursos['Descricao']; ?></h6>
                                <br>
                                <div class="data-t">
                                    <h7> <?php echo "O curso foi criado em: " . date('d/m/Y', strtotime($row_cursos['Datadecriacao'])); ?></h7>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container my-5">
                <!-- Nav tabs -->
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#resumo" role="tab" aria-controls="home" aria-selected="true">Aulas</a>
                        <a class="nav-item nav-link" id="nav-certificado-tab" data-toggle="tab" href="#certificado" role="tab" aria-controls="certificado_aula" aria-selected="false">Certificado</a>
                    </div>
                </nav>
                <div class="position-relative p-2 text-justify text-muted bg-body border rounded-5">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade" id="certificado" role="tabpanel" aria-labelledby="nav-certificado-tab">
                            <div class="text-center" style="padding-top: 20px;">
                                <h1 class="text-body-emphasis">&nbsp;Certificado</h1>
                                <div class="col-sm-10 offset-sm-1"> <!-- Adicionado a classe mx-auto -->
                                    <center>
                                        <img src="../COMUM/img/treinamento/certificado.png"><br>
                                        <a href="certificados.php?Nome_curso=<?php echo $row_cursos["Nome"];?>&carga_horaria=<?php echo $row_cursos['Carga_horaria'];?>&Nome_usuario=<?php echo $nome_usuario;?>&data=<?php echo $data_legivel;?>"><button type="button" class="btn <?php echo ($porcentagemConclusao == 100) ? 'btn-primary' : 'btn-secondary'; ?>" data-dismiss="modal" <?php echo ($porcentagemConclusao < 100) ? 'disabled' : ''; ?> id="downloadButton">
                                            Baixar Diploma
                                        </button></a><br><br><br><br>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="resumo" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div style="padding-top:20px;">
                                <form class="form-horizontal" action="" method="POST">
                                    <h1>&nbsp;<center>Aulas</center></h1><br>
                                    <div class="col-sm-12">
                                        <p class="col-lg-6 mx-auto mb-4">
                                            <!-- Aqui você pode inserir o código PHP que exibe as aulas e módulos de acordo com a estrutura anterior -->
                                            <?php

                                                // Recupere as aulas e módulos do curso no BD
                                                $query_aulas = "SELECT aul.id id_aul, aul.titulo, aul.ordem,
                                                mdu.id id_mdu, mdu.nome nome_mdu
                                                FROM aulas aul 
                                                INNER JOIN modulos AS mdu ON mdu.id = aul.modulo_id 
                                                WHERE mdu.curso_id=:curso_id 
                                                ORDER BY mdu.ordem, aul.ordem ASC";
                                                $result_aulas = $con->prepare($query_aulas);
                                                $result_aulas->bindParam(':curso_id', $id_curso);
                                                $result_aulas->execute();

                                                // Consulta para contar o número total de aulas por módulo
                                                $query_count_aulas = "SELECT modulo_id, COUNT(*) as total_aulas FROM aulas WHERE modulo_id IN (SELECT id FROM modulos WHERE curso_id=:curso_id) GROUP BY modulo_id";
                                                $stmt_count_aulas = $con->prepare($query_count_aulas);
                                                $stmt_count_aulas->bindParam(':curso_id', $id_curso);
                                                $stmt_count_aulas->execute();
                                                $count_aulas_por_modulo = array();

                                                // Use um loop para exibir os módulos e aulas
                                                if (($result_aulas) and ($result_aulas->rowCount() != 0)) {
                                                    $modulo_anterior = null;
                                                    $num_aulas_modulo = 0; // Contador de aulas para o módulo atual

                                                    while ($row_count_aulas = $stmt_count_aulas->fetch(PDO::FETCH_ASSOC)) {
                                                        $count_aulas_por_modulo[$row_count_aulas['modulo_id']] = $row_count_aulas['total_aulas'];
                                                    }
                                                    
                                                    $modulo_anterior = null;

                                                    while ($row_aula = $result_aulas->fetch(PDO::FETCH_ASSOC)) {
                                                        extract($row_aula);

                                                        if ($modulo_anterior !== $id_mdu) {
                                                            if (!is_null($modulo_anterior)) {                         
                                                                echo "</div>";
                                                            }

                                                            echo "<div class='modulo'>
                                                                    <h5>Nome do módulo: $nome_mdu</h5>
                                                                    <div class='fundo-transparente'>
                                                                        <img class='seta' src='../COMUM/img/treinamento/seta.png' width='30' height='30'>
                                                                        <div class='num-aulas'>Aulas: ";
                                                                    // Exibe o número total de aulas no módulo atual
                                                                    echo isset($count_aulas_por_modulo[$id_mdu]) ? $count_aulas_por_modulo[$id_mdu] : 0;

                                                                echo "      </div>
                                                                        </div>
                                                                    </div>";
                                                            echo "<div class='aulas' style='display: none'>";
                                                        }

                                                        // Verifica se a aula está cadastrada na tabela progresso_aula
                                                        $query_progresso = "SELECT * FROM progresso_aula WHERE id_usuario = $id_user AND id_aula = $id_aul";
                                                        $resultado_progresso = mysqli_query($conn, $query_progresso);

                                                        if ($resultado_progresso) {
                                                            $registro_progresso = mysqli_fetch_assoc($resultado_progresso);
                            
                                                            if ($registro_progresso) {
                                                                // Se houver um registro, a aula já foi iniciada
                                                                if ($registro_progresso['concluida']) {
                                                                    // Se a aula foi concluída, exibir o botão "Finalizado"
                                                                    echo "<div class='aula'>
                                                                            <div class='aula-inner'>
                                                                                <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='btn btn-success' href='visualizar_aula.php?id_usuario=$id_user&id=$id_aul&modulo_id=$id_mdu&curso_id=$id_curso&porcentagem=$porcentagemConclusao'>Concluído</a> | Status: <font color= green> Concluído </font>
                                                                            </div>
                                                                        </div>";
                                                                } else {
                                                                    // Se a aula está em andamento, exibir o botão "Continuar"
                                                                    echo "<div class='aula'>
                                                                            <div class='aula-inner'>
                                                                                <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='btn btn-primary' href='visualizar_aula.php?id_usuario=$id_user&id=$id_aul&modulo_id=$id_mdu&curso_id=$id_curso&porcentagem=$porcentagemConclusao'>Continuar</a> | Status: <font color=#4169e1> Em andamento </font> </p>
                                                                            </div>
                                                                        </div>";
                                                                }
                                                            } else {
                                                                // Se não houver registro, a aula ainda não foi iniciada
                                                                // Exibir o botão "Começar"
                                                                echo "<div class='aula'>
                                                                        <div class='aula-inner'>
                                                                            <p class='aula-titulo'>Aulas: $ordem | Título: $titulo | <a class='btn btn-danger' href='php/iniciar_aula.php?id_usuario=$id_user&id_aula=$id_aul&modulo_id=$id_mdu&curso_id=$id_curso&porcentagem=$porcentagemConclusao'>Começar</a> | Status: <font color= red> Não iniciado </font> 
                                                                        </div>
                                                                    </div>";
                                                            }
                                                        } else {
                                                            // Trate o erro, se houver algum
                                                            echo "Erro na consulta: " . mysqli_error($conn);
                                                        }

                                                        $modulo_anterior = $id_mdu;
                                                    }

                                                    // Adiciona o texto para o último módulo
                                                    //echo "<div class='num-aulas'>Aulas: $num_aulas_modulo</div>";
                                                    // Fecha o último contêiner das aulas
                                                        if (!is_null($modulo_anterior)) {
                                                            echo "</div>";
                                                        }
                                                    //echo "</div>"; // Fecha o contêiner do último módulo
                                                    echo "</div>"; // Fecha o contêiner geral
                                                } else {
                                                    echo "<p style='color: #f00;'>Erro: Nenhuma aula encontrada!</p>";
                                                }
                                            }
                                            }
                                            ?>
                                        </p>
                                    </div>
                                <form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!--inicio Botão de voltar ao topo-->
        <button id="myBtn" title="Go to top">Subir</button>
        <script>window.jQuery || document.write('<script src="javascript/jquery.slim.min.js"><\/script>')</script><script src="javascript/bootstrap.bundle.min.js"></script>  
        <script src="javascript/menu.js" defer></script>
        <script src="javascript/subir.js"></script>
        <script src="javascript/darkmode.js"></script>
	</body>
</html>