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
			$Validacion = new NeuralJQueryValidacionFormulario;
			$Validacion->Requerido('Proveedor', 'Seleccione el Proveedor Correspondiente');
			$Validacion->Requerido('Numero', 'Ingrese el Numero de la Factura del Proveedor');
			$Validacion->Requerido('Fecha', 'Selecione la Fecha de la Compra');
			$Validacion->Requerido('ValorNeto', 'Ingrese el Valor Neto de la Compra');
			$Validacion->Numero('ValorNeto', 'Solo Puede Ingresar Datos Numericos');
			$Validacion->Requerido('ValorIVA', 'Ingrese el Valor del IVA de la Compra');
			$Validacion->Numero('ValorIVA', 'Solo Puede Ingresar Datos Numericos');
			$Script[] = $Validacion->MostrarValidacion('Form');
			
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script, AppAyuda::APP));
			$Plantilla->ParametrosEtiquetas('ListaProveedor', $this->Modelo->ListadoProveedores(true));
			echo $Plantilla->MostrarPlantilla('Proveedor/Factura.html', AppAyuda::APP, AppAyuda::CACHE);
		}
		
		/**
		 * Genera el proceso de guardar el consecutivo de la factura
		 */
		public function ProcesarFactura() {
			if(isset($_POST) == true AND isset($_POST['GuardarFactura']) == true AND $_POST['GuardarFactura'] == 'Guardar') {
				if(AyudasPost::DatosVacios($_POST) == false) {
					unset($_POST['GuardarFactura']);
					$DatosPost = AyudasPost::FormatoMayus(AyudasPost::FormatoEspacio(AyudasPost::LimpiarInyeccionSQL($_POST)));
					$IdFactura = $this->Modelo->ProcesarNuevaFactura($DatosPost, $this->DatosSession['Usuario'], date("Y-m-d"), $Hora = date("H:i:s"));
					header("Location: ".NeuralRutasApp::RutaURL('Proveedor/DetalleFactura/'.AyudasConversorHexAscii::ASCII_HEX($IdFactura)));
					exit();
				}
				else {
					$Plantilla = new NeuralPlantillasTwig;
					echo $Plantilla->MostrarPlantilla('Proveedor/Mensajes/FormularioVacio.html', AppAyuda::APP, AppAyuda::CACHE);
				}
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('Proveedor'));
				exit();
			}
		}
		
		/**
		 * Genera el Proceso para Agregar 
		 */
		public function DetalleFactura($Id = false) {
			if($Id == true AND is_numeric(AyudasConversorHexAscii::HEX_ASCII($Id)) == true) {
				$DatosFactura = $this->Modelo->ConsultarIdFactura(AyudasConversorHexAscii::HEX_ASCII($Id));
				if($DatosFactura['Cantidad'] == 1) {
					$ValidCodigo = new NeuralJQueryValidacionFormulario;
					$ValidCodigo->Requerido('Referencia', 'Ingrese la Referencia Correspondiente');
					$ValidCodigo->Numero('Referencia', 'Debe Ingresar Códigos Númericos');
					$ValidCodigo->SubmitHandler(NeuralJQueryAjax::EnviarFormularioPOST('Codigo', 'CargarDatos', NeuralRutasApp::RutaURL('Proveedor/AgregarProductoFactura/'.$Id), true, AppAyuda::APP));
					
					$ValidProducto = new NeuralJQueryValidacionFormulario;
					$ValidProducto->Requerido('Categoria', 'Seleccione la Categoria Correspondiente');
					$ValidProducto->Requerido('SubCategoria', 'Selecciona Una SubCategoria');
					$ValidProducto->SubmitHandler(NeuralJQueryAjax::EnviarFormularioPOST('Producto', 'CargarDatos', NeuralRutasApp::RutaURL('Proveedor/AgregarProductoFactura/'.$Id), true, AppAyuda::APP));					
					
					$Script[] = $ValidCodigo->MostrarValidacion('Codigo');
					$Script[] = $ValidProducto->MostrarValidacion('Producto');
					$Script[] = NeuralJQueryAjax::SelectCargarPeticionPOST('Categoria', 'SubCategoria', NeuralRutasApp::RutaURL('Proveedor/SelectDependiente'), 'Categoria');
					$Script[] = NeuralJQueryAjax::CargarContenidoAutomatico('CargarDatos', NeuralRutasApp::RutaURL('Proveedor/MostrarListaDatosFactura/'.$Id));
					
					$Plantilla = new NeuralPlantillasTwig;
					$Plantilla->ParametrosEtiquetas('DatosFactura', $DatosFactura[0]);
					$Plantilla->ParametrosEtiquetas('ListadoCategoria', $this->Modelo->ListadoCategoria());
					$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script, AppAyuda::APP));
					echo $Plantilla->MostrarPlantilla('Proveedor/DetalleFactura.html', AppAyuda::APP, AppAyuda::CACHE);
				}
				else {
					$Plantilla = new NeuralPlantillasTwig;
					echo $Plantilla->MostrarPlantilla('Proveedor/Mensajes/FacturaNoValida.html', AppAyuda::APP, AppAyuda::CACHE);
				}
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('Proveedor'));
				exit();
			}
		}
		
		/**
		 * Mustra Formulario para agregar cantidad de productos
		 */
		public function AgregarProductoFactura($Factura = false) {
			if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) == false AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND isset($_POST) == true) {
				if(AyudasPost::DatosVacios($_POST) == false AND isset($_POST['GuardarFactura']) == true AND $_POST['GuardarFactura'] == 'Guardar') {
					$DatosPost = AyudasPost::FormatoEspacio(AyudasPost::LimpiarInyeccionSQL($_POST));
					$DatosPost['Referencia'] = (isset($DatosPost['SubCategoria']) == true) ? $DatosPost['SubCategoria'] : $DatosPost['Referencia'];					
					if(is_numeric($DatosPost['Referencia']) == true) {
						$Consulta = $this->Modelo->ConsultarReferencia($DatosPost['Referencia']);
						if($Consulta['Cantidad'] == 1) {
							$Validar = new NeuralJQueryValidacionFormulario;
							$Validar->Requerido('Cantidad', 'Ingrese la Cantidad de Productos');
							$Validar->Numero('Cantidad', 'Debe Ingresar Datos Númericos');
							$Validar->SubmitHandler(NeuralJQueryAjax::EnviarFormularioPOST('CantidadCodigo', 'CargarDatos', NeuralRutasApp::RutaURL('Proveedor/ProcesarAgregarProductoFactura/'.$Factura), true, AppAyuda::APP));
							$Script[] = $Validar->MostrarValidacion('CantidadCodigo');
							
							$Plantilla = new NeuralPlantillasTwig;
							$Plantilla->ParametrosEtiquetas('Data', $Consulta[0]);
							$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script, AppAyuda::APP));
							$Plantilla->AgregarFuncionAnonima('json', function($Array) {
								foreach ($Array AS $Nombre => $Valor) {
									if($Nombre <> 'Id' AND $Nombre <> 'Estado' AND $Nombre <> 'Cantidad' AND $Nombre <> 'ActivoWeb') {
										$Lista[$Nombre] = trim($Valor);
									}
								}
								return json_encode($Lista);
							});
							echo $Plantilla->MostrarPlantilla('Proveedor/Formulario/FormularioCodigo.html', AppAyuda::APP, AppAyuda::CACHE);
						}
						else {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Proveedor/Mensajes/NoExisteRegistro.html', AppAyuda::APP, AppAyuda::CACHE);
						}
					}
					else {
						$Plantilla = new NeuralPlantillasTwig;
						echo $Plantilla->MostrarPlantilla('Proveedor/Mensajes/noNumerico.html', AppAyuda::APP, AppAyuda::CACHE);
					}
				}
				else {
					$Plantilla = new NeuralPlantillasTwig;
					echo $Plantilla->MostrarPlantilla('Proveedor/Mensajes/FormularioVacio.html', AppAyuda::APP, AppAyuda::CACHE);
				}
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('Proveedor'));
				exit();
			}
		}
		
				
		public function ProcesarAgregarProductoFactura($Factura = false) {
			if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) == false AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND isset($_POST) == true) {
				unset($_POST['GuardarFactura']);
				$DatosPost = AyudasPost::FormatoEspacio($_POST);
				$DatosUsuario = AyudaSession::DatosSession(true);
				$this->Modelo->GuardarDetalleFactura(trim(AyudasConversorHexAscii::HEX_ASCII($Factura)), $DatosPost['Cantidad'], json_decode($DatosPost['Inventario'], true), $DatosUsuario['Usuario']);
				header("Location: ".NeuralRutasApp::RutaURL('Proveedor/MostrarListaDatosFactura/'.$Factura));
				exit();
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('Proveedor'));
				exit();
			}
		}
		
		/**
		 * Genera el listado que se procesara para actualizar el inventario
		 */
		public function MostrarListaDatosFactura($Factura = false) {
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Consulta', $this->Modelo->MostrarListaDatosFactura(AyudasConversorHexAscii::HEX_ASCII($Factura)));
			echo $Plantilla->MostrarPlantilla('Proveedor/ListadoDetalleFactura.html', AppAyuda::APP, AppAyuda::CACHE);
		}
		
		/**
		 * Genera el proceso del select dependiente del formulario de Detalle de factura
		 */
		public function SelectDependiente() {
			if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) == false AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND isset($_POST) == true) {
				$DatosPost = AyudasPost::FormatoEspacio(AyudasPost::FormatoMayus(AyudasPost::LimpiarInyeccionSQL($_POST)));
				$Plantilla = new NeuralPlantillasTwig;
				$Plantilla->ParametrosEtiquetas('Datos', $this->Modelo->ListarSubCategoriasSelectDependiente($DatosPost['Categoria']));
				echo $Plantilla->MostrarPlantilla('Proveedor/Ajax/Select.html', AppAyuda::APP, AppAyuda::CACHE);
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