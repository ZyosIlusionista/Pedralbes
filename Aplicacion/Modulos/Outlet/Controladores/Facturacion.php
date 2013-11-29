<?php
	class Facturacion extends Controlador {
		
		function __Construct() {
			parent::__Construct();
			AyudaSession::ValidarSesionActiva();
			$this->DatosSession = AyudaSession::DatosSession(true);
		}
		
		public function Crear_Factura() {
			$Plantilla = new NeuralPlantillasTwig;
			echo $Plantilla->MostrarPlantilla('Facturacion/Crear_Factura.html', 'OUTLET');
		}
	}