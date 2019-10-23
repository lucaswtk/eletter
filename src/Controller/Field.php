<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

class Field {

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
	 * Responsável por renderizar a página de cadastro de metadado.
	 * </p>
	 */
	public function new(): void {
		echo $this->view->render('letter/metadata/new');
	}

	/**
	 * all. <p>
	 * Responsável por renderizar a página que lista todos os metadados.
	 * </p>
	 */
	public function all() {
		echo $this->view->render('letter/metadata/all', [
			'metadatas' => (new \Source\Model\Field())->find('organ_id = :id', "id={$_SESSION['userLogin']['organ_id']}")->fetch(true)
		]);
	}

	/**
	 * create. <p>
	 * Resposável por validar os dados e efetuar a persistência do metadado
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

		// Previne dados maliciosos
		$fieldData = filter_var_array($data, FILTER_SANITIZE_STRING);

		// Verifica campos obrigatórios não preenchidos
		if (in_array('', $fieldData)) {
			$callback['error']['code'] = 1;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Update
		if (!empty($fieldData['id'])) {

			// Instância do modelo de metadado
			$field = (new \Source\Model\Field())->findById($fieldData['id']);
		}

		// Create
		if (empty($fieldData['id'])) {

			// Instância do modelo de metadado
			$field = new \Source\Model\Field();
		}

		// Seta os dados ao objeto
		$field->organ_id = $_SESSION['userLogin']['organ_id'];
		$field->label = $fieldData['label'];
		$field->element = 'input';
		$field->type = $fieldData['type'];
		$field->name = $fieldData['name'];

		// Cadastro/Atualização não realizado
		if (!$field->save()) {
			$callback['error']['code'] = 7;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Update
		if (!empty($fieldData['id'])) {

			// Atualiza nome
			$callback['updateText'] = ['label' => $field->label];
		}

		// Create: Redireciona
		if (!isset($fieldData['id'])) {
			$callback['redirect'] = $this->router->route('field.edit') . "/{$field->id}";
		}

		echo json_encode($callback);
	}

	/**
	 * edit. <p>
	 * Responsável por renderizar a página para editar um metadado específico
	 * onde o ID do metadado pode ser recuperado através do parâmetro $data.
	 * </p>
	 *
	 * @param array $data Dados necessários para executar a operação. (Ex.: id)
	 */
	public function edit(array $data): void {

		// Redireciona se não houver o parâmetro id
		if (!isset($data['id'])) {
			$this->router->redirect('field.all');
		}

		// Previne dados maliciosos
		$fieldId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Consulta um metadado pela chave primária
		$field = (new \Source\Model\Field())->findById($fieldId);

		// Metadado não existe
		if (!$field) {
			$this->router->redirect('field.all');
		}

		echo $this->view->render('letter/metadata/new', [
			'id' => $field->id,
			'label' => $field->label,
			'type' => $field->type,
			'name' => $field->name
		]);
	}

	/**
	 * delete. <p>
	 * Responsável por deletar um metadado específico onde o ID do metadado pode
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
		$fieldId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Instância do modelo de metadado
		$field = (new \Source\Model\Field())->findById($fieldId);

		// Metadado não existe
		if (!$field) {
			$callback['error']['code'] = 17;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Remoção não realizada
		if (!$field->destroy()) {
			return;
		}

		// Remove metadado da lista
		$callback['deleteHtml'] = "metadata-{$fieldId}";

		echo json_encode($callback);
	}

}