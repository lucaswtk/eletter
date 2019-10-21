<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - Órgãos Cadastrados'
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			Órgãos Cadastrados
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
							<th scope="col">#</th>
							<th scope="col">Nome</th>
							<th scope="col">Sigla</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (empty($organs)):
							$v->insert('partials/_table-noRegister', [
								'tableNoRegister' => $organs,
								'tableNoRegisterColspan' => '4',
								'tableNoRegisterApp' => 'órgãos'
							]);
						else:
							foreach ($organs as $organ): ?>
								<tr data-deleteHtml="organ-<?= $organ->id; ?>">
									<th scope="row" style="width: 5rem;">
										<img src="<?= BASE . '/tim.php?src=/' . ($organ->brand ?: AVATAR_DEFAULT) . '&w=50&h=50'; ?>" alt="<?= $organ->name; ?>" title="<?= $organ->name; ?>">
									</th>
									<td>
										<?= $organ->name; ?>
									</td>
									<td>
										<?= $organ->initials; ?>
									</td>
									<td class="text-right" style="width: 10rem;">

										<!-- Edit -->
										<a class="btn btn-sm btn-outline-primary" href="<?= "{$router->route('organ.edit')}/{$organ->id}"; ?>" title="Editar detalhes">
											Editar
										</a>

										<!-- Delete -->
										<button class="btn btn-sm btn-outline-danger" title="Deletar" data-action="delete" data-url="<?= $router->route('organ.delete'); ?>" data-id="<?= $organ->id; ?>">
											Deletar
										</button>
									</td>
								</tr>
							<?php
							endforeach;

							$v->insert('partials/_table-noRegister', [
								'tableNoRegister' => $organs,
								'tableNoRegisterColspan' => '4',
								'tableNoRegisterApp' => 'órgãos'
							]);
						endif; ?>
					</tbody>
				</table>
				<!--/.table-->
			</div>
			<!--/.table-responsive-->
		</div>
	</div>
</main>