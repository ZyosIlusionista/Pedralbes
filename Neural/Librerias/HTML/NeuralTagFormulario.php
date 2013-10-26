<?php
	
	/**
	 * NEURAL FRAMEWORK PHP
	 * 
	 * Clase de impresion de campos de formularios HTML
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
	class NeuralTagFormulario {
		
		public static function Archivo($nombre, $id, $valor, $css, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';			
			$campo='<input type="file" name="'.$nombre.'" id="'.$id.'" value="'.$valor.'" class="'.$css.'"'.$Estilo.'>';
			return $campo;
		}
		
		public static function CheckBox($nombre, $id, $valor, $css, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';			
			$campo='<input type="checkbox" name="'.$nombre.'" id="'.$id.'" value="'.$valor.'" class="'.$css.'"'.$Estilo.'>';
			return $campo;
		}
		
		public static function Text($nombre, $id, $valor, $css, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';
			//Ejemplo de Uso: AgregarText('Nombre Completo', 'nombre', 'nombre', '', 'css', '1', 'Ingrese el Nombre Completo');
			$campo='<input type="text" name="'.$nombre.'" id="'.$id.'" value="'.$valor.'" class="'.$css.'"'.$Estilo.'>';
			return $campo;
		}
		
		public static function Password($nombre, $id, $valor, $css, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';
			//Ejemplo de Uso: AgregarPAssword('Nombre Completo', 'nombre', 'nombre', '', 'css', '1', 'Ingrese el Nombre Completo');
			$campo='<input type="password" name="'.$nombre.'" id="'.$id.'" value="'.$valor.'" class="'.$css.'"'.$Estilo.'>';
			return $campo;
		}
		
		public static function TextMax($nombre, $id, $maxlength, $valor, $css, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';
			//Ejemplo de Uso: AgregarText('Nombre Completo', 'nombre', 'nombre', '', 'css', '1', 'Ingrese el Nombre Completo');
			$campo='<input type="text" name="'.$nombre.'" id="'.$id.'" value="'.$valor.'" class="'.$css.'" maxlength='.$maxlength.''.$Estilo.'>';
			return $campo;
		}
		
		public static function Select($nombre, $id, $valor_select, $valor_mostrar, $css, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';
			//Ejemplo de Uso: AgregarSelect('Escoja una Ciudad', 'ciudad', 'ciudad', array("BOGOTA","CALI","PALMIRA","MEDELLIN"), array("BOGOTA","CALI","PALMIRA","MEDELLIN"), 'CSS_SELECT', 1, 'Seleccione una Ciudad');
			$select='<select name="'.$nombre.'" id="'.$id.'" class="'.$css.'"'.$Estilo.'>'."\n";
			$select .='<option value="">Escoja una Opci&#243;n</option>'."\n";
			for ($i=0; $i<count($valor_select); $i++) {
				$select .='<option value="'.$valor_select[$i].'">'.$valor_mostrar[$i].'</option>'."\n";
			}
			$select .='</select>'."\n";
			$campo=$select;
			return $campo;
		}
		
		public static function SelectValorPre($nombre, $id, $ValorPred, $MostrarvalorPred, $valor_select, $valor_mostrar, $css, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';
			//Ejemplo de Uso: AgregarSelect('Escoja una Ciudad', 'ciudad', 'ciudad', array("BOGOTA","CALI","PALMIRA","MEDELLIN"), array("BOGOTA","CALI","PALMIRA","MEDELLIN"), 'CSS_SELECT', 1, 'Seleccione una Ciudad');
			$select='<select name="'.$nombre.'" id="'.$id.'" class="'.$css.'"'.$Estilo.'>'."\n";
			$select .='<option value="'.$ValorPred.'">'.$MostrarvalorPred.'</option>'."\n";
			$select .='<option value=""></option>'."\n";
			$select .='<option value="">Escoja una Opci&#243;n</option>'."\n";
			for ($i=0; $i<count($valor_select); $i++) {
				$select .='<option value="'.$valor_select[$i].'">'.$valor_mostrar[$i].'</option>'."\n";
			}
			$select .='</select>'."\n";
			$campo=$select;
			return $campo;
		}
		
		public static function TextHidden($nombre, $id, $valor, $css) {
			//Ejemplo de Uso: AgregarTextHidden('oculto', 'dato_oculto', 'dato_oculto', 'CSS_OCULTO');
			return $campo='<input type="hidden" name="'.$nombre.'" id="'.$id.'" value="'.$valor.'" class="'.$css.'">'."\n";
		}
		
		public static function Textarea($nombre, $id, $valor, $css, $alto, $ancho, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';
			//Ejemplo de Uso: TextareaReturn('comentario', 'comentario', '', 'css', 5, 30, '1', 'Ingrese el Comentario');
			$campo='<textarea name="'.$nombre.'" id="'.$id.'" class="'.$css.'" rows="'.$alto.'" cols="'.$ancho.'"'.$Estilo.'>'.$valor.'</textarea>';
			return $campo;
		}
		
		public static function ConfiguracionForm($action, $metodo, $nombre, $id, $css, $style = false) {
			$Estilo = ($style) ? self::Style($style) : '';
			return $MostrarFormulario='<form action="'.$action.'" method="'.strtoupper($metodo).'" name="'.$nombre.'" id="'.$id.'" class="'.$css.'"'.$Estilo.'>';
		}
		
		public static function Submit($nombre, $texto_boton, $css) {
			//Ejemplo de Uso: AgregarSubmit('guardar_datos_form', 'Guardar', 'buttonInput');
			return $campo='<button type="submit" name="'.$nombre.'" value="'.$nombre.'" class="'.$css.'">'.$texto_boton.'</button>';		//Generamos el Boton para enviar los datos del formulario
		}
		
		public static function CerrarForm() {
			return "</form>\n";
		}
		
		private static function Style($Style = false) {
			if($Style) {
				foreach($Style AS $Key => $Value) {
					$Datos[] = $Key.': '.$Value;
				}
				$Style2 = implode("; ", $Datos);
				return ' style="'.$Style2.';"';
			}
		}
	}