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
	class NeuralBDGab {
		
		/**
		 * SeleccionarDestino($BaseDatos, $Tabla)
		 * 
		 * Seleccionamos la base de datos y la tabla donde se realizara el proceso
		 * @param $BaseDatos: Aplicacion seleccionada
		 * @param $Tabla: Tabla donde se realizara el procedimiento
		**/
		public function SeleccionarDestino($BaseDatos = 'DEFAULT', $Tabla) {
			$this->BaseDatos = trim(mb_strtoupper($BaseDatos));
			$this->Tabla = trim($Tabla);
		}
		
		/**
		 * AgregarSentencia($Columna, $Valor)
		 * 
		 * Agregar los datos a base de datos
		 * @param $Columna: Nombre de la Columna Asociativa
		 * @param $Valor: Valor que le damos a la columna
		 */
		public function AgregarSentencia($Columna, $Valor) {
			$this->ObtenerDatos[trim($Columna)] = trim($Valor);
		}
		
		/**
		 * AgregarCondicion($Columna, $Valor)
		 * 
		 * Metodo necesario para generar las condiciones de actualizacion y eliminacion de registros
		**/
		public function AgregarCondicion($Columna, $Valor) {
			$this->ObtenerCondicion[trim($Columna)] = trim($Valor);
		}
		
		/**
		 * InsertarDatos()
		 * 
		 * Inserta los datos en la base de datos y en la tabla especificada
		**/
		public function InsertarDatos() {
			if(isset($this->BaseDatos)) {
				$Conexion = NeuralConexionBaseDatos::ObtenerConexionBase($this->BaseDatos);
				$Conexion->insert($this->Tabla, $this->ObtenerDatos);
			}
		}
		
		/**
		 * ActualizarDatos()
		 * 
		 * Actualiza los datos requeridos
		**/
		public function ActualizarDatos() {
			if(isset($this->BaseDatos)) {
				$Conexion = NeuralConexionBaseDatos::ObtenerConexionBase($this->BaseDatos);
				$Conexion->update($this->Tabla, $this->ObtenerDatos, $this->ObtenerCondicion);
			}
		}
		
		/**
		 * EliminarDatos()
		 * 
		 * Elimina los datos requeridos
		**/
		public function EliminarDatos() {
			if(isset($this->BaseDatos)) {
				$Conexion = NeuralConexionBaseDatos::ObtenerConexionBase($this->BaseDatos);
				$Conexion->delete($this->Tabla, $this->ObtenerCondicion);
			}
		}
	}