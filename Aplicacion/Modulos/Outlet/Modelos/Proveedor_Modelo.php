<?php
	class Proveedor_Modelo extends Modelo {
		
		function __Construct() {
			parent::__Construct();
		}
		
		public function GuardarNuevoProveedor($Array = array(), $Usuario) {
			$SQL = new NeuralBDGab;
			$SQL->SeleccionarDestino('PEDRALBES', 'Proveedores');
			foreach ($Array AS $Columna => $Valor) {
				$SQL->AgregarSentencia($Columna, $Valor);
			}
			$SQL->AgregarSentencia('Usuario', $Usuario);
			$SQL->AgregarSentencia('Fecha', date("Y-m-d"));
			$SQL->AgregarSentencia('Hora', date("H:i:s"));
			$SQL->InsertarDatos();
		}
	}