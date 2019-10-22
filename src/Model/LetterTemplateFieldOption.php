<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class LetterTemplateFieldOption extends DataLayer {

	public function __construct() {
		parent::__construct('el_letters_templates_fields_options', [
			'field_id',
			'text'
		], 'id', false);
	}

}