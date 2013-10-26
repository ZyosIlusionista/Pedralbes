<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de gestion basica de Sesiones
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
	class NeuralSesiones {
		
		/**
		 * NeuralSesiones::Inicializacion();
		 * 
		 * Genera la inicializacion de las opciones de Session
		 * 
		 * */
		public static function Inicializacion() {
			session_start();
		}
		
		/**
		 * NeuralSesiones::AgregarArray($Array);
		 * 
		 * Agrega información como array asociativo o incremental
		 * @param $Array: Array asociativo 
		 * @example array('Llave' => 'Valor')
		 * 
		 * */
		public static function AgregarArray($Array) {
			if(isset($_SESSION)) {
				$_SESSION = array_merge($_SESSION, $Array);
			}
			else {
				$_SESSION = array_merge($_SESSION, $Array);
			}
		}
		
		/**
		 * NeuralSesiones::AgregarLlave($Llave, $Valor);
		 * 
		 * Agrega informacion como Llave => Valor
		 * @param $Llave: apuntador de array
		 * @param $Valor: Valor del apuntador correspondiente
		 * 
		 * */
		public static function AgregarLlave($Llave, $Valor) {
			if(isset($_SESSION)) {
				if(array_key_exists($Llave, $_SESSION)) {
					unset($_SESSION[$Llave]);
					$_SESSION[$Llave] = $Valor;
				}
				else {
					$_SESSION[$Llave] = $Valor;
				}
			}
			else {
				$_SESSION[$Llave] = $Valor;
			}
		}
		
		/**
		 * NeuralSesiones::EliminarValor($Llave);
		 * 
		 * Elimina el valor de primer nivel de datos
		 * @param $Llave: apuntador del valor a eliminar
		 * 
		 * */
		public static function EliminarValor($Llave) {
			if(isset($_SESSION)) {
				if(array_key_exists($Llave, $_SESSION)) {
					unset($_SESSION[$Llave]);
				}
			}
		}
		
		/**
		 * NeuralSesiones::Finalizacion();
		 * 
		 * Elimina y destruye la sesion correspondiente
		 * 
		 * */
		public static function Finalizacion() {
			session_destroy();
			unset($_SESSION);
		}
	}