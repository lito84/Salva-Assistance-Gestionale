<?php 
require("includes/mysql.inc.php");
require("includes/parameters.php");

$sql="SELECT * FROM TABLE196 WHERE 1";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$telefono=str_replace("-","",$rows["telefono"]);
	$telefono=str_replace("/","",$telefono);
	$telefono=str_replace(" ","",$telefono);
	$telefono=trim($telefono);
	
		$sql2="INSERT INTO anagraficastruttura (RagioneSocialeStruttura, IndirizzoOperativaStruttura, CittaOperativaStruttura, ProvinciaOperativaStruttura, CapOperativaStruttura, RegioneStruttura, Telefono1Struttura, migliorsorriso, migliorsalute, Provenienza) VALUES ('".addslashes($rows["ragionesociale"])."','".addslashes($rows["indirizzo"])."','".addslashes($rows["citta"])."','$rows[prov]','$rows[cap]','".addslashes($rows["regione"])."','$telefono','1','0','ADE')";
		echo $sql2;
		$res2=mysql_query($sql2);
		$id=mysql_insert_id();
		
		if($rows["gold"]=='1'){
		$sql3="INSERT INTO servizi_strutture_migliorsorriso (id_struttura, id_contratto) VALUES ('$id','03')";
		$res3=mysql_query($sql3);
		$sql3="INSERT INTO servizi_strutture_migliorsorriso (id_struttura, id_contratto) VALUES ('$id','04')";
		$res3=mysql_query($sql3);
		}
		if($rows["basic"]=='1'){
		$sql3="INSERT INTO servizi_strutture_migliorsorriso (id_struttura, id_contratto) VALUES ('$id','01')";
		$res3=mysql_query($sql3);
		$sql3="INSERT INTO servizi_strutture_migliorsorriso (id_struttura, id_contratto) VALUES ('$id','02')";
		$res3=mysql_query($sql3);
		}
}
?>

