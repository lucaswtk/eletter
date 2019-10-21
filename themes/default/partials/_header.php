<header class="main-header">

	<!-- Fixed navbar -->
	<nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">

		<!-- Brand -->
		<!-- Image and text -->
		<nav class="navbar navbar-light bg-light">
			<a class="navbar-brand" href="<?= BASE . '/dashboard/'; ?>">
				<img class="d-inline-block align-top mr-1" src="<?= INCLUDE_PATH . '/assets/media/brands/eletter-1.png'; ?>" alt="<?= SITE_NAME; ?>" title="<?= SITE_NAME; ?>" height="30">
				eLetter
			</a>
		</nav>

		<!-- Toggler -->
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<!-- Collapse -->
		<div class="collapse navbar-collapse" id="navbarCollapse">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="<?= BASE . '/dashboard/'; ?>">Home</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarOrgan" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Órgão
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarOrgan">
						<?php if ($_SESSION['userLogin']['status'] == USER_DEV): ?>
							<a class="dropdown-item" href="<?= BASE . '/organ/new'; ?>">Novo</a>
							<a class="dropdown-item" href="<?= BASE . '/organ/all'; ?>">Listar todos</a>
						<?php else: ?>
							<a class="dropdown-item" href="<?= BASE . "/organ/edit/{$_SESSION['userLogin']['organ_id']}"; ?>">Configurar dados</a>
						<?php endif; ?>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarUser" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Usuário
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarUser">
						<a class="dropdown-item" href="<?= BASE . '/user/new'; ?>">Novo</a>
						<a class="dropdown-item" href="<?= BASE . '/user/all'; ?>">Listar todos</a>
					</div>
				</li>
				<?php if ($_SESSION['userLogin']['organ_id']): ?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarLetter" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Carta
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarLetter">
							<a class="dropdown-item" href="<?= BASE . '/letter/template/new'; ?>">Novo template</a>
							<a class="dropdown-item" href="<?= BASE . '/letter/template/all'; ?>">Listar templates</a>
							<a class="dropdown-item" href="<?= BASE . '/letter/new'; ?>">Nova</a>
							<a class="dropdown-item" href="<?= BASE . '/letter/all'; ?>">Listar todas</a>
						</div>
					</li>
				<?php endif; ?>
				<li class="nav-item">
					<a class="nav-link text-danger" href="<?= BASE . '/signOut'; ?>">Sair</a>
				</li>
			</ul>
			<!--/.navbar-nav-->
		</div>
		<!--/.collapse-->
	</nav>
	<!--/.navbar-->
</header>
<!--/.main-header-->