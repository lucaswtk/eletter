<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class FieldValue extends DataLayer {

	public function __construct() {
		parent::__construct('el_fields_values', [
			'letter_id',
			'field_id',
			'value'
		], 'id', false);
	}

}