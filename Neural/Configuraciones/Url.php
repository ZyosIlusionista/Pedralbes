<?php
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Marco de Trabajo en PHP
	 * 
	 * @access private
	 * @copyright Copyright (c) 2010-2013 Zyos (neural.framework@gmail.com)
	 * @link http://neuralframework.com/
	 * @license http://neuralframework.com/license.txt
	 * @author neural.framework@gmail.com
	 * @since 1.0
	 * @version 2.0
	 * 
	 */

	//Cargamos la ruta base de la aplicacion
	define('ABSPATH', str_replace('\\', '/', dirname(__FILE__)) . '/'); 
	$RutaTemporal_1 = explode('/', str_replace('\\', '/', dirname($_SERVER['SCRIPT_FILENAME']))); 
	$RutaTemporal_2 = explode('/', substr(ABSPATH, 0, -1)); 
	$RutaTemporal_3 = explode('/', str_replace('\\', '/', dirname($_SERVER['PHP_SELF']))); 
	for ($i = count($RutaTemporal_2); $i<count($RutaTemporal_1); $i++)
		array_pop ($RutaTemporal_3);
	$UrlAddress = $_SERVER['HTTP_HOST'] . implode('/', $RutaTemporal_3); 
	if ($UrlAddress{strlen($UrlAddress) - 1}== '/')
		define('__NeuralUrlRoot__', 'http://' . $UrlAddress);
	else
		define('__NeuralUrlRoot__', 'http://' . $UrlAddress . '/');
	unset($RutaTemporal_1, $RutaTemporal_2, $RutaTemporal_3, $UrlAddress);