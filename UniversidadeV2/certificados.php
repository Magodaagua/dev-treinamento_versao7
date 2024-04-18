<?php
    // http://dev.intranet.copimaq.local/CURSOS/certificados.php

    //pega as informações passadas pela URL
    $Nome_curso = isset($_GET['Nome_curso']) ? $_GET['Nome_curso'] : null;
    $carga_horaria = isset($_GET['carga_horaria']) ? $_GET['carga_horaria'] : null;
    $Nome_usuario = isset($_GET['Nome_usuario']) ? $_GET['Nome_usuario'] : null;
    $data = isset($_GET['data']) ? $_GET['data'] : null;

    // referenciar o DomPDF com namespace
    use Dompdf\Dompdf;
    use Dompdf\Options;

    // include autoloader
    //require_once("dompdf/autoload.inc.php");
    require 'dompdf/vendor/autoload.php';

    // Criando a Instancia
    $options = new Options();
    $options->set('chroot', $_SERVER['DOCUMENT_ROOT']);
    $dompdf = new Dompdf($options);


    // Caminho para o arquivo CSS
    $css_path = "css/certificado.css";

    // Carrega seu HTML com o certificado
    $html = "
                <div class='containerCertificado'>
                    <div class='imagemdefundo'>
                        <div class='topoimagem'>
                        </div>
                        <div class='selo'>
                            <img src='../../COMUM/img/certificado/selo.png'>
                        </div>
                        <div class='topotitulo'>
                            <div class='titulo'>
                                Copimaq
                            </div>
                        </div>
                        <div class='toponomedaempresa'>
                            <div class='textoum'>
                                Certificado de Conclusão de Curso
                            </div>
                        </div>
                        <br><br>
                        <div class='textomeio'>
                                <div class=textodois>
                                    A Copimaq de Campinas, por meio deste,<br>
                                    certifica que $Nome_usuario concluiu o curso de $Nome_curso,<br> 
                                    em $data, com carga horária de $carga_horaria horas</div>
                                </div>
                            <br><br>
                        <div class='final'>
                            <div class='assinaturaesquerda'>_________________________
                                <br>(assinatura do dono)
                                </div>
                            <div class='assinaturadireita'>__________________________
                                <br>(assinatura do instrutor)
                            </div>
                        </div>
                    </div>
                </div>
            ";

    // Carrega o conteúdo do arquivo CSS
    $css_content = file_get_contents($css_path);

    // Adiciona o estilo ao HTML
    $html_with_css = "<style>$css_content</style> $html";

    // Carrega o HTML com o CSS
    $dompdf->load_html($html_with_css);

    $dompdf->setPaper('A4', 'landscape');
    
    // Renderizar o html
    $dompdf->render();

    // Exibir a página
    $dompdf->stream(
        "certificado.pdf",
        array(
            "Attachment" => false //Para realizar o download somente alterar para true
        )
    );
?>
