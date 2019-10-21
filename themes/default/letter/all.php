<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - Usuários Cadastrados'
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			Usuários Cadastrados
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
							<th scope="col">Usuário</th>
							<th scope="col">Órgão</th>
							<th scope="col">Status</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (empty($users)):
							$v->insert('partials/_table-noRegister', [
								'tableNoRegister' => $users,
								'tableNoRegisterColspan' => '5',
								'tableNoRegisterApp' => 'usuários'
							]);
						else:
							foreach ($users as $user): ?>
								<tr data-deleteHtml="user-<?= $user->id; ?>">
									<th scope="row" style="width: 5rem;">
										<img src="<?= BASE . '/tim.php?src=/' . ($user->avatar ?: AVATAR_DEFAULT) . '&w=50&h=50'; ?>" alt="<?= "{$user->first_name} {$user->last_name}"; ?>" title="<?= "{$user->first_name} {$user->last_name}"; ?>">
									</th>
									<td>
										<?= "{$user->first_name} {$user->last_name}"; ?>
									</td>
									<td>
										<?= $user->username; ?>
									</td>
									<td>
										<?= ($user->getOrgan() ? $user->getOrgan()->initials : '---'); ?>
									</td>
									<td>
										<span class="text-<?= (!$user->status ? 'danger' : 'success'); ?>">
											● <?= (!$user->status ? 'Inativo' : 'Ativo'); ?>
										</span>
									</td>
									<td class="text-right" style="width: 10rem;">

										<!-- Edit -->
										<a class="btn btn-sm btn-outline-primary" href="<?= "{$router->route('user.edit')}/{$user->id}"; ?>" title="Editar detalhes">
											Editar
										</a>

										<!-- Delete -->
										<button class="btn btn-sm btn-outline-danger" data-action="delete" data-url="<?= $router->route('user.delete'); ?>" data-id="<?= $user->id; ?>">
											Deletar
										</button>
									</td>
								</tr>
							<?php
							endforeach;

							$v->insert('partials/_table-noRegister', [
								'tableNoRegister' => $users,
								'tableNoRegisterColspan' => '5',
								'tableNoRegisterApp' => 'usuários'
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