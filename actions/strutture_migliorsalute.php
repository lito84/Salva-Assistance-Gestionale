<?php 
include("../includes/auth.inc.php");
include("../includes/mysql.inc.php");
include("../includes/functions.php");
	
	$today=date("Y-m-d H:i:s", strtotime("now"));

	$RagioneSocialeStruttura=$_POST["RagioneSocialeStruttura"];
	$FormaGiuridicaStruttura=$_POST["FormaGiuridicaStruttura"];
	$IndirizzoLegaleStruttura=$_POST["IndirizzoLegaleStruttura"];
	$CittaLegaleStruttura=$_POST["CittaLegaleStruttura"];
	$ProvinciaLegaleStruttura=$_POST["ProvinciaLegaleStruttura"];
	$CapLegaleStruttura=$_POST["CapLegaleStruttura"];
	$IndirizzoOperativaStruttura=$_POST["IndirizzoOperativaStruttura"];
	$CittaOperativaStruttura=$_POST["CittaOperativaStruttura"];
	$ProvinciaOperativaStruttura=$_POST["ProvinciaOperativaStruttura"];
	$CapOperativaStruttura=$_POST["CapOperativaStruttura"];
	$RegioneStruttura=$_POST["RegioneStruttura"];
	$NazioneStruttura=$_POST["NazioneStruttura"];
	$Telefono1Struttura=$_POST["Telefono1Struttura"];
	$CupStruttura=$_POST["CupStruttura"];
	$Telefono2Struttura=$_POST["Telefono2Struttura"];
	$Latitudine=$_POST["Latitudine"];
	$Longitudine=$_POST["Longitudine"];
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

	$CupStruttura=str_replace("-","",$CupStruttura);
	$CupStruttura=str_replace("/","",$CupStruttura);
	$CupStruttura=str_replace(" ","",$CupStruttura);
	$CupStruttura=str_replace(".","",$CupStruttura);
	$CupStruttura=trim($CupStruttura);

	$NumeroVerdeStruttura=$_POST["NumeroVerdeStruttura"];
	$EmailStruttura=trim($_POST["EmailStruttura"]);
	$PecStruttura=trim($_POST["PecStruttura"]);
	$SitoWebStruttura=trim($_POST["SitoWebStruttura"]);
	$CellulareTitolareStruttura=trim($_POST["CellulareTitolareStruttura"]);
	$CodiceFiscaleStruttura=trim($_POST["CodiceFiscaleStruttura"]);
	$PartitaIvaStruttura=trim($_POST["PartitaIvaStruttura"]);
	$CellulareTitolareStruttura=trim($_POST["CellulareTitolareStruttura"]);
	$ResponsabileStruttura=$_POST["ResponsabileStruttura"];
	$NominativoPotereFirmaStruttura=$_POST["NominativoPotereFirmaStruttura"];
	$NominativoConvenzioneStruttura=$_POST["NominativoConvenzioneStruttura"];
	$FissoNominativoConvenzioneStruttura=trim($_POST["FissoNominativoConvenzioneStruttura"]);
	$CellulareNominativoConvenzioneStruttura=trim($_POST["CellulareNominativoConvenzioneStruttura"]);
	$EmailNominativoConvenzioneStruttura=trim($_POST["EmailNominativoConvenzioneStruttura"]);
	$Provenienza=ucfirst($_POST["Provenienza"]);
	$stato=$_POST["stato"];

	$DataConfermaConvenzione=convertiDataUS_IT($_POST["DataConfermaConvenzione"]);
	
	$IdAnagraficaStruttura=$_POST["IdAnagraficaStruttura"];



	if($_POST["action"]=="note_stato"){
	  $sql="UPDATE anagraficastruttura SET note_stato='".addslashes($_POST["note_stato"])."' WHERE IdAnagraficaStruttura = '$_POST[id_struttura]'";
	  $res=mysql_query($sql);
	  exit;
	}

