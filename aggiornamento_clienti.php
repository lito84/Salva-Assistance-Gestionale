<?php include("includes/mysql.inc.php");?>
<?php include("includes/functions.php");?>

<?php 


$sql="SELECT * FROM clienti WHERE LENGTH(citta)>'4'";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$sql1="SELECT * FROM comuni_gl WHERE cod_istat='$rows[citta_istat]' ";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

	$sql2="SELECT cod_catastale FROM comuni_2017 WHERE comune = '".addslashes($rows1["comune"])."'";
	$res2=mysql_query($sql2);
	$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);

	//$comune=substr($rows["codicefiscale"],11,4);
	$comune=$rows2["cod_catastale"];

	$sql3="UPDATE clienti SET citta = '$comune' WHERE id_cliente = '$rows[id_cliente]'";
	echo $sql3."<br />";
	$res3=mysql_query($sql3);
}
?>