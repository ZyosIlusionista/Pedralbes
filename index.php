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
     
    //Generamos el Directorio Principal de las Librerias para la Carga General del Framework
    $LibreriasFramework = __DIR__.'/Neural';
     
    //Validacion de requerimiento de servidor
	if(version_compare(phpversion(), '5.3.2', '>=') == true AND function_exists('ctype_alpha') == true) {
		
		//Incluimos las librerias correspondientes
		require $LibreriasFramework.'/Cargador.php';

		//Cargamos la aplicación correspondiente
		$Boot = new SysNeuralBootstrap();
	}
	else {
		//Llamamos el archivo para mostrar el error correspondiente
		include $LibreriasFramework.'/MensajesError/ErrorInicialParametros.php';
	}