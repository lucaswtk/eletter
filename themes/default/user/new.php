<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - ' . (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Usuário: ' . (!empty($id) ? $full_name : '')
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			<?= (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Usuário' . (!empty($id) ? ": <span data-updateText=\"name\">{$full_name}</span>" : ''); ?>
		</h1>

		<!-- Subheading -->
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, necessitatibus.</p>

		<!-- Divider -->
		<hr class="mb-5">

		<!-- Create User -->
		<form method="post" action="<?= (!empty($id) ? $router->route('user.update') : $router->route('user.create')); ?>">
			<?php if (!empty($id)): ?>
				<input type="hidden" name="id" value="<?= $id; ?>">
			<?php endif; ?>

			<!-- Row -->
			<div class="row align-items-center mb-4">
				<div class="col-md-auto mb-3 mb-md-0 text-center text-md-left">

					<!-- Img -->
					<img src="<?= BASE . '/tim.php?src=' . (!empty($avatar) ? $avatar : AVATAR_DEFAULT) . '&w=100&h=100'; ?>" class="rounded" alt="<?= (!empty($id) ? $full_name : 'Avatar'); ?>" title="<?= (!empty($id) ? $full_name : 'Avatar'); ?>" data-updateSrc="avatar">
				</div>
				<!--/.col-->
				<div class="col-md">

					<!-- Avatar -->
					<div class="form-group mb-0">
						<label>Avatar:</label>
						<div class="input-group">
							<div class="custom-file">
								<input class="custom-file-input" id="inputGroupFileAvatar" type="file" name="avatar" accept="image/jpeg, image/png" aria-describedby="inputGroupFileAvatar">
								<label class="custom-file-label" for="inputGroupFileAvatar" data-browse="Escolher arquivo" data-text-default="Nenhum arquivo selecionado">Nenhum arquivo selecionado</label>
							</div>
							<div class="input-group-append" <?= (empty($avatar) ? 'style="display: none;"' : null); ?> data-showHtml="avatar" data-hideHtml="avatar">
								<button class="btn btn-danger" type="button" data-ajaxRequest data-url="<?= $router->route('user.deleteAvatar'); ?>" data-id="<?= $id; ?>">Remover</button>
							</div>
						</div>
					</div>
				</div>
				<!--/.col-->
			</div>
			<!--/.row-->

			<!-- Row -->
			<div class="row">
				<div class="col-md-6">

					<!-- First Name -->
					<div class="form-group">
						<label>Primeiro Nome:</label>
						<input class="form-control" type="text" name="first_name" required autofocus <?= (!empty($first_name) ? "value=\"{$first_name}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Last Name -->
					<div class="form-group">
						<label>Sobrenome:</label>
						<input class="form-control" type="text" name="last_name" required <?= (!empty($last_name) ? "value=\"{$last_name}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-12">

					<!-- Mail -->
					<div class="form-group">
						<label>E-mail:</label>
						<input class="form-control" type="email" name="email" required <?= (!empty($email) ? "value=\"{$email}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Username -->
					<div class="form-group">
						<label>Nome de Usuário:</label>
						<input class="form-control" type="text" name="username" required <?= (!empty($username) ? "value=\"{$username}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Password -->
					<div class="form-group">
						<label>Senha:</label>
						<input class="form-control" type="password" name="password" <?= (!isset($id) ? 'required' : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Organ -->
					<div class="form-group">
						<label>Orgão:</label>
						<select class="form-control" name="organ_id" <?= (empty($id) || $_SESSION['userLogin']['status'] != USER_DEV || !empty($id) && $_SESSION['userLogin']['id'] != $id && $_SESSION['userLogin']['status'] == USER_DEV ? 'required' : ''); ?>>
							<?php
							if (!empty($id) && $id == $_SESSION['userLogin']['id'] && $_SESSION['userLogin']['status'] == USER_DEV):
								echo '<option>Não existe associação</option>';
							elseif (!$organs):
								echo '<option>Não existem órgãos cadastrados!</option>';
							elseif (!empty($organs->id)):
								echo "<option value='{$organs->id}'>{$organs->initials}</option>";
							elseif ($organs):
								echo '<option></option>';
								foreach ($organs as $organ):
									echo "<option value='{$organ->id}'";
									echo !empty($id) ? ($organ->id == $organ_id ? ' selected' : '') : '';
									echo ">{$organ->initials}</option>" . PHP_EOL;
								endforeach;
							endif;
							?>
						</select>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Status -->
					<div class="form-group">
						<label>Status:</label>
						<select class="form-control" name="status" required>
							<option></option>
							<option value="0" <?= (isset($status) && $status == 0 ? 'selected' : ''); ?>>Inativo</option>
							<option value="1" <?= (!empty($status) ? 'selected' : ''); ?>>Ativo</option>
						</select>
					</div>
				</div>
				<!--/.col-->
			</div>
			<!--/.row-->

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