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
	class Vista {
		
		/**
		 * GenerarVista($Archivo, $Tipo = 0)
		 * 
		 * General las vistas correspondientes segun el mapa cargado
		 * $Archivo: ruta del archivo sin extension .php dentro de vistas
		 * $Tipo: es el mapa que se ha creado, por defecto ya esta uno creado pero se pueden agregar mas
		 */
		public function GenerarVista($Archivo = false, $Tipo = 0) {
			//Validamos que se ingrese un archivo
			if($Archivo) {
				//Tomamos la variable del Mod_Rewrite y validamos el url para determinar el path correspondiente
				$Url = SysNeuralNucleo::LeerURLModReWrite();
				//Leemos el archivo de configuracion de accesos y lo convertimos en un array
				$Array = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigAcceso.json');
				//Validamos si hay un modulo seleccionado
				if(!empty($Url[0])) {
					//Determinamos los datos necesarios para la configuracion
					$Modulo = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Carpeta'];
					$Configuracion = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Configuracion'];
					$Vistas = $Array[mb_strtoupper($Url[0])]['Enrutamiento']['Vistas'];
					//Creamos el Path del Archivo de configuracion de rutas
					$PathVistas = __SysNeuralFileRootModulos__.$Modulo.$Configuracion.'ConfigRutas_AsignacionVistas.json';
					//Validamos si existe el archivo
					if(file_exists($PathVistas)) {
						//Convertimos en array el el archivo de configuracion
						$ArrayVistas = json_decode(file_get_contents($PathVistas), true);
						//Validamos si existe el apuntador de la vista
						if(array_key_exists($Tipo, $ArrayVistas['Asignacion_Vistas'])) {
							//Leemos la Cantidad de archivos a incluir
							$Cantidad = count($ArrayVistas['Asignacion_Vistas'][$Tipo]);
							//Validamos que sea la cantidad iguaL o mayor que 1
							if($Cantidad>=1) {
								//recorremos el array correspondiente
								for ($invNeural=0; $invNeural<$Cantidad; $invNeural++) {
									//Validamos el cambio de valores
									if($ArrayVistas['Asignacion_Vistas'][$Tipo][$invNeural] == '{% Nombre_Archivo %}') {
										//Generamos el Path del Archivo
										$PathArchivo = __SysNeuralFileRootModulos__.$Modulo.$Vistas.$Archivo.'.php';
										//Validamos si Existe el Archivo
										if(file_exists($PathArchivo)) {
											//Incluimos el archivo
											require $PathArchivo;
										}
										else {
											//Generamos el path del archivo de error
											$PathError = __SysNeuralFileRootModulos__.$Modulo.$Vistas.'Errores/NoExisteArchivo.php';
											//Generamos la Variable 
											$NombreArchivo = $Archivo.'.php';
											//Validamos que exista el error
											if(file_exists($PathError)) {
												require $PathError;
											}
											else {
												//Generamos un mensaje de error texto plano
												echo '<h5 style="font-family: verdana; margin-bottom: 10px;">El Archivo: <strong style="color: red;">'.$Archivo.'.php</strong> No Existe.</h5>';
											}
										}
									}
									else {
										//Generamos el Path del Archivo
										$PathArchivo = __SysNeuralFileRootModulos__.$Modulo.$Vistas.$ArrayVistas['Asignacion_Vistas'][$Tipo][$invNeural];
										//Generamos la Variable 
										$NombreArchivo = $ArrayVistas['Asignacion_Vistas'][$Tipo][$invNeural];
										//Validamos si existe el archivo
										if(file_exists($PathArchivo)) {
											//incluimos el archivo
											require $PathArchivo;
										}
										else {
											//Generamos el path del archivo de error
											$PathError = __SysNeuralFileRootModulos__.$Modulo.$Vistas.'Errores/NoExisteArchivo.php';
											//Validamos que exista el error
											if(file_exists($PathError)) {
												require $PathError;
											}
											else {
												//Generamos un mensaje de error texto plano
												echo '<h5 style="font-family: verdana; margin-bottom: 10px;">El Archivo: <strong style="color: red;">'.$Archivo.'.php</strong> No Existe.</h5>';
											}
										}
									}
								}
							}
							else {
								//Generamos el Path del Error
								$PathError = __SysNeuralFileRootModulos__.$Modulo.$Vistas.'Errores/NoExistenLineas.php';
								//Validamos que exista el archivo del error
								if(file_exists($PathError)) {
									//incluimos el error
									require $PathError;
								}
								else {
									//Generamos el mensaje texto plano
									echo '<h5 style="font-family: verdana; margin-bottom: 10px;">No Exiten Archivos en la Configuración de Vistas.</h5>';
								}
							}
						}
						else {
							//Generamos el Path del Error
							$PathError = __SysNeuralFileRootModulos__.$Modulo.$Vistas.'Errores/NoExisteApuntador.php';
							//Validamos que exista el archivo del error
							if(file_exists($PathError)) {
								//incluimos el error
								require $PathError;
							}
							else {
								//Generamos el mensaje texto plano
								echo '<h5 style="font-family: verdana; margin-bottom: 10px;">No Exite el Tipo de Vista '.$Tipo.'.</h5>';
							}
						}
					}
				}
				else {
					//Determinamos los datos necesarios para la configuracion
					$Modulo = $Array['DEFAULT']['Enrutamiento']['Carpeta'];
					$Configuracion = $Array['DEFAULT']['Enrutamiento']['Configuracion'];
					$Vistas = $Array['DEFAULT']['Enrutamiento']['Vistas'];
					//Creamos el Path del Archivo de configuracion de rutas
					$PathVistas = __SysNeuralFileRootModulos__.$Modulo.$Configuracion.'ConfigRutas_AsignacionVistas.json';
					//Validamos si existe el archivo
					if(file_exists($PathVistas)) {
						//Convertimos en array el el archivo de configuracion
						$ArrayVistas = json_decode(file_get_contents($PathVistas), true);
						//Validamos si existe el apuntador de la vista
						if(array_key_exists($Tipo, $ArrayVistas['Asignacion_Vistas'])) {
							//Leemos la Cantidad de archivos a incluir
							$Cantidad = count($ArrayVistas['Asignacion_Vistas'][$Tipo]);
							//Validamos que sea la cantidad iguaL o mayor que 1
							if($Cantidad>=1) {
								//recorremos el array correspondiente
								for ($invNeural=0; $invNeural<$Cantidad; $invNeural++) {
									//Validamos el cambio de valores
									if($ArrayVistas['Asignacion_Vistas'][$Tipo][$invNeural] == '{% Nombre_Archivo %}') {
										//Generamos el Path del Archivo
										$PathArchivo = __SysNeuralFileRootModulos__.$Modulo.$Vistas.$Archivo.'.php';
										//Validamos si Existe el Archivo
										if(file_exists($PathArchivo)) {
											//Incluimos el archivo
											require $PathArchivo;
										}
										else {
											//Generamos el path del archivo de error
											$PathError = __SysNeuralFileRootModulos__.$Modulo.$Vistas.'Errores/NoExisteArchivo.php';
											//Generamos la Variable 
											$NombreArchivo = $Archivo.'.php';
											//Validamos que exista el error
											if(file_exists($PathError)) {
												require $PathError;
											}
											else {
												//Generamos un mensaje de error texto plano
												echo '<h5 style="font-family: verdana; margin-bottom: 10px;">El Archivo: <strong style="color: red;">'.$Archivo.'.php</strong> No Existe.</h5>';
											}
										}
									}
									else {
										//Generamos el Path del Archivo
										$PathArchivo = __SysNeuralFileRootModulos__.$Modulo.$Vistas.$ArrayVistas['Asignacion_Vistas'][$Tipo][$invNeural];
										//Generamos la Variable 
										$NombreArchivo = $ArrayVistas['Asignacion_Vistas'][$Tipo][$invNeural];
										//Validamos si existe el archivo
										if(file_exists($PathArchivo)) {
											//incluimos el archivo
											require $PathArchivo;
										}
										else {
											//Generamos el path del archivo de error
											$PathError = __SysNeuralFileRootModulos__.$Modulo.$Vistas.'Errores/NoExisteArchivo.php';
											//Validamos que exista el error
											if(file_exists($PathError)) {
												require $PathError;
											}
											else {
												//Generamos un mensaje de error texto plano
												echo '<h5 style="font-family: verdana; margin-bottom: 10px;">El Archivo: <strong style="color: red;">'.$Archivo.'.php</strong> No Existe.</h5>';
											}
										}
									}
								}
							}
							else {
								//Generamos el Path del Error
								$PathError = __SysNeuralFileRootModulos__.$Modulo.$Vistas.'Errores/NoExistenLineas.php';
								//Validamos que exista el archivo del error
								if(file_exists($PathError)) {
									//incluimos el error
									require $PathError;
								}
								else {
									//Generamos el mensaje texto plano
									echo '<h5 style="font-family: verdana; margin-bottom: 10px;">No Exiten Archivos en la Configuración de Vistas.</h5>';
								}
							}
						}
						else {
							//Generamos el Path del Error
							$PathError = __SysNeuralFileRootModulos__.$Modulo.$Vistas.'Errores/NoExisteApuntador.php';
							//Validamos que exista el archivo del error
							if(file_exists($PathError)) {
								//incluimos el error
								require $PathError;
							}
							else {
								//Generamos el mensaje texto plano
								echo '<h5 style="font-family: verdana; margin-bottom: 10px;">No Exite el Tipo de Vista '.$Tipo.'.</h5>';
							}
						}
					}
				}
			}
		}
	}