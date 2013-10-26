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
	
	/**
	 * Generamos la Clase para la Carga de configuraciones y librerias del framework
	 * 
	 * */
	class SysNeuralLoadCore {
		
		/**
		 * Metodo Privativo para generar la ruta donde se encuentra actualmente los diferentes archivos
		 * */
		private static function RutaCompleta($Carpeta = false, $Archivo = false) {
			$RutaArchivo = __DIR__.'/'.$Carpeta.'/'.$Archivo;
			if(file_exists($RutaArchivo)) {
				return $RutaArchivo;
			}
		}
		
		/**
		 * Metodo privativo para leer el archivos de configuracion
		 * */
		private static function CargarArchivoJsonConfiguraciones($Archivo = false) {
			$RutaArchivo = self::RutaCompleta('Configuraciones',$Archivo);
			if(file_exists($RutaArchivo)) {
				return json_decode(file_get_contents($RutaArchivo), true);
			}
		}
		
		/**
		 * Metodo privativo para leer el archivos de configuracion que se encuentra en Aplicacion
		 * */
		private static function CargarConfigAplicacionConfiguracion($Archivo = false) {
			$RutaArchivo = __SysNeuralFileRootAplicacion__.'Configuracion/'.$Archivo;
			if(file_exists($RutaArchivo)) {
				return json_decode(file_get_contents($RutaArchivo), true);
			}
		}
		
		/**
		 * Metodo Privativo para cargar las diferentes configuraciones del framework
		 * */
		private static function CargarConfiguraciones($Cargar = false) {
			if($Cargar) {
				//Cargamos la ruta URL principal
				if(file_exists(self::RutaCompleta('Configuraciones', 'Url.php'))) {
					require self::RutaCompleta('Configuraciones', 'Url.php');
				}
				
				//Cargamos las Rutas del Sistema
				if(file_exists(self::RutaCompleta('Configuraciones', 'Rutas.php'))) {
					require self::RutaCompleta('Configuraciones', 'Rutas.php');
				}
			}
		}
		
		/**
		 * Metodo privativo que carga las librerias del framework
		 * */
		private static function CargarLibrerias($Cargar = false) {
			if($Cargar) {
				//Cargamos el archivo de configuracion
				$Librerias = self::CargarArchivoJsonConfiguraciones('Librerias.json');
				foreach ($Librerias AS $Nombre => $Archivo) {
					//Generamos la ruta completa del archivo
					$PathArchivo = self::RutaCompleta('Librerias', $Archivo);
					//Validamos si existe el archivo de lo contrario se omite
					if(file_exists($PathArchivo)) {
						require $PathArchivo;
					}
				}
			}
		}
		
		/**
		 * Metodo privativo que carga las librerias de los Vendors Globales
		 * */
		private static function CargarVendors($Cargar = false) {
			if($Cargar) {
				$Vendors = self::CargarConfigAplicacionConfiguracion('ConfigVendors.json');
				foreach ($Vendors AS $Nombre => $Configuracion) {
					if($Configuracion['Activo']) {
						$PathVendors = __SysNeuralFileRootVendors__.$Configuracion['Ruta'];
						if(file_exists($PathVendors)) {
							require $PathVendors;
						}
					}
				}
			}
		}
		
		/**
		 * Metodo publico para cargar las funciones internas solicitadas
		 * */
		public static function Cargador() {
			//Generamos los procesos correspondientes
			self::CargarConfiguraciones(true);
			self::CargarVendors(true);
			self::CargarLibrerias(true);
		}
	}
	
	//Cargamos el Sistema
	SysNeuralLoadCore::Cargador();