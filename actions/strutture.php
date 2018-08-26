<?php 
include("../includes/auth.inc.php");
include("../includes/mysql.inc.php");
require("../PHPMailer/class.phpmailer.php"); // Gestione email 
require("../PHPMailer/class.smtp.php"); // Gestione email 



function get_include_contents($filename) {
   if (is_file($filename)) {
       ob_start();
       include $filename;
       $contents = ob_get_contents();
       ob_end_clean();
       return $contents;
   }
   return false;
}

$p_smtp_server="93.93.203.180";
$p_smtp_user="web1_migliorsalute";
$p_smtp_password="msal2015";
$p_smtp_mittente="Migliorsalute";
$p_smtp_mittente_email="convenzioni@migliorsalute.it";




	$id_struttura=$_POST["id_struttura"];
	$struttura=addslashes($_POST["struttura"]);
	$email=addslashes($_POST["email"]);
	$referente=addslashes($_POST["referente"]);
	$telefono=addslashes($_POST["telefono"]);
	$telefono1=addslashes($_POST["telefono1"]);
	$indirizzo=addslashes($_POST["indirizzo"]);
	$citta=addslashes($_POST["citta"]);
	$pr=addslashes($_POST["pr"]);
	$cap=addslashes($_POST["cap"]);
	$note=addslashes($_POST["note"]);
	$provenienza=addslashes($_POST["provenienza"]);
	$segnalatore=addslashes($_POST["segnalatore"]);
	$email_segnalatore=addslashes($_POST["email_segnalatore"]);
	$stato=addslashes($_POST["stato"]);
  $strutture_aggiuntive=addslashes($_POST["strutture_aggiuntive"]);
	

if($_POST["action"]=="telefono"){
	$sql="UPDATE anagrafica_salute_semplice SET telefono='$_POST[telefono]' WHERE id_struttura = '$_POST[id_struttura]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="telefono1"){
	$sql="UPDATE anagrafica_salute_semplice SET telefono1='$_POST[telefono]' WHERE id_struttura = '$_POST[id_struttura]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="email"){
	$sql="UPDATE anagrafica_salute_semplice SET email='$_POST[email]' WHERE id_struttura = '$_POST[id_struttura]'";
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="cancella_da_contattare"){
	$sql="DELETE FROM anagrafica_salute_semplice WHERE id_struttura = '$_POST[id_struttura]'";
	echo $sql;
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="modifica"){
	
	
	
	$sql="UPDATE anagrafica_salute_semplice  SET 
	struttura='$struttura',
	indirizzo='$indirizzo',
	citta='$citta',
	cap='$cap',
	pr='$pr',
	email='$email',
	telefono='$telefono',
	referente='$referente',
	note='$note',
	provenienza='$provenienza',
	segnalatore='$segnalatore',
	email_segnalatore='$email_segnalatore',
  strutture_aggiuntive='$strutture_aggiuntive',
	stato='$stato'
	WHERE id_struttura='$id_struttura'";
	$res=mysql_query($sql);
	echo $sql;
	exit;

}

if($_POST["action"]=="inserisci"){
	
	
	
	$sql="INSERT INTO anagrafica_salute_semplice (struttura, indirizzo, citta, pr, cap, email, referente, telefono, stato, note) VALUES ('$struttura','$indirizzo','$citta','$pr','$cap','$email','$referente','$telefono','$stato','$note')";
	$res=mysql_query($sql);
	echo $sql;
	exit;

}


if($_POST["action"]=="sposta"){
	$now=date("Y-m-d H:i:s", strtotime("now"));

	$sql="SELECT * FROM anagrafica_salute_semplice WHERE id_struttura = '$_POST[id]'";
	$res=mysql_query($sql);
	$rows=mysql_fetch_array($res, MYSQL_ASSOC);

	$sql1="INSERT INTO anagraficastruttura (RagioneSocialeStruttura, IndirizzoOperativaStruttura, CittaOperativaStruttura, ProvinciaOperativaStruttura, EmailStruttura, Telefono1Struttura, NominativoConvenzioneStruttura, stato, migliorsalute, DataInserimento, convenzione_confermata, servizi_confermati, utente_conferma, timestamp_conferma, timestamp_servizi_confermati, Provenienza) VALUES ('".addslashes($rows["struttura"])."','".addslashes($rows["indirizzo"])."','".addslashes($rows["citta"])."', '".addslashes($rows["pr"])."', '".addslashes($rows["email"])."', '".addslashes($rows["telefono"])."', '".addslashes($rows["referente"])."', '".addslashes($rows["stato"])."','1','".$now."','1','1','$_SESSION[id_utente]','".$now."','".$now."','Innova')";
	echo $sql1;
	if($res1=mysql_query($sql1)){
		$sql2="UPDATE anagrafica_salute_semplice SET confermata = '1' WHERE id_struttura ='$_POST[id]'";
		$res2=mysql_query($sql2);
		exit;
	}
}
?>


