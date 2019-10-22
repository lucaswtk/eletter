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

		<!-- Create User -->
		<form method="post" action="<?= (!empty($id) ? $router->route('letterTemplate.update') : $router->route('letterTemplate.create')); ?>">
			<?php if (!empty($id)): ?>
				<input type="hidden" name="id" value="<?= $id; ?>">
			<?php endif; ?>

			<!-- Row -->
			<div class="row">
				<div class="col-md-8">

					<!-- Name -->
					<div class="form-group">
						<label>Nome:</label>
						<input class="form-control" type="text" name="name" required autofocus <?= (!empty($name) ? "value=\"{$name}\"" : ''); ?>>
					</div>

					<!-- Content -->
					<div class="form-group">
						<label>Conteúdo HTML:</label>
						<textarea class="form-control" name="content" rows="10" required><?= (!empty($content) ? $content : ''); ?></textarea>
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
				</div>
				<!--/.col-->

				<div class="col-md">

					<!-- Card -->
					<div class="card">
						<div class="card-body">
							<!-- Heading -->
							<p class="font-weight-bold">
								Campos Específicos
							</p>

							<!-- Generated Form -->
							<div data-generatedForm="template">
								Nenhum campo foi adicionado.
							</div>

							<!-- Divider -->
							<hr>

							<!-- Form Generator -->
							<div data-formGenerator="template">

								<!-- Type -->
								<div class="form-group">
									<label>Atributo type:</label>
									<select class="form-control" data-formGenerator-type>
										<option value="text">Texto</option>
										<option value="date">Data</option>
										<option value="email">E-mail</option>
									</select>
								</div>

								<!-- Name -->
								<div class="form-group">
									<labels>Atributo name:</labels>
									<input class="form-control" type="text" data-formGenerator-name>
								</div>

								<!-- Requried -->
								<div class="form-group">
									<label>Obrigatório:</label>
									<select class="form-control" data-formGenerator-required>
										<option value="0">Não</option>
										<option value="1">Sim</option>
									</select>
								</div>

								<!-- Add -->
								<button class="btn btn-primary btn-block" type="button">
									Adicionar
								</button>
							</div>
							<!--/.formGenerator-->
						</div>
						<!--/.card-body-->
					</div>
					<!--/.card-->
				</div>
				<!--/.col-->
			</div>
			<!--/.row-->
		</form>
	</div>
</main>