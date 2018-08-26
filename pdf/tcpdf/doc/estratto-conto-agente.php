<?php include("../../../includes/parameters.php");?>
<?php include("../../../includes/functions.php");?>
<?php include("../../../includes/mysql.inc.php");
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = 'logo-salva.jpg';
        $this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
       
    }

    // Page footer
    public function Footer() {
    	$this->SetTextColor(155,155,155);
        // Position at 15 mm from bottom
        $this->SetY(-20);
        // Page number
        $this->Cell(267, 5, 'Salva Assistance srl - Viale del Lavoro, 2/G - 35010 Vigonza (Pd)', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetY(-15);
        $this->Cell(267, 5, 'Tel 049.6226044 - Fax 049.8936830 Email info@salvassistance.it', 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->SetY(-10);
        $this->Cell(267, 5, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Salva');
$pdf->SetTitle('Estratto conto');
$pdf->SetSubject('Estratto conto');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.

$pdf->SetFont('helvetica', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

$sqla="SELECT * FROM utenti LEFT JOIN comuni_2017 ON comuni_2017.cod_catastale = utenti.citta WHERE id_utente='$_GET[id_agente]'";
$resa=mysql_query($sqla);
$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);
	
$agente=$rowsa["nome"];
$destinatario=<<<EOD
	Spett.le<br />
	<strong>$rowsa[nome]</strong><br />
	$rowsa[indirizzo]<br />
	$rowsa[cap] $rowsa[comune] $rowsa[pr]<br />
	P.I. $rowsa[partitaiva]
EOD;


$pdf->SetXY(200,10);
$pdf->writeHTMLCell(0, 0, '', '', $destinatario, 0, 1, 0, true, '', true);

$y=$pdf->GetY();
$y=$y+5;
$pdf->SetXY(10,$y);


$sqla="SELECT * FROM decadi WHERE decade='$_GET[codice_decade]'";
$resa=mysql_query($sqla);
$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);
$inizio=convertiDataIT_US($rowsa["inizio"]);
$fine=convertiDataIT_US($rowsa["fine"]);

$decade=<<<EOD
	<u>Estratto conto dal <strong>$inizio</strong> al <strong>$fine</strong>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $decade, 0, 1, 0, true, '', true);

$y=$pdf->GetY();
$y=$y+5;
$pdf->SetXY(10,$y);


$dicitura=<<<EOD

Gentile <strong>$agente</strong> la presente per inviarLe l'estratto conto dei contratti integration da Lei segnalati che vorrà rimetterci al netto delle commissioni da Lei maturate al seguente IBAN <b>IT70W0306962969100000001082</b> a noi intestato.<br />
La fattura dovrà essere intestata a:<br /><br />
Salva Assistance srl<br />
Viale del Lavoro, 2/G<br />
35010 Vigonza (PD)<br />
Partita Iva 05155260283<br />
EOD;

$pdf->writeHTMLCell(0, 0, '', '', $dicitura, 0, 1, 0, true, '', true);


$sqla="SELECT percentuale, aliquote_agenti.aliquota AS aliquota FROM utenti LEFT JOIN aliquote_agenti ON aliquote_agenti.id_aliquota = utenti.aliquota WHERE id_utente='$_GET[id_agente]'";
//Prezzo prodotto 
$resa=mysql_query($sqla);
$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);
$percentuale=$rowsa["percentuale"];
$aliquota=$rowsa["aliquota"];


$importo_tot=0;
$incasso_tot=0;
$provvigione_tot=0;
$ritenuta_tot=0;
$versare_tot=0;
$iva_provv_tot=0;


$contenuto_tabella="";
$sql="SELECT * FROM pratiche LEFT JOIN clienti ON clienti.id_cliente = pratiche.id_cliente WHERE id_agente='$_GET[id_agente]' AND codice_attivazione IN (SELECT codice_pratica FROM decadi_pratiche WHERE codice_decade='$_GET[codice_decade]') ORDER BY data_stampa DESC";
        $res=mysql_query($sql);
        $i=0;
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)):

        	$i++;
          $sql1="SELECT *, prodotti.id_prodotto AS id_prodotto FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE  id_convenzione_prodotto='$rows[id_prodotto_convenzione]'";
           $res1=mysql_query($sql1);
           $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
           $id_prodotto=$rows1["id_prodotto"];

          if($rows1["id_prodotto"]=='001') $prodotto="Mezzi Sussistenza";
          if($rows1["id_prodotto"]=='002') $prodotto="Spese sanitarie";
          if($rows1["id_prodotto"]=='003') $prodotto="Mezzi Sussistenza + Spese sanitarie";

          $importo=$rows["importo"];
          $netto=$importo/1.22; 
          $provvigione=$netto*$percentuale/100;    
          $iva_provv=$provvigione*0.22;

          $ritenuta=$provvigione*$aliquota;
          $versare=$importo-($provvigione+$iva_provv-$ritenuta);

          $importo_tot=number_format($importo_tot+$importo,2);
    		  $incasso_tot=number_format($incasso_tot+$netto,2);
    		  $provvigione_tot=number_format($provvigione_tot+$provvigione,2);
    		  $versare_tot=number_format($versare_tot+$versare,2);
    		  $ritenuta_tot=number_format($ritenuta_tot+$ritenuta,2);
          $iva_provv_tot=number_format($iva_provv_tot+$iva_provv,2);

          $importo=number_format($importo,2,",",".");
          $netto=number_format($netto,2,",",".");
          $provvigione=number_format($provvigione,2,",",".");
          $iva_provv=number_format($iva_provv,2,",",".");
          $ritenuta=number_format($ritenuta,2,",",".");
          $versare=number_format($versare,2,",",".");
          $classe="";
          if($i%2==0) $classe="class='odd'";
           $contenuto_tabella.='
          <tr '.$classe.'>
            <td style="border-bottom:1px solid #ccc;padding-bottom:10px;">'.date("d/m/Y", strtotime($rows["data_stampa"])).'</td>
            <td style="border-bottom:1px solid #ccc; padding-bottom:10px;">'.$rows["codice_attivazione"].'</td>
            <td style="border-bottom:1px solid #ccc;padding-bottom:10px;">'.$prodotto.'</td>
            <td style="border-bottom:1px solid #ccc;padding-bottom:10px;">'.utf8_encode($rows["cognome"]." ".$rows["nome"]).'</td>
            
            <td style="text-align:right;border-bottom:1px solid #ccc;padding-bottom:10px;"> € '.$importo.'</td>
            <td style="text-align:right;border-bottom:1px solid #ccc;padding-bottom:10px;"> € '.$netto.'</td>
            <td style="text-align:right;border-bottom:1px solid #ccc;padding-bottom:10px;"> € '.$provvigione.'</td>
            <td style="text-align:right;border-bottom:1px solid #ccc;padding-bottom:10px;"> € '.$iva_provv.'</td>
            <td style="text-align:right; border-bottom:1px solid #ccc;padding-bottom:10px;"> € '.$ritenuta.'</td>
            <td style="text-align:right;border-bottom:1px solid #ccc;padding-bottom:10px;"> € '.$versare.'</td>
            
          </tr>';
     
      endwhile;

