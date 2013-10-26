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
	 * Ruta de Acceso a Carpeta Root
	 * 
	 * Se utiliza la opcion dirname(dirname(__DIR__)) para tomar la ruta default de instalacion.
	 * Se puede reemplazar por la direccion fisica
	 *  
	 * @example Windows [C:\www\htdocs\]
	 * @example Linux [/opt/lampp/htdocs/]
	 * */
	define('__SysNeuralFileRoot__', dirname(dirname(__DIR__)));
	
	/**
	 * Ruta de Acceso a Carpeta Root Aplicacion
	 * 
	 * Se utiliza la opcion dirname(dirname(__DIR__)) para tomar la ruta default de instalacion.
	 * Se puede reemplazar por la direccion fisica
	 * 
	 * @example Windows [C:\www\htdocs\Aplicacion\]
	 * @example Linux [/opt/lampp/htdocs/Aplicacion/] 
	 * */
	define('__SysNeuralFileRootAplicacion__', dirname(dirname(__DIR__)).'/Aplicacion/');
	
	/**
	 * Ruta de Acceso a Carpeta de Cache
	 * 
	 * Se utiliza la opcion dirname(__DIR__) para tomar la ruta default de instalacion.
	 * Se puede reemplazar por la direccion fisica
	 * 
	 * @example Windows [C:\www\htdocs\Aplicacion\]
	 * @example Linux [/opt/lampp/htdocs/Aplicacion/] 
	 * */
	define('__SysNeuralFileRootCache__', __SysNeuralFileRootAplicacion__.'Cache/');
	
	/**
	 * Ruta de Acceso a Carpeta Root Modulos
	 * 
	 * Se utiliza la opcion dirname(dirname(__DIR__)) para tomar la ruta default de instalacion.
	 * Se puede reemplazar por la direccion fisica
	 * 
	 * @example Windows [C:\www\htdocs\Aplicacion\Modulos\]
	 * @example Linux [/opt/lampp/htdocs/Aplicacion/Modulos/] 
	 * */
	define('__SysNeuralFileRootModulos__', dirname(dirname(__DIR__)).'/Aplicacion/Modulos/');
	
	/**
	 * Ruta de Acceso de Separador de Doctrine 2 DBAL
	 * 
	 * Necesario para generar el enrutamiento base de doctrine 2
	 * Se puede reemplazar por la direccion fisica
	 * 
	 * @example Windows [C:\www\htdocs\Vendors\]
	 * @example Linux [/opt/lampp/htdocs/Vendors/]
	 * */
	 define('__SysNeuralFileRootVendors__', dirname(dirname(__DIR__)).'/Vendors/');