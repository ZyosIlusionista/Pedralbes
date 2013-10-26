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
	class Controlador {
		
		function __Construct() {
			$this->Vista = new Vista();
		}
		
		/**
		 * CargarModelo($Modelo = false)
		 * 
		 * Carga Modelo Correspondiente
		 * */
		public function CargarModelo($Modelo = false) {
			//Validamos que el parametro sea ingresado
			if($Modelo) {
				//Tomamos la variable del Mod_Rewrite y validamos el url para determinar el path correspondiente
				$Url = SysNeuralNucleo::LeerURLModReWrite();
				//Leemos el archivo de configuracion de accesos y lo convertimos en un array
				$Array = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigAcceso.json');
				//Validamos si cargamos el default o la aplicación seleccionada
				if(!empty($Url[0])) {
					//Validamos si existe la aplicacion correspondiente
					if(array_key_exists(mb_strtoupper($Url[0]), $Array)) {
						//Generamos las rutas de accesos
						$Modulo = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Carpeta'];
						$Modelos = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Modelos'];
						//Definimos el Nombre del controlador
						$Controlador = (isset($Url[1]) == true AND empty($Url[1]) != true) ? $Url[1] : 'Index';
						//Generamos el Nombre del Modelo y la Ruta correspondiente
						$Archivo = self::GenerarNombreModeloRuta($Modulo, $Modelos, $Controlador);
						//validamos si existe el archivo, si existe lo cargamos de lo contrario lo omitimos
						if(file_exists($Archivo['Archivo'])) {
							//Incluimos el modelo correspondiente
							require $Archivo['Archivo'];
							$this->Modelo = new $Archivo['Nombre'];
						}
					}
				}
				else {
					//Validamos si existe la aplicacion correspondiente
					if(array_key_exists('DEFAULT', $Array)) {
						//Generamos las rutas de accesos
						$Modulo = $Array['DEFAULT']['Enrutamiento']['Carpeta'];
						$Modelos = $Array['DEFAULT']['Enrutamiento']['Modelos'];
						//Definimos el Nombre del controlador
						$Controlador = (isset($Url[1]) == true AND empty($Url[1]) != true) ? $Url[1] : 'Index';
						//Generamos el Nombre del Modelo y la Ruta correspondiente
						$Archivo = self::GenerarNombreModeloRuta($Modulo, $Modelos, $Controlador);
						//validamos si existe el archivo, si existe lo cargamos de lo contrario lo omitimos
						if(file_exists($Archivo['Archivo'])) {
							//Incluimos el modelo correspondiente
							require $Archivo['Archivo'];
							$this->Modelo = new $Archivo['Nombre'];
						}
					}
				}
			}
		}
		
		/**
		 * GenerarNombreModeloRuta($Modulo = false, $Modelo = false, $Controlador = false)
		 * 
		 * Genera path y nombre del modelo correspondiente
		 * */
		private function GenerarNombreModeloRuta($Modulo = false, $Modelo = false, $Controlador = false) {
			//Validamos que se ingresen los parametros correspondientes
			if($Modulo == true AND $Modelo == true AND $Controlador == true){
				$Nombre = $Controlador.'_Modelo';
				$Archivo = $Controlador.'_Modelo.php';
				return array('Archivo' => __SysNeuralFileRootModulos__.$Modulo.$Modelo.$Archivo, 'Nombre' => $Nombre);
			}
		}
	}