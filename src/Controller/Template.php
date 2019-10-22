<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

class Template {

	/** @var Router */
	private $router;

	/** @var Engine */
	private $view;

	/**
	 * LetterTemplate constructor.
	 *
	 * @param Router $router Rota utilizada
	 */
	public function __construct(Router $router) {

		// Valida sessão do usuário
		(new UserSession())->validateSession($router);

		$this->router = $router;

		// Renderização da view
		$this->view = Engine::create(__DIR__ . '/../../themes/' . THEME, 'php');
		$this->view->addData([
			'router' => $router
		]);
	}

	/**
	 * new. <p>
	 * Responsável por renderizar a página de cadastro de usuário.
	 * </p>
	 */
	public function new(): void {
		echo $this->view->render('letter/template/new');
	}

	/**
	 * all. <p>
	 * Responsável por renderizar a página que lista todos os templates.
	 * </p>
	 */
	public function all() {
		echo $this->view->render('letter/template/all', [
			'templates' => (new \Source\Model\Template())->find()->fetch(true)
		]);
	}

	/**
	 * preview. <p>
	 * Responsável por renderizar a página que pré-visualiza o template.
	 * </p>
	 *
	 * @param array $data Dados necessários para executar a operação. (Ex.: id)
	 */
	public function previewPDF(array $data) {

		// Previne dados maliciosos
		$templateId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		echo $this->view->render('letter/template/preview/dompdf', [
			'id' => $templateId
		]);
	}

	/**
	 * create. <p>
	 * Resposável por validar os dados e efetuar a persistência do template
	 * no banco de dados.
	 * </p>
	 *
	 * @param array $data Dados do formulário
	 */
	public function create(array $data): void {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Obtém o conteúdo e elimina tags e áspas
		$templateContent = htmlspecialchars($data['content'], ENT_QUOTES);

		// Previne dados maliciosos
		$templateData = filter_var_array($data, FILTER_SANITIZE_STRING);

		// Verifica campos obrigatórios não preenchidos
		if (in_array('', $templateData)) {
			$callback['error']['code'] = 1;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		$templateData['content'] = $templateContent;

		// Update
		if (!empty($templateData['id'])) {

			// Instância do modelo de template
			$template = (new \Source\Model\Template())->findById($templateData['id']);
		}

		// Create
		if (empty($templateData['id'])) {

			// Instância do modelo de template
			$template = new \Source\Model\Template();
		}

		// Seta os dados ao objeto
		$template->organ_id = $_SESSION['userLogin']['organ_id'];
		$template->name = $templateData['name'];
		$template->content = $templateData['content'];

		// Cadastro/Atualização não realizado
		if (!$template->save()) {
			$callback['error']['code'] = 7;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Update
		if (!empty($templateData['id'])) {

			// Atualiza nome
			$callback['updateText'] = ['name' => $template->name];
		}

		// Create: Redireciona
		if (!isset($templateData['id'])) {
			$callback['redirect'] = $this->router->route('template.edit') . "/{$template->id}";
		}

		echo json_encode($callback);
	}

	/**
	 * edit. <p>
	 * Responsável por renderizar a página para editar um template específico
	 * onde o ID do template pode ser recuperado através do parâmetro $data.
	 * </p>
	 *
	 * @param array $data Dados necessários para executar a operação. (Ex.: id)
	 */
	public function edit(array $data): void {

		// Redireciona se não houver o parâmetro id
		if (!isset($data['id'])) {
			$this->router->redirect('template.all');
		}

		// Previne dados maliciosos
		$templateId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Consulta um template pela chave primária
		$template = (new \Source\Model\Template())->findById($templateId);

		// Template não existe
		if (!$template) {
			$this->router->redirect('template.all');
		}

		echo $this->view->render('letter/template/new', [
			'id' => $template->id,
			'name' => $template->name,
			'content' => $template->content
		]);
	}
}