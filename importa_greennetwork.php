<?php 
$conn = mysql_connect("192.168.200.14", "vm1", "TJcCrCjPKqVwYjUS") or die(mysql_error());
mysql_select_db("migliorsorriso-1", $conn) or die(mysql_error());
$sql="SELECT * FROM TABLE38 WHERE CodiceFiscale NOT IN (SELECT cf FROM greennetwork)";

$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

 $sql1="INSERT INTO greennetwork (cf, cod_cliente) VALUES ('$rows[CodiceFiscale]','$rows[CodiceCliente]')";
 echo $sql1;

 $res1=mysql_query($sql1);

}
?>