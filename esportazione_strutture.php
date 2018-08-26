<?php 
require("includes/mysql.inc.php");
require("includes/parameters.php");
require("libraries/PHPExcel.php");

$filename="Strutture confermate";
   

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("MigliorSalute")
                                           ->setLastModifiedBy("MigliorSalute")
                                           ->setTitle("Office 2007 XLSX Test Document")
                                           ->setSubject("Office 2007 XLSX Test Document")
                                           ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                           ->setKeywords("office 2007 openxml php")
                                           ->setCategory("Test result file");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Ragione Sociale')
            ->setCellValue('B1', 'Indirizzo')
            ->setCellValue('C1', 'Città')
            ->setCellValue('D1', 'Provincia')
            ->setCellValue('E1', 'Regione')
            ->setCellValue('F1', 'Telefono')
            ->setCellValue('G1', 'Email')
            ->setCellValue('H1', 'Nominativo convenzione')
            ->setCellValue('I1', 'Convenzione attiva')
            ->setCellValue('J1', 'Data conferma')
            ->setCellValue('K1', 'Provenienza')
            ->setCellValue('L1', 'Oggetto della convenzione')
            ->setCellValue('M1', 'Forma della convenzione')
            ->setCellValue('N1', 'Circuito');
$i=2;
$sql="SELECT * FROM anagraficastruttura WHERE attivo AND migliorsalute AND da_cancellare='0' AND convenzione_confermata='1'";
$res=mysql_query($sql);
      while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){



      $RagioneSocialeStruttura=$rows["RagioneSocialeStruttura"];
      $IndirizzoOperativaStruttura=$rows["IndirizzoOperativaStruttura"];
      $CittaOperativaStruttura=$rows["CittaOperativaStruttura"];
      $ProvinciaOperativaStruttura=$rows["ProvinciaOperativaStruttura"];
      $RegioneStruttura=$rows["RegioneStruttura"];
      $Telefono1Struttura=$rows["Telefono1Struttura"];
      $Email=$rows["EmailStruttura"];
      $NominativoConvenzioneStruttura=$rows["NominativoConvenzioneStruttura"];

      $ConvenzioneAttiva="SI";
      $DataConferma=date("d-m-Y H:i", strtotime($rows["timestamp_conferma"]));
      $Provenienza=$rows["Provenienza"];


      if($rows["tariffario_pdf"]<>''){
        $oggetto="TARIFFARIO";
      }else{
        $oggetto="SERVIZI";
      }

      $forma="ON-LINE";

      $sql1="SELECT * FROM circuiti_strutture LEFT JOIN circuiti ON circuiti.id_circuito = circuiti_strutture.id_circuito WHERE id_struttura = '$rows[IdAnagraficaStruttura]'";
      $res1=mysql_query($sql1);
      $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

      $circuito=$rows1["circuito"];

      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A'.$i, $RagioneSocialeStruttura,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('B'.$i, $IndirizzoOperativaStruttura,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('C'.$i, $CittaOperativaStruttura,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('D'.$i, $ProvinciaOperativaStruttura,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('E'.$i, $RegioneStruttura,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('F'.$i, $Telefono1Struttura,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('G'.$i, $Email,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('H'.$i, $NominativoConvenzioneStruttura,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('I'.$i, $ConvenzioneAttiva,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('J'.$i, $DataConferma,PHPExcel_Cell_DataType::TYPE_STRING)
          
            ->setCellValueExplicit('K'.$i, $Provenienza,PHPExcel_Cell_DataType::TYPE_STRING)
           
            ->setCellValueExplicit('L'.$i, $oggetto,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('M'.$i, $forma,PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('N'.$i, $circuito,PHPExcel_Cell_DataType::TYPE_STRING);
            $i++;
      }
            

$objPHPExcel->getActiveSheet()->setTitle('Strutture');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>