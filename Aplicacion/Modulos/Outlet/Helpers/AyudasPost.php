<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Helper - Ayuda
	 * Clase que ayudas para validaciones y procedimientos de array asociativos
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
	class AyudasPost {
	
		/**
		 * Metodo Publico
		 * FormatoEspacio($Array = false)
		 * 
		 * Retira los espacios tanto del inicio como del final de 
		 * los valores del array
		 * @param $Array: array tomado como $_POST o $_GET
		 * @access public
		 * */
		public static function FormatoEspacio($Array = false) {
			
			if($Array == true AND is_array($Array) == true) {
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = trim($Valor);
				}
				return $Lista;
			}
		}
		
		/**
		 * Metodo Publico
		 * FormatoEspaciOmitido($Array = false, $Omitidos = false)
		 * 
		 * Retira los espacios tanto del inicio como del final de 
		 * los valores del array
		 * @param $Array: array tomado como $_POST o $_GET
		 * @param $Omitidos: array incremental donde se omitiran
		 * @example $Omitidos: array('Nombre', 'Nombre')
		 * @access public
		 * */
		public static function FormatoEspaciOmitido($Array = false, $Omitidos = false) {
			
			if($Array == true AND is_array($Array) == true AND $Omitidos == true AND is_array($Omitidos) == true) {
				$Matriz = (is_array($Omitidos) == true) ? array_flip($Omitidos) : array();
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = (array_key_exists($Llave, $Matriz) == false) ? trim($Valor) : $Valor;
				}
				return $Lista;
			}
		}
		
		/**
		 * Metodo Estatico Publico
		 * FormatoMin($Array = false)
		 * 
		 * Aplica a los Valores de Array Asociativo de Primer Nivel
		 * el formato de minusculas a los valores de texto y retira los
		 * espacios del comienzo y el final del valor
		 * @param $Array: array tomado como $_POST o $_GET
		 * @access public
		 * */
		public static function FormatoMin($Array = false) {
			
			if($Array == true AND is_array($Array) == true) {
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = mb_strtolower(trim($Valor));
				}
			}
			return $Lista;
		}
		
		/**
		 * Metodo Estatico Publico
		 * FormatoMinOmitido($Array = false, $Omitidos = false)
		 * 
		 * Aplica a los Valores de Array Asociativo de Primer Nivel
		 * el formato de minusculas a los valores de texto y retira los
		 * espacios del comienzo y el final del valor
		 * @param $Array: array tomado como $_POST o $_GET
		 * @param $Omitidos: array donde se omitiran
		 * @example $Omitidos: array('Nombre', 'Nombre')
		 * @access public
		 * */
		public static function FormatoMinOmitido($Array = false, $Omitidos = false) {
			
			if($Array == true AND is_array($Array) == true AND $Omitidos == true AND is_array($Omitidos) == true) {
				$Matriz = (is_array($Omitidos) == true) ? array_flip($Omitidos) : array();
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = (array_key_exists($Llave, $Matriz) == true) ? trim($Valor) : mb_strtolower(trim($Valor));
				}
				return $Lista;
			}
		}
		
		/**
		 * Metodo Estatico Publico
		 * FormatoMayus($Array = false)
		 * 
		 * Aplica a los Valores de Array Asociativo de Primer Nivel
		 * el formato de mayusculas a los valores de texto y retira los
		 * espacios del comienzo y el final del valor
		 * @param $Array: array tomado como $_POST o $_GET
		 * @access public
		 * */
		public static function FormatoMayus($Array = false) {
			
			if($Array == true AND is_array($Array) == true) {
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = mb_strtoupper(trim($Valor));
				}
			}
			return $Lista;
		}
		
		/**
		 * Metodo Estatico Publico
		 * FormatoMayusOmitido($Array = false, $Omitidos = false)
		 * 
		 * Aplica a los Valores de Array Asociativo de Primer Nivel
		 * el formato de mayusculas a los valores de texto y retira los
		 * espacios del comienzo y el final del valor
		 * @param $Array: array tomado como $_POST o $_GET
		 * @param $Omitidos: array donde se omitiran
		 * @example $Omitidos: array('Nombre', 'Nombre')
		 * @access public
		 * */
		public static function FormatoMayusOmitido($Array = false, $Omitidos = false) {
			
			if($Array == true AND is_array($Array) == true AND $Omitidos == true AND is_array($Omitidos) == true) {
				$Matriz = (is_array($Omitidos) == true) ? array_flip($Omitidos) : array();
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = (array_key_exists($Llave, $Matriz) == true) ? trim($Valor) : mb_strtoupper(trim($Valor));
				}
				return $Lista;
			}
		}
		
		/**
		 * Metodo Estatico Publico
		 * DatosVacios($Array = false)
		 * 
		 * Recorre el array de datos POST o GET y regresa valor 
		 * @param $Array: array tomado como $_POST o $_GET
		 * @return true: encuentra valores vacios en el array
		 * @return false: No encuentra valores vacios
		 * @access public
		 * */
		public static function DatosVacios($Array = false) {
			
			if($Array == true) {
				foreach ($Array AS $Llave => $Valor) {
					$Lista[] = (empty($Valor) == true) ? '1' : '0'; 
				}
				return (array_sum($Lista)>=1) ? true : false;
			}
		}
		
		/**
		 * Metodo Estatico Publico
		 * DatosVaciosOmitidos($Array = false, $Omitidos = false)
		 * 
		 * Recorre el array de datos POST o GET y regresa valor 
		 * @param $Array: array tomado como $_POST o $_GET
		 * @param $Omitidos: array con las llaves que se omitiran
		 * @example array('omitir', 'omitir', 'omitir')
		 * @return true: encuentra valores vacios en el array
		 * @return false: No encuentra valores vacios
		 * @access public
		 * */
		public static function DatosVaciosOmitidos($Array = false, $Omitidos = false) {
			
			if($Array == true AND is_array($Array) == true AND $Omitidos == true AND is_array($Omitidos) == true) {
				$Matriz = (is_array($Omitidos) == true) ? array_flip($Omitidos) : array();
				foreach ($Array AS $Llave => $Valor) {
					$Lista[] = (array_key_exists($Llave, $Matriz) == true) ? '0' : (empty($Valor) == true) ? '1' : '0';
				}
				return (array_sum($Lista)>=1) ? true : false;
			}
		}
		
		/**
		 * Metodo Estatico Publico
		 * ConvertirTextoUcwords($Array = false);
		 * 
		 * Toma un Array y aplica funcion ucwords
		 * @param $Array: array de datos formatear
		 * */
		public static function ConvertirTextoUcwords($Array = false) {
			
			if($Array == true AND is_array($Array) == true) {
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = trim(ucwords($Valor));
				}
				return $Lista;
			}
		}
		
		/**
		 * Metodo Estatico Publico
		 * ConvertirTextoUcwordsOmitido($Array = false, $Omitidos = false);
		 * 
		 * Toma un Array y aplica funcion ucwords y omite los key ingresados
		 * @param $Array: array de datos formatear
		 * @param $Omitidos: array de campos a omitir
		 * */
		public static function ConvertirTextoUcwordsOmitido($Array = false, $Omitidos = false) {
			
			if($Array == true AND is_array($Array) == true AND $Omitidos == true AND is_array($Omitidos) == true) {
				$Matriz = (is_array($Omitidos) == true) ? array_flip($Omitidos) : array();
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = (array_key_exists($Llave, $Matriz) == true) ? trim($Valor) : trim(ucwords($Valor));
				}
				return $Lista;
			}
		}
		
		/**
		 * Metodo Publico
		 * LimpiarInyeccionSQL($Array = false)
		 * 
		 * Limpia de cadenas de inyeccion SQL a datos pasados por array
		 * @param $Array: array tomado como $_POST o $_GET
		 * */
		public static function LimpiarInyeccionSQL($Array = false) {
			
			if($Array == true AND is_array($Array) == true) {
				foreach ($Array AS $Llave => $Valor) {
					$Lista[trim($Llave)] = trim(self::SupresorSQL($Valor));
				}
				return $Lista;
			}
		}
		
		/**
		 * Metodo Privado
		 * SupresorSQL($Datos)
		 * 
		 * Suprime las cadenas peligrosas de inyeccion SQL
		 * @param $Datos: Valor a Sanear
		 * */
		private static function SupresorSQL($Datos) {
			
			//$Cadena = str_ireplace('SELECT', '', $Datos);
			//$Cadena = str_ireplace('COPY', '', $Cadena);
			$Cadena = str_ireplace('COPY', '', $Datos);
			$Cadena = str_ireplace('DELETE', '', $Cadena);
			$Cadena = str_ireplace('DROP', '', $Cadena);
			$Cadena = str_ireplace('DUMP', '', $Cadena);
			//$Cadena = str_ireplace(' OR ', '', $Cadena);
			$Cadena = str_ireplace('%', '', $Cadena);
			$Cadena = str_ireplace('LIKE', '', $Cadena);
			$Cadena = str_ireplace('--', '', $Cadena);
			$Cadena = str_ireplace('^', '', $Cadena);
			$Cadena = str_ireplace('[', '', $Cadena);
			$Cadena = str_ireplace(']', '', $Cadena);
			$Cadena = str_ireplace("\\", '', $Cadena);
			$Cadena = str_ireplace('!', '', $Cadena);
			$Cadena = str_ireplace('¡', '', $Cadena);
			$Cadena = str_ireplace('?', '', $Cadena);
			$Cadena = str_ireplace('=', '', $Cadena);
			$Cadena = str_ireplace('&', '', $Cadena);
			$Cadena = str_ireplace('INSERT ', '', $Cadena);
			//$Cadena = str_ireplace('INTO', '', $Cadena);
			$Cadena = str_ireplace('VALUES', '', $Cadena);
			$Cadena = str_ireplace('FROM', '', $Cadena);
			//$Cadena = str_ireplace('LEFT', '', $Cadena);
			$Cadena = str_ireplace('JOIN', '', $Cadena);
			$Cadena = str_ireplace('WHERE', '', $Cadena);
			//$Cadena = str_ireplace('LIMIT', '', $Cadena);
			$Cadena = str_ireplace('ORDER BY', '', $Cadena);
			//$Cadena = str_ireplace('AND', '', $Cadena);
			//$Cadena = str_ireplace('DESC', '', $Cadena);
			$Cadena = str_ireplace('ASC', '', $Cadena);
			//$Cadena = str_ireplace('ON ', '', $Cadena);
			$Cadena = str_ireplace('|', '', $Cadena);
			$Cadena = str_ireplace('°', '', $Cadena);
			$Cadena = str_ireplace('¬', '', $Cadena);
			$Cadena = str_ireplace('"', '', $Cadena);
			$Cadena = str_ireplace('#', '', $Cadena);
			$Cadena = str_ireplace('$', '', $Cadena);
			$Cadena = str_ireplace('&', '', $Cadena);
			//$Cadena = str_ireplace('/', '', $Cadena);
			$Cadena = str_ireplace('(', '', $Cadena);
			$Cadena = str_ireplace(')', '', $Cadena);
			$Cadena = str_ireplace('\'', '', $Cadena);
			$Cadena = str_ireplace('\\', '', $Cadena);
			$Cadena = str_ireplace('¡', '', $Cadena);
			$Cadena = str_ireplace('¿', '', $Cadena);
			$Cadena = str_ireplace('+', '', $Cadena);
			$Cadena = str_ireplace('~', '', $Cadena);
			$Cadena = str_ireplace('*', '', $Cadena);
			$Cadena = str_ireplace('¨', '', $Cadena);
			$Cadena = str_ireplace('´', '', $Cadena);
			$Cadena = str_ireplace('[', '', $Cadena);
			$Cadena = str_ireplace(']', '', $Cadena);
			$Cadena = str_ireplace('{', '', $Cadena);
			$Cadena = str_ireplace('}', '', $Cadena);
			$Cadena = str_ireplace('^', '', $Cadena);
			$Cadena = str_ireplace('`', '', $Cadena);
			$Cadena = addslashes($Cadena);
			return $Cadena;
		}
	}