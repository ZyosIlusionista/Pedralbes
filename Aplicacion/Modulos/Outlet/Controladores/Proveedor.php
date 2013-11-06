<?php
	class Proveedor extends Controlador {
		
		function __Construct() {
			parent::__Construct();
			AyudaSession::ValidarSesionActiva();
			$this->DatosSession = AyudaSession::DatosSession(true);
		}
		
		/**
		 * Carga Informacion Basica
		 * ####### PENDIENTE
		 */
		public function Index() {
			
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('ListadoProveedores', $this->Modelo->ListadoProveedores());
			echo $Plantilla->MostrarPlantilla('Proveedor/Formulario_Nueva_Factura.html', AppAyuda::APP, AppAyuda::CACHE);
			
		}
		
		/**
		 * formulario de ingreso de la factura del proveedor
		 */
		public function Factura() {
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('ListaProveedor', $this->Modelo->ListadoProveedores(true));
			echo $Plantilla->MostrarPlantilla('Proveedor/Factura.html', AppAyuda::APP, AppAyuda::CACHE);
		}
		
		/**
		 * Genera el proceso de guardar el consecutivo de la factura
		 */
		public function ProcesarFactura() {
			if(isset($_POST) == true AND isset($_POST['GuardarFactura']) == true AND $_POST['GuardarFactura'] == 'Guardar') {
				Ayudas::print_r($_POST);
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('Proveedor'));
				exit();
			}
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
					if(AyudasPost::DatosVaciosOmitidos($_POST, array('Telefono_2', 'Contacto_2', 'Comentario')) == false) {
						unset($_POST['GuardarProveedor']);
						$DatosPost = AyudasPost::FormatoEspacio(AyudasPost::FormatoMayus(AyudasPost::LimpiarInyeccionSQL($_POST)));
						$this->Modelo->GuardarNuevoProveedor($DatosPost, $this->DatosSession['Usuario']);
						
						$Plantilla = new NeuralPlantillasTwig;
						$Plantilla->ParametrosEtiquetas('Proveedor', $DatosPost['Nombre']);
						echo $Plantilla->MostrarPlantilla('Proveedor/Mensajes/ProveedorAgregado.html', AppAyuda::APP, AppAyuda::CACHE);
					}
					else {
						$Plantilla = new NeuralPlantillasTwig;
						echo $Plantilla->MostrarPlantilla('MensajeError/AjaxCamposVacios.html', AppAyuda::APP, AppAyuda::CACHE);
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