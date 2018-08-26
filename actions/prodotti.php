<?php require("../includes/mysql.inc.php");
	  require("../includes/parameters.php");

if($_POST["action"]=="inserisci"){
	$sql="INSERT INTO prodotti (prodotto, categoria) VALUES ('$_POST[prodotto]','$_POST[categoria]')";
	$res=mysql_query($sql);

	$id=mysql_insert_id();
	echo $id;
	
	exit;
}


if($_POST["action"]=="nuova_tariffa"){
	$_POST["prezzo"]=str_replace(",",".", $_POST["prezzo"]);
	
	$sql="INSERT INTO tariffario (id_prodotto_convenzione, mesi, prezzo) VALUES ('$_POST[id_convenzione_prodotto]','$_POST[mesi]','$_POST[prezzo]')";
	if($res=mysql_query($sql)) echo "OK";
	exit;
}

if($_POST["action"]=="elimina_tariffa"){

	$sql="DELETE FROM  tariffario WHERE id_tariffario='$_POST[id_tariffario]'";
	if($res=mysql_query($sql)) echo "OK";
	exit;
}


if($_POST["action"]=="nuovo_meta"){

	if($_POST["nuova_chiave"]!="") $chiave=addslashes($_POST["nuova_chiave"]); else $chiave=addslashes($_POST["chiave"]);
	if($_POST["colore"]!="") $valore=addslashes($_POST["colore"]); else $valore=addslashes($_POST["valore"]);
	$sql="INSERT INTO prodotti_meta (id_prodotto, chiave, valore) VALUES ('$_POST[id_prodotto]','$chiave','$valore')";
	$res=mysql_query($sql);

	exit;
}

if($_POST["action"]=="logo"){
	$chiave=addslashes($_POST["chiave"]);
	 $valore=addslashes($_POST["valore"]);
	 $sql0="DELETE FROM prodotti_convenzione_meta_pdf WHERE chiave='$chiave' AND id_prodotto_convenzione='$_POST[id_prodotto_convenzione]'";
	 $res0=mysql_query($sql0);
	 
	 
	$sql="INSERT INTO prodotti_convenzione_meta_pdf (id_prodotto_convenzione, chiave, valore) VALUES ('$_POST[id_prodotto_convenzione]','$chiave','$valore')";
	$res=mysql_query($sql);

	exit;
}

if($_POST["action"]=="modello"){

	$sql="INSERT INTO prodotti_meta (id_prodotto, chiave, valore) VALUES ('$_POST[id_prodotto]','Modello','$_POST[file]')";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="immagine"){

	$sql="INSERT INTO prodotti_meta (id_prodotto, chiave, valore) VALUES ('$_POST[id_prodotto]','Immagine','$_POST[file]')";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="immagine_convenzione"){
	$sql0="DELETE FROM prodotti_convenzione_meta WHERE chiave='Immagine' AND id_prodotto_convenzione='$_POST[id_prodotto]'";
	$res0=mysql_query($sql0);
	$sql="INSERT INTO prodotti_convenzione_meta (id_prodotto_convenzione, chiave, valore) VALUES ('$_POST[id_prodotto]','Immagine','$_POST[file]')";
	$res=mysql_query($sql);
	exit;
}

if($_POST["action"]=="modello_convenzione"){

	$sql0="DELETE FROM prodotti_convenzione_meta WHERE chiave='Modello' AND id_prodotto_convenzione='$_POST[id_prodotto]'";
	$res0=mysql_query($sql0);
	$sql="INSERT INTO prodotti_convenzione_meta (id_prodotto_convenzione, chiave, valore) VALUES ('$_POST[id_prodotto]','Modello','$_POST[file]')";
	$res=mysql_query($sql);
	echo $sql;
	exit;
}

if($_POST["action"]=="card_convenzione"){

	$sql0="DELETE FROM prodotti_convenzione_meta WHERE chiave='Card' AND id_prodotto_convenzione='$_POST[id_prodotto]'";
	$res0=mysql_query($sql0);
	$sql="INSERT INTO prodotti_convenzione_meta (id_prodotto_convenzione, chiave, valore) VALUES ('$_POST[id_prodotto]','Card','$_POST[file]')";
	$res=mysql_query($sql);
	echo $sql;
	exit;
}


if($_POST["action"]=="valore"){

	$sql="UPDATE prodotti_meta SET valore ='".addslashes($_POST['valore'])."' WHERE id_prodotto_meta='$_POST[id]'";
	$res=mysql_query($sql);

	exit;
}

if($_POST["action"]=="chiave"){

	$sql="UPDATE prodotti_meta SET chiave ='".addslashes($_POST['chiave'])."' WHERE id_prodotto_meta='$_POST[id]'";
	$res=mysql_query($sql);

	exit;
}

if($_POST["action"]=="rimuovi_meta"){

	$sql="DELETE FROM prodotti_meta WHERE id_prodotto_meta='$_POST[id]'";
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


if($_POST["action"]=="pacchetto"){

	if($_POST["selezione"]=='0'){
		$sql="DELETE FROM prodotti_meta WHERE id_prodotto='$_POST[id_prodotto]' AND chiave = '$_POST[tipo]' AND valore='$_POST[valore]'";
	}else{
		$sql="INSERT INTO prodotti_meta (id_prodotto, chiave, valore) VALUES ('$_POST[id_prodotto]','$_POST[tipo]','$_POST[valore]')";
	}
	$res=mysql_query($sql);
	exit;
}
?>
