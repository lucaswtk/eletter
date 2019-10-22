<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - ' . (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Template: ' . (!empty($id) ? $name : '')
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			<?= (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Template' . (!empty($id) ? ": <span data-updateText=\"name\">{$name}</span>" : ''); ?>
		</h1>

		<!-- Subheading -->
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, necessitatibus.</p>

		<!-- Divider -->
		<hr class="mb-5">

		<!-- Row -->
		<div class="row">
			<div class="col-md-8">

				<!-- Create User -->
				<form method="post" action="<?= (!empty($id) ? $router->route('template.update') : $router->route('template.create')); ?>">
					<?php if (!empty($id)): ?>
						<input type="hidden" name="id" value="<?= $id; ?>">
					<?php endif; ?>

					<!-- Name -->
					<div class="form-group">
						<label>Nome:</label>
						<input class="form-control" type="text" name="name" required autofocus <?= (!empty($name) ? "value=\"{$name}\"" : ''); ?>>
					</div>

					<!-- Content -->
					<div class="form-group">
						<div class="d-flex align-items-center justify-content-between mb-2">
							<label class="mb-0">Conteúdo HTML:</label>
							<?php if (!empty($id)): ?>
								<button class="btn btn-sm btn-light" type="button" data-previewPDF="content" data-id="<?= $id; ?>">
									Pré-visualizar
								</button>
							<?php endif; ?>
						</div>
						<textarea class="form-control" name="content" rows="14" required><?= (!empty($content) ? $content : ''); ?></textarea>
					</div>

					<!-- Actions -->
					<div class="d-none d-md-block">

						<!-- Submit -->
						<button class="btn btn-primary" type="submit">
							<?= (!empty($id) ? 'Atualizar' : 'Cadastrar'); ?>
						</button>

						<!-- Reset -->
						<button class="btn btn-light" type="reset">
							Resetar
						</button>
					</div>
				</form>
			</div>
			<!--/.col-->

			<div class="col-md">

				<!-- Card -->
				<div class="card">
					<div class="card-body">
						<!-- Heading -->
						<h5 class="font-weight-bold">
							Metadados
						</h5>

						<!-- Divider -->
						<hr>

						<?php if (empty($id)): ?>
							<p class="mb-0">
								Os metadados serão liberados após o cadastro do template.
							</p>
						<?php
						else:

						endif;
						?>
					</div>
					<!--/.card-body-->
				</div>
				<!--/.card-->
			</div>
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</main>