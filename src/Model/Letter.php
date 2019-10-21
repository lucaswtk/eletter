<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class Letter extends DataLayer {

	/**
	 * Organ constructor.
	 */
	public function __construct() {
		parent::__construct('el_letters', [
			'name',
			'content',
			'model',
			'lot',
			'status',
			'send',
			'recipient_zipcode',
			'recipient_street',
			'recipient_number',
			'recipient_neighborhood',
			'recipient_city',
			'recipient_state',
			'recipient_country'
		]);
	}

}