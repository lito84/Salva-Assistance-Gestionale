<?php 
require("includes/mysql.inc.php");
require("includes/parameters.php");

$sql="SELECT * FROM myrete";

$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

	$struttura=addslashes($rows["struttura"]);
	$indirizzo=addslashes($rows["indirizzo"]);
	$citta=addslashes($rows["comune"]);
	$pr=$rows["prov"];
	$cap=$rows["cap"];
	$telefono=$rows["tel"];
	

	$sql1="INSERT INTO anagrafica_da_confermare (struttura, citta, cap, pr, indirizzo, telefono, provenienza, stato) VALUES ('$struttura','$citta','$cap','$pr','$indirizzo','$telefono','MyRete','Da contattare')";


	$res1=mysql_query($sql1);
	$id=mysql_insert_id();


}
?>