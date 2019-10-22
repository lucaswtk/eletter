<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

class LetterTemplate {

	/** @var Router */
	private $router;

	/** @var Engine */
	private $view;

	/**
	 * LetterTemplate constructor.
	 *
	 * @param Router $router Rota utilizada
	 */
	public function __construct(Router $router) {

		// Valida sessão do usuário
		(new UserSession())->validateSession($router);

		$this->router = $router;

		// Renderização da view
		$this->view = Engine::create(__DIR__ . '/../../themes/' . THEME, 'php');
		$this->view->addData([
			'router' => $router
		]);
	}

	/**
	 * new. <p>
	 * Responsável por renderizar a página de cadastro de usuário.
	 * </p>
	 */
	public function new(): void {
		echo $this->view->render('letter/template/new');
	}
}