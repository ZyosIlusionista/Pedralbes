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
	class SysNeuralNucleo {
		
		/**
		 * SysNeuralNucleo::LeerURLModReWrite();
		 * 
		 * Metodo para regresar un array con los datos de URL generados por el Mod_ReWrite
		 * 
		 **/
		public static function LeerURLModReWrite() {
			
			//Tomamos la variable del Mod_Rewrite y validamos el Url para determinar el path correspondiente
			$Url = isset($_GET['url']) ? $_GET['url'] : null;
			$Url = strip_tags(rtrim($Url, '/'));
			return explode('/', $Url);
		}
		
		/**
		 * SysNeuralNucleo::CargarArchivoJsonAplicacion($Archivo = false);
		 * 
		 * Metodo para cargar los archivos JSON que se encuentran dentro de la carpeta Aplicacion
		 * @param $Archivo: Nombre del archivo Json de las Configuraciones
		 * 
		 **/
		public static function CargarArchivoJsonConfiguracion($Archivo = false) {
			if($Archivo) {
				//Generamos la ruta del path
				$ArchivoRuta = __SysNeuralFileRootAplicacion__.'Configuracion/'.$Archivo;
				//Validamos si existe el archivo seleccionado
				if(file_exists($ArchivoRuta)) {
					//Regresamos el contenido del archivo generado como un array
					return json_decode(file_get_contents($ArchivoRuta), true);
				}
				else {
					//Generamos un mensaje de error informando
					return 'Archivo No Existe. Archivo: '.$Archivo;
				}
			}
		}
		
		/**
		 * SysNeuralNucleo::IncluirAyudasModulo($Modulo = false, $Ayudas = false);
		 * 
		 * Metodo para cargar los archivos que se encuentran dentro de la carpeta Aplicacion
		 * @param $Modulo: Carpeta de la aplicacion correspondiente
		 * @param $Ayudas: Carpeta de Ayudas
		 * 
		 **/
		public static function IncluirAyudasModulo($Modulo = false, $Ayudas = false) {
			//Validamos que se ingresen los parametros
			if($Modulo == true AND $Ayudas == true) {
				//Generamos las rutas corrrespondientes
				$RutaAyudas = __SysNeuralFileRootModulos__.$Modulo.$Ayudas;
				//Validamos si es un Directorio
				if(is_dir($RutaAyudas)) {
					if ($DirAyudas = opendir($RutaAyudas)) {
						//Listamos los archivos
			        	while (($ListFileAyudas = readdir($DirAyudas)) !== false) {
			        		//Omitimos los punteros de carpeta oculta y regreso a carpeta anterior como a la carga de configuraciones
			        		if($ListFileAyudas <> '.' AND $ListFileAyudas <> '..' AND $ListFileAyudas <> '.htaccess') {
								//Incluimos los archivos correspondientes
								require $RutaAyudas.$ListFileAyudas;
							}
			        	}
			        	closedir($DirAyudas);
					}
				}
				//Liberamos memoria
				unset($Modulo, $Ayudas, $RutaAyudas, $DirAyudas, $ListFileAyudas);
			}
		}
		
		/**
		 * SysNeuralNucleo::LeerArchivosConfiguracionRutasModulo($Modulo = false, $Configuracion = false);
		 * 
		 * Metodo para cargar los archivos que se encuentran dentro de la carpeta Aplicacion
		 * @param $Modulo: Carpeta de la aplicacion correspondiente
		 * @param $Configuracion: Carpeta de Configuracion
		 * 
		 **/
		public static function LeerArchivosConfiguracionRutasModulo($Modulo = false, $Configuracion = false) {
			//Validamos que se ingresen los parametros
			if($Modulo == true AND $Configuracion == true) {
				//Validamos que exista la carpeta
				if(is_dir(__SysNeuralFileRootModulos__.$Modulo.$Configuracion)) {
					//Validamos si existe el archivo correspondiente
					if(file_exists(__SysNeuralFileRootModulos__.$Modulo.$Configuracion.'ConfigRutas_AsignacionVistas.json')) {
						//Leemos el archivo de configuracion de rutas
						$RutasAdquiridas = json_decode(file_get_contents(__SysNeuralFileRootModulos__.$Modulo.$Configuracion.'ConfigRutas_AsignacionVistas.json'), true);
						//Retornamos los datos					
						return $RutasAdquiridas['Rutas'];
					}
					else {
						//Retornamos el mensaje de error
						return 'No Existe el Archivo de Configuracion';
					}
				}
				else {
					//Retornamos el mensaje de error
					return 'No Existe la Carpeta de Configuracion';
				}
			}
		}
		
		/**
		 * SysNeuralNucleo::CargarConfiguracionesModulo($Array = false);
		 * 
		 * Metodo para cargar los archivos que se encuentran dentro de la carpeta Aplicacion
		 * @param $Array = false: Array con los parametros de la configuracion 
		 * 
		 **/
		public static function CargarConfiguracionesModulo($Array = false) {
			//Validamos que se ingrese el parametro
			if($Array) {
				//Cargamos las opciones del Entorno
				if($Array['Entorno_Desarrollo']) {
					//Validamos que exista el archivo de errores
					if(file_exists(dirname(__DIR__).'/Errores/php_error.php')) {
						error_reporting(E_ALL ^ E_STRICT);
						require dirname(__DIR__).'/Errores/php_error.php';
						\php_error\reportErrors();
					}
					else {
						//Si no Existe el Archivo generamos los Errores de PHP
						error_reporting(E_ALL ^ E_STRICT);
					}
				}
				else {
					//No generamos mas errores
					error_reporting(0);
				}
				//Validamos si hay algun dato para enviar en el header correspondiente
				if(!empty($Array['Codificacion'])) {
					//Generamos la codificacion correspondiente
					header($Array['Codificacion']);
				}
			}
		}
		
		/**
		 * SysNeuralNucleo::CargarVendorsModulo($Modulo = false, $Configuracion = false, $Vendors = false);
		 * 
		 * Metodo para cargar los archivos que se encuentran dentro de la carpeta Aplicacion
		 * @param $Modulo: Carpeta del Modulo Correspondiente
		 * @param $Configuracion: Carpeta de Configuracion del Modulo
		 * @param $Vendors: Carpeta de Vendors
		 * 
		 **/
		public static function CargarVendorsModulo($Modulo = false, $Configuracion = false, $Vendors = false) {
			//Validamos que se ingresen todos los parametros
			if($Modulo == true AND $Configuracion == true AND $Vendors == true) {
				//Validamos que la carpeta vendors exista
				if(is_dir(__SysNeuralFileRootModulos__.$Modulo.$Vendors)) {
					//Validamos que la carpeta de configuracion exista
					if(is_dir(__SysNeuralFileRootModulos__.$Modulo.$Configuracion)) {
						//validamos que exista el archivo de configuracion
						if(file_exists(__SysNeuralFileRootModulos__.$Modulo.$Configuracion.'Vendors.json')) {
							//Extraemos los datos del archivo
							$ListadoVendors = json_decode(file_get_contents(__SysNeuralFileRootModulos__.$Modulo.$Configuracion.'Vendors.json'), true);
							//Validamos si estan activos los vendors
							if($ListadoVendors['Configuracion']['Activo']) {
								//Contamos los Vendors
								$Cantidad = count($ListadoVendors['Vendors']);
								//Incluimos los vendors correspondientes
								for ($i=0; $i<$Cantidad; $i++) {
									//Validamos si se esta activo el vendor correspondiente
									if($ListadoVendors['Vendors'][$i]['Activo']) {
										//Validamos si existe el archivo en Vendors
										if(file_exists(__SysNeuralFileRootModulos__.$Modulo.$Vendors.$ListadoVendors['Vendors'][$i]['Ruta'])) {
											//Incluimos el archivo correspondiente
											require __SysNeuralFileRootModulos__.$Modulo.$Vendors.$ListadoVendors['Vendors'][$i]['Ruta'];
										}
										else {
											//Generamos un Error de no existe el archivo de vendors
										}
									}
								}
							}
						}
						else {
							return 'No Existe El Archivo de Vendors.json';
						}
					}
					else {
						return 'No Existe la Carpeta '.$Modulo.$Configuracion;
					}
				}
				else{
					return 'No Existe la Carpeta '.$Modulo.$Vendors;
				}
			}
		}
		
		/**
		 * SysNeuralNucleo::ListarOrganizarMetodosClase($Clase);
		 * 
		 * Lista y organiza llave valor un array con los metodos publicos de la clase
		 * @param $Clase: La clave a ser validada
		 * 
		**/
		public static function ListarOrganizarMetodosClase($Clase = false) {
			//Generamos la lista de metodos de la clase
			$Array = get_class_methods($Clase);
			foreach ($Array AS $Llave => $Valor) {
				$Datos[$Valor] = $Valor;
			}
			return $Datos;
		}
		
		/**
		 * SysNeuralNucleo::GenerarRutaModuloAplicacion($Modulo = false, $Tipo = false, $Archivo = false);
		 * 
		 * Genera la construccion del path del archivo
		 * @param $Modulo: Carpeta de la aplicacion
		 * @param $Tipo: el tipo de carpeta donde se encuentra el archivo
		 * @param $Archivo: Nombre del archivo
		 * 
		**/
		public static function GenerarRutaArchivoModulo($Modulo = false, $Tipo = false, $Archivo = false) {
			//Validamos que los parametros sean ingresados
			if($Modulo == true AND $Tipo == true AND $Archivo == true) {
				return __SysNeuralFileRootModulos__.$Modulo.$Tipo.$Archivo.'.php';
			}
		}
		
		/**
		 * SysNeuralNucleo::MostrarErroresEntorno($Configuraciones = false, $Desarrollo = false, $Produccion = false);
		 * 
		 * Genera la construccion del path del archivo
		 * @param $Configuraciones: Array con las Configuraciones de la Aplicacion
		 * @param $Desarrollo: Archivo de Error a mostrar en modo desarrollo
		 * @param $Produccion: Archivo de Error a mostrar en modo Produccion
		 * 
		**/
		public static function MostrarErroresEntorno($Configuraciones = false, $Desarrollo = false, $Produccion = false, $Parametros = false) {
			//Validamos que se ingresan todos los parametros
			if($Configuraciones == true AND $Desarrollo == true AND $Produccion == true AND $Parametros == true) {
				//Validamos el Tipo de entorno
				if($Configuraciones['Entorno_Desarrollo']) {
					require dirname(dirname(__DIR__)).'/MensajesError/'.$Desarrollo.'.php';
				}
				else {
					require dirname(dirname(__DIR__)).'/MensajesError/'.$Produccion.'.php';
				}
			}
		}
	}