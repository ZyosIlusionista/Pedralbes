<?php
	class Error extends Controlador {
		
		const APP = 'OUTLET';
		
		function __Construct() {
			parent::__Construct();
		}
		
		public function Index() {
			header("Location: ".NeuralRutasApp::RutaURL('Error/Error403'));
			exit();
		}
		
		public function Error403() {
			$Plantilla = new NeuralPlantillasTwig;
			echo $Plantilla->MostrarPlantilla('Error/403.html', self::APP);
		}
		
		public function NoPermiso() {
			echo 'No Tiene Permisos';
		}
	}