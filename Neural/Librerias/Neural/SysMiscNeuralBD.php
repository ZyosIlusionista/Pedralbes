<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de procesos Internos del Framework
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
	abstract class SysMiscNeuralBD {
		
		public static function OrganizarCondiciones($Array) {
			foreach ($Array AS $Llave => $Valor) {
				$Datos[] = $Valor."='{Datos_$Llave}'";
			}
			return implode(' AND ', $Datos);
		}
		
		public static function CambiarDatos($SQL, $Key, $ArrayNombres, $Array) {
			for ($i=0; $i<count($Array[$Key][$ArrayNombres]); $i++) {
				$Datos[] = str_replace("{Datos_$Key}", $Array[$Key][$ArrayNombres][$i], $SQL);
			}
			return $Datos;
		}
	}