<?php

	/**
     * htmlentities con tutto
	 * @param stringa
     */
	 
	function f_encode($stringa){
		$stringa=htmlentities($stringa, ENT_QUOTES, "UTF-8");
		return $stringa;
	}
	
	/**
     * html_decode con tutto
	 * @param stringa
     */
	 
	function f_decode($stringa){
		$stringa=html_entity_decode($stringa, ENT_QUOTES, "UTF-8");
		return $stringa;
	}
	/**
     * Converte la data da gg/mm/aaaa a aaaa-mm-gg
	 * @param data
     */
	 
	function convertiDataUS_IT($dataEur){
		$rsls=explode(" ", $dataEur);
		$rsl = explode ('/',$rsls[0]);
		$rsl = array_reverse($rsl);
		return implode($rsl,'-')." ".$rsls[1];
	}
	
	/**
     * Converte la data da aaaa-mm-gg mm:ss a gg/mm/aaaa mm ss 
	 * @param data
     */
	 
	function convertiDataIT_US($dataEur){
		$rsl = explode(" ",$dataEur);
		$rsl1 = explode ('-',$rsl[0]);
		$rsl1 = array_reverse($rsl1);
		return implode($rsl1,'/');
	}
	function dateDiff($date1,$date2){
		$date1=date_create($date1);
		$date2=date_create($date2);
		$diff=date_diff($date1,$date2);
		return $diff->format("%a");
	}
	
	function write_value_json($field) {
	$field=utf8_encode($field);
	
	return $field;
	}
	
	function emailize($text){
    $regex = '/(\S+@\S+\.\S+)/';
    $replace = '<a href="mailto:$1">$1</a>';
    return preg_replace($regex, $replace, $text);
	}

	
?>