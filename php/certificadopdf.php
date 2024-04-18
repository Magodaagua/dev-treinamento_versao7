<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizador de Diploma</title>
</head>
<body>
    <embed src="diploma_output.pdf" type="application/pdf" width="100%" height="600px" />
</body>
</html>

<?php
// Função para preencher o diploma com os dados do usuário
function preencher_diploma($nome_usuario, $nome_curso, $nome_instrutor, $pdf_template, $pdf_output) {
    $pdf_reader = new \setasign\Fpdi\Fpdi();
    $pageCount = $pdf_reader->setSourceFile($pdf_template);

    $pdf = new \setasign\Fpdi\Fpdi();
    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        $templateId = $pdf->importPage($pageNo);
        $pdf->AddPage();
        $pdf->useTemplate($templateId);

        // Substitui as lacunas com os dados do usuário
        $pdf->SetFont('Arial');
        $pdf->SetFontSize(12);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY(50, 50);
        $pdf->Write(0, $nome_usuario);
        $pdf->SetXY(50, 60);
        $pdf->Write(0, $nome_curso);
        $pdf->SetXY(50, 70);
        $pdf->Write(0, $nome_instrutor);
    }

    // Salva o PDF com as informações preenchidas
    $pdf->Output($pdf_output, 'F');
}

// Exemplo de uso
$nome_usuario = "João Silva";
$nome_curso = "Programação em PHP";
$nome_instrutor = "Maria Oliveira";
$pdf_template = "diploma_template.pdf";
$pdf_output = "diploma_output.pdf";

require_once('fpdf/fpdf.php');
require_once('fpdi2/src/autoload.php');

preencher_diploma($nome_usuario, $nome_curso, $nome_instrutor, $pdf_template, $pdf_output);
?>
