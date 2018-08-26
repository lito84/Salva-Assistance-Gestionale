<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/getinclude.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php require("../PHPMailer/class.phpmailer.php"); // Gestione email ?>
<?php require("../PHPMailer/class.smtp.php"); // Gestione email ?>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<?php 
$giorni=5;

$data_scadenza=date("Y-m-d", strtotime("now+".$giorni." days"));
$sql="SELECT * FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione=convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN clienti ON pratiche.id_cliente =clienti.id_cliente WHERE pagato AND pratiche.attivo='1' AND pratiche.id_cliente<>'0' AND data_scadenza LIKE '2017-10-11%' AND tipologia='P' AND id_prodotto_convenzione='000062' AND data_invio_rinnovo LIKE '2017-10%' AND data_invio_errore2=''";
	  $res=mysql_query($sql);
	  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

		
		
			$messaggio=get_include_contents("../templates/migliorsalutesorriso_invioerrata_corrige.html");
		
		$campi=array("{CLIENTE}","{GIORNI}","{CARD}","{DATASCADENZA}","{LINK}");

		$sql0="SELECT *, prodotti_categorie.categoria AS categoria FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto LEFT JOIN prodotti_categorie ON prodotti.categoria = prodotti_categorie.id_categoria WHERE id_convenzione_prodotto = '$rows[id_prodotto_convenzione]'";
		$res0=mysql_query($sql0);
		$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);
		$prodotto=utf8_encode($rows0["prodotto"]);
		$data_scadenza=date("d/m/Y", strtotime($rows["data_scadenza"]));

		$link="http://www.migliorsalute.it/rinnovo-card?code=".md5($rows["codice_attivazione"]);

		$valori=array(stripslashes($rows["cognome"]." ".$rows["nome"]),$giorni,$prodotto,$data_scadenza,$link);
		

		$oggetto="Ci scusiamo per l'errata comunicazione";


		$messaggio=str_replace($campi,$valori,$messaggio);
				
			$mail=new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->Username = $p_smtp_user; // SMTP username
			$mail->Password = $p_smtp_password; // SMTP password
			$mail->Host=$p_smtp_server;
			$mail->From=$p_smtp_mittente_email;
			$mail->FromName=$p_smtp_mittente;
			$mail->MsgHTML(utf8_decode($messaggio));
			$mail->Subject=$oggetto;
			$mail->AddAddress($rows["email"], stripslashes($rows["nome"]." ".$rows["cognome"]));
			//$mail->AddAddress("luca.merli84@gmail.com", stripslashes($rows["nome"]." ".$rows["cognome"]));
			//$mail->AddBCC("amministrazione@migliorsalute.it", stripslashes($rows["nome"]." ".$rows["cognome"]));
			//$mail->AddBCC("vittorio.manduchi@gmail.com", stripslashes($rows["nome"]." ".$rows["cognome"]));
			if ($mail->Send()) {
				$mail->ClearAddresses();
				$sql3="UPDATE pratiche SET data_invio_errore2='".date("Y-m-d H:i:s", strtotime("now"))."' WHERE id_pratica='$rows[id_pratica]'";
				$res3=mysql_query($sql3);
			}
	  }
?>