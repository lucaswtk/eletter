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

}