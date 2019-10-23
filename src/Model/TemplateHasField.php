<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class TemplateHasField extends DataLayer {

	public function __construct() {
		parent::__construct('el_templates_has_fields', [
			'template_id',
			'field_id'
		], 'id', false);
	}

	/**
	 * save. <p>
	 * Responsável por verificar se existe a relação entre metadado e template
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

		// Instância do modelo de template relacionado com metadado
		$template = new TemplateHasField();

		// Create: Consulta se existe a relação entre template e metadado
		if (empty($this->id)) {
			$getRelationship = $template->find('template_id = :template AND field_id = :field', "template={$this->template_id}&field={$this->field_id}")->fetch();
		}

		// Relação existe
		if (!empty($getRelationship)) {
			$callback['error']['code'] = 19;
			$callback['error']['message'] = errorMessage($callback['error']['code']);

			echo json_encode($callback);
			return false;
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

}