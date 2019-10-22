<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - Metadados Cadastrados'
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			Metadados Cadastrados
		</h1>

		<!-- Subheading -->
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, necessitatibus.</p>

		<!-- Divider -->
		<hr class="mb-5">

		<div class="card">
			<div class="table-responsive">
				<table class="table table-striped table-borderlesss mb-0">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Rótulo</th>
							<th scope="col">Localizador</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (empty($metadatas)):
							$v->insert('partials/_table-noRegister', [
								'tableNoRegister' => $metadatas,
								'tableNoRegisterColspan' => '3',
								'tableNoRegisterApp' => 'metadados'
							]);
						else:
							foreach ($metadatas as $metadata): ?>
								<tr data-deleteHtml="metadata-<?= $metadata->id; ?>">
									<td>
										<?= $metadata->label; ?>
									</td>
									<td>
										{{<?= $metadata->name; ?>}}
									</td>
									<td class="text-right" style="width: 10rem;">

										<!-- Edit -->
										<a class="btn btn-sm btn-outline-primary" href="<?= "{$router->route('field.edit')}/{$metadata->id}"; ?>" title="Editar detalhes">
											Editar
										</a>

										<!-- Delete -->
										<button class="btn btn-sm btn-outline-danger" data-action="delete" data-url="<?= $router->route('field.delete'); ?>" data-id="<?= $metadata->id; ?>">
											Deletar
										</button>
									</td>
								</tr>
							<?php
							endforeach;

							$v->insert('partials/_table-noRegister', [
								'tableNoRegister' => $metadatas,
								'tableNoRegisterColspan' => '3',
								'tableNoRegisterApp' => 'metadados'
							]);
						endif;
						?>
					</tbody>
				</table>
				<!--/.table-->
			</div>
			<!--/.table-responsive-->
		</div>
	</div>
</main>