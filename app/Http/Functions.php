<?php 
	function getModulosArray(){
		$a = [
			'0' => 'Tipo documento',
			'1' => 'Tipo paciente',
			'2' => 'Sexo',
			'3' => 'Estado civil',
			'4' => 'Status historia',
			'5' => 'Tipo diagnóstico',
			'6' => 'Visita diagnóstico',
			'7' => 'Posología - Medida',
			'8' => 'Posología - Frecuencia',
			'9' => 'Posología - Tiempo',
			'10' => 'Moneda',
			'11' => 'Forma de pago',
			'13' => 'Tipo visita',
			'14' => 'Status comprobante electrónico'
		];
		return $a;

	}
	function getMeses(){
		$m = [
			'01' => 'Enero',
			'02' => 'Febrero',
			'03' => 'Marzo',
			'04' => 'Abril',
			'05' => 'Mayo',
			'06' => 'Junio',
			'07' => 'Julio',
			'08' => 'Agosto',
			'09' => 'Septiembre',
			'10' => 'Octubre',
			'11' => 'Noviembre',
			'12' => 'Diciembre',
		];
		return $m;
	}

	//Key Value From JSon
	function kvfj($json, $key){
		if($json == null):
			return null;
		else:
			$json = $json;
			$json = json_decode($json, true);
			if(array_key_exists($key, $json)):
				return $json[$key];
			else:
				return null;
			endif;
		endif;
		

	}

	function preProm($cant, $pant, $cnue, $pnue){
		$pre = round((($cant * $pant) + ($cnue * $pnue)) / ($cant + $cnue), 4);
		return($pre);
	}

	function prePromE($cant, $pant, $cnue, $pnue){
		if($cant - $cnue == 0){
			$pre = 0.00;
		}else{
			$pre = round((($cant * $pant) - ($cnue* $pnue)) / ($cant - $cnue), 4);
		}		
		return($pre);
	}

	function numDoc($serie,$numero){
		if(strlen(trim($serie))==0){
			return(trim($numero));
		}else{
			return(trim($serie).'-'.trim($numero));
		}

	}

	function pAnterior($periodo){
		$mes = substr($periodo, 0,2);
		$anio = substr($periodo, 2);
		if($mes == '01'){
			$n = '12'.strval(intval($anio)-1);
		}else{
			$n = str_pad(intval($mes)-1, 2, '0', STR_PAD_LEFT).$anio;
		}
		return $n;
	}
	
	function pSiguiente($periodo){
		$mes = substr($periodo, 0,2);
		$anio = substr($periodo, 2);
		if($mes == '12'){
			$n = '01'.strval(intval($anio)+1);
		}else{
			$n = str_pad(intval($mes)+1, 2, '0', STR_PAD_LEFT).$anio;
		}
		return $n;
	}


?>