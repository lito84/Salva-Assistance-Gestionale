<?php 
include("../includes/auth.inc.php");
include("../includes/mysql.inc.php");
include("../includes/functions.php");
	$id_cliente=$_POST["id_cliente"];
	$cognome=addslashes($_POST["cognome"]);
	$nome=addslashes($_POST["nome"]);
	$sesso=addslashes($_POST["sesso"]);
	$data_nascita=convertiDataUS_IT($_POST["data_nascita"]);
	$luogo_nascita=addslashes($_POST["luogo_nascita"]);
	$stato_nascita=addslashes($_POST["stato_nascita"]);
	$indirizzo=addslashes($_POST["indirizzo"]);
	$citta=addslashes($_POST["citta"]);
	$cap=addslashes($_POST["cap"]);
	$email=addslashes($_POST["email"]);
	$telefono=addslashes($_POST["telefono"]);


if($_POST["action"]=="modifica"){
	$sql="UPDATE clienti  SET 
	cognome='$cognome', 
	nome='$nome',
	sesso='$sesso',
	data_nascita='$data_nascita',
	luogo_nascita='$luogo_nascita',
	stato_nascita='$stato_nascita',
	indirizzo='$indirizzo',
	citta='$citta',
	cap='$cap',
	email='$email',
	telefono='$telefono' 
	WHERE id_cliente='$id_cliente'";
	$res=mysql_query($sql);
	echo $sql;
	exit;
}


?>