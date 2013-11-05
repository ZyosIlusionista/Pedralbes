<?php
	
	class Index_Modelo extends Modelo {
		
		function __Construct() {
			parent::__Construct();
		}
		
		public function ConsultarDatosUsuario($Usuario = false, $Password = false) {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('usuarios, permisos');
			$Consulta->AgregarColumnas('usuarios.Usuario, usuarios.Nombre, usuarios.Apellidos, usuarios.Estado, permisos.Detalle AS PermisosUsuario, permisos.Estado AS EstadoPermiso');
			$Consulta->AgregarCondicion("usuarios.Usuario = '$Usuario'");
			$Consulta->AgregarCondicion("usuarios.Password = '$Password'");
			$Consulta->AgregarCondicion("usuarios.Permisos = permisos.Id");
			$Consulta->PrepararCantidadDatos('Cantidad');
			$Consulta->PrepararQuery();
			return $Consulta->ExecuteConsulta(AppAyuda::BASEMYSQL);
		}
	}