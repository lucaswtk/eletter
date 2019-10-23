<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - Templates Cadastrados'
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			Templates Cadastrados
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
							<th scope="col">Nome</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (empty($templates)):
							$v->insert('partials/_table-noRegister', [
								'tableNoRegister' => $templates,
								'tableNoRegisterColspan' => '2',
								'tableNoRegisterApp' => 'templates'
							]);
						else:
							foreach ($templates as $template): ?>
								<tr data-deleteHtml="template-<?= $template->id; ?>">
									<td>
										<?= $template->name; ?>
									</td>
									<td class="text-right" style="width: 10rem;">

										<!-- Edit -->
										<a class="btn btn-sm btn-outline-primary" href="<?= "{$router->route('template.edit')}/{$template->id}"; ?>" title="Editar detalhes">
											Editar
										</a>

										<!-- Delete -->
										<button class="btn btn-sm btn-outline-danger" data-ajaxRequest data-url="<?= $router->route('template.delete'); ?>" data-id="<?= $template->id; ?>">
											Deletar
										</button>
									</td>
								</tr>
							<?php
							endforeach;

							$v->insert('partials/_table-noRegister', [
								'tableNoRegister' => $templates,
								'tableNoRegisterColspan' => '2',
								'tableNoRegisterApp' => 'templates'
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