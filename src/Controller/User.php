<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use CoffeeCode\Uploader\Image;
use League\Plates\Engine;
use Source\Helpers\Check;

class User {

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
	 * Responsável por renderizar a página de cadastro de usuário.
	 * </p>
	 */
	public function new(): void {

		// Consulta todos os órgãos se o login ativo for de um desenvolvedor
		if ($_SESSION['userLogin']['status'] == USER_DEV) {
			$organs = (new \Source\Model\Organ())->find()->fetch(true);
		} // Consulta o orgão relacionado
		else {
			$organs = (new \Source\Model\Organ())->findById($_SESSION['userLogin']['organ_id']);
		}

		echo $this->view->render('user/new', [
			'organs' => $organs
		]);
	}

	/**
	 * all. <p>
	 * Responsável por renderizar a página que lista todos os usuários.
	 * </p>
	 */
	public function all(): void {

		// Consulta todos os usuários se o login ativo for de um desenvolvedor
		if ($_SESSION['userLogin']['status'] == USER_DEV) {
			$users = (new \Source\Model\User())->find()->fetch(true);
		} // Consulta todos os usuarários de acordo com o orgão relacionado
		else {
			$users = (new \Source\Model\User())->find('organ_id = :id', "id={$_SESSION['userLogin']['organ_id']}")->fetch(true);
		}

		echo $this->view->render('user/all', [
			'users' => $users
		]);
	}

	/**
	 * create. <p>
	 * Resposável por validar os dados e efetuar a persistência do usuário
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
		$userData = filter_var_array($data, FILTER_SANITIZE_STRING);

		// Salva os campos não obrigatórios em variáveis
		$organId = $userData['organ_id'] ?: null;

		// Remove do array de dados os campos não obrigatórios
		unset($userData['organ_id']);

		// Update: Se não houver senha, remove o elemento do array
		if (!empty($userData['id']) && !$userData['password']) {
			unset($userData['password']);
		}

		// Verifica campos obrigatórios não preenchidos
		if (in_array('', $userData)) {
			$callback['error']['code'] = 1;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Valida o e-mail
		if (!Check::email($userData['email']) || !filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
			$callback['error']['code'] = 4;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Trata o nome de usuário
		$userData['username'] = Check::stringTreatment($userData['username'], '.');

		// Encripta a senha
		if (!empty($userData['password'])) {
			$userData['password'] = hash('sha512', $userData['password']);
		}

		// Valida o status
		$userData['status'] = !empty($userData['status']) ? $userData['status'] : '0';

		// Update
		if (!empty($userData['id'])) {

			// Instância do modelo de usuário
			$user = (new \Source\Model\User())->findById($userData['id']);
		}

		// Create
		if (empty($userData['id'])) {

			// Instância do modelo de usuário
			$user = new \Source\Model\User();
		}

		// Seta os dados ao objeto
		$user->organ_id = $organId;
		$user->first_name = $userData['first_name'];
		$user->last_name = $userData['last_name'];
		$user->email = $userData['email'];
		$user->username = $userData['username'];
		$user->status = $userData['status'];

		// Cadastra/Atualiza a senha
		if (!empty($userData['password'])) {
			$user->password = $userData['password'];
		}

		// Cadastra/Atualiza
		$try = $user->save();

		// Cadastro/Atualização não realizado
		if (!$try) {
			return;
		}

		// Cadastra/Atualiza avatar
		if (!empty($_FILES['avatar'])) {

			// Instância da classe de upload
			$avatar = new Image('storage', 'avatars');

			try {

				// Envio do avatar não realizado
				if (empty($_FILES['avatar']['type']) || !in_array($_FILES['avatar']['type'], $avatar::isAllowed())) {
					$callback['error']['code'] = 8;
					$callback['error']['message'] = errorMessage($callback['error']['code']);
				}

				// Envia o avatar
				$uploaded = $avatar->upload($_FILES['avatar'], "{$user->id}-{$user->first_name}-{$user->last_name}", 300);
			} catch (\Exception $e) {
				$callback['error']['code'] = $e->getCode();
				$callback['error']['message'] = $e->getMessage();
			}

			$user->avatar = $uploaded;
			$user->save();
		}

		// Update
		if (!empty($userData['id'])) {

			// Atualiza nome
			$callback['updateText'] = ['name' => "{$user->first_name} {$user->last_name}"];

			// Somente no envio de avatar
			if (!empty($_FILES['avatar'])) {

				// Atualiza avatar
				if ($user->avatar) {
					$callback['updateSrc'] = ['avatar' => BASE . "/tim.php?src={$user->avatar}&w=100&h=100"];
				}

				// Exibe botão que remove avatar
				$callback['showHtml'] = ['avatar'];
			}
		}

		// Create: Redireciona
		if (!isset($userData['id'])) {
			$callback['redirect'] = $this->router->route('user.edit') . "/{$user->id}";
		}

		echo json_encode($callback);
	}

	/**
	 * edit. <p>
	 * Responsável por renderizar a página para editar um usuário específico
	 * onde o ID do usuário pode ser recuperado através do parâmetro $data.
	 * </p>
	 *
	 * @param array $data Array com dados essenciais para processar os dados de um usuário (Ex.: id)
	 */
	public function edit(array $data): void {

		// Redireciona se não houver o parâmetro id
		if (!isset($data['id'])) {
			$this->router->redirect('user.all');
		}

		// Previne dados maliciosos
		$userId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Consulta um usuário pela chave primária
		$user = (new \Source\Model\User())->findById($userId);

		// Usuário não existe
		if (!$user) {
			$this->router->redirect('user.all');
		}

		echo $this->view->render('user/new', [
			'id' => $user->id,
			'avatar' => $user->avatar,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'full_name' => "{$user->first_name} {$user->last_name}",
			'email' => $user->email,
			'username' => $user->username,
			'password' => $user->password,
			'status' => $user->status,
			'organ_id' => $user->organ_id,
			'organ_name' => $user->getOrgan()->name,
			'organs' => (new \Source\Model\Organ())->find()->fetch(true)
		]);
	}

