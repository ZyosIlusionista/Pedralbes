<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de procesos Internos del Framework
	 * 
	 * @access private
	 * @copyright Copyright (c) 2010-2013 Zyos (neural.framework@gmail.com)
	 * @link http://neuralframework.com/
	 * @license http://neuralframework.com/license.txt
	 * @author neural.framework@gmail.com
	 * @since 1.0
	 * @version 2.0
	 * 
	 */
	class SysNeuralBootstrap {
		
		/**
		 * Construimos el Nucleo Base
		 * */
		 public function __Construct() {
		 	//Tomamos la variable del Mod_Rewrite y validamos el url para determinar el path correspondiente
		 	$Url = SysNeuralNucleo::LeerURLModReWrite();
		 	//Leemos el archivo de configuracion de accesos y lo convertimos en un array
		 	$Array = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigAcceso.json');
		 	//Validamos si esta seleccionada un modulo
		 	if(!empty($Url[0])) {
		 		//Validamos si existe la aplicacion en el archivo de configuracion
		 		if(array_key_exists(mb_strtoupper($Url[0]), $Array)) {
		 			//Generamos las rutas de accesos
		 			$Modulo = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Carpeta'];
		 			$Configuracion = $Array[mb_strtoupper($Url[0])]['Configuracion'];
		 			$Configuraciones = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Configuracion'];
		 			$Controladores = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Controladores'];
		 			$Ayudas = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Ayudas'];
		 			$Vendors = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Vendors'];
		 			//Validamos que exista la carpeta del Modulo
		 			if(is_dir(__SysNeuralFileRootModulos__.$Modulo)) {
		 				//Cargamos las Ayudas
		 				require __DIR__.'/NeuralRutasApp.php';
		 				//Cargamos las Configuraciones Correspondientes del modulo seleccionado
		 				SysNeuralNucleo::CargarConfiguracionesModulo($Configuracion);
		 				//Cargamos los Vendors de la aplicacion si esta activado
		 				SysNeuralNucleo::CargarVendorsModulo($Modulo, $Configuraciones, $Vendors);
		 				//Cargamos las ayudas de la aplicacion
		 				SysNeuralNucleo::IncluirAyudasModulo($Modulo, $Ayudas);
		 				//Validamos si se ha ingresado un Controlador en la URL
		 				if(isset($Url[1]) == true AND empty($Url[1]) != true) {
		 					//Generamos el Nombre del Archivo
		 					$PathControlador = SysNeuralNucleo::GenerarRutaArchivoModulo($Modulo, $Controladores, $Url[1]);
		 					//Validamos si existe el archivo del controlador
		 					if(file_exists($PathControlador)) {
		 						//Incluimos el archivo del controlador
		 						require $PathControlador;
		 						//Validamos si existe un Metodo
			 					if(isset($Url[2]) == true AND empty($Url[2]) != true) {
			 						//Validamos si Existe el metodo correspondiente
			 						if(array_key_exists($Url[2], SysNeuralNucleo::ListarOrganizarMetodosClase($Url[1]))) {
			 							//Validamos si hay algun tipo de parametro
			 							if(isset($Url[3]) == true AND empty($Url[3]) != true) {
			 								//Cargamos el Controlador correspondiente
											$Controlador = new $Url[1];
											$Controlador->CargarModelo($Url[1]);
											$Cantidad = count($Url)-1;
											for ($i=3; $i<=$Cantidad; $i++) {
												$Datos[] = '$Url['.$i.']';
											}
											$Lista = implode(', ', $Datos);
											eval("\$Controlador->\$Url[2](".$Lista.");");
											unset($Cantidad, $Datos, $Lista);
			 							}
			 							else {
			 								//Cargamos el Controlador correspondiente
											$Controlador = new $Url[1];
											$Controlador->CargarModelo($Url[1]);
											$Controlador->$Url[2](false);
			 							}
			 						}
			 						else {
			 							//Validamos si el metodo existe
			 							if(method_exists($Url[1], $Url[2])) {
											//Generamos El mensaje de error de metodo protegido o privado
			 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'MetodoProtegido', '404', array('URL' => $Url, 'Modulo' => $Modulo));
			 								exit();
			 							}
			 							else {
											//Generamos El mensaje de error de metodo No Existe
			 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'MetodoNoExiste', '404', array('URL' => $Url, 'Modulo' => $Modulo));
			 								exit();
			 							}
			 						}
		 						}
		 						else {
		 							//Validamos si existe el metodo Index
		 							if(array_key_exists('Index', SysNeuralNucleo::ListarOrganizarMetodosClase($Url[1]))) {
		 								//Cargamos el Controlador correspondiente
										$Controlador = new $Url[1];
										$Controlador->CargarModelo($Url[1]);
										$Controlador->Index(false);
		 							}
		 							else {
		 								//Validamos si es un metodo protegido o privado
		 								if(method_exists($Url[1], $Url[2])) {
		 									//Generamos El mensaje de error de metodo protegido o privado
			 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'MetodoProtegido', '404', array('URL' => $Url, 'Modulo' => $Modulo));
			 								exit();
	 									}
	 									else {
	 										//Generamos El mensaje de error de metodo No Existe
			 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'MetodoNoExiste', '404', array('URL' => $Url, 'Modulo' => $Modulo));
			 								exit();
	 									}
		 							}
		 						}
		 					}
		 					else {
								//Generamos El mensaje de error de Controlador No Existe
 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'ControladorNoExiste', '404', array('URL' => $Url, 'Modulo' => $Modulo));
 								exit();
		 					}
		 				}
		 				else {
		 					//Generamos el Nombre del Archivo
		 					$PathControlador = SysNeuralNucleo::GenerarRutaArchivoModulo($Modulo, $Controladores, 'Index');
		 					//Validamos si existe el Controlador Correspondiente
		 					if(file_exists($PathControlador)) {
		 						//Incluimos el archivo del controlador
		 						require $PathControlador;
		 						//Validamos si existe el metodo Index
								if(array_key_exists('Index', SysNeuralNucleo::ListarOrganizarMetodosClase('Index'))) {
									//Cargamos el Controlador correspondiente
									$Controlador = new Index;
									$Controlador->CargarModelo('Index');
									$Controlador->Index(false);
								}
								else {
									//Validamos si es un metodo protegido o privado
									if(method_exists('Index', 'Index')) {
										//Generamos El mensaje de error de metodo protegido o privado
		 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'MetodoProtegido', '404', array('URL' => array('Default', 'Index', 'Index'), 'Modulo' => $Modulo));
		 								exit();
									}
									else {
										//Generamos El mensaje de error de metodo No Existe
		 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'MetodoNoExiste', '404', array('URL' => array('Default', 'Index', 'Index'), 'Modulo' => $Modulo));
		 								exit();
									}
								}
		 					}
		 					else {
		 						//Generamos El mensaje de error de Controlador No Existe
 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'ControladorNoExiste', '404', array('URL' => array($Url[0], 'Index'), 'Modulo' => $Modulo));
 								exit();
		 					}
		 				}
		 			}
		 			else {
		 				//Generamos El mensaje de error de Carpeta No Existe
						SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'CarpetaModuloNoExiste', '404', array('URL' => $Url, 'Modulo' => $Modulo));
						exit();
		 			}
		 		}
		 		else {
					//Generamos la consulta de los datos de configuracion de la aplicacion DEFAULT
					$Configuracion = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigAcceso.json');
					//Generamos El mensaje de error de No Existe Modulo
					SysNeuralNucleo::MostrarErroresEntorno($Configuracion['DEFAULT']['Configuracion'], 'ModuloNoExiste', '404', array('Modulo' => $Url[0]));
					//Liberamos memoria
					unset($Configuracion);
					exit();
		 		}
		 	}
		 	else {
		 		//Generamos las rutas de accesos
	 			$Modulo = $Array['DEFAULT']['Enrutamiento']['Carpeta'];
	 			$Configuracion = $Array['DEFAULT']['Configuracion'];
	 			$Configuraciones = $Array['DEFAULT']['Enrutamiento']['Configuracion'];
	 			$Controladores = $Array['DEFAULT']['Enrutamiento']['Controladores'];
	 			$Ayudas = $Array['DEFAULT']['Enrutamiento']['Ayudas'];
	 			$Vendors = $Array['DEFAULT']['Enrutamiento']['Vendors'];
	 			//Validamos que exista la carpeta del Modulo
	 			if(is_dir(__SysNeuralFileRootModulos__.$Modulo)) {
	 				//Cargamos las Ayudas
	 				require __DIR__.'/NeuralRutasApp.php';
	 				//Cargamos las Configuraciones Correspondientes del modulo seleccionado
	 				SysNeuralNucleo::CargarConfiguracionesModulo($Configuracion);
	 				//Cargamos los Vendors de la aplicacion si esta activado
	 				SysNeuralNucleo::CargarVendorsModulo($Modulo, $Configuraciones, $Vendors);
	 				//Cargamos las ayudas de la aplicacion
	 				SysNeuralNucleo::IncluirAyudasModulo($Modulo, $Ayudas);
	 				//Generamos el Nombre del Archivo
 					$PathControlador = SysNeuralNucleo::GenerarRutaArchivoModulo($Modulo, $Controladores, 'Index');
 					//Validamos si existe el archivo del controlador
 					if(file_exists($PathControlador)) {
 						//Incluimos el archivo del controlador
 						require $PathControlador;
 						//Validamos si existe el metodo Index
						if(array_key_exists('Index', SysNeuralNucleo::ListarOrganizarMetodosClase('Index'))) {
							//Cargamos el Controlador correspondiente
							$Controlador = new Index;
							$Controlador->CargarModelo('Index');
							$Controlador->Index(false);
						}
						else {
							//Validamos si es un metodo protegido o privado
							if(method_exists('Index', 'Index')) {
								//Generamos El mensaje de error de metodo protegido o privado
 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'MetodoProtegido', '404', array('URL' => array('Default', 'Index', 'Index'), 'Modulo' => $Modulo));
 								exit();
							}
							else {
								//Generamos El mensaje de error de metodo No Existe
 								SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'MetodoNoExiste', '404', array('URL' => array('Default', 'Index', 'Index'), 'Modulo' => $Modulo));
 								exit();
							}
						}
 					}
 					else {
 						//Generamos El mensaje de error de Controlador No Existe
						SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'ControladorNoExiste', '404', array('URL' => array('Default', 'Index'), 'Modulo' => $Modulo));
						exit();
 					}
	 			}
	 			else {
	 				//Generamos El mensaje de error de Carpeta No Existe
					SysNeuralNucleo::MostrarErroresEntorno($Configuracion, 'CarpetaModuloNoExiste', '404', array('URL' => $Url, 'Modulo' => $Modulo));
					exit();
	 			}
		 	}
		 	//Liberamos la memoria sobre los datos contenidos
		 	unset($Url, $Array);
		 }
	}