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
if($_POST["action"]=="importa_pratiche"){

$inputFileName="uploads/importazioni/files/".$_POST["file"];
	//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
    . '": ' . $e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
for ($row = 2; $row <= $highestRow; $row++) {
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'AG' . $row, 
    NULL, TRUE, FALSE);
    $pratica=array();
	foreach($rowData[0] as $k=>$v){
        array_push($pratica,$v);
	}
	if($pratica[6]!=NULL) {

		$nome=$pratica[2];
		$cognome=$pratica[3];
		$tipo=$pratica[5];
		$codicefiscale=$pratica[6];
		$cap=$pratica[7];
		$indirizzo=$pratica[8];
		$citta=$pratica[9];
		$email=$pratica[11];
		
		$nome_ben=$pratica[12];
		$cognome_ben=$pratica[13];
		$cf_ben=$pratica[14];

		$nome_ben2=$pratica[15];
		$cognome_ben2=$pratica[16];
		$cf_ben2=$pratica[17];

		$nome_ben3=$pratica[18];
		$cognome_ben3=$pratica[19];
		$cf_ben3=$pratica[20];

		$nome_ben4=$pratica[21];
		$cognome_ben4=$pratica[22];
		$cf_ben4=$pratica[23];
		
		$nome_ben5=$pratica[24];
		$cognome_ben5=$pratica[25];
		$cf_ben5=$pratica[26];

		$nome_ben6=$pratica[27];
		$cognome_ben6=$pratica[28];
		$cf_ben6=$pratica[29];

	
		$nome_ben7=$pratica[30];
		$cognome_ben7=$pratica[31];
		$cf_ben7=$pratica[32];

		$sqlcheck="SELECT * ";
		$sqlcheck.="FROM clienti ";
		$sqlcheck.="WHERE clienti.codicefiscale='".trim(strtoupper($codicefiscale))."'";

		$rescheck=mysql_query($sqlcheck);
		$rowscheck=mysql_fetch_array($rescheck,MYSQL_ASSOC);
		$numcheck=mysql_num_rows($rescheck);
		
		$sql1="SELECT * FROM comuni_gl WHERE comune = '".addslashes($citta)."'";
		$res1=mysql_query($sql1);
		$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
		$citta=$rows1["cod_istat"];


		if($numcheck==0){ //Azienda non esistente in anagrafica
			$sql="INSERT INTO clienti (
				cognome,
				nome,
				codicefiscale,
				indirizzo,
				citta,
				cap,
				email,
				tipo
				) VALUES ( ";
		
		$sql.="'".trim(addslashes($cognome))."','".trim(addslashes($nome))."','".trim(addslashes($codicefiscale))."','".trim(addslashes($indirizzo))."','".trim(addslashes($citta))."','".trim(strtoupper($cap))."','".trim(addslashes($email))."','".trim(addslashes($tipo))."')";
			
			$res=mysql_query($sql);
			$aff=mysql_affected_rows();
			$id=mysql_insert_id();
			
			if($aff) $count++;
		}else{ //Aggiornamento anagrafica azienda
			
			$sql0="SELECT id_cliente FROM clienti WHERE codicefiscale='".trim(addslashes($codicefiscale))."'";
			$res0=mysql_query($sql0);
			$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);

			$sql="UPDATE clienti SET cognome='".trim(addslashes($cognome))."', nome='".trim(addslashes($nome))."', indirizzo='".trim(addslashes($indirizzo))."', citta='".trim(addslashes($citta))."', cap='".trim(addslashes($cap))."', email='".trim(addslashes($email))."' WHERE codicefiscale='".trim(addslashes($codicefiscale))."'";
			$res=mysql_query($sql);	

			$id=$rows0["id_cliente"];
		}
		
		//Dati prodotto

		$id_convenzione_prodotto=$_POST["id_convenzione_prodotto"];




		$sqlx="SELECT * FROM pratiche WHERE id_cliente = '$id' AND id_prodotto_convenzione='$id_convenzione_prodotto' ORDER BY data_scadenza DESC";
		$resx=mysql_query($sqlx);

		if(mysql_num_rows($resx)==0){ // Nuova pratica

				$sql="SELECT *, convenzioni_prodotti.id_convenzione AS idConvenzione FROM convenzioni_prodotti LEFT JOIN convenzioni ON convenzioni_prodotti.id_convenzione = convenzioni.id_convenzione LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto='$_POST[id_convenzione_prodotto]'";
				$res=mysql_query($sql);
				$rows=mysql_fetch_array($res, MYSQL_ASSOC);

				$id_convenzione=$rows["idConvenzione"];
				$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_POST[id_convenzione_prodotto]' AND chiave='Validita'";
				$res1=mysql_query($sql1);
				$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

				$mesi=$rows1["valore"];

				$data_scadenza=date("Y-m-d H:i", strtotime("now +".$mesi." months"));
				//Generazione record pratica

				//Inserisco il record con stato non pagato e attivo
				$sql2="INSERT INTO pratiche (id_cliente, id_prodotto_convenzione, data_inserimento, data_scadenza, data_attivazione, pagato, attivo, user_agent) VALUES ('$id', '$id_convenzione_prodotto', '".date("Y-m-d H:i", strtotime("now"))."','$data_scadenza','".date("Y-m-d H:i", strtotime("now"))."','1','1','".$_SERVER['HTTP_USER_AGENT']."')";
				$res2=mysql_query($sql2);


				$id_pratica=mysql_insert_id();
				$id_pratica=str_pad($id_pratica,10,"0", STR_PAD_LEFT);

				if($nome_ben!=""){

					$sqlint="INSERT INTO beneficiari (id_pratica, nome, cognome) VALUES ('$id_pratica', '$nome_ben', '$cognome_ben' )";
					$resint=mysql_query($sqlint);
					
				}

				if($nome_ben2!=""){

					$sqlint="INSERT INTO beneficiari (id_pratica, nome, cognome) VALUES ('$id_pratica', '$nome_ben2', '$cognome_ben2' )";
					$resint=mysql_query($sqlint);
					
				}

				if($nome_ben3!=""){

					$sqlint="INSERT INTO beneficiari (id_pratica, nome, cognome) VALUES ('$id_pratica', '$nome_ben3', '$cognome_ben3' )";
					$resint=mysql_query($sqlint);
					
				}

				if($nome_ben4!=""){

					$sqlint="INSERT INTO beneficiari (id_pratica, nome, cognome) VALUES ('$id_pratica', '$nome_ben4', '$cognome_ben4' )";
					$resint=mysql_query($sqlint);
					
				}

				if($nome_ben5!=""){

					$sqlint="INSERT INTO beneficiari (id_pratica, nome, cognome) VALUES ('$id_pratica', '$nome_ben5', '$cognome_ben5' )";
					$resint=mysql_query($sqlint);
					
				}

				if($nome_ben6!=""){

					$sqlint="INSERT INTO beneficiari (id_pratica, nome, cognome) VALUES ('$id_pratica', '$nome_ben6', '$cognome_ben6' )";
					$resint=mysql_query($sqlint);
					
				}

				if($nome_ben7!=""){

					$sqlint="INSERT INTO beneficiari (id_pratica, nome, cognome) VALUES ('$id_pratica', '$nome_ben7', '$cognome_ben7' )";
					$resint=mysql_query($sqlint);
					
				}

				//Genero il codice di attivazione come stringa radom da 5 + id_pratica

				$codice_attivazione = generateRandomString(6).substr($id_pratica,5,5);

				//Aggiorno la pratica inserendo il codice attivazione 
				$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione' WHERE id_pratica = '$id_pratica'";
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

						$messaggio=utf8_decode($rows0["testo_mail_prodotto"]);
						

						$campi=array("{CLIENTE}","{PRODOTTO}","{LINK}");
					
						$link="http://www.migliorsalute.it/download.php?codice_attivazione=".$rows0["codice_attivazione"];

						$valori=array(stripslashes($rows0["cognome"]." ".$rows0["nome"]),$prodotto, $link);
								
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
							$mail->Subject="Il tuo acquisto Miglior Salute";


							$mail->AddAddress($rows0["email"], stripslashes($rows0["nome"]." ".$rows0["cognome"]));
							if ($mail->Send()) {
								$mail->ClearAddresses();
							}

				}else{ //Rinnovo

					$rows0=mysql_fetch_array($resx, MYSQL_ASSOC);
					//$data_attivazione=$rows0["data_scadenza"];
					$data_attivazione=date("Y-m-d H:i", strtotime($rows0["data_scadenza"]));
					$data_inserimento=date("Y-m-d H:i", strtotime("now"));
					$codice_attivazione=$rows0["codice_attivazione"];

					$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$id_convenzione_prodotto' AND chiave='Validita'";
					$res1=mysql_query($sql1);
					$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
					$mesi=$rows1["valore"];


					$data_attivazione=$data_inserimento;
					$data_scadenza=date("Y-m-d H:i", strtotime($data_attivazione." +".$mesi." months"));

					$id_pratica=$rows0["id_pratica"];

					$sqlr="UPDATE pratiche SET tipologia='R' WHERE id_pratica='$id_pratica'"; //Aggiorno le date pratica
					$resr=mysql_query($sqlr);
					//Inserisco il record con stato pagato e attivo riferito al codice pratica corrente
					$sql2="INSERT INTO pratiche (id_prodotto_convenzione, id_cliente, data_inserimento, data_attivazione, data_scadenza, pagato, attivo, user_agent, codice_attivazione_master) VALUES ('$id_convenzione_prodotto','$rows0[id_cliente]', '$data_inserimento','$data_attivazione','$data_scadenza','1','1','".$_SERVER['HTTP_USER_AGENT']."','$codice_attivazione')";
					$res2=mysql_query($sql2);

					$id_pratica_new=mysql_insert_id();
					$id_pratica_new=str_pad($id_pratica_new,10,"0", STR_PAD_LEFT);
					$codice_attivazione_new = generateRandomString(6).substr($id_pratica_new,5,5);

					//Aggiorno la pratica inserendo il codice attivazione 
					$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione_new' WHERE id_pratica = '$id_pratica_new'";
					$res3=mysql_query($sql3);


					//Secondo codice AXPO

					if($rows0["id_prodotto_convenzione"]=="000062"){

						$sql2="INSERT INTO pratiche (id_prodotto_convenzione, data_inserimento, pagato, attivo, user_agent) VALUES ('$id_convenzione_prodotto', '".date("Y-m-d H:i", strtotime("now"))."','1','1','".$_SERVER['HTTP_USER_AGENT']."')";
						$res2=mysql_query($sql2);

						$id_pratica_secondo=mysql_insert_id();
						$id_pratica_secondo=str_pad($id_pratica_secondo,10,"0", STR_PAD_LEFT);
						$codice_attivazione_secondo = generateRandomString(6).substr($id_pratica_secondo,5,5);

						//Aggiorno la pratica inserendo il codice attivazione 
						$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione_secondo', secondo_codice='$codice_attivazione_new' WHERE id_pratica = '$id_pratica_secondo'";
						$res3=mysql_query($sql3);


					}

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
				
					$link="http://www.migliorsalute.it/download.php?codice_attivazione=".$codice_attivazione_new;

					$valori=array(stripslashes($rows0["cognome"]." ".$rows0["nome"]),$prodotto, $link,$codice_attivazione_secondo);
				
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
					$mail->AddAddress($rows0["email"], stripslashes($rows0["nome"]." ".$rows0["cognome"]));
					if ($mail->Send()) {
						$mail->ClearAddresses();
					}
						

								
				}//Fine Rinnovo	
			
				$count++;
	}
}

}	
?>