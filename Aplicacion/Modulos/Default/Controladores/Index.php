<?php

	/**
	 * Clase Index
	 * 
	 * Clase Inicial que carga el framework para la visualizacion Inicial
	 */
	class Index extends Controlador {
		
		/**
		 * Metodo Contructor
		 * 
		 * Metodo que carga todo el proceso del framework
		 * en este metodo se puede utilizar para cargar informacion
		 * que sera utilizado en todo el controlador
		 */
		function __Construct() {
			parent::__Construct();
		}
		
		/**
		 * Metodo Index
		 * 
		 * Metodo el cual se carga inicialmente cada
		 * vez que se llama el controlador correspondiente
		 * este es el punto de partida para generar la aplicacion
		 */
		public function Index() {
			
			echo 'Este es el Index de la Aplicación';
		}
	}