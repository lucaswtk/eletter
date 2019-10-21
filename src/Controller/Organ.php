<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use CoffeeCode\Uploader\Image;
use League\Plates\Engine;

class Organ {

	/** @var Router */
	private $router;

	/** @var Engine */
	private $view;

	/**
	 * User constructor.
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
	 * Responsável por renderizar a página de cadastro de órgão.
	 * </p>
	 */
	public function new() {
		echo $this->view->render('organ/new');
	}

	/**
	 * all. <p>
	 * Responsável por renderizar a página que lista todos os órgãos.
	 * </p>
	 */
	public function all() {
		echo $this->view->render('organ/all', [
			'organs' => (new \Source\Model\Organ())->find()->fetch(true)
		]);
	}

	/**
	 * create. <p>
	 * Resposável por validar os dados e efetuar a persistência do órgão
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
		$organData = filter_var_array($data, FILTER_SANITIZE_STRING);

		// Verifica campos obrigatórios não preenchidos
		if (in_array('', $organData)) {
			$callback['error']['code'] = 1;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Trata a sigla do órgão
		$organData['initials'] = strtoupper($organData['initials']);

		// Update
		if (!empty($organData['id'])) {

			// Instância do modelo de órgão
			$organ = (new \Source\Model\Organ())->findById($organData['id']);
		}

		// Create
		if (empty($organData['id'])) {

			// Instância do modelo de órgão
			$organ = new \Source\Model\Organ();
		}

		// Seta os dados ao objeto
		$organ->name = $organData['name'];
		$organ->initials = $organData['initials'];

		// Cadastra/Atualiza
		$try = $organ->save();

		// Cadastro/Atualização não realizado
		if (!$try) {
			return;
		}

		// Cadastra/Atualiza logo
		if (!empty($_FILES['brand'])) {

			// Instância da classe de upload
			$brand = new Image('storage', 'brands');

			try {

				// Envio da logo não realizado
				if (empty($_FILES['brand']['type']) || !in_array($_FILES['brand']['type'], $brand::isAllowed())) {
					$callback['error']['code'] = 13;
					$callback['error']['message'] = errorMessage($callback['error']['code']);
				}

				// Envia a logo
				$uploaded = $brand->upload($_FILES['brand'], "{$organ->id}-{$organ->name}-{$organ->initials}", 300);
			} catch (\Exception $e) {
				$callback['error']['code'] = $e->getCode();
				$callback['error']['message'] = $e->getMessage();
			}

			$organ->brand = $uploaded;
			$organ->save();
		}

		// Update
		if (!empty($organData['id'])) {

			// Atualiza nome
			$callback['updateText'] = ['name' => $organ->name];

			// Somente no envio de logo
			if (!empty($_FILES['brand'])) {

				// Atualiza logo
				if ($organ->brand) {
					$callback['updateSrc'] = ['brand' => BASE . "/tim.php?src={$organ->brand}&w=100&h=100"];
				}

				// Exibe botão que remove logo
				$callback['showHtml'] = ['brand'];
			}
		}

		// Create: Redireciona
		if (!isset($organData['id'])) {
			$callback['redirect'] = $this->router->route('organ.edit') . "/{$organ->id}";
		}

		echo json_encode($callback);
	}

	/**
	 * edit. <p>
	 * Responsável por renderizar a página para editar um órgão específico
	 * onde o ID do órgão pode ser recuperado através do parâmetro $data.
	 * </p>
	 *
	 * @param array $data Array com dados essenciais para processar os dados de um usuário (Ex.: id)
	 */
	public function edit(array $data): void {

		// Redireciona se não houver o parâmetro id
		if (!isset($data['id'])) {
			$this->router->redirect('organ.all');
		}

		// Previne dados maliciosos
		$organId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Consulta um órgão pela chave primária
		$organ = (new \Source\Model\Organ())->findById($organId);

		// Órgão não existe
		if (!$organ) {
			$this->router->redirect('organ.all');
		}

		echo $this->view->render('organ/new', [
			'id' => $organ->id,
			'brand' => $organ->brand,
			'name' => $organ->name,
			'initials' => $organ->initials
		]);
	}

	/**
	 * delete. <p>
	 * Responsável por deletar um órgão específico onde o ID do órgão pode
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
		$organId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Instância do modelo de órgão
		$organ = (new \Source\Model\Organ())->findById($organId);

		// Órgão não existe
		if (!$organ) {
			$callback['error']['code'] = 14;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Deleta
		$try = $organ->destroy();

		// Remoção não realizada
		if (!$try) {
			return;
		}

		// Remove usuário da lista
		$callback['deleteHtml'] = "organ-{$organId}";

		echo json_encode($callback);
	}

	/**
	 * deleteBrand. <p>
	 * Responsável por deletar a logo de um órgão específico onde o
	 * ID do órgão pode ser recuperado através do parâmetro $data.
	 * </p>
	 *
	 * @param array $data Dados necessários para executar a operação. (Ex.: id)
	 */
	public function deleteBrand(array $data): void {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Previne dados maliciosos
		$organId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Instância do modelo de órgão
		$organ = (new \Source\Model\Organ())->findById($organId);

		// Órgão não existe
		if (!$organ) {
			$callback['error']['code'] = 14;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Logo não existe
		if (!$organ->brand) {
			$callback['error']['code'] = 15;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Caminho do arquivo
		$filePath = __DIR__ . '/../../';

		// Valida se existe logo e se é um arquivo
		if (file_exists($filePath . $organ->brand) && !is_dir($filePath . $organ->brand)) {

			// Deleta arquivo de logo
			unlink($filePath . $organ->brand);
		}

		// Atualiza o órgão
		$organ->brand = null;
		$organ->save();

		// Atualiza logo
		$callback['updateSrc'] = ['brand' => BASE . '/tim.php?src=' . AVATAR_DEFAULT];

		// Esconde botão que remove logo
		$callback['hideHtml'] = ['brand'];

		echo json_encode($callback);
	}
}