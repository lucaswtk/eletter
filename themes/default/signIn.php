<?php $v->layout('_template', [
	'title' => SITE_NAME . ' - Entrar!',
	'bodyClass' => 'align-items-center justify-content-center bg-light'
]); ?>

<form class="text-center my-5" id="form-signin" method="post" action="<?= $router->route('access.validateSignIn'); ?>" enctype="multipart/form-data">

	<!-- Brand -->
	<img class="mb-3" src="<?= INCLUDE_PATH . '/assets/media/brands/eletter-1.png'; ?>" alt="<?= SITE_NAME; ?>" title="<?= SITE_NAME; ?>" height="50px">

	<!-- Heading -->
	<h1 class="h3 mb-5 font-weight-normal">
		eLetter
	</h1>

	<!-- Username -->
	<div class="form-group">
		<input class="form-control" type="text" name="username" placeholder="Usuário" required autofocus value="dev.system">
	</div>

	<!-- Password -->
	<div class="form-group">
		<input class="form-control" type="password" name="password" placeholder="Senha" required value="dev">
	</div>

	<!-- Submit -->
	<button class="btn btn-primary btn-block" type="submit">
		Entrar
	</button>

	<!-- Copyright -->
	<p class="mt-3 mb-0 text-muted">eLetter &copy; <?= date('Y'); ?></p>
</form>