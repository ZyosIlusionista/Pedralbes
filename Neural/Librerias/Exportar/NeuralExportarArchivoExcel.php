<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de Exportar datos a Excel
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
	class NeuralExportarArchivoExcel {
		
		protected $FileName = 'export';
		protected $xls = '';
		protected $row = 1;
		protected $col = 1;
		
		private function ExportarExcel($file_name = 'export') {
			$this->FileName = $file_name;
		}
		
		private function Head($file_name = '', $Ext = 'xls') {
			$this->FileName = ($file_name == '') ? $this->FileName : $file_name;
			$f = $this->FileName;
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Last-Modified: ' . gmdate("D,d M YH:i:s") . ' GMT');
			header('Cache-Control: no-cache, must-revalidate');
			header('Pragma: no-cache');
			header('Content-type: application/x-msexcel');
			header("Content-Disposition: attachment; filename=$f.$Ext");
			header('Content-Description: PHP/INTERBASE Generated Data');
			header('Expires: 0');
		}
		
		private function BOF() {
			return pack('ssssss', 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		}
		
		private function EOF() {
			return pack('ss', 0x0A, 0x00);
		}
		
		private function Number($Row, $Col, $Value) {
			$this->xls .= pack('sssss', 0x203, 14, $Row, $Col, 0x0);
			$this->xls .= pack("d", $Value);
		}
		
		private function Text($Row, $Col, $Value) {
			$Value2UTF8 = $Value;
			$L = strlen($Value2UTF8);
			$this->xls .= pack('ssssss', 0x204, 8 + $L, $Row, $Col, 0x0, $L);
		    $this->xls .= $Value2UTF8;
		}
		
		private function Write($Row, $Col, $Value) {
		    if (is_numeric($Value))
		        $this->Number($Row, $Col, $Value);
		    else
		        $this->Text($Row, $Col, $Value);
		}
		
		/**
		 * MatrizDatos($Matriz)
		 * 
		 * Array de datos incremental con array con los datos correspondientes
		 * @param $Matriz: $Matriz = array(
		 * 		array('Nombre', 'Apellido', 'Edad'),
		 * 		array('Nombre', 'Apellido', 'Edad'),
		 * 		array('Nombre', 'Apellido', 'Edad'),
		 * 		array('Nombre', 'Apellido', 'Edad'),
		 * 	);
		 * 
		 * */
		public function MatrizDatos($Matriz) {
			$this->xls = '';
			$nRow = 0;
			$nCol = 0;
			
			foreach ($Matriz as $Row) {
				foreach ($Row as $Value) {
					$this->Write($nRow, $nCol, $Value);
					$nCol++;
				}
				$nCol = 0;
				$nRow++;
			}
		}
		
		/**
		 * DescargarCrearExcel($file_name = "", $Ext='xls')
		 * 
		 * Descarga archivo excel con extension xls
		 * @param $file_name: nombre del archivo
		 * @param $Ext: extension por defecto xls
		 * 
		 * */
		public function DescargarCrearExcel($file_name = '', $Ext = 'xls') {
			$this->Head($file_name, $Ext);
			echo $this->BOF();
			echo $this->xls;
			echo $this->EOF();
		}
		
		/**
		 * Archivo($loc_file)
		 * 
		 * Guarda en la ubicacion fisica el archivo correspondiente
		 * @param $loc_file: ruta completa del archivo
		 * Windows: c:\carpeta\archivo.xls
		 * linux: /home/Carpeta/archivo.xls
		 * 
		 * */
		public function Archivo($loc_file){
			$f = fopen($loc_file, 'w');
			fwrite($f, $this->BOF());
			fwrite($f, $this->xls);
			fwrite($f, $this->EOF());
			fclose($f);
		}
	}