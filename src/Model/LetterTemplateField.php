<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class LetterTemplateField extends DataLayer {

	public function __construct() {
		parent::__construct('el_letters_templates_fields', [
			'template_id',
			'name'
		], 'id', false);
	}

}