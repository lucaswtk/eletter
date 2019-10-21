<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

class Dashboard {

	/** @var Router */
	private $router;

	/** @var Engine */
	private $view;

	/**
	 * System constructor.
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
	 * home. <p>
	 * Responsável por renderizar a página home do sistema após efetuar login.
	 * </p>
	 */
	public function home() {
		echo $this->view->render('dashboard/home');
	}

}