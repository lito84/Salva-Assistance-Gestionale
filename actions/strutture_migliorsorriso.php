<?php 
include("../includes/mysql.inc.php");
include("../includes/functions.php");
	
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
	$NominativoPotereFirmaStruttura=$_POST["NominativoPotereFirmaStruttura"];
	$NominativoConvenzioneStruttura=$_POST["NominativoConvenzioneStruttura"];
	$FissoNominativoConvenzioneStruttura=trim($_POST["FissoNominativoConvenzioneStruttura"]);
	$CellulareNominativoConvenzioneStruttura=trim($_POST["CellulareNominativoConvenzioneStruttura"]);
	$EmailNominativoConvenzioneStruttura=trim($_POST["EmailNominativoConvenzioneStruttura"]);
	$Provenienza=$_POST["Provenienza"];

	//$DataConfermaConvenzione=convertiDataUS_IT($_POST["DataConfermaConvenzione"]);
	
	$IdAnagraficaStruttura=$_POST["IdAnagraficaStruttura"];


	if($_POST["action"]=="logo"){
		$sql="UPDATE anagraficastruttura SET LogoStruttura = '$_POST[file]' WHERE IdAnagraficaStruttura='$_POST[id_struttura]'";
		$res=mysql_query($sql);
		exit;
	}

	if($_POST["action"]=="modifica")
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
			$sql.="NominativoConvenzioneStruttura='".addslashes($NominativoConvenzioneStruttura)."', ";
			$sql.="FissoNominativoConvenzioneStruttura='".addslashes($FissoNominativoConvenzioneStruttura)."', ";
			$sql.="CellulareNominativoConvenzioneStruttura='".addslashes($CellulareNominativoConvenzioneStruttura)."', ";
			$sql.="EmailNominativoConvenzioneStruttura='".addslashes($EmailNominativoConvenzioneStruttura)."', ";
			
			$sql.="Latitudine='".addslashes($Latitudine)."', ";
			$sql.="Longitudine='".addslashes($Longitudine)."', ";
			
			$sql.="Provenienza='".addslashes($Provenienza)."' ";

			//$sql.="timestamp_conferma='".addslashes($DataConfermaConvenzione)."' ";
			
			$sql.="WHERE anagraficastruttura.IdAnagraficaStruttura='".$IdAnagraficaStruttura."'";
			if($res=mysql_query($sql)){	
				$complete=1;
				exit;
			}

		


?>
