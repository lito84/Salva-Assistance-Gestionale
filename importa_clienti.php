<?php 
require("includes/mysql.inc.php");
require("includes/parameters.php");
require("includes/functions.php");

$sql="SELECT * 
FROM  clienti_old WHERE nuovo_id='' ";


$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$sql1="SELECT * FROM clienti WHERE codicefiscale = '$rows[CodiceFiscale]'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
	if(mysql_num_rows($res1)>0){
		

		$sql2="UPDATE clienti_old SET nuovo_id='$rows1[id_cliente]' WHERE IDCliente = '$rows[IDCliente]'";
		$res2=mysql_query($sql2);

	}else{
		$sql2="INSERT INTO clienti (cognome, nome, codicefiscale, data_nascita, sesso, luogo_nascita, email, telefono, citta, ragionesociale, nomereferente,cognomereferente,  partitaiva,tipo) VALUES ('".addslashes($rows["Cognome"])."','".addslashes($rows["Nome"])."','".addslashes($rows["CodiceFiscale"])."','".addslashes($rows["DataNascita"])."', '".addslashes($rows["Sesso"])."', '".addslashes(substr($rows["CodiceFiscale"], 11, 4))."', '".addslashes($rows["Email"])."', '".addslashes($rows["Telefono"])."', '".addslashes($rows["Citta"])."', '".addslashes($rows["RagioneSociale"])."', '".addslashes($rows["NomeReferente"])."', '".addslashes($rows["CognomeReferente"])."', '".addslashes($rows["PartitaIVA"])."','".addslashes($rows["TipoCliente"])."')";
		$res2=mysql_query($sql2);

		echo $sql2;

		$id=mysql_insert_id();

		$sql3="UPDATE clienti_old SET nuovo_id='$id' WHERE IDCliente = '$rows[IDCliente]'";
		$res3=mysql_query($sql3);
	}

}
?>