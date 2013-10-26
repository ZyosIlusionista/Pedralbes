<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de Manejo de Motor de Plantillas Twig
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
	class NeuralPlantillasTwig {
		
		/**
		 * static $Codificacion = 'UTF-8';
		 * Variable define la codificacion de la plantilla
		 * @param $Codificacion = 'UTF-8': puede cambiarse a valor ISO o el cual se requiera
		 * */
		static $Codificacion = 'UTF-8';
		
		/**
		 * static $Depuracion = false;
		 * Modo depuracion para observar los distintos errores
		 * @param $Depuracion = false: valor true activo, valor false Inactivo
		 * */
		static $Depuracion = false;
		
		/**
		 * Metodo Privado
		 * Registro($Registro = 'Twig')
		 * 
		 * Genera el proceso de registrar el las diferentes librerias
		 * de el motor de plantillas
		 * */
		private function Registro() {
			
			Twig_Autoloader::register();
		}
		
		/**
		 * Metodo Privado
		 * ActivarVendor();
		 * 
		 * Valida si esta activo en los vendors para incluir el autoloader correspondiente
		 * */
		private function ActivarVendor() {
			
			$ListadoVendors = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigVendors.json');
			if($ListadoVendors['Twig']['Activo'] == false) {
				if(file_exists(__SysNeuralFileRootVendors__.'Twig/Autoloader.php') == true) {
					require_once __SysNeuralFileRootVendors__.'Twig/Autoloader.php';
				}
				else {
					exit('Lo Sentimos, el Vendor Correspondiente No Existe: '.__SysNeuralFileRootVendors__.'Twig/Autoloader.php');
				}
			}
		}
		
		/**
		 * Metodo Publico
		 * ParametrosEtiquetas($Etiqueta = false, $Valor = false)
		 * 
		 * Metodo que toma los parametros para pasarlos a la plantilla correspondiente
		 * @param $Etiqueta = false: Nombre de la Etiqueta Correspondiente
		 * @param $Valor = false: Valor que tendra la etiqueta correspondiente
		 * */
		public function ParametrosEtiquetas($Etiqueta = false, $Valor = false) {
			
			if($Etiqueta == true AND $Valor == true) {
				$this->Parametro[$Etiqueta] = $Valor;
			}
		}
		
		/**
		 * Metodo Publico
		 * AgregarFuncionAnonima($NombreFuncion = false, $Funcion = false)
		 * 
		 * Metodo en el cual se pueden pasar funciones anonimas a la plantilla
		 * @param $NombreFuncion: Nombre que tendra la funcion
		 * @Funcion $Funcion: Funcion anonima que se ejecutara
		 */
		public function AgregarFuncionAnonima($NombreFuncion = false, $Funcion = false) {
			if($NombreFuncion == true AND $Funcion == true) {
				$this->FuncionAnonima[$NombreFuncion] = $Funcion;
			}
		}
		
		/**
		 * Metodo Publico
		 * ParametrosEtiquetasArray($Array = false)
		 * 
		 * Metodo que toma los parametros para pasarlos a la plantilla correspondiente
		 * en formato array('Parametro' => 'Valor', 'Parametro' => 'Valor')
		 * @param $Array = false: array asociativo con los parametros correspondientes
		 * @example array('Parametro' => 'Valor', 'Parametro' => 'Valor')
		 * */
		public function ParametrosEtiquetasArray($Array = false) {
			
			if($Array == true AND  is_array($Array) == true) {
				$this->ParametroArray = $Array;
			}
		}
		
		/**
		 * Metodo Publico
		 * MostrarPlantilla($Plantilla = false, $Aplicacion = 'DEFAULT', $Cache = false)
		 * 
		 * Genera el proceso de construccion de la plantilla correspondiente
		 * @param $Plantilla = false: ruta y nombre del archivo dentro de la carpeta vistas
		 * @param $Aplicacion = 'DEFAULT': nombre de la aplicacion donde se tomaran los accesos
		 * @param $Cache = false: sistema de cache de la plantilla, true para utilizar la cache
		 * 
		 * */
		public function MostrarPlantilla($Plantilla = false, $Aplicacion = 'DEFAULT', $Cache = false) {
			
			if($Plantilla == true) {
				
				$ParametrosPlantilla = self::OrganizarParametros();
				$CarpetaAplicacion = self::ValidarConfiguracionAplicacion($Aplicacion);
				$Rutas = self::LeerArchivoRutas($CarpetaAplicacion['Carpeta'], $CarpetaAplicacion['Configuracion']);
				if(file_exists(__SysNeuralFileRootModulos__.$CarpetaAplicacion['Carpeta'].$CarpetaAplicacion['Vistas'].$Plantilla)) {
					
					self::ActivarVendor();
					self::Registro();
					if($Cache == true) {
						
						$Cargador = new Twig_Loader_Filesystem(__SysNeuralFileRootModulos__.$CarpetaAplicacion['Carpeta'].$CarpetaAplicacion['Vistas']);
						$Twig = new Twig_Environment($Cargador, array('charset' => self::$Codificacion, 'debug' => self::$Depuracion, 'cache' => __SysNeuralFileRootCache__));
						$Twig->addGlobal('NeuralRutasApp', array(
							'RutaURL' => __NeuralUrlRoot__.$Rutas['Modulo'].'/', 
							'RutaURLBase' => __NeuralUrlRoot__, 
							'RutaPublico' => __NeuralUrlRoot__.'Public/'.$Rutas['Carpeta_Public'].'/',
							'RutaJs' => __NeuralUrlRoot__.'Public/'.$Rutas['Carpeta_Public'].'/'.$Rutas['Carpeta_Js'].'/', 
							'RutaImagenes' => __NeuralUrlRoot__.'Public/'.$Rutas['Carpeta_Public'].'/'.$Rutas['Carpeta_Imagenes'].'/', 
							'RutaCss' => __NeuralUrlRoot__.'Public/'.$Rutas['Carpeta_Public'].'/'.$Rutas['Carpeta_Css'].'/'
						));
						
						if(isset($this->FuncionAnonima) == true) {
							foreach ($this->FuncionAnonima AS $Nombre => $Funcion) {
								$Filtro = new Twig_SimpleFilter($Nombre, $Funcion);
								$Twig->addFilter($Filtro);
							}
						}
						return $Twig->render($Plantilla, $ParametrosPlantilla);
					}
					else {
						
						$Cargador = new Twig_Loader_Filesystem(__SysNeuralFileRootModulos__.$CarpetaAplicacion['Carpeta'].$CarpetaAplicacion['Vistas']);
						$Twig = new Twig_Environment($Cargador, array('charset' => self::$Codificacion, 'debug' => self::$Depuracion));
						$Twig->addGlobal('NeuralRutasApp', array(
							'RutaURL' => __NeuralUrlRoot__.$Rutas['Modulo'].'/', 
							'RutaURLBase' => __NeuralUrlRoot__, 
							'RutaPublico' => __NeuralUrlRoot__.'Public/'.$Rutas['Carpeta_Public'].'/',
							'RutaJs' => __NeuralUrlRoot__.'Public/'.$Rutas['Carpeta_Public'].'/'.$Rutas['Carpeta_Js'].'/', 
							'RutaImagenes' => __NeuralUrlRoot__.'Public/'.$Rutas['Carpeta_Public'].'/'.$Rutas['Carpeta_Imagenes'].'/', 
							'RutaCss' => __NeuralUrlRoot__.'Public/'.$Rutas['Carpeta_Public'].'/'.$Rutas['Carpeta_Css'].'/'
						));
						
						if(isset($this->FuncionAnonima) == true) {
							foreach ($this->FuncionAnonima AS $Nombre => $Funcion) {
								$Filtro = new Twig_SimpleFilter($Nombre, $Funcion);
								$Twig->addFilter($Filtro);
							}
						}
						return $Twig->render($Plantilla, $ParametrosPlantilla);
					}
				}
				else {
					exit('No Existe el Archivo Correspondiente en la Carpeta de Vistas: '.$Plantilla);
				}
			}
			else {
				exit('No Se Ha Ingresado Una Plantilla Valida');
			}
		}
		
		/**
		 * Metodo Privado
		 * LeerArchivoRutas($Carpeta = false, $Configuracion = false)
		 * 
		 * Lee el archivo de configuracion de rutas
		 * */
		private function LeerArchivoRutas($Carpeta = false, $Configuracion = false) {
			
			if($Carpeta == true AND $Configuracion == true) {
				return SysNeuralNucleo::LeerArchivosConfiguracionRutasModulo($Carpeta, $Configuracion);
			}
		}
		
		/**
		 * Metodo Privado
		 * ValidarConfiguracionAplicacion($Aplicacion = false)
		 * 
		 * Genera la Validacion de la Carperta de Vistas y Aplicacion
		 * */
		private function ValidarConfiguracionAplicacion($Aplicacion = false) {
			
			if($Aplicacion == true) {
				$Accesos = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigAcceso.json');
				if(array_key_exists($Aplicacion, $Accesos) == true) {
					return $Accesos[$Aplicacion]['Enrutamiento'];
				}
				else {
					exit('No Existe la Aplicacion: '.$Aplicacion.' En La Configuracion de Accesos');
				}
			}
		}
		
		/**
		 * Metodo Privado
		 * OrganizarParametros()
		 * 
		 * Este metodo valida y organiza el array de datos que se van a enviar como parametros de Twig
		 * */
		private function OrganizarParametros() {
			
			$ParametrosEtiqueta = (isset($this->Parametro) == true) ? $this->Parametro : array();
			$ParametrosEtiquetaArray = (isset($this->ParametroArray) == true) ? $this->ParametroArray : array();
			return array_merge($ParametrosEtiqueta, $ParametrosEtiquetaArray);
		}
	}