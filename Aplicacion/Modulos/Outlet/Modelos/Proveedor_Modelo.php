<?php
	class Proveedor_Modelo extends Modelo {
		
		function __Construct() {
			parent::__Construct();
			$this->Conexion = NeuralConexionBaseDatos::ObtenerConexionBase(AppAyuda::BASEMYSQL);
		}
		
		/**
		 * Guarda los datos del Nuevo Proveedor
		 */
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
		
		/**
		 * Genera el listado de los proveedores activos
		 */
		public function ListadoProveedores($Validacion = false) {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('proveedores');
			$Consulta->AgregarColumnas('Id, Nombre');
			$Consulta->AgregarCondicion("Estado = 'ACTIVO'");
			$Consulta->AgregarOrdenar('Nombre', 'ASC');
			$Consulta->PrepararQuery();
			return $Consulta->ExecuteConsulta(AppAyuda::BASEMYSQL);
		}
		
		/**
		 * Procesa la nueva factura y regresa el ID ingresados
		 */
		public function ProcesarNuevaFactura($Array = array(), $Usuario, $Fecha, $Hora) {
			self::GuardarFactura($Array, $Usuario, $Fecha, $Hora);
			return self::ConsultarFacturaProcesarNuevaFactura($Usuario, $Fecha, $Hora);
		}
		
		/**
		 * Dependiente de ProcesarNuevaFactura()
		 * Guarda los datos de la factura
		 */
		private function GuardarFactura($Array = array(), $Usuario, $Fecha, $Hora) {
			$SQL = new NeuralBDGab;
			$SQL->SeleccionarDestino($this->Conexion, 'factura_proveedor');
			foreach ($Array AS $Columna => $Valor) {
				$SQL->AgregarSentencia($Columna, $Valor);
			}
			$SQL->AgregarSentencia('Usuario', $Usuario);
			$SQL->AgregarSentencia('FechaIngreso', $Fecha);
			$SQL->AgregarSentencia('HoraIngreso', $Hora);
			$SQL->InsertarDatos();
		}
		
		/**
		 * Dependiente de ProcesarNuevaFactura()
		 * genera la consulta de la factura correspondiente
		 */
		private function ConsultarFacturaProcesarNuevaFactura($Usuario, $Fecha, $Hora) {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('factura_proveedor');
			$Consulta->AgregarColumnas('Id');
			$Consulta->AgregarCondicion("Usuario = '$Usuario'");
			$Consulta->AgregarCondicion("FechaIngreso = '$Fecha'");
			$Consulta->AgregarCondicion("HoraIngreso = '$Hora'");
			$Consulta->PrepararQuery();
			$Data = $Consulta->ExecuteConsulta($this->Conexion);
			return $Data[0]['Id'];
		}
		
		/**
		 * Consultar la informacion de la factura por ID
		 */
		public function ConsultarIdFactura($Id = false) {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('factura_proveedor');
			$Consulta->AgregarColumnas(self::ListarColumnasTabla('factura_proveedor'));
			$Consulta->AgregarCondicion("Id = '$Id'");
			$Consulta->PrepararCantidadDatos('Cantidad');
			$Consulta->PrepararQuery();
			return $Consulta->ExecuteConsulta($this->Conexion);
		}
		
		public function ListadoCategoria() {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('inventario');
			$Consulta->AgregarColumnas('Categoria');
			$Consulta->AgregarAgrupar('Categoria');
			$Consulta->AgregarOrdenar('Categoria', 'ASC');
			$Consulta->PrepararQuery();
			return $Consulta->ExecuteConsulta($this->Conexion);
		}
		
		private function ListarColumnasTabla($Tabla = false) {
			if($Tabla == true) {
				$Consulta = new NeuralBDConsultas;
				$Data = $Consulta->ExecuteQueryManual($this->Conexion, "DESCRIBE $Tabla");
				foreach ($Data AS $Consecutivo => $Valor) {
					$Lista[] = $Valor['Field'];
				}
				return implode(', ', $Lista);
			}
		}
	}