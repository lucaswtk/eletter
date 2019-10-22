<?php

require __DIR__ . '/../../../../../vendor/autoload.php';

use Dompdf\Dompdf;
use Source\Model\Template;

// Instância do modelo de template
$template = new Template();

// Obtém o conteúdo html do template
$content = $template->findById($id)->data()->content;

// Instância de DomPDF
$dompdf = new Dompdf();

// Abre sessão que não armazena cache do conteúdo
ob_start();

// Escreve o conteúdo HTML na página
echo htmlspecialchars_decode($content);

// Carrega o código HTML no arquivo pdf
$dompdf->loadHtml(ob_get_clean());

// Aplica o tipo da folha
$dompdf->setPaper('A4');

// Renderiza a página
$dompdf->render();

// Abre o PDF no navegador
$dompdf->stream('templatePreview.pdf', ['Attachment' => false]);

