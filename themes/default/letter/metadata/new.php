<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - ' . (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Metadado: ' . (!empty($id) ? $label : '')
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			<?= (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Metadado' . (!empty($id) ? ": <span data-updateText=\"label\">{$label}</span>" : ''); ?>
		</h1>

		<!-- Subheading -->
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, necessitatibus.</p>

		<!-- Divider -->
		<hr class="mb-5">

		<!-- Create User -->
		<form method="post" action="<?= (!empty($id) ? $router->route('field.update') : $router->route('field.create')); ?>">
			<?php if (!empty($id)): ?>
				<input type="hidden" name="id" value="<?= $id; ?>">
			<?php endif; ?>

			<!-- Label -->
			<div class="form-group">
				<label>Rótulo:</label>
				<input class="form-control" type="text" name="label" autofocus required <?= (!empty($label) ? "value=\"{$label}\"" : ''); ?>>
			</div>

			<!-- Type -->
			<div class="form-group">
				<label>Tipo:</label>
				<select class="form-control" name="type" required>
					<option></option>
					<option value="text" <?= (!empty($type) && $type == 'text' ? 'selected' : ''); ?>>
						Texto
					</option>
					<option value="email" <?= (!empty($type) && $type == 'email' ? 'selected' : ''); ?>>
						E-mail
					</option>
					<option value="date" <?= (!empty($type) && $type == 'date' ? 'selected' : ''); ?>>
						Data
					</option>
				</select>
			</div>

			<!-- Name -->
			<div class="form-group">
				<label>Localizador:</label>
				<input class="form-control" type="text" name="name" required <?= (!empty($name) ? "value=\"{$name}\"" : ''); ?>>
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