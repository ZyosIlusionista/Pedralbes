<?php
	class Proveedor_Modelo extends Modelo {
		
		function __Construct() {
			parent::__Construct();
		}
		
		public function GuardarNuevoProveedor($Array = array(), $Usuario) {
			$SQL = new NeuralBDGab;
			$SQL->SeleccionarDestino(AppAyuda::BASEMYSQL, 'proveedores');
			foreach ($Array AS $Columna => $Valor) {
				$SQL->AgregarSentencia($Columna, $Valor);
			}
			$SQL->AgregarSentencia('Estado', 'ACTIVO');
			$SQL->AgregarSentencia('Usuario', $Usuario);
			$SQL->AgregarSentencia('Fecha', date("Y-m-d"));
			$SQL->AgregarSentencia('Hora', date("H:i:s"));
			$SQL->InsertarDatos();
		}
		
		public function ListadoProveedores($Validacion = false) {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('proveedores');
			$Consulta->AgregarColumnas('Id, Nombre');
			$Consulta->AgregarCondicion("Estado = 'ACTIVO'");
			$Consulta->AgregarOrdenar('Nombre', 'ASC');
			$Consulta->PrepararQuery();
			return $Consulta->ExecuteConsulta(AppAyuda::BASEMYSQL);
		}
	}