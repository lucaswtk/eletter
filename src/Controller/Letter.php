<?php

namespace Source\Controller;

use CoffeeCode\Router\Router;
use League\Plates\Engine;

class Letter {

	/** @var Router */
	private $router;

	/** @var Engine */
	private $view;

	/**
	 * User constructor.
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
	 * Responsável por renderizar a página de cadastro de carta.
	 * </p>
	 */
	public function new() {
		echo $this->view->render('letter/new');
	}

	/**
	 * all. <p>
	 * Responsável por renderizar a página que lista todas as cartas.
	 * </p>
	 */
	public function all() {
		echo $this->view->render('letter/all', [
			'letters' => (new \Source\Model\Letter())->find()->fetch(true)
		]);
	}

}