<?php require("../includes/mysql.inc.php");
	  require("../includes/parameters.php");

if($_POST["action"]=="bugiardino"){
	$bugiardino=addslashes(utf8_encode($_POST["bugiardino"]));
	$categoria=addslashes($_POST["categoria"]);
	$sql="UPDATE pacchetti SET bugiardino='$bugiardino' WHERE id_pacchetto='$_POST[id_pacchetto]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="bugiardino_ss"){
	$bugiardino_ss=addslashes(utf8_encode($_POST["bugiardino_ss"]));
	$categoria=addslashes($_POST["categoria"]);
	$sql="UPDATE pacchetti SET bugiardino_ss='$bugiardino_ss' WHERE id_pacchetto='$_POST[id_pacchetto]'";
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="bugiardino_servizio"){
	$bugiardino=addslashes(utf8_encode($_POST["bugiardino"]));
	$categoria=addslashes($_POST["categoria"]);
	$sql="UPDATE aree_servizi SET bugiardino='$bugiardino' WHERE id_area='$_POST[id_area]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="bugiardino_servizio_ss"){
	$bugiardino_ss=addslashes(utf8_encode($_POST["bugiardino_ss"]));
	$categoria=addslashes($_POST["categoria"]);
	$sql="UPDATE aree_servizi SET bugiardino_ss='$bugiardino_ss' WHERE id_area='$_POST[id_area]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="pacchetto_circuito"){
	if($_POST["check"]=="0"){
		$sql="DELETE FROM circuiti_pacchetti WHERE id_pacchetto='$_POST[id_pacchetto]' AND id_circuito='$_POST[id_circuito]'";
	}else{
		$sql="INSERT INTO circuiti_pacchetti (id_pacchetto, id_circuito) VALUES ('$_POST[id_pacchetto]','$_POST[id_circuito]')";
	}
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="servizio_circuito"){
	if($_POST["check"]=="0"){
		$sql="DELETE FROM circuiti_servizi WHERE id_servizio='$_POST[id_servizio]' AND id_circuito='$_POST[id_circuito]'";
	}else{
		$sql="INSERT INTO circuiti_servizi (id_servizio, id_circuito) VALUES ('$_POST[id_servizio]','$_POST[id_circuito]')";
	}
	$res=mysql_query($sql);
	exit;
}
?>