if($_POST["action"]=="ScontoUnicoStruttura"){
	  $sql="UPDATE anagraficastruttura SET ScontoUnicoStruttura='".addslashes($_POST["ScontoUnicoStruttura"])."' WHERE IdAnagraficaStruttura = '$_POST[id_struttura]'";
	  $res=mysql_query($sql);
	  exit;
	}



	if($_POST["action"]=="logo"){
		$sql="UPDATE anagraficastruttura SET LogoStruttura = '$_POST[file]' WHERE IdAnagraficaStruttura='$_POST[id_struttura]'";
		$res=mysql_query($sql);
		exit;
	}

	if($_POST["action"]=="tariffario"){
		$sql="UPDATE anagraficastruttura SET tariffario_pdf = '$_POST[file]', data_tariffario='".date("Y-m-d H:i", strtotime("now"))."' WHERE IdAnagraficaStruttura='$_POST[id_struttura]'";


		$res=mysql_query($sql);
		exit;
	}



	if($_POST["action"]=="convenzione"){
		$sql="UPDATE anagraficastruttura SET convenzione_pdf = '$_POST[file]', data_convenzione='".date("Y-m-d H:i", strtotime("now"))."' WHERE IdAnagraficaStruttura='$_POST[id_struttura]'";


		$res=mysql_query($sql);
		exit;
	}

	if($_POST["action"]=="modifica"){
	
			$sql="UPDATE anagraficastruttura SET ";
			$sql.="RagioneSocialeStruttura='".addslashes($RagioneSocialeStruttura)."', ";
			$sql.="IndirizzoOperativaStruttura='".addslashes($IndirizzoOperativaStruttura)."', ";
			$sql.="CittaOperativaStruttura='".addslashes($CittaOperativaStruttura)."', ";
			$sql.="ProvinciaOperativaStruttura='".addslashes($ProvinciaOperativaStruttura)."', ";
			$sql.="CapOperativaStruttura='".addslashes($CapOperativaStruttura)."', ";
			$sql.="RegioneStruttura='".addslashes($RegioneStruttura)."', ";
			$sql.="NazioneStruttura='".addslashes($NazioneStruttura)."', ";
			$sql.="Telefono1Struttura='".addslashes($Telefono1Struttura)."', ";
			$sql.="Telefono2Struttura='".addslashes($Telefono2Struttura)."', ";
			$sql.="CupStruttura='".addslashes($CupStruttura)."', ";
			
			$sql.="NumeroVerdeStruttura='".addslashes($NumeroVerdeStruttura)."', ";
			$sql.="EmailStruttura='".addslashes($EmailStruttura)."', ";
			$sql.="PecStruttura='".addslashes($PecStruttura)."', ";
			$sql.="SitoWebStruttura='".addslashes($SitoWebStruttura)."', ";
			
			$sql.="CellulareTitolareStruttura='".addslashes($CellulareTitolareStruttura)."', ";
			$sql.="ResponsabileStruttura='".addslashes($ResponsabileStruttura)."', ";
			$sql.="NominativoPotereFirmaStruttura='".addslashes($NominativoPotereFirmaStruttura)."', ";
			$sql.="NominativoConvenzioneStruttura='".addslashes($NominativoConvenzioneStruttura)."', ";
			$sql.="FissoNominativoConvenzioneStruttura='".addslashes($FissoNominativoConvenzioneStruttura)."', ";
			$sql.="CellulareNominativoConvenzioneStruttura='".addslashes($CellulareNominativoConvenzioneStruttura)."', ";
			$sql.="EmailNominativoConvenzioneStruttura='".addslashes($EmailNominativoConvenzioneStruttura)."', ";
			
			$sql.="Latitudine='".addslashes($Latitudine)."', ";
			$sql.="Longitudine='".addslashes($Longitudine)."', ";
			$sql.="stato='".addslashes($stato)."', ";
			
			$sql.="Provenienza='".addslashes($Provenienza)."' ";

			//$sql.="timestamp_conferma='".addslashes($DataConfermaConvenzione)."' ";
			
			$sql.="WHERE anagraficastruttura.IdAnagraficaStruttura='".$IdAnagraficaStruttura."'";

			if($res=mysql_query($sql)){	
				$complete=1;
				exit;
			}

	}




	if($_POST["action"]=="inserisci"){
		$sql="INSERT INTO anagraficastruttura (RagioneSocialeStruttura,IndirizzoOperativaStruttura,CittaOperativaStruttura, ProvinciaOperativaStruttura, CapOperativaStruttura, RegioneStruttura, NazioneStruttura, Telefono1Struttura, Telefono2Struttura, CupStruttura, NumeroVerdeStruttura, EmailStruttura, PecStruttura, SitoWebStruttura, CellulareTitolareStruttura, ResponsabileStruttura, NominativoPotereFirmaStruttura, NominativoConvenzioneStruttura, CellulareNominativoConvenzioneStruttura, EmailNominativoConvenzioneStruttura, Latitudine, Longitudine, stato, Provenienza, migliorsalute, attivo, utente_conferma, convenzione_confermata, timestamp_conferma, servizi_confermati, timestamp_servizi_confermati, DataInserimento) ";
		$sql.="VALUES ('".addslashes($RagioneSocialeStruttura)."','".addslashes($IndirizzoOperativaStruttura)."', '".addslashes($CittaOperativaStruttura)."','".addslashes($ProvinciaOperativaStruttura)."','".addslashes($CapOperativaStruttura)."', '".addslashes($RegioneStruttura)."', '".addslashes($NazioneStruttura)."','".addslashes($Telefono1Struttura)."','".addslashes($Telefono2Struttura)."','".addslashes($CupStruttura)."', '".addslashes($NumeroVerdeStruttura)."','".addslashes($EmailStruttura)."', '".addslashes($PecStruttura)."','".addslashes($SitoWebStruttura)."','".addslashes($CellulareTitolareStruttura)."','".addslashes($ResponsabileStruttura)."','".addslashes($NominativoPotereFirmaStruttura)."','".addslashes($NominativoConvenzioneStruttura)."','".addslashes($CellulareNominativoConvenzioneStruttura)."','".addslashes($EmailNominativoConvenzioneStruttura)."','".addslashes($Latitudine)."','".addslashes($Longitudine)."','".addslashes($stato)."','".addslashes($Provenienza)."','1','1','$_SESSION[id_utente]','1','$DataConfermaConvenzione','1','$DataConfermaConvenzione','$today')";
		echo $sql;
		
			if($res=mysql_query($sql)){	
				$complete=1;
				exit;
			}
	}	


	if($_POST["action"]=="pacchetto"){

	if($_POST["selezione"]=='0'){
		$sql="DELETE FROM strutture_meta WHERE id_struttura='$_POST[id_struttura]' AND chiave = '$_POST[tipo]' AND valore='$_POST[valore]'";
	}else{
		$sql="INSERT INTO strutture_meta (id_struttura, chiave, valore) VALUES ('$_POST[id_struttura]','$_POST[tipo]','$_POST[valore]')";
		echo $sql;
	}
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="elimina_struttura"){
	$sql="DELETE FROM anagraficastruttura WHERE IdAnagraficaStruttura = '$_POST[id_struttura]'";
	$res=mysql_query($sql);

	$sql1="DELETE FROM servizi_strutture_migliorsalute WHERE id_struttura = '$_POST[id_struttura]'";
	$res1=mysql_query($sql1);
	exit;
}


if($_POST["action"]=="disabilita_struttura"){
	$sql="UPDATE anagraficastruttura SET attivo = '0' WHERE IdAnagraficaStruttura = '$_POST[id_struttura]'";
	$res=mysql_query($sql);			
	exit;
}


if($_POST["action"]=="da_cancellare"){
	$sql="UPDATE anagraficastruttura SET da_cancellare='$_POST[da_cancellare]' WHERE IdAnagraficaStruttura='$_POST[id_struttura]'";

	$res=mysql_query($sql);
	exit;
}

?>
