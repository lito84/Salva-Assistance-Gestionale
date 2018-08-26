<?php 
include("includes/mysql.inc.php");
require("PHPMailer/class.phpmailer.php"); // Gestione email 
require("PHPMailer/class.smtp.php"); // Gestione email 


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


  $sql="SELECT * FROM anagraficastruttura WHERE RagioneSocialeStruttura LIKE '%Primo%' AND migliorsalute ";
  $res=mysql_query($sql);
  echo $sql;
  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){ 
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

	$messaggio=get_include_contents("modelli/invio.html");
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
                 // $mail->AddAddress($EmailStruttura, stripslashes($RagioneSocialeStruttura));
                  $mail->AddAddress("g.trogu@centridentisticiprimo.it", stripslashes($RagioneSocialeStruttura));
                  $mail->AddCC("convenzioni@migliorsalute.it", "Convenzioni MS");
                  if ($mail->Send()) {
                        $mail->ClearAddresses();
                        $sql1="UPDATE anagraficastruttura SET stato='Email inviata', data_stato='".date("Y-m-d H:i", strtotime("now"))."' WHERE IdAnagraficaStruttura='$IdAnagraficaStruttura'";
                        $res1=mysql_query($sql);
                  }
  }