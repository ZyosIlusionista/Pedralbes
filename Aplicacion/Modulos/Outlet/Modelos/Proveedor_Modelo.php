<?php
	class Proveedor_Modelo extends Modelo {
		
		function __Construct() {
			parent::__Construct();
		}
		
		public function ListadoProveedores() {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('proveedores');
			$Consulta->AgregarColumnas('Nombre');
			$Consulta->AgregarCondicion("Estado = 'ACTIVO'");
			$Consulta->PrepararQuery();
			$Data = $Consulta->ExecuteConsulta('PEDRALBES');
			foreach ($Data AS $Valor) {
				$Lista[] = $Valor['Nombre'];
			}
			return json_encode($Lista);
		}
	}