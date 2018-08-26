<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/getinclude.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php require("../PHPMailer/class.phpmailer.php"); // Gestione email ?>
<?php require("../PHPMailer/class.smtp.php"); // Gestione email ?>


<?php 
$sql="SELECT * FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione=convenzioni_prodotti.id_convenzione_prodotto WHERE pagato AND attivo AND id_cliente <> '0' AND esportato_migliorsalute='0' AND salute_semplice='1'";
$res=mysql_query($sql);
$now=date("Y-m-d H:i:s", strtotime("now"));
$scadenza=date("Y-m-d H:i:s", strtotime("now +12 months"));
$oggi=date("d-m-Y", strtotime("now"));

$messaggio="<h1>Attivazioni del ".$oggi."</h1>";
$messaggio.="<table><thead><tr><th>Nome</th><th>Cognome</th><th>Codice Attivazione</th></tr></thead><tbody>";
$invio_email=0;
if(mysql_num_rows($res)>0) $invio_email=1;
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)):

	$id_pratica=$rows["id_pratica"];
	$sql1="SELECT * FROM clienti WHERE id_cliente = '$rows[id_cliente]'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);


	//Cerco quale pacchetto è collegato al prodotto
	$migliorsalute=0;
	$migliorsorriso=0;
	$basic=0;
	$gold=0;
	$platinum=0;

	$sql0="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows[id_prodotto_convenzione]' AND chiave='Pacchetto' AND valore='01'";
	$res0=mysql_query($sql0);
	if(mysql_num_rows($res0)==1) $migliorsalute=1;

	$sql0="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows[id_prodotto_convenzione]' AND chiave='Pacchetto' AND valore='02'";
	$res0=mysql_query($sql0);
	if(mysql_num_rows($res0)==1) $migliorsorriso=1;

	$sql0="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows[id_prodotto_convenzione]' AND chiave='Servizio' AND valore='061'";
	$res0=mysql_query($sql0);
	if(mysql_num_rows($res0)==1) $basic=1;

	$sql0="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows[id_prodotto_convenzione]' AND chiave='Servizio' AND valore='062'";
	$res0=mysql_query($sql0);
	if(mysql_num_rows($res0)==1) $platinum=1;

	$sql0="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows[id_prodotto_convenzione]' AND chiave='Servizio' AND valore='063'";
	$res0=mysql_query($sql0);
	if(mysql_num_rows($res0)==1) $gold=1;

	if($migliorsalute==1 && $migliorsorriso==0){
		$id_prodotto_convenzione='000373'; // Premium One
	}

	if($migliorsalute==1 && $migliorsorriso==1){
		if($basic==1) $id_prodotto_convenzione='000375'; //SaluteSorriso Basic
		if($gold==1) $id_prodotto_convenzione='000376'; //SaluteSorriso Gold
		if($platinum==1) $id_prodotto_convenzione='000374'; //SaluteSorriso Platinum
	}

	if($migliorsalute==0 && $migliorsorriso==1){
		if($basic==1) $id_prodotto_convenzione='000082'; //Dental Basic
		if($gold==1) $id_prodotto_convenzione='000087'; //Dental Gold
		if($platinum==1) $id_prodotto_convenzione='000229'; //Dental Platinum
	}

	$nome=addslashes(utf8_encode($rows1["nome"]));
	$cognome=addslashes(utf8_encode($rows1["cognome"]));
	$sesso=addslashes(utf8_encode($rows1["sesso"]));
	$codicefiscale=addslashes(utf8_encode($rows1["codicefiscale"]));
	$data_nascita=addslashes(utf8_encode($rows1["data_nascita"]));
	$luogo_nascita=addslashes(utf8_encode($rows1["luogo_nascita"]));
	$indirizzo=addslashes(utf8_encode($rows1["indirizzo"]));
	$citta=addslashes(utf8_encode($rows1["citta"]));
	$prov=addslashes(utf8_encode($rows1["prov"]));
	$cap=addslashes(utf8_encode($rows1["cap"]));
	$email="bifinser@gmail.com";

	$codice_attivazione=$rows["codice_attivazione"]."BS";
	
		$host="213.183.128.214";
		$user="vm1";
		$pass="TJcCrCjPKqVwYjUS";
		$database="migliorsalute";

		$con1=mysql_connect($host,$user,$pass) or die ("Errore durante la connessione al database $database!");
		$db1=mysql_select_db($database,$con1) or die ("Errore durante la selezione del database!");


		$sqlc="INSERT INTO clienti (nome, cognome, sesso, codicefiscale,data_nascita, luogo_nascita,indirizzo, citta, prov, cap, email ) VALUES ('$nome','$cognome','$sesso','$codicefiscale','$data_nascita','$luogo_nascita','$indirizzo','$citta','$prov','$cap','$email')";
		
		
		$resc=mysql_query($sqlc);
		$id_cliente=mysql_insert_id();
		

		$sqlp="INSERT INTO pratiche(id_cliente, id_prodotto_convenzione, data_inserimento, codice_attivazione, data_attivazione, data_scadenza, pagato, attivo) VALUES ('$id_cliente', '$id_prodotto_convenzione', '$now','$codice_attivazione','$now','$scadenza','1','1')";
		$resp=mysql_query($sqlp);
		
		mysql_close($con1);

		$host="saluteseukss.mysql.db";
		$user="saluteseukss";
		$pass="KVB6b3wmB6qy73Aa";
		$database="saluteseukss";
		$con=mysql_connect($host,$user,$pass) or die ("Errore durante la connessione al database $database!");
		$db=mysql_select_db($database,$con) or die ("Errore durante la selezione del database!");



		$sqlt="UPDATE pratiche SET esportato_migliorsalute='1' WHERE id_pratica='$id_pratica'";
		$rest=mysql_query($sqlt);	

		$messaggio.="<tr><td>".$nome."</td><td>".$cognome."</td><td>".$codice_attivazione."</td></tr>";

endwhile;


$messaggio.="</tbody></table>";

if($invio_email):
	$mail=new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = $p_smtp_user; // SMTP username
	$mail->Password = $p_smtp_password; // SMTP password
	$mail->Host=$p_smtp_server;
	$mail->From=$p_smtp_mittente_email;
	$mail->FromName=$p_smtp_mittente;
	$mail->Port=465;
	$mail->SMTPSecure="ssl";
	$mail->MsgHTML($messaggio);
	$mail->Subject="Importazioni in Migliorsalute del ".$oggi;
	$mail->AddAddress("info@salute-semplice.it", "Salute Semplice");
	//$mail->AddBCC("amministrazione@migliorsalute.it", "Amministrazione Migliorsalute");
	$mail->Send();
endif;
?>