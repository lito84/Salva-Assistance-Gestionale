<?php 
include("../includes/auth.inc.php");
include("../includes/mysql.inc.php");
include("../includes/functions.php");
	
	$today=date("Y-m-d H:i:s", strtotime("now"));
	$utente_conferma=$_SESSION["id_utente"];

	$RagioneSocialeStruttura=$_POST["struttura"];
	
	$IndirizzoOperativaStruttura=$_POST["indirizzo"];
	$CittaOperativaStruttura=$_POST["citta"];
	$ProvinciaOperativaStruttura=$_POST["pr"];
	$CapOperativaStruttura=$_POST["cap"];


	$Telefono1Struttura=$_POST["telefono"];
	$Telefono2Struttura=$_POST["telefono1"];
	
	$Telefono1Struttura=str_replace("-","",$Telefono1Struttura);
	$Telefono1Struttura=str_replace("/","",$Telefono1Struttura);
	$Telefono1Struttura=str_replace(" ","",$Telefono1Struttura);
	$Telefono1Struttura=str_replace(".","",$Telefono1Struttura);
	$Telefono1Struttura=trim($Telefono1Struttura);
	$Telefono2Struttura=str_replace("-","",$Telefono2Struttura);
	$Telefono2Struttura=str_replace("/","",$Telefono2Struttura);
	$Telefono2Struttura=str_replace(" ","",$Telefono2Struttura);
	$Telefono2Struttura=str_replace(".","",$Telefono2Struttura);
	$Telefono2Struttura=trim($Telefono2Struttura);

	$EmailStruttura=trim($_POST["email"]);
	$ResponsabileStruttura=$_POST["referente"];
	
	$Provenienza='Innova';

	$stato='Convenzione chiusa';
	$note_stato=$_POST["note"];

	$sql="INSERT INTO anagraficastruttura (RagioneSocialeStruttura,IndirizzoOperativaStruttura,CittaOperativaStruttura, ProvinciaOperativaStruttura, CapOperativaStruttura, Telefono1Struttura, Telefono2Struttura, EmailStruttura, ResponsabileStruttura, Provenienza, migliorsalute, attivo, utente_conferma, convenzione_confermata, timestamp_conferma, servizi_confermati, timestamp_servizi_confermati, DataInserimento, stato, note_stato) ";
	
	$sql.="VALUES ('".addslashes($RagioneSocialeStruttura)."','".addslashes($IndirizzoOperativaStruttura)."', '".addslashes($CittaOperativaStruttura)."','".addslashes($ProvinciaOperativaStruttura)."','".addslashes($CapOperativaStruttura)."','".addslashes($Telefono1Struttura)."','".addslashes($Telefono2Struttura)."','".addslashes($EmailStruttura)."','".addslashes($ResponsabileStruttura)."','".addslashes($Provenienza)."','1','1','$_SESSION[id_utente]','1','$today','1','$today','$today','$stato','".addslashes($note_stato)."')";

		if($res=mysql_query($sql)){	
			$complete=1;
			$id=mysql_insert_id();
			$sql1="UPDATE anagrafica_da_confermare SET stato='$stato', confermata='1', id_anagraficastruttura='$id' WHERE id_struttura='$_POST[id_struttura]'";
			$res1=mysql_query($sql1);
			exit;
		}

		
		


?>
