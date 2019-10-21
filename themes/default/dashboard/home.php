<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - Página Inicial'
]);
?>

<main role="main" class="flex-shrink-0 d-flex align-items-center" style="min-height: calc(100% - 56px);">
	<div class="container text-center">
		<h1>Bem-Vindo(a), <?= $_SESSION['userLogin']['first_name']; ?>!</h1>
		<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, necessitatibus.</p>
	</div>
</main>