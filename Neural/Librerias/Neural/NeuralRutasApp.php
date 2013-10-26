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
	class NeuralRutasApp {
		
		public static function __Constructor($Tipo = false) {
			//Tomamos la variable del Mod_Rewrite y validamos el url para determinar el path correspondiente
		 	$Url = SysNeuralNucleo::LeerURLModReWrite();
		 	//Convertimos el Modulo correspondiente
		 	$Modulo = (empty($Url[0])) ? 'Default' : $Url[0];
		 	//Leemos el archivo de configuracion de accesos y lo convertimos en un array
		 	$Array = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigAcceso.json');
		 	//Validamos si existe la aplicacion correspondiente
		 	if(array_key_exists(mb_strtoupper($Modulo), $Array)) {
		 		//Leemos el archivo de configuracion
			 	$Rutas = SysNeuralNucleo::LeerArchivosConfiguracionRutasModulo($Array[mb_strtoupper($Modulo)]['Enrutamiento']['Carpeta'], $Array[mb_strtoupper($Modulo)]['Enrutamiento']['Configuracion']);
		 	}
		 	//Liberamos Memoria
		 	unset($Url, $Modulo, $Array);
		 	//Regresamos el Array Correspondiente
		 	return $Rutas[$Tipo];
		}
		
		/**
		 * RutaURLBase generada http://localhost/
		 * */
		public static function RutaURLBase($Ruta = false) {
			return __NeuralUrlRoot__.$Ruta;
		}
		
		/**
		 * RutaURL generada http://localhost/Modulo/Controlador/Metodo
		 * */
		public static function RutaURL($Ruta = false) {
			return __NeuralUrlRoot__.self::__Constructor('Modulo').'/'.$Ruta;
		}
		
		/**
		 * RutaPublico generada http://localhost/Public/Carpeta_Modulo/
		 * */
		public static function RutaPublico($Ruta = false) {
			return __NeuralUrlRoot__.'Public/'.self::__Constructor('Carpeta_Public').'/'.$Ruta;
		}
		
		/**
		 * RutaImagenes generada http://localhost/Public/Carpeta_Modulo/Carpeta_Imagenes/
		 * */
		public static function RutaImagenes($Ruta) {
			return __NeuralUrlRoot__.'Public/'.self::__Constructor('Carpeta_Public').'/'.self::__Constructor('Carpeta_Imagenes').'/'.$Ruta;
		}
		
		/**
		 * RutaCss generada http://localhost/Public/Carpeta_Modulo/Carpeta_Css/
		 * */
		public static function RutaCss($Ruta) {
			return __NeuralUrlRoot__.'Public/'.self::__Constructor('Carpeta_Public').'/'.self::__Constructor('Carpeta_Css').'/'.$Ruta;
		}
		
		/**
		 * RutaJs generada http://localhost/Public/Carpeta_Modulo/Carpeta_Js/
		 * */
		public static function RutaJs($Ruta) {
			return __NeuralUrlRoot__.'Public/'.self::__Constructor('Carpeta_Public').'/'.self::__Constructor('Carpeta_Js').'/'.$Ruta;
		}
	}