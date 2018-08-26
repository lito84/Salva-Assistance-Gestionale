<?php include("includes/setup.php");?>
<?php include("includes/menu.php");?>
<?php 
function generateRandomString($length = 10) {
    $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

<?php $sql="SELECT * FROM prodotti WHERE categoria <> '01'";
	  $res=mysql_query($sql);
	  while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	  	for($i=0;$i<100;$i++){
	  		$string = generateRandomString(10);

	  		$sql1="INSERT INTO convenzioni_prodotti_codici (id_prodotto, codice_attivazione, codice_convenzione) VALUES ('$rows[id_prodotto]','$string','GBRGQNV1Z')";
	  		$res1=mysql_query($sql1);
	  	}
	  	
	  

	  }