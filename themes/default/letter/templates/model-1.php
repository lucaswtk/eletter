<html>
	<head>
		<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
		<style type="text/css">
			<!--
			* {
				margin: 0;
				padding: 0;
				font-family: Arial, sans-serif;
			}

			body {
				font-size: 12px;
				line-height: 1.4;
			}

			p {
				margin-bottom: 12px;
			}

			.text-center {
				text-align: center;
			}

			.document {
				width: 100%;
				max-width: 650px;
				margin: 0 auto;
				padding: 50px 0;
			}

			.brand {
				text-align: center;
				margin-bottom: 10px;
			}

			.brand img {
				width: 50px;
			}

			.title-main {
				margin-bottom: 10px;
				font-size: 20px;
			}

			.title-organ {
				margin-bottom: 5px;
				font-size: 16px;
			}

			.title-subject {
				margin-bottom: 50px;
				font-size: 16px;
			}

			.table {
				margin: 10px 0 30px;
				border: 1px solid #212121;
			}

			.table .td {
				float: left;
				padding: 5px;
				border: 1px solid #212121;
			}

			.table .td-title {
				margin-bottom: 5px;
				font-size: 10px;
			}

			.table .td-name {
				width: 372px;
			}

			.table .td-cpf-cnpj,
			.table .td-subscription,
			.table .td-number,
			.table .td-edifice {
				width: 120px;
			}

			.table .td-street {
				width: 372px;
			}

			.table .td-complement,
			.table .td-allotment {
				width: 240px;
			}

			.table .td-neighborhood,
			.table .td-block {
				width: 160px;
			}

			.table .td-zipcode {
				width: 100px;
			}

			.table .td-telephone {
				width: 100px;
			}

			.table .td-lot {
				width: 212px;
			}

			ol {
				list-style: lower-alpha;
				margin-left: 26px;
				margin-bottom: 30px;
			}

			.clearfix:after {
				visibility: hidden;
				display: block;
				font-size: 0;
				content: " ";
				clear: both;
				height: 0;
			}

			* html .clearfix {
				zoom: 1;
			}

			/* IE6 */
			*:first-child + html .clearfix {
				zoom: 1;
			}

			-->
		</style>
	</head>
	<body>
		<div class="document">

			<!-- Brand -->
			<div class="brand">
				<img src="themes/default/assets/media/brands/maceio-al-1.png">
			</div>

			<!-- Heading -->
			<h1 class="title-main text-center">
				PREFEITURA MUNICIPAL DE MACEIÓ
			</h1>

			<!-- Organ -->
			<h3 class="title-organ text-center">
				{{organ_name}}
			</h3>

			<!-- Subject -->
			<h4 class="title-subject text-center">
				{{subject}}
			</h4>

			<!-- Identification -->
			<b>IDENTIFICAÇÃO DO NOTIFICADO</b>
			<div class="table">
				<div class="tr clearfix">
					<div class="td td-name">
						<div class="td-title">Contribuinte</div>
						{{recipient_name}}
					</div>
					<div class="td td-cpf-cnpj">
						<div class="td-title">CPF/CNPJ</div>
						{{recipient_cpf/cnpj}}
					</div>
					<div class="td td-subscription">
						<div class="td-title">Inscrição do Imóvel</div>
						{{recipient_subscription}}
					</div>
				</div>
				<!--/.tr-->
			</div>
			<!--/.table -->

			<!-- Address -->
			<b>ENDEREÇO</b>
			<div class="table">
				<div class="tr clearfix">
					<div class="td td-street">
						<div class="td-title">Logradouro</div>
						{{recipient_street}}
					</div>
					<div class="td td-number">
						<div class="td-title">Número</div>
						{{recipient_number}}
					</div>
					<div class="td td-edifice">
						<div class="td-title">Condomínio/Edifício</div>
						{{recipient_edifice}}
					</div>
				</div>
				<!--/.tr-->
				<div class="tr clearfix">
					<div class="td td-complement">
						<div class="td-title">Complemento</div>
						{{recipient_complement}}
					</div>
					<div class="td td-neighborhood">
						<div class="td-title">Bairro</div>
						{{recipient_neighborhood}}
					</div>
					<div class="td td-zipcode">
						<div class="td-title">CEP</div>
						{{recipient_zipcode}}
					</div>
					<div class="td td-telephone">
						<div class="td-title">Telefone</div>
						{{recipient_telephone}}
					</div>
				</div>
				<!--/.tr-->
				<div class="tr clearfix">
					<div class="td td-allotment">
						<div class="td-title">Loteamento/Desmembramento</div>
						{{recipient_allotment}}
					</div>
					<div class="td td-block">
						<div class="td-title">Quadra</div>
						{{recipient_block}}
					</div>
					<div class="td td-lot">
						<div class="td-title">Lote</div>
						{{recipient_lot}}
					</div>
				</div>
				<!--/.tr-->
			</div>
			<!--/.table -->

			<p>
				Prezado Senhor (a),<br>
				<u><b>Foi identficada uma alteração da área de construção do imóvel descrito acima</b></u>.
			</p>
			<p>
				No cadastro da Secretaria Municipal de Economia o referido imóvel estava com área de construção de {{area}} mt2.
				Após verificação identficou-se que o imóvel tem na verdade {{area_geo_semec}} mt2 de área de construção.
			</p>
			<p>
				Essa difererença vai
				ocasionar um lançamento de valor complementar do IPTU e brevemente chegará,no seu endereço, um novo carnê com
				esse complemento. Esse complemento não substtui o carnê doIPTU 2018 já enviado e deve ser pago em conjunto com
				aquele.Discordando da alteração ora identficada de área construída, V.Sa. poderá solicitar revisãojustficando o
				motvo e anexando documentos que comprovam a situação do imóvel (ver abaixo).Essa revisão deverá ser agendada pelo
				site: www.semecmaceio.com/notficacao . O nãoagendamento até26/10/2018 configurará concordância e aceitação tácita
				da nova área de construção
			</p>
			<p>
				Obs: Documentos que comprovam a situação do imóvel:
			</p>
			<ol>
				<li>
					Cópia de Escritura/Compra e Venda ou outro documento que comprove a posse;
				</li>
				<li>
					Cópía de CPF, RG e Comprovante de Residência (conta de energia);
				</li>
				<li>
					Plantas em arquivos DWG (Baixa, Situação, Etc);
				</li>
				<li>
					Alvará de Construção.
				</li>
			</ol>
			<p>
				<i>Atenciosamente</i>,<br>
				Secretaria Municipal de Economia CCI - Notficação (mat 24493-7)
			</p>
		</div>
		<!--/.document-->
	</body>
</html>