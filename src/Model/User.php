<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer {

	/**
	 * User constructor.
	 */
	public function __construct() {
		parent::__construct('el_users', [
			'first_name',
			'last_name',
			'email',
			'username',
			'password'
		]);
	}

	/**
	 * getOrgan. <p>
	 * Responsável por retornar consultar no banco e retornar os dados do órgão
	 * que o usuário está relacionado.
	 * </p>
	 *
	 * @return DataLayer|null
	 */
	public function getOrgan() {
		if (empty($this->organ_id)) {
			return null;
		}

		return (new \Source\Model\Organ())->findById($this->organ_id);
	}

	/**
	 * save. <p>
	 * Responsável por verificar a existência de e-mail e nome de usuário
	 * antes de efetuar a persistência. Retorna TRUE se for sucesso, ou FALSE.
	 * </p>
	 *
	 * @return bool TRUE se for sucesso, ou FALSE
	 */
	public function save(): bool {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Instância do modelo de usuário
		$user = new User();

		// Update: Consulta se existe o e-mail informado em outro usuário
		if (!empty($this->id)) {
			$getEmail = $user->find('id != :id AND email = :email', "id={$this->id}&email={$this->email}")->fetch();
		}

		// Create: Consulta se o e-mail informado já foi cadastrado
		if (empty($this->id)) {
			$getEmail = $user->find('email = :email', "email={$this->email}")->fetch();
		}

		// E-mail existe
		if ($getEmail) {
			$callback['error']['code'] = 5;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return false;
		}

		// Update: Consulta se existe o nome de usuário informado em outro usuário
		if (!empty($this->id)) {
			$getUsername = $user->find('id != :id AND username = :username', "id={$this->id}&username={$this->username}")->fetch();
		}

		// Create: Consulta se o nome de usuário informado já foi cadastrado
		if (empty($this->id)) {
			$getUsername = $user->find('username = :username', "username={$this->username}")->fetch();
		}

		// Nome de usuário existe
		if ($getUsername) {
			$callback['error']['code'] = 6;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return false;
		}

		// Update: Consulta se existe avatar caso o usuário esteja enviando uma image
		if (!empty($this->id) && !empty($_FILES['avatar'])) {
			$getAvatar = $user->findById($this->id)->avatar;

			// Caminho do arquivo
			$filePath = __DIR__ . '/../../';

			// Valida se é um arquivo
			if ($getAvatar && file_exists($filePath . $getAvatar) && !is_dir($filePath . $getAvatar)) {

				// Deleta arquivo de avatar
				unlink($filePath . $getAvatar);
			}
		}

		// Cadastro/Atualização não realizado
		if (!parent::save()) {
			$callback['error']['code'] = 7;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return false;
		}

		return true;
	}

	/**
	 * destroy. <p>
	 * Responsável por verificar a existência do avatar e deletar o arquivo,
	 * se existir, antes de deletar o usuário. Retorna TRUE se for sucesso, ou FALSE.
	 * </p>
	 *
	 * @return bool TRUE se for sucesso, ou FALSE
	 */
	public function destroy(): bool {

		// Retorno
		$callback = ['error' => [
			'code' => 0,
			'message' => ''
		]];

		// Instância do modelo de usuário
		$user = new User();

		// Update: Consulta se existe avatar
		if (!empty($this->id) && !empty($this->avatar)) {
			$getAvatar = $user->findById($this->id)->avatar;

			// Caminho do arquivo
			$filePath = __DIR__ . '/../../';

			// Valida se é um arquivo
			if ($getAvatar && file_exists($filePath . $getAvatar) && !is_dir($filePath . $getAvatar)) {

				// Deleta arquivo de avatar
				unlink($filePath . $getAvatar);
			}
		}

		// Remoção não realizada
		if (!parent::destroy()) {
			$callback['error']['code'] = 10;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return false;
		}

		return true;
	}

}