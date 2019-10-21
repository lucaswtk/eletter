<?php

namespace Source\Helpers;

class Check {

	/**
	 * email. <p>
	 * Responsável por validar o formuato de e-mail. Retorna TRUE se for válido,
	 * FALSE caso contrário.
	 * </p>
	 *
	 * @param string $email E-mail para validação
	 *
	 * @return bool TRUE para e-mail válido, ou FALSE
	 */
	public static function email(string $email): bool {

		// Expressão regular para validar e-mail
		$format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

		// Valida o e-mail
		if (preg_match($format, $email)):
			return true;
		endif;

		return false;
	}

	/**
	 * stringTreatment. <p>
	 * Responsável por tratar de uma string substituindo caracteres especiais
	 * pelo dado contido no parâmetro $replace.
	 * </p>
	 *
	 * @param string $subject String que será tratada
	 * @param string $replace O caractere que será aplicado nas regras definidas em str_replace
	 *
	 * @return string String tratada
	 */
	public static function stringTreatment(string $subject, string $replace): string {

		// Os caracteres em A serão tratados e convertidos para os caracteres em B
		$format = [
			'a' => 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª',
			'b' => 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 '
		];

		// Trata a string convertendo os dados do array $format
		$data = strtr(utf8_decode($subject), utf8_decode($format['a']), $format['b']);

		// Elimina espaços desnecessários
		$data = strip_tags(trim($data));

		// Trata os espaços vazios
		$data = str_replace(' ', $replace, $subject);

		// Trata multiplos traços
		if (strstr($data, '-')) {
			$data = str_replace(['-----', '----', '---', '--'], $replace, $data);
		}

		return strtolower(utf8_encode($data));
	}

	/**
	 * template. <p>
	 * Responsável por construir um template e alimentá-lo por strings
	 * localizadoras com os dados de um array.
	 * </p>
	 *
	 * @param string $filePath Caminho do arquivo de template
	 * @param array  $data Dados que serão adicionados no arquivo de template
	 *
	 * @return string Template
	 */
	public static function template(string $filePath, array $data = []): string {

		// Obtém o conteúdo do arquivo template
		$template = file_get_contents($filePath);

		// Obtém e trata as chaves para se tornarem strings localizadoras
		$keys = explode('&', '{{' . implode("}}&{{", array_keys($data)) . '}}');

		// Extrai somente os valores
		$values = array_values($data);

		// Substitui as strings localizadoras pelos valores no arquivo de template
		return str_replace($keys, $values, $template);
	}

}