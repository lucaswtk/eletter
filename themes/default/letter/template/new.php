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
			<div class="col-lg-8">

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
								<button class="btn btn-sm btn-light" type="button" data-previewPDF="<?= $router->route('template.previewPDF') . $id; ?>">
									Pré-visualizar
								</button>
							<?php endif; ?>
						</div>
						<textarea class=" form-control
							" name="content" rows="14" required><?= (!empty($content) ? $content : ''); ?></textarea>
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
			<!--/.col-->

			<div class="col-lg-4 mt-5 mt-lg-0">

				<!-- Card -->
				<div class="card">
					<div class="card-header">

						<!-- Heading -->
						<h5 class="mb-0">
							Metadados
						</h5>
					</div>
					<!--/.card-header-->

					<?php if (empty($id)): ?>
						<div class="card-body">
							<p class="card-text">
								Os metadados serão listados após o cadastro do template.
							</p>
						</div>
						<!--/.card-body-->
					<?php elseif (empty($metadata)): ?>
						<div class="card-body">
							<p class="card-text">
								Não existem metadados cadastrados.
							</p>
						</div>
						<!--/.card-body-->
					<?php else: ?>
						<ul class="list-group list-group-flush">
							<?php foreach ($metadata as $meta): ?>
								<li class="list-group-item d-flex align-items-center justify-content-between">
									<?= $meta->name; ?>

									<!-- Actions -->
									<div>

										<!-- Active -->
										<button class="btn btn-sm btn-light rounded-pill" type="button" data-ajaxRequest data-url="<?= ($router->route('template.createMetadata')); ?>" data-template_id="<?= $id; ?>" data-field_id="<?= $meta->id; ?>" data-hideHtmlNoEffect="add-<?= $meta->id; ?>" data-showHtmlNoEffect="add-<?= $meta->id; ?>" <?= (!empty($metadataEnabled) && in_array($meta->id, $metadataEnabled) ? 'style="display: none;"' : ''); ?>>
											<i class="fas fa-power-off text-secondary"></i>
										</button>

										<!-- Inactive -->
										<button class="btn btn-sm btn-light rounded-pill" type="button" data-ajaxRequest data-url="<?= ($router->route('template.deleteMetadata')); ?>" data-template_id="<?= $id; ?>" data-field_id="<?= $meta->id; ?>" data-hideHtmlNoEffect="remove-<?= $meta->id; ?>" data-showHtmlNoEffect="remove-<?= $meta->id; ?>" <?= (!empty($metadataEnabled) && in_array($meta->id, $metadataEnabled) ? '' : 'style="display: none;"'); ?>>
											<i class="fas fa-power-off text-success"></i>
										</button>

										<!-- Required True -->
										<button class="btn btn-sm btn-light rounded-pill" type="button" data-ajaxRequest data-url="<?= ($router->route('template.updateMetadata')); ?>" data-template_id="<?= $id; ?>" data-field_id="<?= $meta->id; ?>" data-required="1" data-hideHtmlNoEffect="update-1-<?= $meta->id; ?>" data-showHtmlNoEffect="update-1-<?= $meta->id; ?>" <?= (!empty($metadataRequired) && in_array($meta->id, $metadataRequired) ? 'style="display: none;"' : ''); ?>>
											<i class="fas fa-exclamation-circle text-secondary"></i>
										</button>

										<!-- Required False -->
										<button class="btn btn-sm btn-light rounded-pill" type="button" data-ajaxRequest data-url="<?= ($router->route('template.updateMetadata')); ?>" data-template_id="<?= $id; ?>" data-field_id="<?= $meta->id; ?>" data-required="0" data-hideHtmlNoEffect="update-0-<?= $meta->id; ?>" data-showHtmlNoEffect="update-0-<?= $meta->id; ?>" <?= (!empty($metadataRequired) && in_array($meta->id, $metadataRequired) ? '' : 'style="display: none;"'); ?>>
											<i class="fas fa-exclamation-circle text-success"></i>
										</button>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<!--/.card-->
			</div>
			<!--/.col-->
		</div>
		<!--/.row-->
	</div>
</main>

<?php $v->start('js'); ?>
<script defer src="https://use.fontawesome.com/releases/v5.11.2/js/solid.js" integrity="sha384-Mf3ap7OwO+bjTkzM1RsrothLh38uKXvMWJ2TQPXGHqZcqfeI/cyCV+sfV0IDnBDq" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.11.2/js/fontawesome.js" integrity="sha384-EYYaHDhIRoBhd/Ir/1fPnxg9rZLk/55lKtlNT5KrIcONoCS2kjf7ZWzMoCLLACeo" crossorigin="anonymous"></script>
<?php $v->end(); ?>
