<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");
//require("../libraries/tcpdf/tcpdf.php"); // Librerie generazione PDF
//require("../libraries/tcpdf/fpdi.php"); // Librerie importazione PDF

require('fpdf.php');
require('fpdi.php');

session_name("Migliorsalute_Download");
session_start();

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


$_SESSION["codice_attivazione"]=$_GET["codice_attivazione"];

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


$sqlu="SELECT * FROM clienti WHERE clienti.id_cliente = '$rows[id_cliente]'";
$resu=mysql_query($sqlu);
$rowsu=mysql_fetch_array($resu, MYSQL_ASSOC);

$dettaglio_prodotto = <<<EOD
<span style="color:#$colore;">$prodotto</span>
EOD;

// initiate FPDI
$pdf = new FPDI();
//$modello="SaluteSorriso_Card_Dental-Platinum_foglio-stampa (3).pdf";
//$pdf->setPrintHeader(false);
//$pdf->SetPrintFooter(false);
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile("certificato_salva.pdf");
$pageCount = $pdf->setSourceFile('certificato_salva.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx);


$pdf->SetTitle($prodotto);

$pdf->AddFont('verdana','','Verdana.php');
$pdf->setFont('verdana','',10);

$pdf->SetXY(15,50);   
$pdf->SetFont("helvetica","B",10);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(50,5,"DOMANDA DI ADESIONE N.",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(65,50);   
$pdf->Cell(39,5,$rows["codice_attivazione"],1,1,'L','1');
$pdf->SetXY(104,50);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(60,5,"CERTIFICATO DI ADESIONE N.",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(164,50);   
$pdf->Cell(39,5,$rows["codice_attivazione"],1,1,'L','1');

$pdf->SetXY(15,60);  
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(30,5,"Promotore",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(45,60);   
$pdf->Cell(60,5,$rows["agente"],1,1,'L','1');
$pdf->SetXY(105,60);  
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(30,5,"Rete",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(135,60);   
$pdf->Cell(68,5,"Salute Semplice",1,1,'L','1');


$pdf->SetXY(15,70);   
$pdf->SetFont("helvetica","B",10);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(188,5,"DATI DEL RICHIEDENTE",1,1,'C','1');

$pdf->SetXY(15,80);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(20,5,"Cognome",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(35,80);   
$pdf->Cell(50,5,$rows["cognome"],1,1,'L','1');

$pdf->SetXY(85,80);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(10,5,"Nome",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(95,80);   
$pdf->Cell(50,5,$rows["nome"],1,1,'L','1');
$pdf->SetXY(145,80);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(10,5,"Sesso",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(155,80);   
$pdf->Cell(10,5,$rowsu["sesso"],1,1,'L','1');
$pdf->SetXY(165,80);  
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(20,5,"Data nascita",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(185,80);   
$pdf->Cell(18,5,$rowsu["data_nascita"],1,1,'L','1');


$pdf->SetXY(15,85);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(25,5,"Luogo di nascita",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(40,85);   
$pdf->Cell(70,5,$luogo_nascita,1,1,'L','1');
$pdf->SetXY(110,85); 
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(10,5,"Pr",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(120,85);   
$pdf->Cell(10,5,$pr_nascita,1,1,'L','1');
$pdf->SetXY(130,85); 
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(30,5,"Codice Fiscale",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(160,85);   
$pdf->Cell(43,5,$rowsu["codicefiscale"],1,1,'L','1');

$pdf->SetXY(15,90);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(20,5,"Indirizzo",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(35,90);   
$pdf->Cell(70,5,$rowsu["indirizzo"],1,1,'L','1');
$pdf->SetXY(105,90); 
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(10,5,"CAP",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(115,90);   
$pdf->Cell(10,5,$rowsu["cap"],1,1,'L','1');
$pdf->SetXY(125,90); 
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(15,5,utf8_decode("Località"),1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(140,90);   
$pdf->Cell(45,5,$citta,1,1,'L','1');

$pdf->SetXY(185,90); 
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(10,5,utf8_decode("Pr"),1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(195,90);   
$pdf->Cell(8,5,$pr,1,1,'L','1');

$pdf->SetXY(15,95);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(20,5,"Telefono",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(35,95);   
$pdf->Cell(40,5,$rowsu["telefono"],1,1,'L','1');

$pdf->SetXY(75,95);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(20,5,"Cellulare",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(95,95);   
$pdf->Cell(35,5,$rowsu["telefono"],1,1,'L','1');
$pdf->SetXY(130,95);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(20,5,"Email",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(150,95);   
$pdf->Cell(53,5,$rowsu["email"],1,1,'L','1');

$pdf->SetXY(15,100);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(30,5,"Documento",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(45,100);   
$pdf->Cell(55,5,utf8_decode($rowsu["documento"]),1,1,'L','1');
$pdf->SetXY(100,100);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(30,5,"Data rilascio",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(130,100);   
$pdf->Cell(20,5,$rowsu["data_rilascio"],1,1,'L','1');
$pdf->SetXY(150,100);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(30,5,"Data scadenza",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(180,100);   
$pdf->Cell(23,5,$rowsu["data_scadenza"],1,1,'L','1');


$pdf->SetXY(15,105);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(40,5,"Ente di Rilascio",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(45,105);   
$pdf->Cell(90,5,utf8_decode($rowsu["ente_rilascio"]),1,1,'L','1');
$pdf->SetXY(135,105);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(30,5,"Numero documento",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(165,105);   
$pdf->Cell(38,5,$rowsu["documento_numero"],1,1,'L','1');


$pdf->SetXY(15,120);   
$pdf->SetFont("helvetica","B",10);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(188,5,"PRESTAZIONI GARANTITE",1,1,'C','1');
$pdf->SetXY(15,125);  
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetFont("helvetica","B",8);
$pdf->Cell(50,5,"SALVASALUTE E SORRISO",1,1,'L','1');
$pdf->SetXY(65,125);  
$pdf->Cell(50,5,$prodotto,1,1,'L','1');
$pdf->SetXY(115,125);  
$pdf->Cell(30,5,"1 persona",1,1,'L','1');
$pdf->SetXY(145,125);  
$pdf->Cell(30,5,"Vedi regolamento",1,1,'L','1');
$pdf->SetXY(175,125);  

define('EURO',chr(128));

$pdf->Cell(28,5,EURO." ".$prezzo,1,1,'L','1');


$sqla="SELECT * FROM pratiche_meta WHERE id_pratica = '$id_pratica' AND chiave='assistito_nome'";
$resa=mysql_query($sqla);
if(mysql_num_rows($resa)>0):
$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);

$y=$pdf->GetY();
$y=$y+10;

$pdf->SetXY(15,$y);   
$pdf->SetFont("helvetica","B",10);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(188,5,"ASSISTITO COPERTO DALLA CARD  SE DIVERSO DAL RICHIEDENTE",1,1,'C','1');
$y=$y+5;

$pdf->SetXY(15,$y);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(40,5,"Nome e Cognome",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(55,$y);   
$pdf->Cell(50,5,$rowsa["valore"],1,1,'L','1');

$sqla="SELECT * FROM pratiche_meta WHERE id_pratica = '$id_pratica' AND chiave='assistito_cf'";
$resa=mysql_query($sqla);
$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);
$pdf->SetXY(105,$y);  
$pdf->SetFont("helvetica","B",8);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(40,5,"Codice Fiscale",1,1,'L','1');
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetXY(145,$y);   
$pdf->Cell(58,5,$rowsa["valore"],1,1,'L','1');

endif;
$y=$pdf->GetY();
$y=$y+10;

$pdf->SetXY(15,$y);   
$pdf->SetFont("helvetica","B",10);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(188,5,"TIPOLOGIA PAGAMENTO",1,1,'C','1');
$y=$y+5;
$pdf->SetXY(15,$y);  
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetFont("helvetica","B",8);
$pdf->Cell(188,5,"ANNUALE",1,1,'C','1');

$y=$pdf->GetY();
$y=$y+10;

$pdf->SetXY(15,$y);   
$pdf->SetFont("helvetica","B",10);
$pdf->SetTextColor(255,255,255);
$pdf->SetFillColor(50,50,153);
$pdf->Cell(188,5,"COSTO DEL PIANO INDENNITARIO",1,1,'C','1');
$y=$y+5;
$pdf->SetXY(15,$y);  
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetFont("helvetica","",8);
$pdf->Cell(100,5,"Contributo associativo",1,1,'L','1');
$pdf->SetXY(115,$y);
$pdf->Cell(88,5,EURO." 5,00",1,1,'R','1');
$y=$y+5;
$pdf->SetXY(15,$y);  
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetFont("helvetica","",8);
$pdf->Cell(100,5,"Contributo Sussidio Salva Salute e Sorriso prescelto",1,1,'L','1');
$pdf->SetXY(115,$y);
$pdf->Cell(88,5,EURO." ".number_format($prezzo,2,",",""),1,1,'R','1');

$totale=$prezzo+5;

$y=$y+5;
$pdf->SetXY(15,$y);  
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(50,50,153);
$pdf->SetDrawColor(50,50,153);
$pdf->SetFont("helvetica","B",8);
$pdf->Cell(100,5,"TOTALE QUOTA DA VERSARE",1,1,'L','1');
$pdf->SetXY(115,$y);
$pdf->Cell(88,5,EURO." ".number_format($totale,2,",",""),1,1,'R','1');



$filenameinit="INIT".rand(5).time();

$pdf->Output("tmp/".$filenameinit.".pdf","F");
//array_push($files,$filename.".pdf");




require('PDFMerger.php');


$pdff = new PDFMerger;

$pdff->addPDF('tmp/'.$filenameinit.".pdf", 'all');


//$pdff->addPDF('tmp/Bugiardino.pdf', 'all');
$pdff->merge('browser', $_GET["codice_attivazione"].'.pdf');
?>