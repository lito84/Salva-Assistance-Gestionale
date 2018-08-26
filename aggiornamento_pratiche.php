<?php include("includes/mysql.inc.php");?>
<?php include("includes/functions.php");?>

<?php 


$sql="SELECT * FROM convenzioni_prodotti WHERE id_convenzione='4' AND prezzo_cliente_scontato <> '0.00' ";
$res=mysql_query($sql);
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$sql1="INSERT INTO convenzioni_prodotti_sconti (id_convenzione_prodotto, codice_sconto, prezzo) VALUES ('$rows[id_convenzione_prodotto]','MITI2018','$rows[prezzo_cliente_scontato]')";
	$res1=mysql_query($sql1);
}
?>