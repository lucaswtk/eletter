<?php
session_start();

// Config de conexão com o banco de dados
define("DATA_LAYER_CONFIG", [
	"driver" => "mysql",
	"host" => "localhost",
	"port" => "3306",
	"dbname" => "eletter",
	"username" => "root",
	"passwd" => "",
	"options" => [
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
		PDO::ATTR_CASE => PDO::CASE_NATURAL
	]
]);

// URL de instalação do sistem
define('BASE', 'https://localhost/project/eletter');

// Nome do site
define('SITE_NAME', 'eLetter');

// Tema
define('THEME', 'default');

// Caminho completo
define('INCLUDE_PATH', BASE . '/themes/' . THEME);

// Caminho de referência ao arquivo
define('REQUIRE_PATH', '/themes/' . THEME);

// Caminho para avatar default
define('AVATAR_DEFAULT', REQUIRE_PATH . '/assets/media/avatars/default.jpg');

// Status do usuário desenvolvedor
define('USER_DEV', 999);

/**
 * message. <p>
 * Constrói e retorna uma estrutura de alerta utilizando o componente
 * alert do bootstrap.
 * </p>
 *
 * @param string $message Messagem que será exibida
 * @param string $type Tipo (cor do alerta)
 *
 * @return string Estrutura em HTML do alerta
 */
function message(string $message, string $type): string {
	return "<div class=\"alert alert-{$type}\" role=\"alert\">{$message}</div>";
}

/**
 * errorMessage. <p>
 * Mensagens de erro do sistema. Para obter a mensagem de acordo com o erro,
 * basta informar o código do erro via parâmetro.
 * </p>
 *
 * @param int $error Código de erro
 *
 * @return string Mensagem de erro
 */
function errorMessage(int $error): string {
	$message = [
		0 => '',
		1 => 'Campo obrigatório não preeenchido',
		2 => 'Usuário não encontrado',
		3 => 'Senha incorreta',
		4 => 'Formato de e-mail inválido',
		5 => 'E-mail já cadastrado',
		6 => 'Nome de usuário já cadastrado',
		7 => 'Cadastro não realizado',
		8 => 'A imagem para o avatar não possui formato válido',
		9 => 'Avatar não encontrado',
		10 => 'Remoção não realizada',
		11 => 'Usuário não possui nível de acesso permitido',
		12 => 'Órgão já cadastrado',
		13 => 'A imagem para a logo não possui formato válido',
		14 => 'Órgão não existe',
		15 => 'Logo não encontrada',
		16 => 'Sigla já cadastrada',
		17 => 'Metadado não existe'
	];

	return $message[$error];
}

/**
 * callback. <p>
 * Responsável por preparara e retornar uma estrutura json como callback.
 * A estrutura é construída a partir do código de erro informado via parâmetro.
 * </p>
 *
 * @param int  $error Código de erro
 * @param bool $convert TRUE para converter e exibir o retorno, FALSE para não
 *
 * @return array $callback Retorna o array de callback
 */
function callback(int $error = 0, bool $convert = true): array {

	// Retorno
	$callback = ['error' => [
		'error' => $error,
		'message' => errorMessage($error)
	]];

	// Converte retorno para json
	if ($convert) {
		echo json_encode($callback);
	}

	return $callback;
}