<?php if($_POST["action"]=="invia_adesione"){
	  $sql="SELECT * FROM anagraficastruttura WHERE IdAnagraficaStruttura = '$_POST[id_anagrafica]'";
  $res=mysql_query($sql);
  $rows=mysql_fetch_array($res, MYSQL_ASSOC);
 
  $RagioneSocialeStruttura=stripslashes(utf8_encode($rows["RagioneSocialeStruttura"]));
  $IndirizzoLegaleStruttura=stripslashes(utf8_encode($rows["IndirizzoLegaleStruttura"]));
  $CittaLegaleStruttura=stripslashes(utf8_encode($rows["CittaLegaleStruttura"]));
  $ProvinciaLegaleStruttura=stripslashes(utf8_encode($rows["ProvinciaLegaleStruttura"]));
  $CapLegaleStruttura=stripslashes(utf8_encode($rows["CapLegaleStruttura"]));
  $IndirizzoOperativaStruttura=stripslashes(utf8_encode($rows["IndirizzoOperativaStruttura"]));
  $CittaOperativaStruttura=stripslashes(utf8_encode($rows["CittaOperativaStruttura"]));
  $ProvinciaOperativaStruttura=stripslashes(utf8_encode($rows["ProvinciaOperativaStruttura"]));
  $CapOperativaStruttura=stripslashes(utf8_encode($rows["CapOperativaStruttura"]));
  $Telefono1Struttura=stripslashes(utf8_encode($rows["Telefono1Struttura"]));
  $Telefono2Struttura=stripslashes(utf8_encode($rows["Telefono2Struttura"]));
  $NumeroVerdeStruttura=stripslashes(utf8_encode($rows["NumeroVerdeStruttura"]));
  $FaxStruttura=stripslashes(utf8_encode($rows["FaxStruttura"]));
  $EmailStruttura=stripslashes(utf8_encode($rows["EmailStruttura"]));
  $SitoWebStruttura=stripslashes(utf8_encode($rows["SitoWebStruttura"]));
  $NominativoConvenzioneStruttura=stripslashes(utf8_encode($rows["NominativoConvenzioneStruttura"]));
  $FissoNominativoConvenzioneStruttura=stripslashes(utf8_encode($rows["FissoNominativoConvenzioneStruttura"]));
  $CellulareNominativoConvenzioneStruttura=stripslashes(utf8_encode($rows["CellulareNominativoConvenzioneStruttura"]));
  $EmailNominativoConvenzioneStruttura=stripslashes(utf8_encode($rows["EmailNominativoConvenzioneStruttura"]));
  $IdAnagraficaStruttura=$rows["IdAnagraficaStruttura"];
  $provenienza=$rows["Provenienza"];
  $servizi=$rows["servizi"];

	$messaggio=get_include_contents("../modelli/invio.html");
                  $mail=new PHPMailer();
                  $mail->IsSMTP();
                  $mail->SMTPAuth = true; // turn on SMTP authentication
                  $mail->Username = $p_smtp_user; // SMTP username
                  $mail->Password = $p_smtp_password; // SMTP password
                  $mail->Host=$p_smtp_server;
                  $mail->From=$p_smtp_mittente_email;
                  $mail->FromName=$p_smtp_mittente;

                  $campi=array("{NOME-STRUTTURA}","{CODE}","{NOSERVIZI}");
                  $dicitura="";
                  if($servizi=='0'){
                    $dicitura="Siete pregati di rispondere a questa mail inviandoci il vostro tarifarrio in formato pdf.";
                  }
                  $valori=array($RagioneSocialeStruttura, md5($IdAnagraficaStruttura),$dicitura);
                  $messaggio=str_replace($campi,$valori,$messaggio);
                
                  $mail->MsgHTML($messaggio);
                  $mail->AltBody=strip_tags(html_entity_decode($messaggio));
                  
                  $mail->Subject="Conferma dati Migliorsalute";
                  $mail->AddAddress($EmailStruttura, stripslashes($RagioneSocialeStruttura));
                  $mail->AddCC("convenzioni@migliorsalute.it", "Convenzioni MS");
                  if ($mail->Send()) {
                        $mail->ClearAddresses();
                        $sql="UPDATE anagraficastruttura SET stato='Email inviata', data_stato='".date("Y-m-d H:i", strtotime("now"))."' WHERE IdAnagraficaStruttura='$IdAnagraficaStruttura'";
                        $res=mysql_query($sql);
                  }
                  exit;
}?>


