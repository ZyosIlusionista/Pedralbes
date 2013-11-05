<?php
	class Central extends Controlador {
		
		function __Construct() {
			parent::__Construct();
			AyudaSession::ValidarSesionActiva();
		}
		
		public function Index() {
			Ayudas::print_r($_SESSION);
			/*$Plantilla = new NeuralPlantillasTwig;
			echo $Plantilla->MostrarPlantilla('Central/Central.html', 'OUTLET');
			*/
		}
	}