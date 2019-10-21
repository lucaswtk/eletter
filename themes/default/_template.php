<!doctype html>
<html lang="pt-br" <?= !empty($htmlClass) ? "class=\"{$htmlClass}\"" : null; ?><?= !empty($htmlId) ? "class=\"{$htmlId}\"" : null; ?>>
	<head <?= !empty($headClass) ? "class=\"{$headClass}\"" : null; ?><?= !empty($headId) ? "class=\"{$headId}\"" : null; ?>>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

		<!-- Custom CSS -->
		<link rel="stylesheet" href="<?= INCLUDE_PATH . '/assets/css/default.css'; ?>">
		<?= $v->section('css'); ?>

		<title><?= $title; ?></title>
	</head>
	<body <?= !empty($bodyClass) ? "class=\"{$bodyClass}\"" : null; ?><?= !empty($bodyId) ? "class=\"{$bodyId}\"" : null; ?>>

		<?php if (isset($_SESSION['userLogin'])): ?>
			<!-- Header
			==================================================-->
			<?= $v->insert('partials/_header'); ?>
		<?php endif; ?>

		<?php if ($v->section('content')): ?>
			<!-- Content
			==================================================-->
			<?= $v->section('content'); ?>
		<?php endif; ?>

		<?php if (isset($_SESSION['userLogin'])): ?>
			<!-- Footer
			==================================================-->
			<?= $v->insert('partials/_footer'); ?>
		<?php endif; ?>

		<!-- Javascript
		==================================================-->
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

		<!-- Custom JS -->
		<script src="<?= INCLUDE_PATH . '/assets/js/default.js'; ?>"></script>
		<?= $v->section('js'); ?>
	</body>
</html>