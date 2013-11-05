<?php

	class Index extends Controlador {
		
		function __Construct() {
			parent::__Construct();
			NeuralSesiones::Inicializacion();
			if(isset($_SESSION['Pedralbes']) == true) {
				header("Location: ".NeuralRutasApp::RutaURL('Central'));
				exit();
			}
		}
		
		/**
		 * Se genera la plantilla del Index y validacion del formulario
		 */
		public function Index() {
			$Validacion = new NeuralJQueryValidacionFormulario;
			$Validacion->Requerido('username', 'Debe ingresar un Usuario');
			$Validacion->Requerido('password', 'Debe Ingresar una Contraseña');
			$Script[] = $Validacion->MostrarValidacion('loginform');
			
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script, AppAyuda::APP));
			echo $Plantilla->MostrarPlantilla('Login/Login.html', AppAyuda::APP, AppAyuda::CACHE);
		}
		
		/**
		 * Se genera proceso de validacion de inicio de session
		 */
		public function Autenticacion() {
			if(isset($_POST) == true AND isset($_POST['Ingresar']) == true AND $_POST['Ingresar'] == 'Ingresado' AND is_array($_POST) == true) {
				if(AyudasPost::DatosVacios($_POST) == false) {
					$DatosPost = AyudasPost::FormatoEspacio(AyudasPost::FormatoMayusOmitido(AyudasPost::LimpiarInyeccionSQL($_POST), array('password')));
					$DatosPost['password'] = sha1($DatosPost['password']);
					$Consulta = $this->Modelo->ConsultarDatosUsuario($DatosPost['username'], $DatosPost['password']);
					if($Consulta['Cantidad'] === 1) {
						if($Consulta[0]['EstadoPermiso'] == 'ACTIVO' AND $Consulta[0]['Estado'] == 'ACTIVO') {
							AyudaSession::RegistrarSession($Consulta[0]['Nombre'].' '.$Consulta[0]['Apellidos'], $Consulta[0]['Usuario'], date("Y-m-d"), date("H:i:s"), $Consulta[0]['PermisosUsuario']);
							header("Location: ".NeuralRutasApp::RutaURL('Central'));
							exit();
						}
						else {
							//Usuario suspendido
							header("Location: ".NeuralRutasApp::RutaURL('Index/Index/Suspendido'));
							exit();
						}
					}
					else {
						//Usuario y/ o contraseña errononeos o usuario no existe
						header("Location: ".NeuralRutasApp::RutaURL('Index/Index/NoExiste'));
						exit();
					}
				}
				else {
					//Formulario Vacio
					header("Location: ".NeuralRutasApp::RutaURL('Index/Index/DatosVacios'));
					exit();
				}
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('Index'));
				exit();
			}
		}
	}