<?php 
include("../includes/auth.inc.php");
include("../includes/mysql.inc.php");
	$id_circuito=$_POST["id_circuito"];
	$circuito=addslashes($_POST["circuito"]);
	$email=addslashes($_POST["email"]);
	$responsabile=addslashes($_POST["responsabile"]);
	$telefono=addslashes($_POST["telefono"]);
	$descrizione=addslashes($_POST["descrizione"]);

if($_POST["action"]=="inserisci"){
	$sql="INSERT INTO circuiti (circuito, responsabile, email, telefono, descrizione) VALUES ('$circuito','$responsabile','$email','$telefono','$descrizione')";
	$res=mysql_query($sql);
	echo $sql;
	exit;
}

if($_POST["action"]=="modifica"){
	$sql="UPDATE circuiti  SET circuito='$circuito', responsabile='$responsabile',email='$email',telefono='$telefono', descrizione='$descrizione' WHERE id_circuito='$id_circuito'";
	$res=mysql_query($sql);
	echo $sql;
	exit;
}

if($_POST["action"]=="tariffario"){
	$sql="UPDATE circuiti SET tariffario_pdf = '$_POST[file]' WHERE id_circuito='$_POST[id_circuito]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="struttura_circuito"){
	if($_POST["struttura"]=="0"){
		$sql="DELETE FROM circuiti_strutture WHERE id_struttura='$_POST[id_struttura]' AND id_circuito='$_POST[id_circuito]'";
	}else{
		$sql="INSERT INTO circuiti_strutture(id_struttura, id_circuito) VALUES ('$_POST[id_struttura]','$_POST[id_circuito]')";
	}
	echo $sql;
	$res=mysql_query($sql);
	exit;
}

?>