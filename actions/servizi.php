<?php include("../includes/mysql.inc.php");
if($_POST["action"]=="elimina"){
	$sql="UPDATE servizi_strutture_migliorsalute SET attivo='0' WHERE id_servizio_struttura = '$_POST[id_servizio]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="sconto"){
	$sql="UPDATE servizi_strutture_migliorsalute SET sconto='$_POST[sconto]' WHERE id_servizio_struttura = '$_POST[id_servizio]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="prezzo_listino"){
	$sql="UPDATE servizi_strutture_migliorsalute SET prezzo_listino='$_POST[prezzo_listino]' WHERE id_servizio_struttura = '$_POST[id_servizio]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="prezzo_scontato"){
	$sql="UPDATE servizi_strutture_migliorsalute SET prezzo_scontato='$_POST[prezzo_scontato]' WHERE id_servizio_struttura = '$_POST[id_servizio]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="circuito"){
	$sql="UPDATE servizi_strutture_migliorsalute SET circuito='$_POST[circuito]' WHERE id_servizio_struttura = '$_POST[id_servizio]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="trova_servizi"){
	$sql="SELECT * FROM servizi_migliorsalute WHERE id_area = '$_POST[area]' ORDER BY servizio";
	$res=mysql_query($sql);
	echo '<div class="separatore"><div class="col-xs-2"><label>Servizi esistenti </label></div>';
	echo '<div class="col-xs-10"><select class="servizio_esistente"><option>Seleziona un servizio</option>';
	while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
		echo '<option value="'.$rows["id_servizio"].'">'.utf8_encode($rows["servizio"]).'</option>';
	}
	echo '</select></div></div>';
	exit;
}

if($_POST["action"]=="aggiungi_servizio"){
	if($_POST["nuovo_servizio"]!=""){
		$sql0="INSERT INTO servizi_migliorsalute (id_area, servizio) VALUES ('".$_POST["id_area"]."','".addslashes($_POST["nuovo_servizio"])."')";
		$res0=mysql_query($sql0);
		$id=mysql_insert_id();
	}else{
		$id=$_POST["servizio"];
	}

	$sql="INSERT INTO servizi_strutture_migliorsalute (id_struttura, id_circuito, circuito, id_area_servizio, id_servizio, sconto, prezzo_listino, prezzo_scontato) VALUES ('$_POST[id_struttura]', '$_POST[id_circuito]','".addslashes($_POST["circuito"])."', '$_POST[id_area]', '$id', '".addslashes($_POST["sconto"])."', '".addslashes($_POST["prezzo_listino"])."', '".addslashes($_POST["prezzo_scontato"])."')";
	$res=mysql_query($sql);
	echo $sql;
	exit;
}


?>
