<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php 

require('fpdf.php');
require('fpdi.php');

$sql="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto='$_GET[id_convenzione_prodotto]'";
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
$sql="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE id_convenzione_prodotto='$_GET[id_convenzione_prodotto]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);


$sqlp="SELECT *, prodotti_categorie.categoria AS categoria FROM prodotti LEFT JOIN prodotti_categorie ON prodotti_categorie.id_categoria = prodotti.categoria WHERE id_prodotto = '$rows[id_prodotto]'";
$resp=mysql_query($sqlp);
$rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

$prodotto=utf8_encode(stripslashes($rowsp["prodotto"]." ".$rowsp["categoria"]));
$codice_attivazione=$_GET["codice_attivazione"];
$data_attivazione=date("d-m-Y", strtotime($rows["data_attivazione"]));
$data_scadenza=date("d-m-Y", strtotime($rows["data_scadenza"]));

//Meta dati//

//Modello

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Modello'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$modello=$rows1["valore"];
if($modello==NULL){
	echo "MODELLO MANCANTE"; 
	exit;
} 

//Nome reale card

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Nome reale card'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
if($num1=mysql_num_rows($res1>0)){
  $prodotto=$rows1["valore"];
}

//Loghi

$sql1="SELECT * FROM prodotti_convenzione_meta_pdf WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'logo1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta_pdf WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'logo2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo2=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta_pdf WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'logo3'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$logo3=$rows1["valore"];

//Altezze celle loghi
$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Altezza Cella Logo 1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$altezza_logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Altezza Cella Logo 2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$altezza_logo2=$rows1["valore"];

//Larghezze loghi
$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Larghezza Logo 1'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$largezza_logo1=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Larghezza Logo 2'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$larghezza_logo2=$rows1["valore"];

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Larghezza Logo 3'";
$res1=mysql_query($sql1);
$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
$larghezza_logo3=$rows1["valore"];

//Colore font

$sql1="SELECT * FROM prodotti_convenzione_meta WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Colore'";
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

// set the source file
$pdf->setSourceFile('../uploads/modelli/files/'.$modello);
$pageCount = $pdf->setSourceFile('../uploads/modelli/files/'.$modello);

// add a page
$pdf->AddPage();

// import page 1
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->SetTextColor(0,63,104);

$pdf->SetTitle($prodotto);

$pdf->SetXY(0,68);   

$pdf->SetFont("helvetica","B",23);
$pdf->Cell(210,10,utf8_decode($rows["nome"]." ".$rows["cognome"]),0,1,'C');

$pdf->SetFont("helvetica","B",11);
  $y=203;
//Dati prodotto

$pdf->SetXY(150,$y);
if(strlen($prodotto)>18){
$pdf->MultiCell(40,4.5,utf8_decode($prodotto),0,'L');
$y=$y+3;
}else{
$pdf->Cell(210,10,utf8_decode($prodotto),0,1,'L');  
}
$pdf->SetXY(150,$y+6);
$pdf->SetFont("helvetica","B",10);
$pdf->Cell(210,10,utf8_decode("n. ".$codice_attivazione),0,1,'L');

//validita
$pdf->SetFont("helvetica","",8);

$pdf->SetXY(150,$y+10);
$pdf->Cell(210,10,utf8_decode("valida dal "),0,1,'L');
$pdf->SetFont("helvetica","B",8);
$pdf->SetXY(163,$y+10);
$pdf->Cell(216,10,utf8_decode($data_attivazione),0,1,'L');
$pdf->SetXY(150,$y+13);
$pdf->SetFont("helvetica","",8);
$pdf->Cell(210,10,utf8_decode("al "),0,1,'L');
$pdf->SetFont("helvetica","B",8);
$pdf->SetXY(153,$y+13);
$pdf->Cell(216,10,utf8_decode($data_scadenza),0,1,'L');

$pdf->SetXY(150,$y+17);

$pdf->SetFont("helvetica","",8);
$pdf->Cell(210,10,utf8_decode("titolare"),0,1,'L');
$pdf->SetFont("helvetica","B",8);
$pdf->SetXY(150,$y+20);
$pdf->Cell(210,10,utf8_decode($rows["cognome"]." ".$rows["nome"]),0,1,'L');

$pdf->SetXY(150,$y+23);
$pdf->SetFont("helvetica","",8);
$pdf->Cell(210,10,utf8_decode("codice fiscale"),0,1,'L');
$pdf->SetFont("helvetica","B",8);
$pdf->SetXY(150,$y+26);
$pdf->Cell(210,10,strtoupper(utf8_decode($rows["codicefiscale"])),0,1,'L');

//Sezione Beneficiari

$sqlb="SELECT * FROM beneficiari WHERE id_pratica = '$id_pratica'";
$resb=mysql_query($sqlb);
if($numb=mysql_num_rows($resb)!=0){
$pdf->SetXY(150,$y+29.5);
$pdf->SetFont("helvetica","",8);
$pdf->Cell(210,10,"beneficiari",0,1,'L');
$beneficiari="";  
   while($rowsb=mysql_fetch_array($resb, MYSQL_ASSOC)){
      $beneficiari.=$rowsb["nome"]." ".$rowsb["cognome"].", ";
   }
$beneficiari=utf8_encode(mb_substr($beneficiari, 0, -2));   
$pdf->SetFont("helvetica","B",5.5);
$pdf->SetXY(150,$y+36.5);
$pdf->MultiCell(45,1.7,$beneficiari,0,'L');
}


$filenameinit="INIT".rand(5).time();

$pdf->Output($filenameinit.".pdf","I");
?>