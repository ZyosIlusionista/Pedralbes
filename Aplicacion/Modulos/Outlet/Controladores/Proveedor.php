<?php
	class Proveedor extends Controlador {
		
		const APP = 'OUTLET';
		
		function __Construct() {
			parent::__Construct();
		}
		
		public function Prueba() {
			AyudaSession::RegistrarSession('alejandro', 'Alejo', date("Y-m-d"), date("H:i:s"), '{"Central":true, "Proveedor":true, "Caja":false}');
			Ayudas::print_r($_SESSION);
		}
		
		public function Index() {
			
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('ListadoProveedores', $this->Modelo->ListadoProveedores());
			echo $Plantilla->MostrarPlantilla('Proveedor/Formulario_Nueva_Factura.html', AppAyuda::APP, AppAyuda::CACHE);
			
		}
		
		/**
		 * Genera el formulario de un Nuevo Proveedor
		 */
		public function Nuevo() {
			$Plantilla = new NeuralPlantillasTwig;
			echo $Plantilla->MostrarPlantilla('Proveedor/Nuevo.html', AppAyuda::APP, AppAyuda::CACHE);
		}
		
		/**
		 * Genera el proceso de guardar la informacion del formulario
		 */
		public function NuevoProcesar() {
			if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) == false AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND isset($_POST) == true) {
				if(isset($_POST['GuardarProveedor']) == true AND $_POST['GuardarProveedor'] == 'Guardar') {
					if(AyudasPost::DatosVaciosOmitidos($_POST, array('Telefono_2', 'Contacto_2')) == false) {
						$DatosPost = AyudasPost::FormatoEspacio(AyudasPost::FormatoMayus(AyudasPost::LimpiarInyeccionSQL($_POST))); 
						$this->Modelo->GuardarNuevoProveedor($DatosPost);
					}
					else {
						//Datos Vacios Template
					}
				}
				else {
					header("Location: ".NeuralRutasApp::RutaURL('Proveedor'));
					exit();
				}
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('Proveedor'));
				exit();
			}
		}
	}