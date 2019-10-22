<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Source\Model\User;

class Access {

	/** @var Router */
	private $router;

	/** @var Engine */
	private $view;

	/**
	 * Access constructor.
	 *
	 * @param Router $router Rota utilizada
	 */
	public function __construct(Router $router) {
		$this->router = $router;

		// Renderização da view
		$this->view = Engine::create(__DIR__ . '/../../themes/' . THEME, 'php');
		$this->view->addData([
			'router' => $router
		]);
	}

	/**
	 * signIn. <p>
	 * Responsável por renderizar a página de login.
	 * </p>
	 */
	public function signIn(): void {

		// Verifica se existe sessão ativa
		if (isset($_SESSION['userLogin']) && $_SESSION['userLogin']['status'] && $_SESSION['userLogin']['status'] != 0) {
			$this->router->redirect('dashboard.home');
		}

		echo $this->view->render('signIn');
	}

	/**
	 * signOut. <p>
	 * Responsável por eliminar qualquer sessão do usuário existente
	 * e redirecionar o usuário para tela login.
	 * </p>
	 */
	public function signOut() {

		// Verifica se há sessão ativa
		if (isset($_SESSION['userLogin'])) {

			// Registra o último acesso
			$user = (new User())->findById($_SESSION['userLogin']['id']);
			$user->last_access = date('Y-m-d H:i:s');
			$user->save();

			// Elimina sessão
			unset($_SESSION['userLogin']);
		}

		// Redireciona para tela de login
		$this->router->redirect('access.signIn');
	}

	/**
	 * validateSignIn. <p>
	 * Responsável por validar os dados informados para efeutar login no sistema.
	 * </p>
	 *
	 * @param array $data Dados do formulário
	 */
	public function validateSignIn(array $data): void {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Previne dados maliciosos
		$userData = filter_var_array($data, FILTER_SANITIZE_STRING);

		// Verifica campos obrigatórios não preenchidos
		if (in_array('', $userData)) {
			$callback['error']['code'] = 1;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Instância do modelo de usuário
		$user = new User();

		// Usuário desenvolvedor
		if ($userData['username'] == 'dev.system') {

			// Consulta o usuário desenvolvedor
			$userDev = $user->find('username = :username AND status = ' . USER_DEV, "username={$userData['username']}")->fetch();

			// Cadastro do usuário desenvolvedor
			if (!$userDev) {
				$user->first_name = 'Dev';
				$user->last_name = 'System';
				$user->email = 'dev.system@eletter.com';
				$user->username = 'dev.system';
				$user->password = hash('sha512', 'dev');
				$user->status = USER_DEV;
				$user->save();
			}
		}

		// Consulta usuário
		$getUser = $user->find('username = :username', "username={$userData['username']}")->fetch();

		// Usuário não existe
		if (!$getUser) {
			$callback['error']['code'] = 2;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Encripta senha
		$password = hash('sha512', $userData['password']);

		// Consulta se a senha é compatível
		$getUser = $user->find('username = :username AND password = :password', "username={$userData['username']}&password={$password}")->fetch();

		// Senha incompatível
		if (!$getUser) {
			$callback['error']['code'] = 3;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Status não permitido
		if ($getUser->status == 0) {
			$callback['error']['code'] = 11;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return;
		}

		// Cria sessão do usuário
		$_SESSION['userLogin'] = [
			'organ_id' => $getUser->organ_id,
			'id' => $getUser->id,
			'first_name' => $getUser->first_name,
			'last_name' => $getUser->last_name,
			'status' => $getUser->status
		];

		// Redireciona
		$callback['redirect'] = $this->router->route('dashboard.home');

		// Converte retorno para json
		echo json_encode($callback);
	}
}