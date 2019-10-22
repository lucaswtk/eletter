<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class Field extends DataLayer {

	public function __construct() {
		parent::__construct('el_fields', [
			'organ_id',
			'label',
			'element',
			'type',
			'name'
		]);
	}

}