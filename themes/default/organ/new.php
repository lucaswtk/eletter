<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - ' . (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Órgão: ' . (!empty($id) ? $name : '')
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			<?= (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Órgão' . (!empty($id) ? ": <span data-updateText=\"name\">{$name}</span>" : ''); ?>
		</h1>

		<!-- Subheading -->
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, necessitatibus.</p>

		<!-- Divider -->
		<hr class="mb-5">

		<!-- Create User -->
		<form method="post" action="<?= (!empty($id) ? $router->route('organ.update') : $router->route('organ.create')); ?>">
			<?php if (!empty($id)): ?>
				<input type="hidden" name="id" value="<?= $id; ?>">
			<?php endif; ?>

			<!-- Row -->
			<div class="row align-items-center mb-4">
				<div class="col-md-auto mb-3 mb-md-0 text-center text-md-left">

					<!-- Img -->
					<img src="<?= BASE . '/tim.php?src=' . (!empty($brand) ? $brand : AVATAR_DEFAULT) . '&w=100&h=100'; ?>" class="rounded" alt="<?= (!empty($id) ? $name : 'Brand'); ?>" title="<?= (!empty($id) ? $name : 'Brand'); ?>" data-updateSrc="brand">
				</div>
				<!--/.col-->
				<div class="col-md">

					<!-- Avatar -->
					<div class="form-group mb-0">
						<label>Logo:</label>
						<div class="input-group">
							<div class="custom-file">
								<input class="custom-file-input" id="inputGroupFileBrand" type="file" name="brand" accept="image/jpeg, image/png" aria-describedby="inputGroupFileBrand">
								<label class="custom-file-label" for="inputGroupFileBrand" data-browse="Escolher arquivo" data-text-default="Nenhum arquivo selecionado">Nenhum arquivo selecionado</label>
							</div>
							<div class="input-group-append" <?= (empty($brand) ? 'style="display: none;"' : null); ?> data-showHtml="brand" data-hideHtml="brand">
								<button class="btn btn-danger" type="button" data-ajaxRequest data-url="<?= $router->route('organ.deleteBrand'); ?>" data-id="<?= $id; ?>">
									Remover
								</button>
							</div>
						</div>
					</div>
				</div>
				<!--/.col-->
			</div>
			<!--/.row-->

			<!-- Name -->
			<div class="form-group">
				<label>Nome:</label>
				<input class="form-control" type="text" name="name" required autofocus <?= (!empty($name) ? "value=\"{$name}\"" : ''); ?>>
			</div>

			<!-- Initials -->
			<div class="form-group">
				<label>Sigla:</label>
				<input class="form-control" type="text" name="initials" required <?= (!empty($initials) ? "value=\"{$initials}\"" : ''); ?>>
			</div>

			<!-- Submit -->
			<button class="btn btn-primary" type="submit">
				<?= (!empty($id) ? 'Atualizar' : 'Cadastrar'); ?>
			</button>

			<!-- Reset -->
			<button class="btn btn-light" type="reset">
				Resetar
			</button>
		</form>
	</div>
</main>