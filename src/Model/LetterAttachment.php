<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class LetterAttachment extends DataLayer {

	public function __construct() {
		parent::__construct('el_letters_attachments', [
			'letter_id',
			'data'
		], 'id', false);
	}

}