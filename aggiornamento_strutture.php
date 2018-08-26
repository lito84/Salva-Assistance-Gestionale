<?php include("includes/mysql.inc.php");?>
<?php include("includes/functions.php");?>

<?php 

/*$sql="SELECT * FROM check_province";
$res=mysql_query($sql);

while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

	$sql1="SELECT pr FROM comuni_2017 WHERE comune LIKE '".addslashes($rows["CittaOperativaStruttura"])."'";
	$res1=mysql_query($sql1);
	if(mysql_num_rows($res1)==1){
		$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

		if($rows["ProvinciaOperativaStruttura"]!=$rows1["pr"]){
			$sql2="UPDATE check_province SET NewProvincia = '$rows1[pr]' WHERE IdAnagraficaStruttura = '$rows[IdAnagraficaStruttura]'";
			$res2=mysql_query($sql2);
			echo $sql2."<br />";
		}
		
	}


}*/

$sql="SELECT IdAnagraficaStruttura FROM  anagraficastruttura WHERE Provenienza='Innova' AND convenzione_confermata='1' AND IdAnagraficaStruttura NOT IN (SELECT id_struttura FROM circuiti_strutture GROUP BY id_struttura) AND NazioneStruttura <> 'ITALIA' AND NazioneStruttura <> ''";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$sql1="INSERT INTO circuiti_strutture (id_circuito, id_struttura) VALUES ('004','$rows[IdAnagraficaStruttura]')";
	echo $sql1."<br />";

	$res1=mysql_query($sql1);
}
?>