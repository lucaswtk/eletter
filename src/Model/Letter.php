<?php

namespace Source\Model;

use CoffeeCode\DataLayer\DataLayer;

class Letter extends DataLayer {

	/**
	 * Organ constructor.
	 */
	public function __construct() {
		parent::__construct('el_letters', [
			'subject',
			'content',
			'template',
			'lot',
			'status',
			'send',
			'recipient_name',
			'recipient_addr_zipcode',
			'recipient_addr_street',
			'recipient_addr_number',
			'recipient_addr_neighborhood',
			'recipient_addr_city',
			'recipient_addr_state',
			'recipient_addr_country'
		]);
	}

}