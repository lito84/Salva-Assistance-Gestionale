<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php 

require('fpdf.php');
require('fpdi.php');

$sql="SELECT * FROM  prodotti WHERE id_prodotto='$_GET[id_prodotto]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);

$files=array();

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

$url_loghi="../uploads/immagini/files/";

//Meta dati//

//Modello

$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Modello'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$modello=$rows1["valore"];
if($modello==NULL){
	echo "MODELLO MANCANTE"; 
	exit;
} 

//Nome reale card

$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Nome reale card'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
if($num1=mysql_num_rows($res1>0)){
  $prodotto=$rows1["valore"];
}

//Loghi

$sql1="SELECT * FROM prodotti_meta_pdf WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'logo1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_meta_pdf WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'logo2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo2=$rows1["valore"];

$sql1="SELECT * FROM prodotti_meta_pdf WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'logo3'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo3=$rows1["valore"];

//Altezze celle loghi
$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Altezza Cella Logo 1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$altezza_logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Altezza Cella Logo 2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$altezza_logo2=$rows1["valore"];

//Larghezze loghi
$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Larghezza Logo 1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$largezza_logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Larghezza Logo 2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$larghezza_logo2=$rows1["valore"];

$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Larghezza Logo 3'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$larghezza_logo3=$rows1["valore"];

//Colore font

$sql1="SELECT * FROM prodotti_meta WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Colore'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$colore=$rows1["valore"];
$colore=hex2rgb($colore);

$dettaglio_prodotto = <<<EOD
<span style="color:#$colore;">$prodotto</span>
EOD;

$y=0;

// initiate FPDI
$pdf = new FPDI();

//$pdf->setPrintHeader(false);
//$pdf->SetPrintFooter(false);
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile('../uploads/modelli/files/'.$modello);
$pageCount = $pdf->setSourceFile('../uploads/modelli/files/'.$modello);
// import page 1
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->SetTextColor(0,119,149);


$pdf->SetTitle($prodotto);

   $pdf->SetXY(0,68);   




$filenameinit="INIT".rand(5).time();

$pdf->Output("tmp/".$filenameinit.".pdf","F");
//array_push($files,$filename.".pdf");

$sql="SELECT * FROM prodotti_meta LEFT JOIN pacchetti ON pacchetti.id_pacchetto = prodotti_meta.valore WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Pacchetto' ORDER BY valore";
$res=mysql_query($sql);
$bugiardino="";
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
  $bugiardino.=$rows["bugiardino"];

  $sql1="SELECT * FROM prodotti_meta LEFT JOIN aree_servizi ON aree_servizi.id_area = prodotti_meta.valore WHERE id_prodotto='$_GET[id_prodotto]' AND chiave = 'Servizio' AND id_pacchetto='$rows[id_pacchetto]' ORDER BY valore";
  $res1=mysql_query($sql1);
  while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){
    $bugiardino.=$rows1["bugiardino"];
  }
}





array_push($files,$filename.".pdf");
require('PDFMerger.php');


$pdff = new PDFMerger;

$pdff->addPDF('tmp/'.$filenameinit.".pdf", 'all');
foreach($files as $file){
  $pdff->addPDF('tmp/'.$file, 'all');
}

//$pdff->addPDF('tmp/Bugiardino.pdf', 'all');
$pdff->merge('browser', $_GET["codice_attivazione"].'.pdf');
?>