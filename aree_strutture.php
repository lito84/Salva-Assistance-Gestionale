<?php include("includes/mysql.inc.php");?>

<?php $sql="SELECT * FROM servizi_strutture_migliorsalute GROUP BY id_struttura, id_area_servizio";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$sql1="INSERT INTO aree_strutture_migliorsalute (id_struttura, id_area) VALUES ('$rows[id_struttura]','$rows[id_area_servizio]')";
	$res1=mysql_query($sql1);
}
?>