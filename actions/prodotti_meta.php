<?php require("../includes/mysql.inc.php");
	  require("../includes/parameters.php");

if($_POST["action"]=="nuovo_meta"){

	if($_POST["nuova_chiave"]!="") $chiave=addslashes($_POST["nuova_chiave"]); else $chiave=addslashes($_POST["chiave"]);
	$valore=addslashes($_POST["valore"]);
	$sql="INSERT INTO prodotti_convenzione_meta (id_prodotto_convenzione, chiave, valore) VALUES ('$_POST[id_convenzione_prodotto]','$chiave','$valore')";
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="modello_mail"){

	$sql="UPDATE convenzioni_prodotti SET testo_mail_prodotto='".addslashes($_POST[testo_mail_prodotto_convenzione])."' WHERE id_convenzione_prodotto='$_POST[id_convenzione_prodotto]'";
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="modello_rinnovo"){

	$sql="UPDATE convenzioni_prodotti SET testo_mail_rinnovo='".addslashes($_POST[testo_mail_prodotto_convenzione_rinnovo])."' WHERE id_convenzione_prodotto='$_POST[id_convenzione_prodotto]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="modello_prenotazione"){

	$sql="UPDATE convenzioni_prodotti SET testo_mail_prenotazione='".addslashes($_POST[testo_mail_prodotto_convenzione_prenotazione])."' WHERE id_convenzione_prodotto='$_POST[id_convenzione_prodotto]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="modello_codice"){

	$sql="UPDATE convenzioni_prodotti SET testo_mail_invio_codice='".addslashes($_POST[testo_mail_prodotto_convenzione_invio_codice])."' WHERE id_convenzione_prodotto='$_POST[id_convenzione_prodotto]'";
	$res=mysql_query($sql);
	exit;
}


if($_POST["action"]=="valore"){

	$sql="UPDATE prodotti_convenzione_meta SET valore ='".addslashes(utf8_encode($_POST['valore']))."' WHERE id_prodotto_meta='$_POST[id]'";
	$res=mysql_query($sql);

	exit;
}
if($_POST["action"]=="chiave"){

	$sql="UPDATE prodotti_convenzione_meta SET chiave ='".addslashes($_POST['chiave'])."' WHERE id_prodotto_meta='$_POST[id]'";
	$res=mysql_query($sql);

	exit;
}
if($_POST["action"]=="rimuovi_meta"){

	$sql="DELETE FROM prodotti_convenzione_meta WHERE id_prodotto_meta='$_POST[id]'";
	$res=mysql_query($sql);

	exit;
}
if($_POST["action"]=="modifica"){
	$prodotto=addslashes($_POST["prodotto"]);
	$categoria=addslashes($_POST["categoria"]);
	$sql="UPDATE prodotti SET prodotto='$prodotto', categoria='$categoria' WHERE id_prodotto='$_POST[id_prodotto]'";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="aggiungi_struttura"){

	$sql="INSERT INTO prodotti_convenzione_meta (id_prodotto_convenzione, chiave, valore) VALUES ('$_POST[id_prodotto]','id_struttura','$_POST[struttura]')";
	$res=mysql_query($sql);

	exit;
}

if($_POST["action"]=="rimuovi_struttura"){

	$sql="DELETE FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_POST[id_prodotto]' AND  chiave='id_struttura' AND  valore='$_POST[struttura]'";
	$res=mysql_query($sql);

	exit;
}

if($_POST["action"]=="pacchetto"){

	if($_POST["selezione"]=='0'){
		$sql="DELETE FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_POST[id_convenzione_prodotto]' AND chiave = '$_POST[tipo]' AND valore='$_POST[valore]'";
	}else{
		$sql="INSERT INTO prodotti_convenzione_meta (id_prodotto_convenzione, chiave, valore) VALUES ('$_POST[id_convenzione_prodotto]','$_POST[tipo]','$_POST[valore]')";
	}
	$res=mysql_query($sql);
	exit;
}

?>
