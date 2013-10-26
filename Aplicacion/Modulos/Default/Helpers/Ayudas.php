<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Marco de Trabajo en PHP
	 * 
	 * @access public
	 * @copyright Copyright (c) 2010-2013 Zyos (neural.framework@gmail.com)
	 * @link http://neuralframework.com/
	 * @license http://neuralframework.com/license.txt
	 * @author neural.framework@gmail.com
	 * @since 1.0
	 * @version 2.0
	 * 
	 */
	abstract class Ayudas {
		
		/**
		 * Ayudas::print_r($Array = false);
		 * 
		 * Metodo que imprime en pantalla el contenido de un array
		 * @param $Array: array de datos para ser impreso
		 */
		public static function print_r($Array = false) {
			if($Array == true) {
				echo '<code style="font-family: verdana; font-size: 11px;"><pre>';
				print_r($Array);
				echo '</pre></code>';
			}
		}
		
		/**
		 * Ayudas::var_dump($Array = false);
		 * 
		 * Metodo que muestra información estructurada sobre una o más 
		 * expresiones incluyendo su tipo y valor
		 * @param $Array: datos que pueden ser variables, objetos, array, etc.
		 */
		public static function var_dump($Array = false) {
			if($Array == true) {
				echo '<code style="font-family: verdana; font-size: 11px;"><pre>';
				var_dump($Array);
				echo '</pre></code>';
			}
		}
		
	}