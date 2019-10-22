<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class LetterTemplate extends DataLayer {

	public function __construct() {
		parent::__construct('el_letters_templates', [
			'name',
			'content'
		]);
	}

}