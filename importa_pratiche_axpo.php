<?php 
require("includes/auth.inc.php");
require("includes/mysql.inc.php");
require("includes/parameters.php");


$sql="SELECT * FROM pratiche_old WHERE Agente LIKE 'AXPO%' AND processato='0' LIMIT 0,2500";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)):

	$nome=$rows["Nome"];
	$cognome=$rows["Cognome"];
	$codice_fiscale=$rows["CodiceFiscale"];
	$email=$rows["Email"];
	$comune=addslashes($rows["Comune"]);

	$sql1="SELECT cod_catastale FROM comuni_2017 WHERE comune LIKE '%$comune%'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
	$comune=$rows1["cod_catastale"];

	
	
	$provincia=addslashes($rows["Provincia"]);
	
	$sql1="SELECT pr FROM istat_pr WHERE den_provincia='$provincia' OR den_provincia_alias='$provincia'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
	$provincia=$rows1["pr"];

	$codice_attivazione=$rows["CodiceAttivazione"];
	$data_inserimento=date("Y-m-d H:i", strtotime($rows["DataInserimento"]));
	$data_scadenza=date("Y-m-d H:i", strtotime($rows["Scadenza"]));

	

	//Controllo esistenza cliente

	$sql2="SELECT * FROM clienti WHERE codicefiscale='$codice_fiscale'";
	$res2=mysql_query($sql2);
	if(mysql_num_rows($res2)>0){
		$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);
		$id_cliente=$rows2["id_cliente"];
	}else{
		$sql3="INSERT INTO clienti (nome, cognome, codicefiscale, email, citta, prov) VALUES ('".addslashes($nome)."','".addslashes($cognome)."', '".addslashes($codice_fiscale)."','".addslashes($email)."','".$comune."','$provincia')";
		$res3=mysql_query($sql3);
		$id_cliente=mysql_insert_id();

		
	}

	$sql4="INSERT INTO pratiche (id_cliente, id_prodotto_convenzione, data_inserimento, codice_attivazione, data_attivazione, data_scadenza, pagato, attivo) VALUES ('$id_cliente','62','$data_inserimento','$codice_attivazione','$data_inserimento','$data_scadenza','1','1')";
	$res4=mysql_query($sql4);

	
	$sql5="UPDATE pratiche_old SET processato='1' WHERE IDPratica='$rows[IDPratica]'";
	$res5=mysql_query($sql5);

endwhile;	
?>