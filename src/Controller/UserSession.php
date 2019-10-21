<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use Source\Model\User;

class UserSession {

	/**
	 * validateSession. <p>
	 * Responsável por verificar se existe sessão do usuário ativa.
	 * Se não existir, expulsa o usuário da área do sistema.
	 * </p>
	 *
	 * @param Router $router Rota utilizada
	 */
	public function validateSession(Router $router): void {

		// Redireciona se não houver sessão
		if (!isset($_SESSION['userLogin'])) {
			$router->redirect('access.signIn');
		}

		// Valida o status
		$this->validateStatus($router);
	}

	/**
	 * validateStatus. <p>
	 * Responsável por verificar se o usuário ainda possui permissão
	 * para acessar o sistema. Expulsa-o se não tiver.
	 * </p>
	 *
	 * @param Router $router Rota utilizada
	 */
	private function validateStatus(Router $router): void {

		// Executa leitura dos dados do usuário online
		$user = (new User())->findById($_SESSION['userLogin']['id']);

		// Verifica o status e expulsa se o usuário não tiver nível de permissão para continuar logado
		if (!$user || $user->status == 0) {
			unset($_SESSION['userLogin']);
			$router->redirect('access.signIn');
		}
	}
}