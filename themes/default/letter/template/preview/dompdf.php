<?php

require __DIR__ . '/../../../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Source\Model\Template;

// Consulta se existe template
$template = (new Template())->findById($id);

// Não existe template
if (empty($template)) {
	$router->redirect('template.all');
}

// Instância de DomPDF
$dompdf = new Dompdf();

// Abre sessão que não armazena cache do conteúdo
ob_start();

// Escreve o conteúdo HTML na página
echo str_replace('{{page_title}}', $template->name, htmlspecialchars_decode($template->content));

// Carrega o código HTML no arquivo pdf
$dompdf->loadHtml(ob_get_clean());

// Aplica o tipo da folha
$dompdf->setPaper('A4');

// Renderiza a página
$dompdf->render();

// Abre o PDF no navegador
$dompdf->stream('templatePreview.pdf', ['Attachment' => false]);

