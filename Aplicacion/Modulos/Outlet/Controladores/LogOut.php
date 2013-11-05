<?php
	class LogOut extends Controlador {
		
		function __Construct() {
			parent::__Construct();
			NeuralSesiones::Inicializacion();
			NeuralSesiones::Finalizacion();
			header("Location: ".NeuralRutasApp::RutaURL('Index'));
		}
		
		public function Index() {
			
		}
	}