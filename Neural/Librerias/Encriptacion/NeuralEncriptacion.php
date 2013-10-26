<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de Codificacion de datos
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
	class NeuralEncriptacion {
		
		/**
		 * NeuralEncriptacion::DesencriptarDatos($Cadena)
		 * 
		 * Sistema de Des-Encriptación de datos
		 * @param $Cadena: Cadena para Des-Encriptacion
		 * @param $Aplicacion: aplicacion donde se tomara la llave de encriptacion
		 * 
		 * */
		public static function DesencriptarDatos($Cadena = false, $Aplicacion = 'DEFAULT') {
			if($Cadena == true AND $Aplicacion == true) {
				//Generamos la Llave Correspondiente
				$Llave = self::SeleccionClave($Aplicacion);
				//decodificamos el base64
				$String = base64_decode($Cadena);
				//Generamos el proceso de Desencriptacion
				$Encriptacion = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $Llave, $String, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
				//retornamos el dato correspondiente
				return trim($Encriptacion);
			}
		}
		
		/**
		 * NeuralEncriptacion::EncriptarDatos($Cadena)
		 * 
		 * Sistema de Encriptación de datos
		 * @param $Cadena: Cadena para Encriptacion
		 * @param $Aplicacion: aplicacion donde se tomara la llave de encriptacion
		 * 
		 **/
		public static function EncriptarDatos($Cadena = false, $Aplicacion = 'DEFAULT') {
			if($Cadena == true AND $Aplicacion == true) {
				//Generamos la Llave Correspondiente
				$Llave = self::SeleccionClave($Aplicacion);
				//Generamos la Cadena encriptada
				$Encriptacion = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $Llave, $Cadena, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND));
				//Retornamos el dato encriptado con formato base64 para poder guardarla en una base de datos
				return base64_encode($Encriptacion);
			}
		}
		
		/**
		 * self::SeleccionClave($Array = false);
		 * 
		 * Valida si se genera una clave por defecto del archivo de configuracion
		 * valida si es una clave especializada ingresada por el desarrollador
		 * @param $Array: datos que se reciben para ser evaluados
		 * 
		 * */
		private static function SeleccionClave($Array = false) {
			if($Array) {
				//Validamos si es un array o un string
				if(is_array($Array)) {
					//Validamos que existan los datos requeridos
					if(isset($Array[0]) == true AND isset($Array[1]) == true) {
						//Codificamos la Clave a base64 paa hacer un key seguro
						$Clave = base64_encode(trim($Array[0]));
						//Generamos el nombre de la aplicacion
						$Aplicacion = mb_strtoupper(trim($Array[1]));
						//validamos que la aplicacion exista,validacion redundante
						if(array_key_exists($Aplicacion, SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigAcceso.json'))) {
							//regresamos la clave correspondiente
							return $Clave;
						}
						else {
							//Generamos mensaje de error no existe aplicacion especificada
							exit('No es Posible aceptar la llave de Encriptacion, Aplicacion No Existe');
						}
					}
					else {
						//error si no envian los parametros correctos 
						exit('Los parametros de requeridos de Aplicacion no son Correctos');
					}
				}
				else {
					//Enviamos la clave desde el archivo de configuracion
					return self::ArchivoConfiguracion($Array);
				}
			}
		}
		
		/**
		 * self::ArchivoConfiguracion($Archivo = false);
		 * 
		 * Lee el archivo de configuracion para la extraccion de la clave de encriptacion
		 * @param $Archivo: Nombre del Archivo de configuracion
		 * */
		private static function ArchivoConfiguracion($Aplicacion = false) {
			if($Aplicacion) {
				//Leemos el archivo de configuracion
				$Configuracion = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigAcceso.json');
				//Validamos si existe la aplicacion correspondiente
				if(array_key_exists(mb_strtoupper(trim($Aplicacion)), $Configuracion)) {
					//Recuperamos la clave correspondiente
					$Clave = $Configuracion[mb_strtoupper(trim($Aplicacion))]['Configuracion']['Llave_Encriptacion'];
					//Validamos que no este vacia la clave correspondiente
					if(!empty($Clave)) {
						//Retornamos la clave correspondiente
						unset($Aplicacion, $Configuracion);
						return $Clave;
					}
					else {
						//Generamos un Mensaje de Error de Usuario
						exit('NeuralEncriptacion: Debe Ingresar Una Clave de Encriptacion en el Archivo de Configuracion');
					}
				}
				else {
					//Generamos un Mensaje de Error de Usuario
					exit('NeuralEncriptacion: La Aplicacion Seleccionada No Existe en el Archivo de Configuracion');
				}
			}
		}
	}