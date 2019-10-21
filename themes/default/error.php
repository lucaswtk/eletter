<?php $v->layout('_template', [
	'title' => SITE_NAME . " - Erro {$errcode}"
]); ?>

<main role="main" class="flex-shrink-0 d-flex align-items-center" style="min-height: calc(100% - 56px);">
	<div class="container text-center">

		<!-- Heading -->
		<h1><?php echo "Erro {$errcode}"; ?>!</h1>

		<!-- Subheading -->
		<p class="lead">
			<?php
			switch ($errcode):
				case 400:
					echo 'A rota existe, mas não foi implementada!';
					break;

				case 404:
					echo 'Página não encontrada!';
					break;

				case 405:
					echo 'A rota existe e está parcialmente implementada!';
					break;

				case 501:
					echo 'O método está implementado, mas não está autorizado!';
					break;

				default:
					echo 'Definir erro';
			endswitch;
			?>
		</p>

		<!-- Back -->
		<?php if (!isset($_SESSION['userLogin'])): ?>
			<a class="btn btn-primary" href="<?= BASE; ?>" title="Voltar para tela de login">
				Ir para tela de login
			</a>
		<?php endif; ?>
	</div>
</main>