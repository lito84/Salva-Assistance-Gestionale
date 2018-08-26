<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

require("../includes/mysql.inc.php");
require("../includes/parameters.php");

function generateRandomString($length = 11) {
    $characters = '123456789BCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if($_POST["action"]=="insert"){
	
	$nome=addslashes($_POST["nome"]);
	$cognome=addslashes($_POST["cognome"]);
	$sesso=addslashes(strtoupper($_POST["sesso"]));
	$data_nascita=addslashes($_POST["data_nascita"]);
	$indirizzo=addslashes($_POST["address"]);
	$cognome=addslashes($_POST["cognome"]);	
	$email=addslashes($_POST["email"]);
	$telefono=addslashes($_POST["telefono"]);
	$token=addslashes($_POST["token"]);
	$product_id=addslashes($_POST["product_id"]);

	$id_prodotto_convenzione=$product_id;

	$sql="INSERT INTO clienti (nome, cognome, email, telefono, sesso, indirizzo, data_nascita) VALUES ('$nome','$cognome','$email', '$telefono','$sesso','$indirizzo','$data_nascita')";
	$res=mysql_query($sql);
	$id=mysql_insert_id();

	$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$id_convenzione_prodotto' AND chiave='Validita'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

	$mesi=$rows1["valore"];

	$data_scadenza=date("Y-m-d H:i", strtotime("now +".$mesi." months"));

		//Inserisco il record con stato non pagato e attivo
	$sql2="INSERT INTO pratiche (id_cliente, id_prodotto_convenzione, data_inserimento, data_scadenza, data_attivazione, tipo_pagamento, pagato, attivo, user_agent) VALUES ('$id', '$product_id', '".date("Y-m-d H:i", strtotime("now"))."','$data_scadenza','".date("Y-m-d H:i", strtotime("now"))."','".addslashes($metodo)."','0','1','".$_SERVER['HTTP_USER_AGENT']."')";
	$res2=mysql_query($sql2);

	$id_pratica=mysql_insert_id();
	$id_pratica=str_pad($id_pratica,10,"0", STR_PAD_LEFT);	

	$sqlc="INSERT INTO pratiche_meta (id_pratica, chiave, valore) VALUES ('$id_pratica','Token','$token')";
	$resc=mysql_query($sqlc);

	//Genero il codice di attivazione come stringa radom da 5 + id_pratica
	$codice_attivazione = generateRandomString(6).substr($id_pratica,5,5);

	//Aggiorno la pratica inserendo il codice attivazione 
	$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione' WHERE id_pratica = '$id_pratica'";
	$res3=mysql_query($sql3);

	echo md5($codice_attivazione);
	exit;
}
?>