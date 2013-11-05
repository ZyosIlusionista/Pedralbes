<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Helper - Ayuda
	 * Clase que ayuda a convertir strings de ASCII - HEX - ASCII
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
	class AyudasConversorHexAscii {
		
		/**
		 * Metodo Estatico Publico
		 * ASCII_HEX($Ascii = false)
		 * 
		 * Convierte una cadena de ASCII - HEX
		 * @param $Ascii: Valor Ascii que se desea convertir
		 * @example
		 * @access public
		 * */
		public static function ASCII_HEX($Ascii = false) {
			
			if($Ascii == true) {
				$Cantidad = strlen($Ascii);
				for ($i = 0; $i<$Cantidad; $i++) {
					$Byte = dechex(ord($Ascii[$i]));
					$Hex[] = str_repeat('0', 2 -strlen($Byte)).$Byte;
				}
				return implode('', $Hex);
			}
		}
		
		/**
		 * Metodo Estatico Publico
		 * HEX_ASCII($Hex = false)
		 * 
		 * Convierte una Cadena HEX - ASCII
		 * @param $Hex: valor Hex que se desea convertir
		 * @access public
		 * */
		public static function HEX_ASCII($Hex = false) {
			
			if($Hex == true) {
				$Cantidad = strlen($Hex);
				for ($i = 0; $i<$Cantidad; $i = $i+2) {
					$Ascii[] = chr(hexdec(substr($Hex, $i, 2)));
				}
				return implode('', $Ascii);
			}
		}
	}