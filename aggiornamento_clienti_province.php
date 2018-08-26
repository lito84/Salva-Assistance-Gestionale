<?php include("includes/mysqli.inc.php");?>
<?php include("includes/functions.php");?>

<?php 


$sql="SELECT * FROM clienti WHERE citta='' LIMIT 0,1";
$res=$mysqli->query($sql);
$rows=$res->fetch_assoc();


$url = "http://www.nonsolocap.it/cap?k=".$rows["cap"]."&b=+Cerca+&c=";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
// This is what solved the issue (Accepting gzip encoding)
curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
$response = curl_exec($ch);
curl_close($ch);
$risposta=htmlentities($response);

echo $risposta;

$codice_catastale=explode('Calcola il',$risposta);
$codice_catastale=$codice_catastale[1];
$codice_catastale=substr($codice_catastale,25,4);

echo $codice_catastale;

?>