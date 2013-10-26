<?php
	
	/**
	 * Clase Index_Modelo
	 * 
	 * Clase correspondiente como modelo
	 * para los procesos de consultas a 
	 * bases de datos y/o manejo de conexiones
	 * remotas y WebServices.
	 */
	class Index_Modelo extends Modelo {
		
		/**
		 * Metodo Constructor
		 * 
		 * Es aquel que carga todo el proceso y las
		 * librerias para las conexiones a las bases
		 * de datos.
		 * En este metodo tambien se puede manejar
		 * informacion que puede ser utilizado en 
		 * todo el modelo.
		 */
		function __Construct() {
			parent::__Construct();
		}
		
		/**
		 * Metodo Publico
		 * 
		 * Estos son los metodos llamados por
		 * el controlador para realizar el
		 * procesos de generar las consultas
		 * correspondientes.
		 */
		public function Consulta() {
			//Proceso de Consulta de Bases de Datos
		}
	}