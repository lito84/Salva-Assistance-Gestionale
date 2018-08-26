<?php include("includes/mysql.inc.php");

$sql="SELECT * FROM anagraficastruttura WHERE RagioneSocialeStruttura LIKE '%Mcfit%'";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$sql1="INSERT INTO servizi_strutture_migliorsalute (id_struttura, id_servizio) VALUES ('$rows[IdAnagraficaStruttura]','013147')";
	$res1=mysql_query($sql1);

}
?>