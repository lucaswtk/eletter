<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class Template extends DataLayer {

	public function __construct() {
		parent::__construct('el_templates', [
			'organ_id',
			'name',
			'content'
		]);
	}

}