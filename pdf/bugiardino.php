<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");
require("../libraries/tcpdf/tcpdf.php"); // Librerie generazione PDF
//require("../libraries/tcpdf/fpdi.php"); // Librerie importazione PDF
//require('fpdf.php');
require('fpdi.php');

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

$url_loghi="uploads/immagini/files/";
$sql="SELECT *, clienti.cognome AS cognome, clienti.nome AS nome, utenti.nome AS agente FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE pratiche.codice_attivazione='$_GET[codice_attivazione]'";
$res=mysql_query($sql);
$rows=mysql_fetch_array($res, MYSQL_ASSOC);

$id_pratica=$rows["id_pratica"];

$_GET["id_convenzione_prodotto"]=$rows["id_prodotto_convenzione"];

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

$pdf->setPrintHeader(false);
$pdf->SetPrintFooter(false);
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile('../uploads/modelli/files/'.$modello);
$pageCount = $pdf->setSourceFile('../uploads/modelli/files/'.$modello);
// import page 1
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);
$pdf->AddFont("helvetica","","helvetica.php");
$pdf->AddFont("helveticaneue","","helveticaneue.php");
$pdf->AddFont("helveticaneue","B","helveticaneueb.php");
$pdf->AddFont("helveticaneueblk","","helveticai.php");
$pdf->SetFont("helveticaneueblk","",10);
$pdf->SetTextColor(0,119,149);


$pdf->SetTitle($prodotto);

//Altezza Cherry Box
if($_GET["id_convenzione_prodotto"]=="00041"){
 
   $pdf->SetXY(0,75);   
}else{
//Altezza Standard   
   $pdf->SetXY(0,68);   
}

$pdf->SetFont("helveticaneue","B",23);
$pdf->Cell(210,10,utf8_decode($rows["nome"]." ".$rows["cognome"]),0,1,'C');

$pdf->SetFont("helveticaneue","B",11);
//Altezza Cherry Box
if($_GET["id_convenzione_prodotto"]=="00041"){
   $pdf->SetTextColor($colore[0],$colore[1],$colore[2]);

   $y=206;
}else{
//Altezza Standard   
  $y=203;
}
//Dati prodotto

$pdf->SetXY(150,$y);
if(strlen($prodotto)>18){
$pdf->MultiCell(40,1,utf8_decode($prodotto),0,'L');
$y=$y+3;
}else{
$pdf->Cell(210,10,utf8_decode($prodotto),0,1,'L');  
}
$pdf->SetXY(150,$y+6);
$pdf->SetFont("helveticaneue","B",10);
$pdf->Cell(210,10,utf8_decode("n. ".$codice_attivazione),0,1,'L');

//validita
$pdf->SetFont("helveticaneue","",8);
//Secondo colore per CherryBox
if($_GET["id_convenzione_prodotto"]=="00041"){
   $pdf->SetTextColor(135,135,135);
}
$pdf->SetXY(150,$y+10);
$pdf->Cell(210,10,utf8_decode("valida dal "),0,1,'L');
$pdf->SetFont("helveticaneue","B",8);
$pdf->SetXY(163,$y+10);
$pdf->Cell(216,10,utf8_decode($data_attivazione),0,1,'L');
$pdf->SetXY(150,$y+13);
$pdf->SetFont("helveticaneue","",8);
$pdf->Cell(210,10,utf8_decode("al "),0,1,'L');
$pdf->SetFont("helveticaneue","B",8);
$pdf->SetXY(153,$y+13);
$pdf->Cell(216,10,utf8_decode($data_scadenza),0,1,'L');

$pdf->SetXY(150,$y+17);

$pdf->SetFont("helveticaneue","",8);
$pdf->Cell(210,10,utf8_decode("titolare"),0,1,'L');
$pdf->SetFont("helveticaneue","B",8);
$pdf->SetXY(150,$y+20);
$pdf->Cell(210,10,utf8_decode($rows["cognome"]." ".$rows["nome"]),0,1,'L');

$pdf->SetXY(150,$y+23);
$pdf->SetFont("helveticaneue","",8);
$pdf->Cell(210,10,utf8_decode("codice fiscale"),0,1,'L');
$pdf->SetFont("helveticaneue","B",8);
$pdf->SetXY(150,$y+26);
$pdf->Cell(210,10,strtoupper(utf8_decode($rows["codicefiscale"])),0,1,'L');

//Sezione Beneficiari

$sqlb="SELECT * FROM beneficiari WHERE id_pratica = '$id_pratica'";
$resb=mysql_query($sqlb);
if($numb=mysql_num_rows($resb)!=0){
$pdf->SetXY(150,$y+29.5);
$pdf->SetFont("helveticaneue","",8);
$pdf->Cell(210,10,"beneficiari",0,1,'L');
$beneficiari="";  
   while($rowsb=mysql_fetch_array($resb, MYSQL_ASSOC)){
      $beneficiari.=$rowsb["nome"]." ".$rowsb["cognome"].", ";
   }
$beneficiari=utf8_encode(mb_substr($beneficiari, 0, -2));   
$pdf->SetFont("helveticaneue","B",5.5);
$pdf->SetXY(150,$y+36.5);
$pdf->MultiCell(45,1.7,$beneficiari,0,'L');
}


$filenameinit="INIT".rand(5).time();

$pdf->Output("tmp/".$filenameinit.".pdf","F");
//array_push($files,$filename.".pdf");

$sql="SELECT * FROM prodotti_convenzione_meta LEFT JOIN pacchetti ON pacchetti.id_pacchetto = prodotti_convenzione_meta.valore WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Pacchetto' ORDER BY valore";
$res=mysql_query($sql);
$bugiardino="";
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){
	$bugiardino.=$rows["bugiardino"];

	$sql1="SELECT * FROM prodotti_convenzione_meta LEFT JOIN aree_servizi ON aree_servizi.id_area = prodotti_convenzione_meta.valore WHERE id_prodotto_convenzione='$_GET[id_convenzione_prodotto]' AND chiave = 'Servizio' AND id_pacchetto='$rows[id_pacchetto]' ORDER BY valore";
	$res1=mysql_query($sql1);
	while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){
		$bugiardino.=$rows1["bugiardino"];
	}
}

class PDF extends FPDI {
// Page header
	function Header(){
		$this->Image('../libraries/tcpdf/images/logo_migliorsalute.jpg',20,10,50);
    	$this->Image('../libraries/tcpdf/images/logo_migliorsorriso.jpg',140,10,50);
	}

// Page footer
function Footer(){
		$this->SetY(-15);
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->SetMargins(20, 30, 20, true);
$pdf->AddPage();
$pdf->AddFont("helvetica","","helvetica.php");
$pdf->AddFont("helveticaneue","","helveticaneue.php");
$pdf->AddFont("helveticaneue","B","helveticaneueb.php");
$pdf->AddFont("helveticaneueblk","","helveticai.php");
$pdf->SetFont("helveticaneue","",12);
$pdf->SetXY(30,0);
$pdf->writeHTMLCell(0,0,20,44,$bugiardino);
$pdf->SetPrintFooter(false);
$pdf->SetPrintHeader(false);

$filename=rand(5).time();
$pdf->Output("tmp/".$filename.".pdf","F");


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