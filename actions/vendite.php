<?php 
require("../libraries/func.getinclude.php"); 
include("../includes/mysql.inc.php");
include("../includes/auth.inc.php");

function generateRandomString($length = 11) {
    $characters = '123456789BCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

     
if($_POST["action"]=="attivazione_pratica"){
	$now=date("Y-m-d H:i:s", strtotime("now"));
		$sql="UPDATE pratiche SET attivo='1', data_attivazione = '$now' WHERE codice_attivazione='$_POST[codice_attivazione]'";
		$res=mysql_query($sql);
	
	exit;
}

if($_POST["action"]=="richiesta_eliminazione"){
	
		$sql="UPDATE pratiche SET richiesta_eliminazione='1' WHERE codice_attivazione='$_POST[codice_attivazione]'";
		$res=mysql_query($sql);
	
	exit;
}


if($_POST["action"]=="elimina_admin"){
	
	$sql="DELETE FROM pratiche WHERE codice_attivazione='$_POST[codice_attivazione]'";
	$res=mysql_query($sql);
	$sql1="DELETE FROM decadi_pratiche WHERE codice_pratica='$_POST[codice_attivazione]'";
	$res1=mysql_query($sql1);
	exit;
}


if($_POST["action"]=="attiva"){
	if($_POST["stampa_prodotto"]):
		$sql="UPDATE pratiche SET attivo = '1' WHERE codice_attivazione='$_POST[codice_attivazione]'";
		$res=mysql_query($sql);
	endif;
	exit;
}


if($_POST["action"]=="carica_contratto"){

		$sql="UPDATE pratiche SET contratto = '$_POST[contratto]' WHERE codice_attivazione='$_POST[codice_attivazione]'";
		$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="stampa"){
	$now=date("Y-m-d H:i:s", strtotime("now"));
	
	$sql="UPDATE pratiche SET data_stampa = '$now' WHERE codice_attivazione='$_POST[codice_attivazione]'";
	$res=mysql_query($sql);
	
	$sql1="INSERT INTO decadi_pratiche (codice_decade, codice_pratica) VALUES ('$_SESSION[decade]','$_POST[codice_attivazione]')";
	$res1=mysql_query($sql1);

	$sql0="SELECT secondo_codice FROM pratiche WHERE codice_attivazione='$_POST[codice_attivazione]'";
	$res0=mysql_query($sql0);
	$rows0=mysql_fetch_array($res0, MYSQL_ASSOC);
	if($rows0["secondo_codice"]!=""): // Prodotto composto, aggiorno anche la pratica collegata con la data di stampa
		
		$sql="UPDATE pratiche SET data_stampa = '$now' WHERE codice_attivazione='$rows0[secondo_codice]'";
		$res=mysql_query($sql);
		
		$sql1="INSERT INTO decadi_pratiche (codice_decade, codice_pratica) VALUES ('$_SESSION[decade]','$rows0[secondo_codice]')";
		$res1=mysql_query($sql1);
	endif;
	exit;
}


if($_POST["action"]=="crea_pratica"){
	$nome=addslashes($_POST["nome"]);
	$cognome=addslashes($_POST["cognome"]);
	$datanascita=addslashes($_POST["datanascita"]);
	$nascita=addslashes($_POST["nascita"]);
	$sesso=addslashes(strtoupper($_POST["sesso"]));

	$passaporto=addslashes(strtoupper($_POST["passaporto_val"]));
	$visto=addslashes(strtoupper($_POST["visto_val"]));

	$provenienza=addslashes($_POST["provenienza"]);
	$codicefiscale=addslashes($_POST["codicefiscale"]);

	$documento=addslashes($_POST["documento"]);
	$numero_documento=addslashes($_POST["numero_documento"]);
	$data_documento=addslashes(strtoupper($_POST["data_documento"]));

	$nome_invitante=addslashes($_POST["nome_invitante"]);
	$cognome_invitante=addslashes($_POST["cognome_invitante"]);
	$datanascita_invitante=addslashes($_POST["datanascita_invitante"]);
	$nascita_invitante=addslashes($_POST["nascita_invitante"]);
	$sesso_invitante=addslashes(strtoupper($_POST["sesso_invitante"]));
	$codicefiscale_invitante=addslashes($_POST["codicefiscale_invitante"]);
	$viadomicilio_invitante=addslashes($_POST["viadomicilio_invitante"]);
	$domicilio_invitante=addslashes($_POST["domicilio_invitante"]);
	$capdomicilio_invitante=addslashes($_POST["capdomicilio_invitante"]);
	$email=addslashes($_POST["email"]);
	$telefono=addslashes($_POST["telefono"]);
	$prezzo=addslashes($_POST["prezzo"]);
	//$validita=addslashes($_POST["validita"]);

	$validita=12;
	$copertura=addslashes($_POST["copertura"]);

	$id_utente=addslashes($_POST["id_utente"]);
	$data_effetto=addslashes($_POST["data_effetto"]);

	$id_convenzione_prodotto=addslashes($_POST["id_convenzione_prodotto"]);

	$sql="SELECT * FROM clienti WHERE codicefiscale='$codicefiscale' AND codicefiscale<> ''";
	$res=mysql_query($sql);
	if($num=mysql_num_rows($res)==0){

		//Inserisco il nuovo cliente

		$sql1="INSERT INTO clienti (
			cognome,
			nome,
			sesso,
			codicefiscale,
			data_nascita,
			luogo_nascita,
			provenienza,
			documento,
			numero_documento,
			data_documento,
			passaporto,
			visto

		) VALUES (
			'$cognome',
			'$nome',
			'$sesso',
			'$codicefiscale',
			'$datanascita',
			'$nascita',
			'$provenienza',
			'$documento',
			'$numero_documento',
			'$data_documento',
			'$passaporto',
			'$visto'
		)";
		$res1=mysql_query($sql1);
		$id=mysql_insert_id();
	}else{ //Aggiorno il cliente 
		$rows=mysql_fetch_array($res, MYSQL_ASSOC);

		$sql1="UPDATE clienti SET 
			cognome='$cognome',
			nome='$nome',
			sesso='$sesso',
			codicefiscale='$codicefiscale',
			data_nascita='$datanascita',
			luogo_nascita='$nascita',
			provenienza='$provenienza',
			documento='$documento',
			numero_documento='$numero_documento',
			data_documento='$data_documento',
			passaporto='$passaporto',
			visto='$visto'
			WHERE id_cliente='$rows[id_cliente]'";		
			$res1=mysql_query($sql1);
			$id=$rows["id_cliente"];

	}

	$sql="SELECT * FROM invitanti WHERE codicefiscale='$codicefiscale_invitante' AND codicefiscale<> ''";
	$res=mysql_query($sql);
	if($num=mysql_num_rows($res)==0){

		//Inserisco il nuovo cliente

		$sql1="INSERT INTO invitanti (
			cognome,
			nome,
			sesso,
			codicefiscale,
			data_nascita,
			luogo_nascita,
			indirizzo,
			citta,
			cap,
			telefono,
			email

		) VALUES (
			'$cognome_invitante',
			'$nome_invitante',
			'$sesso_invitante',
			'$codicefiscale_invitante',
			'$datanascita_invitante',
			'$nascita_invitante',
			'$viadomicilio_invitante',
			'$domicilio_invitante',
			'$capdomicilio_invitante',
			'$telefono',
			'$email'
		)";
		$res1=mysql_query($sql1);


		$id_invitante=mysql_insert_id();
	}else{ //Aggiorno il cliente 
		$rows=mysql_fetch_array($res, MYSQL_ASSOC);

		$sql1="UPDATE invitanti SET 
			cognome='$cognome_invitante',
			nome='$nome_invitante',
			sesso='$sesso_invitante',
			codicefiscale='$codicefiscale_invitante',
			data_nascita='$datanascita_invitante',
			luogo_nascita='$nascita_invitante',
			indirizzo='$viadomicilio_invitante',
			citta='$domicilio_invitante',
			cap='$capdomicilio_invitante',
			telefono='$telefono',
			email='$email'
			WHERE id_invitante='$rows[id_invitante]'";		
			$res1=mysql_query($sql1);
			$id_invitante=$rows["id_invitante"];

	}


	if($id_convenzione_prodotto=='00004'){ // Mezzi sussistenza + Spese sanitarie

		$prodotti=array('00002','00003');
		$codici_attivazione=array();
		foreach($prodotti as $id_convenzione_prodotto){
			$codice_attivazione='';
			//Dati prodotto
				$sql="SELECT *, convenzioni_prodotti.id_convenzione AS idConvenzione, prodotti.id_prodotto AS id_prodotto FROM convenzioni_prodotti LEFT JOIN convenzioni ON convenzioni_prodotti.id_convenzione = convenzioni.id_convenzione LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto='$id_convenzione_prodotto'";
				$res=mysql_query($sql);
				$rows=mysql_fetch_array($res, MYSQL_ASSOC);
				$attivazione_immediata=$rows["attivazione_immediata"];
				$pagato='0';
				if($attivazione_immediata){
					$pagato='1';
				}
				$id_convenzione=$rows["idConvenzione"];


				$sqlp="SELECT prezzo FROM tariffario WHERE id_prodotto='$rows[id_prodotto]' AND mesi='$copertura'";
				$resp=mysql_query($sqlp);
				$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

				$prezzo=$rowsp["prezzo"];

				$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$id_convenzione_prodotto' AND chiave='Validita'";
				$res1=mysql_query($sql1);
				$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
				$mesi=$rows1["valore"];
				$data_scadenza=date("Y-m-d H:i", strtotime("now +".$mesi." months"));
				//Inserisco il record con stato non pagato e attivo
				$sql2="INSERT INTO pratiche (id_cliente, id_invitante, id_prodotto_convenzione, data_inserimento, data_effetto, data_scadenza, data_attivazione, tipo_pagamento, pagato, attivo, user_agent, importo, copertura, validita, id_agente) VALUES ('$id','$id_invitante','$id_convenzione_prodotto', '".date("Y-m-d H:i", strtotime("now"))."','$data_effetto','$data_scadenza','".date("Y-m-d H:i", strtotime("now"))."','".addslashes($pagamento)."','$pagato','0','".$_SERVER['HTTP_USER_AGENT']."','$prezzo','$validita','$copertura','$id_utente')";
				$res2=mysql_query($sql2);
				$id_pratica=mysql_insert_id();
				//$id_pratica=str_pad($id_pratica,3,"0", STR_PAD_LEFT);

				$anno=date("Y", strtotime("now"));
				$sqls="SELECT * FROM prodotti_meta WHERE id_prodotto='$rows[id_prodotto]' AND chiave='Sigla'";
				$ress=mysql_query($sqls);
				$rowss=mysql_fetch_array($ress, MYSQL_ASSOC);

				$sigla=$rowss["valore"];

				$codice_attivazione = "CSA".$sigla.$anno.generateRandomString(4).substr($id_pratica,0,3);
				//Aggiorno la pratica inserendo il codice attivazione 
				$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione' WHERE id_pratica = '$id_pratica'";
				$res3=mysql_query($sql3);
				array_push($codici_attivazione, $codice_attivazione);

				$sqlc="UPDATE pratiche SET secondo_codice='$codici_attivazione[1]' WHERE codice_attivazione='$codici_attivazione[0]'";
				$resc=mysql_query($sqlc);
				echo $codici_attivazione[0];
		}

	}else{


			//Dati prodotto
			$sql="SELECT *, convenzioni_prodotti.id_convenzione AS idConvenzione, prodotti.id_prodotto AS id_prodotto FROM convenzioni_prodotti LEFT JOIN convenzioni ON convenzioni_prodotti.id_convenzione = convenzioni.id_convenzione LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto='$id_convenzione_prodotto'";
			$res=mysql_query($sql);
			$rows=mysql_fetch_array($res, MYSQL_ASSOC);
			$attivazione_immediata=$rows["attivazione_immediata"];
			$pagato='0';
			if($attivazione_immediata){
				$pagato='1';
			}
			$id_convenzione=$rows["idConvenzione"];
			$item_name = $rows["prodotto"];
			$item_amount = str_replace(",",".",$rows["prezzo_cliente"]);
			$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$id_convenzione_prodotto' AND chiave='Validita'";
			$res1=mysql_query($sql1);
			$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
			$mesi=$rows1["valore"];
			$data_scadenza=date("Y-m-d H:i", strtotime("now +".$mesi." months"));
			//Inserisco il record con stato non pagato e attivo
			$sql2="INSERT INTO pratiche (id_cliente, id_invitante, id_prodotto_convenzione, data_inserimento, data_effetto, data_scadenza, data_attivazione, tipo_pagamento, pagato, attivo, user_agent, importo, copertura, validita, id_agente) VALUES ('$id','$id_invitante','$id_convenzione_prodotto', '".date("Y-m-d H:i", strtotime("now"))."','$data_effetto','$data_scadenza','".date("Y-m-d H:i", strtotime("now"))."','".addslashes($pagamento)."','$pagato','0','".$_SERVER['HTTP_USER_AGENT']."','$prezzo','$validita','$copertura','$id_utente')";
			$res2=mysql_query($sql2);
			$id_pratica=mysql_insert_id();
			//$id_pratica=str_pad($id_pratica,3,"0", STR_PAD_LEFT);

			$anno=date("Y", strtotime("now"));
			$sqls="SELECT * FROM prodotti_meta WHERE id_prodotto='$rows[id_prodotto]' AND chiave='Sigla'";
			$ress=mysql_query($sqls);
			$rowss=mysql_fetch_array($ress, MYSQL_ASSOC);

			$sigla=$rowss["valore"];

			$codice_attivazione = "CSA".$sigla.$anno.generateRandomString(4).substr($id_pratica,0,3);
			//Aggiorno la pratica inserendo il codice attivazione 
			$sql3="UPDATE pratiche SET codice_attivazione = '$codice_attivazione' WHERE id_pratica = '$id_pratica'";
			$res3=mysql_query($sql3);

			echo $codice_attivazione;	

	}
	exit;
}
?>