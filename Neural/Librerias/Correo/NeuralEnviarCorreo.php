<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de Envios de Correos Electronicos con la
	 * libreria PHPMailer
	 * 
	 * @access public
	 * @copyright Copyright (c) 2010-2013 Zyos (neural.framework@gmail.com)
	 * @link http://neuralframework.com/
	 * @license http://neuralframework.com/license.txt
	 * @author neural.framework@gmail.com
	 * @since 1.0
	 * @version 2.0
	 * 
	 */
	class NeuralEnviarCorreos {
		
		/**
		 * Emisor($Nombre)
		 * Nombre del Emisor del Correo
		 * 
		 * @param $Nombre: Nombre de quien envia el correo electronico
		**/
		public function Emisor($Nombre) {
			$this->NombreEmisor = $Nombre;
		}
		
		/**
		 * ResponderMensajeEnviado($Correo, $Nombre)
		 * Correo electronico al cual se puede reenviar el mensaje actual
		 * 
		 * @param $Correo: Correo Electronico al cual responder
		 * @param $Nombre: Nombre del Destinatario del correo
		**/
		public function ResponderMensajeEnviado($Correo, $Nombre) {
			$this->ResponderMensaje = array(
				'CORREO' => $Correo, 
				'NOMBRE' => $Nombre
			);
		}
		
		/**
		 * EnviarCorreoA($Correo, $Nombre)
		 * Crea un Array con los destinatarios a los cuales se le envian los correos
		 * 
		 * @param $Correo: Correo electronico correo@correo.com
		 * @param $Nombre: Nombre de la Persona que se le Envia el Correo
		**/
		public function EnviarCorreoA($Correo, $Nombre) {
			$this->EnviarCorreoTo[] = array(
				'CORREO' => $Correo, 
				'NOMBRE' => $Nombre
			);
		}
		
		/**
		 * EnviarCorreoCopia($Correo, $Nombre)
		 * Crea un Array con los destinatarios a los cuales se le envian copia del correo
		 * 
		 * @param $Correo: Correo electronico correo@correo.com
		 * @param $Nombre: Nombre de la Persona que se le Envia el Correo
		**/
		public function EnviarCorreoCopia($Correo, $Nombre) {
			$this->EnviarCorreoCC[] = array(
				'CORREO' => $Correo, 
				'NOMBRE' => $Nombre
			);
		}
		
		/**
		 * EnviarCorreoCopia($Correo, $Nombre)
		 * Crea un Array con los destinatarios a los cuales se le envian copia oculta
		 * 
		 * @param $Correo: Correo electronico correo@correo.com
		 * @param $Nombre: Nombre de la Persona que se le Envia el Correo
		**/
		public function EnviarCorreoOculto($Correo, $Nombre) {
			$this->EnviarCorreoCCO[] = array(
				'CORREO' => $Correo, 
				'NOMBRE' => $Nombre
			);
		}
		
		/**
		 * AsuntoCorreo($Asunto)
		 * Genera el asunto del correo es unico
		 * 
		 * @param $Asunto: Asunto del mensaje
		**/
		public function AsuntoCorreo($Asunto) {
			$this->AsuntoMail = $Asunto;
		}
		
		/**
		 * MensajeAlternativoNoHTML($Mensaje)
		 * Este es el mensaje alternativo para clientes de correo, o correos web que no soportan html
		 * 
		 * @param $Mensaje: mensaje en archivo plano txt
		**/
		public function MensajeAlternativoNoHTML($Mensaje) {
			$this->MensajeAlternativo = $Mensaje;
		}
		
		/**
		 * MensajeHTML($Mensaje)
		 * Mensaje en html para enviar
		 * @param $Mensaje: Mensaje HTML para enviar
		**/
		public function MensajeHTML($Mensaje) {
			$this->MensajeGeneralHTML = $Mensaje;
		}
		
		/**
		 * ArchivosAdjuntos($Ruta)
		 * Adjuntamos los archivos adjuntos correspondientes
		 * @param $Ruta: ruta de la imagen
		 * Esta ruta debe ir por fichero mas no por url
		**/
		public function ArchivosAdjuntos($Ruta) {
			$this->ArchAdjuntos[] = $Ruta;
		}
		
		/**
		 * SMTPDebug($Opcion)
		 * Habilita información SMTP (opcional para pruebas)
		 * @param $Opcion: este maneja dos parametros
		 * @param 1: errores y mensajes
		 * @param 2: solo mensajes
		**/
		public function SMTPDebug($Opcion) {
			$this->SMTPDebugValid = $Opcion;
		}
		
		/**
		 * EnviarCorreo($AplicacionEnvia)
		 * Proceso de envio de correo electronico
		 * 
		 * @param $AplicacionEnvia: se selecciona la aplicacion correspondiente para la configuracion
		 * de las opciones del mail
		**/
		public function EnviarCorreo($AplicacionEnvia = 'DEFAULT') {
			//Parametros de Configuracion
			$ArchivoConfiguracion = self::ArchivoConfiguracion(true);
			//Validamos si la aplicacion ingresada esta en el archivo de configuracion
			if(array_key_exists($AplicacionEnvia, $ArchivoConfiguracion)) {
				//Validamos si se debe emplear la funcion mail
				if($ArchivoConfiguracion[$AplicacionEnvia]['Funcion_Mail']) {
					//Utilizamos la Funcion Mail
					return self::ConfiguracionMail(true);
				}
				else {
					//Utilizamos el PHPMailer
					return self::ConfigurarPHPMailer($ArchivoConfiguracion[$AplicacionEnvia]['Configuracion']);
				}
			}
			else {
				exit('La Aplicacion Indicada No Existe en el Archivo de Configuracion');
			}
		}
		
		/**
		 * Metodo privativo para determinar si se debe incluir la libreria
		 * 
		 * */
		private function IncluirLibreria($Cargar = false) {
			if($Cargar) {
				//Leemos el archivo de configuracion de los vendors
				$Configuracion = SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigVendors.json');
				//Buscamos La libreria correspondiente si existe
				if(array_key_exists('PHPMailer', $Configuracion)) {
					//Validamos la Configuracion si estan activados los vendors o debemos incluirlo
					if($Configuracion['PHPMailer']['Activo'] == false) {
						//incluimos la libreria correspondiente
						return __SysNeuralFileRootVendors__.$Configuracion['PHPMailer']['Ruta'];
					}
				}
			}
		}
		
		/**
		 * self::ArchivoConfiguracion($Cargar = false);
		 * Cargamos el archivo de configuracion
		 * */
		private function ArchivoConfiguracion($Cargar = false) {
			if($Cargar) {
				//Cargamos el archivo de configuracion
				return SysNeuralNucleo::CargarArchivoJsonConfiguracion('ConfigCorreo.json');
			}
		}
		
		/**
		 * self::ConfigurarPHPMailer($Configuraciones = false);
		 * Generamos el proceso de envio de correo por PHPMailer
		 * */
		private function ConfigurarPHPMailer($Configuraciones = false) {
			if($Configuraciones) {
				//Generamos el instanciamiento del PHPMailer
				$Mail = new PHPMailer(true);
				//Instanciamos las opciones de envio de correos
				$Mail->IsSMTP();
				$Mail->IsHTML();
				//Validamos las configuraciones las leemos y las imprimimos
				foreach ($Configuraciones AS $Key => $Value) {
					$Mail->$Key = $Value;
				}
				
				try {
					
					//Validamos si se activa el Debug para el SMTP
					if(isset($this->SMTPDebugValid)) {
						$Mail->SMTPDebug = $this->SMTPDebugValid;
					}
					//Generamos la opcion de responder este mensaje a este destino
					$Mail->AddReplyTo($this->ResponderMensaje['CORREO'], $this->ResponderMensaje['NOMBRE']);
					//Generamos a los destinatarios que se les envia este correo titular
					if(isset($this->EnviarCorreoTo)) {
						if(count($this->EnviarCorreoTo)>=1) {
							for ($i=0; $i<count($this->EnviarCorreoTo); $i++) {
								$Mail->AddAddress($this->EnviarCorreoTo[$i]['CORREO'], $this->EnviarCorreoTo[$i]['NOMBRE']);
							}
						}
					}
					//Generamos los destinatarios de copia de este correo
					if(isset($this->EnviarCorreoCC)) {
						if(count($this->EnviarCorreoCC)>=1) {
							for ($j=0; $j<count($this->EnviarCorreoCC); $j++) {
								$Mail->AddCC($this->EnviarCorreoCC[$j]['CORREO'], $this->EnviarCorreoCC[$j]['NOMBRE']);
							}
						}
					}
					//Generamos los destinatarios de copia oculta
					if(isset($this->EnviarCorreoCCO)) {
						if(count($this->EnviarCorreoCCO)>=1) {
							for ($l=0; $l<count($this->EnviarCorreoCCO); $l++) {
								$Mail->AddBCC($this->EnviarCorreoCCO[$l]['CORREO'], $this->EnviarCorreoCCO[$l]['NOMBRE']);
							}
						}
					}
					//Generamos el Emisor del correo
					$Mail->SetFrom($Configuraciones['Username'], $this->NombreEmisor);
					//Generamos el asunto correspondiente
					$Mail->Subject = $this->AsuntoMail;
					//validamos si enviamos mensaje alternativo que no soporte html
					if(isset($this->MensajeAlternativo)) {
						$Mail->AltBody($this->MensajeAlternativo);
					}
					//Generamos el Mensaje HTML correspondiente
					$Mail->MsgHTML($this->MensajeGeneralHTML);
					//validamos los datos adjuntos correspondientes
					if(isset($this->ArchAdjuntos)) {
						if(count($this->ArchAdjuntos)>=1) {
							for ($h=0; $h<count($this->ArchAdjuntos); $h++) {
								$Mail->AddAttachment($this->ArchAdjuntos[$h]);
							}
						}
					}
					//Enviamos el correo correspondiente
					$Mail->Send();
				}
				catch (phpmailerException $e) {
					//Errores de PhpMailer
					return $e->errorMessage();
				}
				catch (Exception $e) {
					//Errores de cualquier otra cosa.
					return $e->getMessage();
				}
			}
		}
		
		private function ConfiguracionMail($Cargar = false) {
			if($Cargar) {
				// Content-type se Adiciona
				$Cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$Cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				//Generamos a los destinatarios que se les envia este correo titular
				if(isset($this->EnviarCorreoTo)) {
					if(count($this->EnviarCorreoTo)>=1) {
						for ($i=0; $i<count($this->EnviarCorreoTo); $i++) {
							$DatosEnviarTo[] = $this->EnviarCorreoTo[$i]['CORREO'];
						}
						//Organizamos los correos correspondientes 
						$CabeceraEnviarTo = implode(", ", $DatosEnviarTo);
						//Generamos la cabecera correspondiente
						$Cabeceras .= 'To: '.$CabeceraEnviarTo. "\r\n";
					}
				}
				//Generamos los destinatarios de copia de este correo
				if(isset($this->EnviarCorreoCC)) {
					if(count($this->EnviarCorreoCC)>=1) {
						for ($j=0; $j<count($this->EnviarCorreoCC); $j++) {
							$DatosEnviarCC[] = $this->EnviarCorreoCC[$j]['CORREO'];
						}
						//Organizamos los correos correspondientes 
						$CabeceraEnviarCC = implode(", ", $DatosEnviarCC);
						//Generamos la cabecera correspondiente
						$Cabeceras .= 'Cc: '.$CabeceraEnviarCC. "\r\n";
					}
				}
				//Generamos los destinatarios de copia oculta
				if(isset($this->EnviarCorreoCCO)) {
					if(count($this->EnviarCorreoCCO)>=1) {
						for ($l=0; $l<count($this->EnviarCorreoCCO); $l++) {
							$DatosEnviarBCC[] = $this->EnviarCorreoCCO[$l]['CORREO'];
						}
						//Organizamos los correos correspondientes 
						$CabeceraEnviarBCC = implode(", ", $DatosEnviarBCC);
						//Generamos la cabecera correspondiente
						$Cabeceras .= 'Bcc: '.$CabeceraEnviarBCC. "\r\n";
					}
				}
				//Enviamos el correo correspondiente
				mail($CabeceraEnviarTo, $this->AsuntoMail, $this->MensajeGeneralHTML, $Cabeceras);
			}
		}
	}