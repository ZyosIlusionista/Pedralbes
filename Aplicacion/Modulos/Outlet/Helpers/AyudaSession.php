<?php
	class AyudaSession {
		
		/**
		 * Key complemento adicional
		 */
		private static $Complemento = 'M4RC3LI74$3L14';
		
		/**
		 * Tiempo de session en segundos
		 */
		private static $TiempoSession = 5100;
		
		/**
		 * Registra la session correspondiente
		 */
		public static function RegistrarSession($Nombre = false, $Usuario = false, $Fecha = false, $Hora = false, $Permisos = false) {
			if($Nombre == true AND $Usuario == true AND $Fecha == true AND $Hora == true AND $Permisos == true) {
				NeuralSesiones::AgregarLlave('Pedralbes', self::CodificacionSession($Nombre, $Usuario, $Fecha, $Hora, $Permisos));
			}
		}
		
		/**
		 * Validacion de la session activa y sus permisos
		 */
		public static function ValidarSesionActiva() {
			NeuralSesiones::Inicializacion();
			if(isset($_SESSION['Pedralbes']) == true) {
				$DatosSession = self::DecodificacionSession($_SESSION['Pedralbes']);
				if(self::ValidacionParametros($DatosSession) == true) {
					if(self::ValidacionPermisos($DatosSession['Informacion']['Permisos']) == false) {
						header("Location: ".NeuralRutasApp::RutaURL('Error/NoPermiso'));
						exit();
					}
				}
				else {
					header("Location: ".NeuralRutasApp::RutaURL('LogOut'));
					exit();
				}
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('LogOut'));
				exit();
			}
		}
		
		/**
		 * regresa los datos basicos del usuario registrado
		 */
		public static function DatosSession($Valido = false) {
			if($Valido == true) {
				$Data = self::DecodificacionSession($_SESSION['Pedralbes']);
				return $Data['Informacion'];
			}
		}
		
		/**
		 * Valida los permisos de la session
		 */
		private static function ValidacionPermisos($Permisos = false) {
			$Permisos = json_decode($Permisos, true);
			$ModReWrite = SysNeuralNucleo::LeerURLModReWrite();
			$Controlador = (isset($ModReWrite[1]) == true) ? $ModReWrite[1] : 'Index';
			if($Permisos == true) {
				if(array_key_exists($Controlador, $Permisos) == true) {
					return $Permisos[$Controlador];
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}
		
		/**
		 * valida los parametros de la session para su registro
		 */
		private static function ValidacionParametros($Array = array()) {
			$Data[] = ($Array['Session']['Tiempo'] == strtotime($Array['Informacion']['Fecha'].' '.$Array['Informacion']['Hora'])+self::$TiempoSession) ? true : false;
			$Data[] = ($Array['Session']['Fecha'] == $Array['Informacion']['Fecha']) ? true : false;
			$Data[] = ($Array['Session']['Hora'] == $Array['Informacion']['Hora']) ? true : false;
			$Data[] = ($Array['Session']['Llave'] == implode('_', array($Array['Informacion']['Usuario'], $Array['Informacion']['Fecha'], $Array['Informacion']['Hora'], self::$Complemento))) ? true : false;
			$Data[] = ($Array['Session']['Tiempo'] >= strtotime(date("Y-m-d H:i:s"))) ? true : false;
			$Data[] = (strtotime(date("Y-m-d H:i:s")) >= strtotime($Array['Informacion']['Fecha'].' '.$Array['Informacion']['Hora'])) ? true : false;
			$Data[] = (strtotime(date("Y-m-d H:i:s")) >= strtotime($Array['Session']['Fecha'].' '.$Array['Session']['Hora'])) ? true : false;
			foreach ($Data AS $Llave => $Valor){ if($Valor == false) { $Error[] = 'Error'; } };
			return (isset($Error[0]) == true) ? false: true;
		}
		
		/**
		 * Decodifica los datos de la session
		 */
		private static function DecodificacionSession($Data = false) {
			if($Data == true) {
				return self::MatrizDeCodificacionParametros(self::MatrizDeCodificacionBase($Data));
			}
		}
		
		/**
		 * codifica los datos de la session
		 */
		private static function CodificacionSession($Nombre = false, $Usuario = false, $Fecha = false, $Hora = false, $Permisos = false) {
			return self::MatrizCodificacionBase(self::MatrizCodificacionParametros(self::MatrizSession($Nombre, $Usuario, $Fecha, $Hora, $Permisos)));
		}
		
		/**
		 * Genera la Matriz de Session
		 */
		private static function MatrizSession($Nombre, $Usuario, $Fecha, $Hora, $Permisos) {
			return array(
				'Session' => array(
					'Llave' => implode('_', array($Usuario, $Fecha, $Hora, self::$Complemento)),
					'Fecha' => $Fecha,
					'Hora' => $Hora,
					'Tiempo' => strtotime($Fecha.' '.$Hora)+self::$TiempoSession
				),
				'Informacion' => array(
					'Nombre' => $Nombre,
					'Usuario' => $Usuario,
					'Fecha' => $Fecha, 
					'Hora' => $Hora,
					"Permisos" => $Permisos
				)
			);
		}
		
		/**
		 * DesCodifica los parametros del array base
		 */
		private static function MatrizDeCodificacionBase($Data = false) {
			$Array = json_decode(NeuralEncriptacion::DesencriptarDatos($Data, AppAyuda::APP), true);
			foreach ($Array AS $Nombre => $Valor) {
				$Datos[$Nombre] = json_decode(NeuralEncriptacion::DesencriptarDatos($Valor, AppAyuda::APP), true);
			}
			return $Datos;
		}
		
		/**
		 * DesCodifica los parametros correspondientes del arbol del array
		 */
		private static function MatrizDeCodificacionParametros($Array = array()) {
			$Matriz = self::MatrizCodificacion(true);
			foreach ($Array AS $Llave => $Parametros) {
				foreach ($Parametros AS $Nombre => $Valor) {
					if(array_key_exists($Nombre, $Matriz) == true) {
						$Array[$Llave][$Nombre] = NeuralEncriptacion::DesencriptarDatos($Valor, $Matriz[$Nombre]);
					}
				}
			}
			return $Array;
		}
		
		/**
		 * Codifica los parametros del array base
		 */
		private static function MatrizCodificacionBase($Array = array()) {
			foreach ($Array AS $Nombre => $Valor) {
				$Data[$Nombre] = NeuralEncriptacion::EncriptarDatos(json_encode($Valor), AppAyuda::APP);
			}
			return NeuralEncriptacion::EncriptarDatos(json_encode($Data), AppAyuda::APP);
		}
		
		/**
		 * Codifica los parametros correspondientes del arbol del array
		 */
		private static function MatrizCodificacionParametros($Array = array()) {
			$Matriz = self::MatrizCodificacion(true);
			foreach ($Array AS $Llave => $Parametros) {
				foreach ($Parametros AS $Nombre => $Valor) {
					if(array_key_exists($Nombre, $Matriz) == true) {
						$Array[$Llave][$Nombre] = NeuralEncriptacion::EncriptarDatos($Valor, $Matriz[$Nombre]);
					}
				}
			}
			return $Array;
		}
		
		/**
		 * Matriz de Codificacion
		 */
		private static function MatrizCodificacion($Valid = false) {
			if($Valid == true) {
				return array('Llave' => array(date("Y-m-d"), AppAyuda::APP), 'Fecha' => AppAyuda::APP, 'Hora' => AppAyuda::APP, 'Tiempo' => array(date("Y-m-d"), AppAyuda::APP), 'Nombre' => AppAyuda::APP, 'Usuario' => array(date("Y-m-d"), AppAyuda::APP), 'Permisos' => array(date("Y-m-d"), AppAyuda::APP));
			}
		}
	}