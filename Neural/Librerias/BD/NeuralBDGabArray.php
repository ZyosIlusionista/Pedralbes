<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de procesos de Actualizar, Insertar, Eliminar
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
	class NeuralBDGabArray {
		
		/**
		 * SeleccionarDestino($BaseDatos, $Tabla)
		 * 
		 * Seleccionamos la base de datos y la tabla donde se realizara el proceso
		**/
		public function SeleccionarDestino($BaseDatos = 'DEFAULT', $Tabla) {
			$this->BaseDatos = trim(mb_strtoupper($BaseDatos));
			$this->Tabla = trim($Tabla);
		}
		
		/**
		 * AgregarSentencia($Columna, $Valor)
		 * 
		 * Agregar los datos a base de datos
		 * @var $Array: array asociativo continuo
		 * $Array[{Valor Incremental}][{Columna}][{Valor}]
		 * $Array(
		 * 		Array('Columna' => 'Valor')
		 * )
		 */
		public function AgregarSentenciaArray($Array) {
			$this->ObtenerDatos = $Array;
		}
		
		/**
		 * AgregarCondicion($Columna, $Valor)
		 * 
		 * Metodo necesario para generar las condiciones de actualizacion y eliminacion de registros
		 * @var $Array: array asociativo continuo
		 * $Array[{Valor Incremental}][{Columna}][{Valor}]
		 * $Array(
		 * 		Array('Columna' => 'Valor')
		 * )
		**/
		public function AgregarCondicionArray($Array) {
			$this->ObtenerCondicion = $Array;
		}
		
		/**
		 * InsertarDatos()
		 * 
		 * Inserta los datos en la base de datos y en la tabla especificada
		 * 
		**/
		public function InsertarDatosArray() {
			if(isset($this->BaseDatos)) {
				$Conn = new NeuralConexionBaseDatos;
				$Conexion = $Conn->ObtenerConexionBase($this->BaseDatos);
				$CantidadDatos = count($this->ObtenerDatos);
				for ($i=0; $i<$CantidadDatos; $i++) {
					$Conexion->insert($this->Tabla, $this->ObtenerDatos[$i]);
				}
			}
		}
		
		/**
		 * ActualizarDatos()
		 * 
		 * Actualiza los datos requeridos
		**/
		public function ActualizarDatosArray() {
			if(isset($this->BaseDatos)) {
				$Conn = new NeuralConexionBaseDatos;
				$Conexion = $Conn->ObtenerConexionBase($this->BaseDatos);
				$CantidadDatos = count($this->ObtenerDatos);
				for ($i=0; $i<$CantidadDatos; $i++) {
					$Conexion->update($this->Tabla, $this->ObtenerDatos[$i], $this->ObtenerCondicion[$i]);
				}
			}
		}
		
		/**
		 * EliminarDatos()
		 * 
		 * Elimina los datos requeridos
		**/
		public function EliminarDatosArray() {
			if(isset($this->BaseDatos)) {
				$Conn = new NeuralConexionBaseDatos;
				$Conexion = $Conn->ObtenerConexionBase($this->BaseDatos);
				$CantidadDatos = count($this->ObtenerCondicion);
				for ($i=0; $i<$CantidadDatos; $i++) {
					$Conexion->delete($this->Tabla, $this->ObtenerCondicion[$i]);
				}
			}
		}
	}