$importo_tot=number_format($importo_tot,2,",",".");
$incasso_tot=number_format($incasso_tot,2,",",".");
$provvigione_tot=number_format($provvigione_tot,2,",",".");
$versare_tot=number_format($versare_tot,2,",",".");
$ritenuta_tot=number_format($ritenuta_tot,2,",",".");
$iva_provv_tot=number_format($iva_provv_tot,2,",",".");


$tabella=<<<EOD
<table class='table'>
    <tr>
    <th style="width:80px;"><b>Data stampa</b></th>
     <th style="width:140px;"><b>Codice Pratica</b></th>
     <th style="width:140px;"><b>Prodotto</b></th>
     <th style="width:140px;"><b>Cliente</b></th>
     <th style="width:80px;text-align:right;"><b>Incasso</b></th>
     <th style="width:80px;text-align:right;"><b>Imponibile</b></th>
     <th style="width:80px;text-align:right;"><b>Provvigioni</b></th>
     <th style="width:80px;text-align:right;"><b>Iva Provv.</b></th>
     <th style="width:80px;text-align:right;"><b>Ritenuta</b></th>
     <th style="width:80px;text-align:right;"><b>Da Versare</b></th>
     
    </tr> 
    <tr>
    <td colspan="9"> </td>
    </tr> 
    $contenuto_tabella
    <tr>
    <td colspan="9"> </td>
    </tr> 
    <tr>
    	<td colspan="4"><b>Totali</b></td>
    	<td style="width:80px;text-align:right;"><b>€ $importo_tot</b></td>
    	<td style="width:80px;text-align:right;"><b>€ $incasso_tot</b></td>
    	<td style="width:80px;text-align:right;"><b>€ $provvigione_tot</b></td>
      <td style="width:80px;text-align:right;"><b>€ $iva_provv_tot</b></td>
    	<td style="width:80px;text-align:right;"><b>€ $ritenuta_tot</b></td>
    	<td style="width:80px;text-align:right;color:#f00;"><b>€ $versare_tot</b></td>
    </tr>
</table>
EOD;

$y=$pdf->GetY();
$y=$y+5;
$pdf->SetXY(10,$y);
// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $tabella, 0, 1, 0, true, '', true);


$y=$pdf->GetY();
$y=$y+10;
$pdf->SetXY(10,$y);

$tabella=<<<EOD
<table class='table' cellspacing="5" style="background-color:#eee;">
    <tr><td style="width:140px;">Tot. Incasso Lordo</td><td align="right">€ $importo_tot</td></tr>
    <tr><td style="width:140px;">Imponibile</td><td align="right">€ $incasso_tot</td></tr>
    <tr><td style="width:140px;">Provvigione</td><td align="right">€ $provvigione_tot</td></tr>
    <tr><td style="width:140px;">Iva Provvigione</td><td align="right">€ $iva_provv_tot</td></tr>
    <tr><td style="width:140px;">Ritenuta d'acconto</td><td align="right" style="border-bottom:1px solid #ccc;">€ $ritenuta_tot</td></tr>
    <tr><td style="width:140px;"><b>Importo da versare</b></td><td align="right" style="color:#F00;"><b>€ $versare_tot</b></td></tr>
</table>
EOD;

$pdf->writeHTMLCell(60, 0, '', '', $tabella, 0, 1, 0, true, '', true);


// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('estratto-conto.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
