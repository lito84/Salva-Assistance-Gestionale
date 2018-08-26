<?php 
require("includes/mysql.inc.php");
require("includes/parameters.php");
require("PHPMailer/class.phpmailer.php"); // Gestione email 
require("PHPMailer/class.smtp.php"); // Gestione email 
require_once 'libraries/PHPExcel.php';
require_once 'libraries/PHPExcel/IOFactory.php';
require_once 'libraries/PHPExcel/Writer/Excel2007.php';

$sql="SELECT * 
FROM  `convenzioni_old` ";

$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

	$codice=addslashes(utf8_encode($rows["CodiceCompleto"]));
	$descrizione=addslashes(utf8_encode($rows["Descrizione"]));
	$id_utente=addslashes(utf8_encode($rows["IDUtente"]));
	
	$sql1="INSERT INTO convenzioni (id_utente, codice_convenzione, descrizione) VALUES ('$id_utente','$codice','$descrizione')";

	echo $sql1;

	if($res1=mysql_query($sql1)){
		$id=mysql_insert_id();

		$sql2="UPDATE convenzioni_old SET nuovo_id_convenzione='$id' WHERE IDCoupon = '$rows[IDCoupon]'";
		$res2=mysql_query($sql2);

	}


/*	$sql1="SELECT nuovo_id FROM agenti_old WHERE IDUtente = '$rows[IDUtente]'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
	
	$sql2="UPDATE convenzioni_old SET IDUtente='$rows1[nuovo_id]' WHERE IDCoupon='$rows[IDCoupon]'";
	$res2=mysql_query($sql2);*/

}
?>