<?php if($_POST["action"]=="invia_adesione_lettera"){
	  $sql="SELECT * FROM anagraficastruttura WHERE IdAnagraficaStruttura = '$_POST[id_anagrafica]'";
  $res=mysql_query($sql);
  $rows=mysql_fetch_array($res, MYSQL_ASSOC);
 
  $RagioneSocialeStruttura=stripslashes(utf8_encode($rows["RagioneSocialeStruttura"]));
  $IndirizzoLegaleStruttura=stripslashes(utf8_encode($rows["IndirizzoLegaleStruttura"]));
  $CittaLegaleStruttura=stripslashes(utf8_encode($rows["CittaLegaleStruttura"]));
  $ProvinciaLegaleStruttura=stripslashes(utf8_encode($rows["ProvinciaLegaleStruttura"]));
  $CapLegaleStruttura=stripslashes(utf8_encode($rows["CapLegaleStruttura"]));
  $IndirizzoOperativaStruttura=stripslashes(utf8_encode($rows["IndirizzoOperativaStruttura"]));
  $CittaOperativaStruttura=stripslashes(utf8_encode($rows["CittaOperativaStruttura"]));
  $ProvinciaOperativaStruttura=stripslashes(utf8_encode($rows["ProvinciaOperativaStruttura"]));
  $CapOperativaStruttura=stripslashes(utf8_encode($rows["CapOperativaStruttura"]));
  $Telefono1Struttura=stripslashes(utf8_encode($rows["Telefono1Struttura"]));
  $Telefono2Struttura=stripslashes(utf8_encode($rows["Telefono2Struttura"]));
  $NumeroVerdeStruttura=stripslashes(utf8_encode($rows["NumeroVerdeStruttura"]));
  $FaxStruttura=stripslashes(utf8_encode($rows["FaxStruttura"]));
  $EmailStruttura=stripslashes(utf8_encode($rows["EmailStruttura"]));
  $SitoWebStruttura=stripslashes(utf8_encode($rows["SitoWebStruttura"]));
  $NominativoConvenzioneStruttura=stripslashes(utf8_encode($rows["NominativoConvenzioneStruttura"]));
  $FissoNominativoConvenzioneStruttura=stripslashes(utf8_encode($rows["FissoNominativoConvenzioneStruttura"]));
  $CellulareNominativoConvenzioneStruttura=stripslashes(utf8_encode($rows["CellulareNominativoConvenzioneStruttura"]));
  $EmailNominativoConvenzioneStruttura=stripslashes(utf8_encode($rows["EmailNominativoConvenzioneStruttura"]));
  $IdAnagraficaStruttura=$rows["IdAnagraficaStruttura"];
  $provenienza=$rows["Provenienza"];

	$messaggio=get_include_contents("../modelli/inviolettera.html");
                  $mail=new PHPMailer();
                  $mail->IsSMTP();
                  $mail->SMTPAuth = true; // turn on SMTP authentication
                  $mail->Username = $p_smtp_user; // SMTP username
                  $mail->Password = $p_smtp_password; // SMTP password
                  $mail->Host=$p_smtp_server;
                  $mail->From=$p_smtp_mittente_email;
                  $mail->FromName=$p_smtp_mittente;
                  $campi=array("{NOME-STRUTTURA}","{CODE}");
                  $valori=array($RagioneSocialeStruttura, md5($IdAnagraficaStruttura));
                  $messaggio=str_replace($campi,$valori,$messaggio);
                  $mail->MsgHTML($messaggio);
                  $mail->AltBody=strip_tags(html_entity_decode($messaggio));
                  
                  $mail->Subject="Conferma dati Migliorsalute";
                  $mail->AddAddress($EmailStruttura, stripslashes($RagioneSocialeStruttura));
                  $mail->AddCC("convenzioni@migliorsalute.it", "Convenzioni MS");
                  if ($mail->Send()) {
                        $mail->ClearAddresses();
                        $sql="UPDATE anagraficastruttura SET stato='Email inviata + lettera', data_stato='".date("Y-m-d H:i", strtotime("now"))."' WHERE IdAnagraficaStruttura='$IdAnagraficaStruttura'";
                       $res=mysql_query($sql);
                  }
                  exit;
}?>
