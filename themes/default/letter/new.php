<?php
$v->layout('_template', [
	'title' => SITE_NAME . ' - ' . (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Carta: ' . (!empty($id) ? $name : '')
]);
?>

<main role="main" class="flex-shrink-0 my-5">
	<div class="container">

		<!-- Heading -->
		<h1 class="h3">
			<?= (!empty($id) ? 'Atualizar' : 'Cadastrar') . ' Carta' . (!empty($id) ? ": <span data-updateText=\"name\">{$name}</span>" : ''); ?>
		</h1>

		<!-- Subheading -->
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, necessitatibus.</p>

		<!-- Divider -->
		<hr class="mb-5">

		<!-- Create User -->
		<form method="post" action="<?= (!empty($id) ? $router->route('letter.update') : $router->route('letter.create')); ?>">
			<?php if (!empty($id)): ?>
				<input type="hidden" name="id" value="<?= $id; ?>">
			<?php endif; ?>

			<!-- Row -->
			<div class="row">
				<div class="col-md-12">

					<!-- Subject -->
					<div class="form-group">
						<label>Assunto:</label>
						<input class="form-control" type="text" name="subject" required autofocus <?= (!empty($subject) ? "value=\"{$subject}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-12">

					<!-- Content -->
					<div class="form-group">
						<label>Conteúdo:</label>
						<textarea class="form-control" name="content" rows="4" required><?= (!empty($content) ? $content : ''); ?></textarea>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Model -->
					<div class="form-group">
						<label>Modelo:</label>
						<select class="form-control" name="model" required>
							<option value=""></option>
							<option value="1">Revisão de Área de Construção</option>
							<option value="2">Revisão de Lançamento de IPTU</option>
						</select>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Send -->
					<div class="form-group">
						<label>Data de envio:</label>
						<input class="form-control" type="date" name="send" required>
					</div>
				</div>
				<!--/.col-->
			</div>
			<!--/.row-->

			<!-- Heading -->
			<h5 class="mt-5">
				Dados Relacionados ao Modelo
			</h5>

			<!-- Divider -->
			<hr class="mb-3">

			<!-- Row -->
			<div class="row">
				<div class="col">
					Selecione um modelo para liberar os campos relacionados.
				</div>
			</div>
			<!--/.row-->

			<!-- Heading -->
			<h5 class="mt-5">
				Destinatário
			</h5>

			<!-- Divider -->
			<hr class="mb-3">

			<!-- Row -->
			<div class="row">
				<div class="col-md-6">

					<!-- Zipcode -->
					<div class="form-group">
						<label>CEP:</label>
						<input class="form-control" type="text" name="recipient_zipcode" required <?= (!empty($recipient_zipcode) ? "value=\"{$recipient_zipcode}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Street -->
					<div class="form-group">
						<label>Rua:</label>
						<input class="form-control" type="text" name="recipient_street" required <?= (!empty($recipient_street) ? "value=\"{$recipient_street}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Number -->
					<div class="form-group">
						<label>Número:</label>
						<input class="form-control" type="text" name="recipient_number" required <?= (!empty($recipient_number) ? "value=\"{$recipient_number}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Neighborhodd -->
					<div class="form-group">
						<label>Bairro:</label>
						<input class="form-control" type="text" name="recipient_neighborhood" required <?= (!empty($recipient_neighborhood) ? "value=\"{$recipient_neighborhood}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Complement -->
					<div class="form-group">
						<label>Complemento:</label>
						<input class="form-control" type="text" name="recipient_complement" <?= (!empty($recipient_complement) ? "value=\"{$recipient_complement}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- City -->
					<div class="form-group">
						<label>Cidade:</label>
						<input class="form-control" type="text" name="recipient_city" required <?= (!empty($recipient_city) ? "value=\"{$recipient_city}\"" : ''); ?>>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- State -->
					<div class="form-group">
						<label>Estado:</label>
						<select class="form-control" name="state" required>
							<option value=""></option>
							<option value="AC" <?= (!empty($recipient_state) && $recipient_state == 'AC' ? 'selected' : ''); ?>>Acre</option>
							<option value="AL" <?= (!empty($recipient_state) && $recipient_state == 'AL' ? 'selected' : ''); ?>>Alagoas</option>
							<option value="AP" <?= (!empty($recipient_state) && $recipient_state == 'AP' ? 'selected' : ''); ?>>Amapá</option>
							<option value="AM" <?= (!empty($recipient_state) && $recipient_state == 'AM' ? 'selected' : ''); ?>>Amazonas</option>
							<option value="BA" <?= (!empty($recipient_state) && $recipient_state == 'BA' ? 'selected' : ''); ?>>Bahia</option>
							<option value="CE" <?= (!empty($recipient_state) && $recipient_state == 'CE' ? 'selected' : ''); ?>>Ceará</option>
							<option value="DF" <?= (!empty($recipient_state) && $recipient_state == 'DF' ? 'selected' : ''); ?>>Distrito Federal</option>
							<option value="ES" <?= (!empty($recipient_state) && $recipient_state == 'ES' ? 'selected' : ''); ?>>Espírito Santo</option>
							<option value="GO" <?= (!empty($recipient_state) && $recipient_state == 'GO' ? 'selected' : ''); ?>>Goiás</option>
							<option value="MA" <?= (!empty($recipient_state) && $recipient_state == 'MA' ? 'selected' : ''); ?>>Maranhão</option>
							<option value="MT" <?= (!empty($recipient_state) && $recipient_state == 'MT' ? 'selected' : ''); ?>>Mato Grosso</option>
							<option value="MS" <?= (!empty($recipient_state) && $recipient_state == 'MS' ? 'selected' : ''); ?>>Mato Grosso do Sul</option>
							<option value="MG" <?= (!empty($recipient_state) && $recipient_state == 'MG' ? 'selected' : ''); ?>>Minas Gerais</option>
							<option value="PA" <?= (!empty($recipient_state) && $recipient_state == 'PA' ? 'selected' : ''); ?>>Pará</option>
							<option value="PB" <?= (!empty($recipient_state) && $recipient_state == 'PB' ? 'selected' : ''); ?>>Paraíba</option>
							<option value="PR" <?= (!empty($recipient_state) && $recipient_state == 'PR' ? 'selected' : ''); ?>>Paraná</option>
							<option value="PE" <?= (!empty($recipient_state) && $recipient_state == 'PE' ? 'selected' : ''); ?>>Pernambuco</option>
							<option value="PI" <?= (!empty($recipient_state) && $recipient_state == 'PI' ? 'selected' : ''); ?>>Piauí</option>
							<option value="RJ" <?= (!empty($recipient_state) && $recipient_state == 'RJ' ? 'selected' : ''); ?>>Rio de Janeiro</option>
							<option value="RN" <?= (!empty($recipient_state) && $recipient_state == 'RN' ? 'selected' : ''); ?>>Rio Grande do Norte</option>
							<option value="RS" <?= (!empty($recipient_state) && $recipient_state == 'RS' ? 'selected' : ''); ?>>Rio Grande do Sul</option>
							<option value="RO" <?= (!empty($recipient_state) && $recipient_state == 'RO' ? 'selected' : ''); ?>>Rondônia</option>
							<option value="RR" <?= (!empty($recipient_state) && $recipient_state == 'RR' ? 'selected' : ''); ?>>Roraima</option>
							<option value="SC" <?= (!empty($recipient_state) && $recipient_state == 'SC' ? 'selected' : ''); ?>>Santa Catarina</option>
							<option value="SP" <?= (!empty($recipient_state) && $recipient_state == 'SP' ? 'selected' : ''); ?>>São Paulo</option>
							<option value="SE" <?= (!empty($recipient_state) && $recipient_state == 'SE' ? 'selected' : ''); ?>>Sergipe</option>
							<option value="TO" <?= (!empty($recipient_state) && $recipient_state == 'TO' ? 'selected' : ''); ?>>Tocantins</option>
						</select>
					</div>
				</div>
				<!--/.col-->

				<div class="col-md-6">

					<!-- Country -->
					<div class="form-group">
						<label>País:</label>
						<input class="form-control" type="text" name="recipient_country" required value="<?= (!empty($recipient_country) ? $recipient_country : 'Brasil'); ?>">
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