<?php 
require("includes/auth.inc.php");
require("includes/mysql.inc.php");
require("includes/parameters.php");
require("PHPMailer/class.phpmailer.php"); // Gestione email 
require("PHPMailer/class.smtp.php"); // Gestione email 
require_once 'libraries/PHPExcel.php';
require_once 'libraries/PHPExcel/IOFactory.php';
require_once 'libraries/PHPExcel/Writer/Excel2007.php';


function generateRandomString($length = 11) {
    $characters = '123456789BCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

			$id_pratica='0000173417';

						$sql0="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, utenti.nome AS agente, clienti.email AS email, convenzioni_prodotti.id_prodotto AS idProdotto FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE pratiche.id_pratica='$id_pratica'";



						$res0=mysql_query($sql0);
						

					$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);
					//$data_attivazione=$rows0["data_scadenza"];
					$data_attivazione=date("Y-m-d H:i", strtotime("now"));
					$codice_attivazione=$rows0["codice_attivazione"];

					$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$id_convenzione_prodotto' AND chiave='Validita'";
					$res1=mysql_query($sql1);
					$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
					$mesi=$rows1["valore"];

					$data_scadenza=date("Y-m-d H:i", strtotime($data_attivazione." +".$mesi." months"));

					$id_pratica=$rows0["id_pratica"];

					$sqlr="UPDATE pratiche SET tipologia='R', data_attivazione='$data_attivazione', data_scadenza='$data_scadenza' WHERE id_pratica='$id_pratica'"; //Aggiorno le date pratica
					$resr=mysql_query($sqlr);
					//Inserisco il record con stato pagato e attivo riferito al codice pratica corrente
					$sql2="INSERT INTO pratiche (id_prodotto_convenzione, data_inserimento, data_scadenza, pagato, attivo, user_agent, codice_attivazione_master) VALUES ('$id_convenzione_prodotto', '".date("Y-m-d H:i", strtotime("now"))."','$data_scadenza','1','1','".$_SERVER['HTTP_USER_AGENT']."','$codice_attivazione')";
					$res2=mysql_query($sql2);

					$id_pratica_new=mysql_insert_id();
					$id_pratica_new=str_pad($id_pratica_new,10,"0", STR_PAD_LEFT);
					$codice_attivazione_new = generateRandomString(6).substr($id_pratica_new,5,5);

					//Aggiorno la pratica inserendo il codice attivazione 
					$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione_new' WHERE id_pratica = '$id_pratica_new'";
					$res3=mysql_query($sql3);


						

					$sql0="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, utenti.nome AS agente, clienti.email AS email, convenzioni_prodotti.id_prodotto AS idProdotto FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE pratiche.id_pratica='$id_pratica'";

					$res0=mysql_query($sql0);
					$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);
					
					$sqlp="SELECT *, prodotti_categorie.categoria AS categoriaProdotto FROM prodotti LEFT JOIN prodotti_categorie ON prodotti_categorie.id_categoria = prodotti.categoria WHERE id_prodotto = '$rows0[idProdotto]'";
					$resp=mysql_query($sqlp);
					$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

					$prodotto = utf8_encode($rowsp["prodotto"]." ".$rowsp["categoriaProdotto"]);

					$sql2="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$rows0[id_convenzione_prodotto]' AND chiave='Validita'";
					$res2=mysql_query($sql2);
					$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);

					$data_scadenza=date("Y-m-d H:i", strtotime("now +".$rows2["valore"]." months"));

					$messaggio=utf8_decode($rows0["testo_mail_rinnovo"]);

					$campi=array("{CLIENTE}","{PRODOTTO}","{LINK}","{CODICEATTIVAZIONE}");
				
					$link="http://www.migliorsalute.it/download.php?codice_attivazione=".$rows0["codice_attivazione"];

					$valori=array(stripslashes($rows0["cognome"]." ".$rows0["nome"]),$prodotto, $link,$codice_attivazione_new);
				
					$messaggio=str_replace($campi,$valori,$messaggio);

					$p_smtp_server="93.93.203.180";
					$p_smtp_user="web1_migliorsalute";
					$p_smtp_password="msal2015";
					$p_smtp_mittente="Migliorsalute";
					$p_smtp_mittente_email="info@migliorsalute.it";
					
					$mail=new PHPMailer();
					$mail->IsSMTP();
					$mail->SMTPAuth = true; // turn on SMTP authentication
					$mail->Username = $p_smtp_user; // SMTP username
					$mail->Password = $p_smtp_password; // SMTP password
					$mail->Host=$p_smtp_server;
					$mail->From=$p_smtp_mittente_email;
					$mail->FromName=$p_smtp_mittente;
					$mail->MsgHTML($messaggio);

					$mail->AltBody=strip_tags(html_entity_decode($messaggio));
					$mail->Subject="La tua Card MigliorSalute";
					//$mail->AddAddress($rows0["email"], stripslashes($rows0["nome"]." ".$rows0["cognome"]));

					$mail->AddAddress("dentalcard@axpo.com", stripslashes($rows0["nome"]." ".$rows0["cognome"]));
					$mail->AddAddress("sergio@migliorsalute.it", stripslashes($rows0["nome"]." ".$rows0["cognome"]));
					
					if ($mail->Send()) {
						$mail->ClearAddresses();
					}
						

								
			
			
?>