<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class Organ extends DataLayer {

	/**
	 * Organ constructor.
	 */
	public function __construct() {
		parent::__construct('el_organs', [
			'name',
			'initials'
		]);
	}

	/**
	 * save. <p>
	 * Responsável por verificar a se um órgão com o mesmo nome antes de efetuar
	 * a persistência. Retorna TRUE se for sucesso, ou FALSE.
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

		// Instância do modelo de órgão
		$organ = new Organ();

		// Update: Consulta se existe o nome informado em outro órgão
		if (!empty($this->id)) {
			$getName = $organ->find('id != :id AND name = :name', "id={$this->id}&name={$this->name}")->fetch();
		}

		// Create: Consulta se o nome informado já foi cadastrado
		if (empty($this->id)) {
			$getName = $organ->find('name = :name', "name={$this->name}")->fetch();
		}

		// Nome existe
		if ($getName) {
			$callback['error']['code'] = 12;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return false;
		}

		// Update: Consulta se existe a sigla informada em outro órgão
		if (!empty($this->id)) {
			$getInitials = $organ->find('id != :id AND initials = :initials', "id={$this->id}&initials={$this->initials}")->fetch();
		}

		// Create: Consulta se a sigla informada já foi cadastrada
		if (empty($this->id)) {
			$getInitials = $organ->find('initials = :initials', "initials={$this->initials}")->fetch();
		}

		// Sigla existe
		if ($getInitials) {
			$callback['error']['code'] = 16;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return false;
		}

		// Update: Consulta se existe logo caso o órgão esteja enviando uma image
		if (!empty($this->id) && !empty($_FILES['brand'])) {
			$getBrand = $organ->findById($this->id)->brand;

			// Caminho do arquivo
			$filePath = __DIR__ . '/../../';

			// Valida se é um arquivo
			if ($getBrand && file_exists($filePath . $getBrand) && !is_dir($filePath . $getBrand)) {

				// Deleta arquivo de logo
				unlink($filePath . $getBrand);
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
	 * Responsável por verificar a existência da logo e deletar o arquivo,
	 * se existir, antes de deletar o órgão. Retorna TRUE se for sucesso, ou FALSE.
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

		// Instância do modelo de órgão
		$organ = new Organ();

		// Update: Consulta se existe logo
		if (!empty($this->id) && !empty($this->brand)) {
			$getBrand = $organ->findById($this->id)->brand;

			// Caminho do arquivo
			$filePath = __DIR__ . '/../../';

			// Valida se é um arquivo
			if ($getBrand && file_exists($filePath . $getBrand) && !is_dir($filePath . $getBrand)) {

				// Deleta arquivo de logo
				unlink($filePath . $getBrand);
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