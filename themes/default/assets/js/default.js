/**
 * Ajax Mode
 * Coloca todos os formulários em modo ajax.
 */

'use strict';

const ajaxMode = (function () {

	/*
	 * Variáveis
	 */

	let form = 'form:not(.no-ajax)';

	/*
	 * Funções
	 */

	/**
	 * serializeFiles. <p>
	 * Responsável por identificar todos os campos no formulário,
	 * criar um objeto formData e salvar seus valores para envia=los
	 * na requisição ajax.
	 * </p>
	 *
	 * @param el Objeto jQuery do formulário
	 * @returns {FormData} Objeto com todos os dados do formulário
	 */
	function serializeFiles(el) {

		// Objeto que conterá todos os dados a serem enviados pelo formulário
		var formData = new FormData();

		// Monta um array com todos os dados de todos os campos existentes
		// Não inclui os campos type="file".
		var formParams = el.serializeArray();

		// Indexa os dados dos campos type="file"
		if (el.find('input[type="file"]').length) {
			$.each(el.find('input[type="file"]'), function (i, tag) {
				$.each($(tag)[0].files, function (i, file) {
					formData.append(tag.name, file);
				});
			});
		}

		// Indexa os dados dos campos (não inclui o type="file")
		$.each(formParams, function (i, val) {
			formData.append(val.name, val.value);
		});

		return formData;
	}

	/**
	 * request. <p>
	 * Responsável por iniciar o processo de requisição ajax e tratar
	 * as respostas de callback.
	 * </p>
	 *
	 * @param el Objeto jQuery do formulário
	 */
	function request(el) {

		// Inicia requisição
		let request = $.ajax({
			url: el.attr('action'),
			type: el.attr('method'),
			data: serializeFiles(el),
			dataType: 'json',
			processData: false,
			contentType: false,
			cache: false
		});

		// Sucesso na requisição
		request.done(function (response) {

			// Debug
			console.log(response);

			// Texto dinâmico
			if (response.updateText) {

				// Somente objetos
				if (typeof response.updateText === 'object') {
					$.each(response.updateText, function (key, value) {
						$('[data-updateText="' + key + '"]').text(value);
					});
				}
			}

			// Source dinâmico
			if (response.updateSrc) {

				// Somente objetos
				if (typeof response.updateSrc === 'object') {
					$.each(response.updateSrc, function (key, value) {
						$('[data-updateSrc="' + key + '"]').attr('src', value);
					});
				}
			}

			// Exibe html (show)
			if (response.showHtml) {

				// Somente objetos
				if (typeof response.showHtml === 'object') {
					$.each(response.showHtml, function (key, value) {
						$('[data-showHtml="' + value + '"]').show(200);
					});
				}
			}

			// Exibe html (fadeIn)
			if (response.fadeInHtml) {

				// Somente objetos
				if (typeof response.fadeInHtml === 'object') {
					$.each(response.fadeInHtml, function (key, value) {
						$('[data-fadeInHtml="' + value + '"]').fadeIn(200);
					});
				}
			}

			// Redireciona
			if (response.redirect) {
				window.location.href = response.redirect;
			}

			// Reseta campo file
			if (!response.error.code && el.find('input[type="file"]').length) {
				el.find('input[type="file"]').val('');

				// Bootstrap: Custom Input File
				if (el.find('.custom-file-input').length) {
					el.find('.custom-file-label').text(el.find('.custom-file-label').attr('data-text-default'));
				}
			}
		});

		// Falha na requisição
		request.fail(function (response) {

			// Debug
			console.warn(response.responseText);
		});
	}

	/*
	 * Eventos
	 */

	// Monitora o evento submit
	$('html').on('submit', form, function (e) {

		// Bloqueia o refresh da página
		e.preventDefault();

		// Inicia requisição
		request($(this));
	});

})();


/**
 * Actions
 * Ações de editar, deletar utilizando ajax.
 */

'use strict';

const actions = (function () {

	/*
	 * Variáveis
	 */

	let toggle = '[data-action]';

	/*
	 * Funções
	 */

	/**
	 * remove. <p>
	 * Responsável pela por requisições de remoção de dados pelo método POST.
	 * </p>
	 *
	 * @param el Objeto jQuery do elemento clicado
	 * @param data Dados recuperados de atributos personalizados (Ex.: data-x)
	 */
	function remove(el, data) {

		// Inicia requisição
		let request = $.ajax({
			url: data.url,
			type: 'POST',
			data: data,
			dataType: 'json',
			cache: false
		});

		// Sucesso na requisição
		request.done(function (response) {

			// Debug
			console.log(response);

			// Source dinâmico
			if (response.updateSrc) {

				// Somente objetos
				if (typeof response.updateSrc === 'object') {
					$.each(response.updateSrc, function (key, value) {
						$('[data-updateSrc="' + key + '"]').attr('src', value);
					});
				}
			}

			// Esconde html (hide)
			if (response.hideHtml) {

				// Somente objetos
				if (typeof response.hideHtml === 'object') {
					$.each(response.hideHtml, function (key, value) {
						$('[data-hideHtml="' + value + '"]').hide(200);
					});
				}
			}

			// Esconde html (fadeOut)
			if (response.fadeOutHtml) {

				// Somente objetos
				if (typeof response.fadeOutHtml === 'object') {
					$.each(response.fadeOutHtml, function (key, value) {
						$('[data-fadeOutHtml="' + value + '"]').fadeOut(200);
					});
				}
			}

			// Deleta html
			if (response.deleteHtml) {

				// String ou Número
				if (typeof response.deleteHtml === 'string' || typeof response.deleteHtml === 'number') {
					$('[data-deleteHtml="' + response.deleteHtml + '"]').fadeOut(100, function () {

						// Exibe célula informativa quando a tabela não possui registros
						if ($(this).parents('table').length) {

							// Pega tabela
							let table = $(this).parents('table');
							let tr = table.find('tbody tr');

							// Exibe célula informativa
							if (tr.length <= 2) {
								table.find('[data-noRegister]').removeClass('d-none');
							}
						}

						// Remove elemento html
						$(this).remove();
					});
				}
			}
		});

		// Falha na requisição
		request.fail(function (response) {

			// Debug
			console.warn(response.responseText);
		});
	}

	/*
	 * Eventos
	 */

	// Monitora o evento click
	$('html').on('click', toggle, function (e) {

		// Bloqueia o refresh da página
		e.preventDefault();

		// Ação: deletar
		if ($(this).data('action') === 'delete')
			remove($(this), $(this).data());
	});

})();


/**
 * Custom File Input - Estrutura do bootstrap para campos de arquivos.
 * Responsável por escrever o nome do arquivo no campo de exibição ou
 * a quantidade de arquivos selecionados para muitos.
 */

'use strict';

const customFileInput = (function () {

	/*
	 * Variáveis
	 */

	let input = '.custom-file-input';
	let label = '.custom-file-label';

	/*
	 * Funções
	 */

	/**
	 * init. <p>
	 * Função de escopo para tratamento e reconhecimento dos dados
	 * selecionados pelo campo file.
	 * </p>
	 *
	 * @param el Objeto jQuery do campo file
	 */
	function init(el) {

		let files = el[0].files;

		if (files.length === 0) {
			$(label).text($(label).attr('data-text-default'));
		} else if (files.length === 1) {
			$(label).text(files[0].name);
		} else {
			$(label).text(files.length + ' arquivos selecionados');
		}
	}

	/*
	 * Eventos
	 */

	// Monitora o evento change
	$('html').on('change', input, function () {

		// Inicia processo
		init($(this));
	});

})();