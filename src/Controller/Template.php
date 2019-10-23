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

		// Consulta os metadados relacionados com o template
		$templateHasMetadata = (new \Source\Model\TemplateHasField())->find('template_id = :id', "id={$templateId}")->fetch(true);

		// IDs dos metadados relacionados
		$metadataEnabled = [];

		// IDs dos metadados relacionados que são obrigatórios
		$metadataRequired = [];

		if ($templateHasMetadata) {
			foreach ($templateHasMetadata as $metadata) {
				$metadataEnabled[] = $metadata->field_id;

				if ($metadata->required) {
					$metadataRequired[] = $metadata->field_id;
				}
			}
		}

		echo $this->view->render('letter/template/new', [
			'id' => $template->id,
			'name' => $template->name,
			'content' => $template->content,
			'metadata' => (new \Source\Model\Field())->find()->fetch(true),
			'metadataEnabled' => $metadataEnabled,
			'metadataRequired' => $metadataRequired
		]);
	}

	/**
	 * delete. <p>
	 * Responsável por deletar um template específico onde o ID do template pode
	 * ser recuperado através do parâmetro $data.
	 * </p>
	 *
	 * @param array $data Dados necessários para executar a operação. (Ex.: id)
	 */
	public function delete(array $data): void {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Previne dados maliciosos
		$templateId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Instância do modelo de template
		$template = (new \Source\Model\Template())->findById($templateId);

		// Template não existe
		if (!$template) {
			$callback['error']['code'] = 18;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Remoção não realizada
		if (!$template->destroy()) {
			return;
		}

		// Remove template da lista
		$callback['deleteHtml'] = "template-{$templateId}";

		echo json_encode($callback);
	}

	/**
	 * createMetadata. <p>
	 * Resposável por relacionar os metadados com os templates.
	 * </p>
	 *
	 * @param array $data Dados necessários para executar a operação. (Ex.: template_id, field_id)
	 */
	public function createMetadata(array $data): void {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Previne dados maliciosos
		$fieldData = filter_var_array($data, FILTER_SANITIZE_NUMBER_INT);

		// Update
		if (isset($fieldData['required'])) {

			// Instância do modelo de template relacionado com metadado
			$template = (new \Source\Model\TemplateHasField())->find('template_id = :template AND field_id = :field', "template={$fieldData['template_id']}&field={$fieldData['field_id']}")->fetch();

			// Não existe relação
			if (empty($template)) {
				$callback['error']['code'] = 20;
				$callback['error']['message'] = errorMessage($callback['error']['code']);

				echo json_encode($callback);
				return;
			}
		}

		// Create
		if (!isset($fieldData['required'])) {

			// Instância do modelo de template relacionado com metadado
			$template = new \Source\Model\TemplateHasField();
		}

		// Seta os dados ao objeto
		$template->template_id = $fieldData['template_id'];
		$template->field_id = $fieldData['field_id'];
		$template->required = !empty($fieldData['required']) ? 1 : 0;

		// Cadastra/Atualiza
		$try = $template->save();

		// Cadastro/Atualização não realizado
		if (!$try) {
			return;
		}

		// Update
		if (isset($fieldData['required'])) {
			if ($fieldData['required'] == 1) {
				$callback['hideHtmlNoEffect'] = ["update-1-{$template->field_id}"];
				$callback['showHtmlNoEffect'] = ["update-0-{$template->field_id}"];
			} else {
				$callback['hideHtmlNoEffect'] = ["update-0-{$template->field_id}"];
				$callback['showHtmlNoEffect'] = ["update-1-{$template->field_id}"];
			}
		}

		// Create
		if (!isset($fieldData['required'])) {
			$callback['hideHtmlNoEffect'] = ["add-{$template->field_id}"];
			$callback['showHtmlNoEffect'] = ["remove-{$template->field_id}"];
		}

		echo json_encode($callback);
	}

	/**
	 * deleteMetadata. <p>
	 * Resposável por deletar a relação entre os metadados com os templates.
	 * </p>
	 *
	 * @param array $data Dados necessários para executar a operação. (Ex.: template_id, field_id)
	 */
	public function deleteMetadata(array $data): void {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Previne dados maliciosos
		$templateData = filter_var_array($data, FILTER_SANITIZE_NUMBER_INT);

		// Instância do modelo de template relacionado com metadado
		$template = (new \Source\Model\TemplateHasField())->find('template_id = :template AND field_id = :field', "template={$templateData['template_id']}&field={$templateData['field_id']}")->fetch();

		// Template não existe
		if (!$template) {
			$callback['error']['code'] = 20;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Remoção não realizada
		if (!$template->destroy()) {
			return;
		}

		$callback['hideHtmlNoEffect'] = [
			"remove-{$template->field_id}",
			"update-0-{$template->field_id}"
		];

		$callback['showHtmlNoEffect'] = [
			"add-{$template->field_id}",
			"update-1-{$template->field_id}"
		];

		echo json_encode($callback);
	}

}