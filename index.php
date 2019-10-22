<?php
ob_start();

require_once __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Router\Router;

/*
 * Rotas
 */

$router = new Router(BASE);

// Aplica característica de controlador para rota
$router->namespace('Source\Controller');

// Não aplica hierarquia de url
$router->group(null);

/*
 * Acesso
 */
$router->get('/', 'Access:signIn', 'access.signIn');
$router->get('/signOut', 'Access:signOut', 'access.signOut');
$router->post('/validateSignIn', 'Access:validateSignIn', 'access.validateSignIn');

/*
 * Sistema
 */
$router->group('dashboard');
$router->get('/', 'Dashboard:home', 'dashboard.home');

/*
 * Usuário
 */
$router->group('user');
$router->get('/new', 'User:new', 'user.new');
$router->get('/all', 'User:all', 'user.all');
$router->get('/edit', 'User:edit', 'user.edit');
$router->get('/edit/{id}', 'User:edit', 'user.edit');
$router->post('/create', 'User:create', 'user.create');
$router->post('/update', 'User:create', 'user.update');
$router->post('/delete', 'User:delete', 'user.delete');
$router->post('/deleteAvatar', 'User:deleteAvatar', 'user.deleteAvatar');

/*
 * Órgão
 */
$router->group('organ');
$router->get('/new', 'Organ:new', 'organ.new');
$router->get('/all', 'Organ:all', 'organ.all');
$router->get('/edit', 'Organ:edit', 'organ.edit');
$router->get('/edit/{id}', 'Organ:edit', 'organ.edit');
$router->post('/create', 'Organ:create', 'organ.create');
$router->post('/update', 'Organ:create', 'organ.update');
$router->post('/delete', 'Organ:delete', 'organ.delete');
$router->post('/deleteBrand', 'Organ:deleteBrand', 'organ.deleteBrand');

/*
 * Carta
 */
$router->group('letter');
$router->get('/new', 'Letter:new', 'letter.new');
$router->get('/all', 'Letter:all', 'letter.all');

$router->get('/template/new', 'Template:new', 'template.new');
$router->get('/template/all', 'Template:all', 'template.all');
$router->get('/template/preview/', 'Template:previewPDF', 'template.previewPDF');
$router->get('/template/preview/{id}', 'Template:previewPDF', 'template.previewPDF');
$router->get('/template/edit', 'Template:edit', 'template.edit');
$router->get('/template/edit/{id}', 'Template:edit', 'template.edit');
$router->post('/template/create', 'Template:create', 'template.create');
$router->post('/template/update', 'Template:create', 'template.update');
$router->post('/template/delete', 'Template:delete', 'template.delete');

$router->get('/metadata/new', 'Field:new', 'field.new');
$router->get('/metadata/all', 'Field:all', 'field.all');
$router->get('/metadata/edit', 'Field:edit', 'field.edit');
$router->get('/metadata/edit/{id}', 'Field:edit', 'field.edit');
$router->post('/metadata/create', 'Field:create', 'field.create');
$router->post('/metadata/update', 'Field:create', 'field.update');
$router->post('/metadata/delete', 'Field:delete', 'field.delete');

// Executa o roteador
$router->dispatch();

/*
 * Tratamento de erro
 */
if ($router->error()) {

	// Renderização da view
	$leaguePlates = League\Plates\Engine::create(__DIR__ . '/themes/' . THEME, 'php');
	echo $leaguePlates->render('error', [
		'errcode' => $router->error()
	]);
}

ob_end_flush();