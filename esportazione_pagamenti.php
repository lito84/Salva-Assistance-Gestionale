<?php 
require("includes/auth.inc.php");
require("includes/mysql.inc.php");
require("includes/parameters.php");
require("libraries/PHPExcel.php");

$filename="Pagamenti al ".date("Y-m-d H:i");
   /*   header( "Content-Type: application/vnd.ms-excel" );
      header( "Content-disposition: attachment; filename=".$filename );
      
      $head="codice_attivazione"."\t"."codicefiscale"."\t"."cognome"."\t"."nome"."\t"."sesso"."\t"."data_nascita"."\t"."luogo_nascita"."\t"."indirizzo"."\t"."citta"."\t"."prov"."\t"."cap"."\t"."telefono"."\t"."email"."\t"."beneficiario1nome"."\t"."beneficiario1cognome"."\t"."beneficiario2nome"."\t"."beneficiario2cognome"."\t"."beneficiario3nome"."\t"."beneficiario3cognome"."\t"."beneficiario4nome"."\t"."beneficiario4cognome"."\t"."beneficiario5nome"."\t"."beneficiario5cognome"."\t"."beneficiario6nome"."\t"."beneficiario6cognome"."\t"."beneficiario7nome"."\t"."beneficiario7cognome" ;

      $head.="\n";
      echo $head;

      
      $dati="";
     
$sql="SELECT * FROM pratiche LEFT JOIN clienti ON clienti.id_cliente = pratiche.id_cliente LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = pratiche.id_prodotto_convenzione WHERE esportazione_pagamento = '$_GET[id_pagamento]'";
$res=mysql_query($sql);
      while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

            $dati.=$rows["codice_attivazione"]."\t".$rows["codicefiscale"]."\t".$rows["cognome"]."\t".$rows["nome"]."\t".$rows["sesso"]."\t".$rows["data_nascita"]."\t".$rows["luogo_nascita"]."\t".$rows["indirizzo"]."\t".$rows["citta"]."\t".$rows["prov"]."\t".$rows["cap"]."\t".$rows["telefono"]."\t".$rows["email"];
      
            $sql1="SELECT * FROM beneficiari WHERE id_pratica = '$rows[id_pratica]'";
            $res1=mysql_query($sql1);
            while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){
                  $dati.="\t".$rows1["nome"]."\t".$rows1["cognome"];
            }
            $dati.="\n";
      }

      echo $dati; */

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Salute Semplice")
                                           ->setLastModifiedBy("Salute Semplice")
                                           ->setTitle("Office 2007 XLSX Test Document")
                                           ->setSubject("Office 2007 XLSX Test Document")
                                           ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                           ->setKeywords("office 2007 openxml php")
                                           ->setCategory("Test result file");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'codice_attivazione')
            ->setCellValue('B1', 'codicefiscale')
            ->setCellValue('C1', 'cognome')
            ->setCellValue('D1', 'nome')
            ->setCellValue('E1', 'sesso')
            ->setCellValue('F1', 'data_nascita')
            ->setCellValue('G1', 'luogo_nascita')
            ->setCellValue('H1', 'indirizzo')
            ->setCellValue('I1', 'citta')
            ->setCellValue('J1', 'prov')
            ->setCellValue('K1', 'cap')
            ->setCellValue('L1', 'telefono')
            ->setCellValue('M1', 'email')
            ->setCellValue('N1', 'beneficiario1nome')
            ->setCellValue('O1', 'beneficiario1cognome')
            ->setCellValue('P1', 'beneficiario2nome')
            ->setCellValue('Q1', 'beneficiario2cognome')
            ->setCellValue('R1', 'beneficiario3nome')
            ->setCellValue('S1', 'beneficiario3cognome')
            ->setCellValue('T1', 'beneficiario4nome')
            ->setCellValue('U1', 'beneficiario4cognome')
            ->setCellValue('V1', 'beneficiario5nome')
            ->setCellValue('W1', 'beneficiario5cognome')
            ->setCellValue('X1', 'beneficiario6nome')
            ->setCellValue('Y1', 'beneficiario6cognome')
            ->setCellValue('Z1', 'beneficiario7nome')
            ->setCellValue('AA1', 'beneficiario7cognome');
$i=2;
$sql="SELECT * FROM pratiche LEFT JOIN clienti ON clienti.id_cliente = pratiche.id_cliente LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = pratiche.id_prodotto_convenzione WHERE esportazione_pagamento = '$_GET[id_pagamento]'";
$res=mysql_query($sql);
      while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){

      $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A'.$i, $rows["codice_attivazione"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('B'.$i, $rows["codicefiscale"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('C'.$i, $rows["cognome"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('D'.$i, $rows["nome"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('E'.$i, $rows["sesso"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('F'.$i, $rows["data_nascita"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('G'.$i, $rows["luogo_nascita"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('H'.$i, $rows["indirizzo"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('I'.$i, $rows["citta"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('J'.$i, $rows["prov"],PHPExcel_Cell_DataType::TYPE_STRING)
          
            ->setCellValueExplicit('K'.$i, $rows["cap"],PHPExcel_Cell_DataType::TYPE_STRING)
            //->setCellValue('A'.$i, $rows['codice_attivazione'])
            //->setCellValue('B'.$i, $rows['codicefiscale'])
            //->setCellValue('C'.$i, $rows['cognome'])
            //->setCellValue('D'.$i, $rows['nome'])
            //->setCellValue('E'.$i, $rows['sesso'])
            //->setCellValue('F'.$i, $rows['data_nascita'])
            //->setCellValue('G'.$i, $rows['luogo_nascita'])
            //->setCellValue('H'.$i, $rows['indirizzo'])
            //->setCellValue('I'.$i, $rows['citta'])
            //->setCellValue('J'.$i, $rows['prov'])
            //->setCellValue('K'.$i, $rows['cap'])
            //->setCellValue('L'.$i, $rows['telefono'])
           // ->setCellValue('M'.$i, $rows['email']);
            ->setCellValueExplicit('L'.$i, $rows["telefono"],PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('M'.$i, $rows["email"],PHPExcel_Cell_DataType::TYPE_STRING);
            
      $sql1="SELECT * FROM beneficiari WHERE id_pratica = $rows[id_pratica]";
      $res1=mysql_query($sql1);
      $letter="N";
      while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){
             //$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter.$i, $rows1['nome']);
             $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($letter.$i, $rows1['nome'],PHPExcel_Cell_DataType::TYPE_STRING);
             $letter++;
             //$objPHPExcel->setActiveSheetIndex(0)->setCellValue($letter.$i, $rows1['cognome']);
             $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit($letter.$i, $rows1['cognome'],PHPExcel_Cell_DataType::TYPE_STRING);
             $letter++;
      }


            $i++;
      }
            

$objPHPExcel->getActiveSheet()->setTitle('Pagamenti');
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