	/**
	 * delete. <p>
	 * Responsável por deletar um usuário específico onde o ID do usuário pode
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
		$userId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Instância do modelo de usuário
		$user = (new \Source\Model\User())->findById($userId);

		// Usuário não existe
		if (!$user) {
			$callback['error']['code'] = 2;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Deleta
		$try = $user->destroy();

		// Remoção não realizada
		if (!$try) {
			return;
		}

		// Remove usuário da lista
		$callback['deleteHtml'] = "user-{$userId}";

		echo json_encode($callback);
	}

	/**
	 * deleteAvatar. <p>
	 * Responsável por deletar o avatar de um usuário específico onde o
	 * ID do usuário pode ser recuperado através do parâmetro $data.
	 * </p>
	 *
	 * @param array $data Dados necessários para executar a operação. (Ex.: id)
	 */
	public function deleteAvatar(array $data): void {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Previne dados maliciosos
		$userId = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

		// Instância do modelo de usuário
		$user = (new \Source\Model\User())->findById($userId);

		// Usuário não existe
		if (!$user) {
			$callback['error']['code'] = 2;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Avatar não existe
		if (!$user->avatar) {
			$callback['error']['code'] = 9;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Caminho do arquivo
		$filePath = __DIR__ . '/../../';

		// Valida se existe avatar e se é um arquivo
		if (file_exists($filePath . $user->avatar) && !is_dir($filePath . $user->avatar)) {

			// Deleta arquivo de avatar
			unlink($filePath . $user->avatar);
		}

		// Atualiza o usuário
		$user->avatar = null;
		$user->save();

		// Atualiza avatar
		$callback['updateSrc'] = ['avatar' => BASE . '/tim.php?src=' . AVATAR_DEFAULT];

		// Esconde botão que remove avatar
		$callback['hideHtml'] = ['avatar'];

		echo json_encode($callback);
	}
}