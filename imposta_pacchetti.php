<?php 
require("includes/mysql.inc.php");

$sql="SELECT * 
FROM  `anagraficastruttura` 
WHERE Provenienza =  'Synlab'
AND IdAnagraficaStruttura NOT 
IN (

SELECT id_struttura
FROM circuiti_strutture
WHERE id_circuito =  '1'
)";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$sql1="INSERT INTO circuiti_strutture (id_circuito,id_struttura) VALUES ('01', '$rows[IdAnagraficaStruttura]')";
	$res1=mysql_query($sql1);

	$sql2="UPDATE anagraficastruttura SET Provenienza = 'Innova' WHERE IdAnagraficaStruttura='$rows[IdAnagraficaStruttura]'";
	$res2=mysql_query($sql2);
}
?>