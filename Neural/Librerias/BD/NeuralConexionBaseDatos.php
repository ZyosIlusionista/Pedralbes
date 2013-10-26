<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de Conexion a Bases de Datos
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
	class NeuralConexionBaseDatos {
		
		/**
		 * NeuralConexionBaseDatos($Base)
		 * 
		 * Genera la conexión a la base de datos previamente configurada
		 * Este metodo utiliza Doctrine 2 DBAL para el crud correspondiente 
		 * 
		 * $Aplicacion: nombre en mayusculas de la aplicacion correspondiente
		 * en caso de no seleccionar aplicacion tomara el valor de la aplicacion actual
		 * si no se reconoce configuracion de la aplicacion o no existe envia valores null
		 * generando error en doctrine
		 */
		public static function ObtenerConexionBase($Aplicacion = 'DEFAULT') {
			//Leemos el archivo de configuraciones de bases de datos
			$DatosBaseDatos = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigBasesDatos.json');
			//Validamos si existe la base de datos
			if(array_key_exists(mb_strtoupper($Aplicacion), $DatosBaseDatos)) {
				foreach ($DatosBaseDatos[trim(mb_strtoupper($Aplicacion))] as $key => $value) {
					$ParametrosConexion[trim($key)] = trim($value);
				}
				//Validamos si se encuentra la libreria de Doctrine se encuentra en el archivo de configuracion activo o inactivo
				$ListadoVendors = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigVendors.json');
				//Validamos si el estado es true o false
				if($ListadoVendors['DBAL Doctrine 2']['Activo'] == false) {
					require_once __SysNeuralFileRootVendors__.'Doctrine/Common/ClassLoader.php';
				}
				//Incluimos y retornamos la conexion correspondiente
				$ClassLoader = new \Doctrine\Common\ClassLoader('Doctrine');
        		$ClassLoader->register();
				//Retornamos los datos de la conexion correspondiente
	        	return \Doctrine\DBAL\DriverManager::getConnection($ParametrosConexion);
			}
		}
	}