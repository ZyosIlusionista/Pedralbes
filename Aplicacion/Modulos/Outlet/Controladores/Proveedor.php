<?php
	class Proveedor extends Controlador {
		
		const APP = 'OUTLET';
		
		function __Construct() {
			parent::__Construct();
		}
		
		public function Index() {
			
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('ListadoProveedores', $this->Modelo->ListadoProveedores());
			echo $Plantilla->MostrarPlantilla('Proveedor/Formulario_Nueva_Factura.html', self::APP);
			
		}
	}