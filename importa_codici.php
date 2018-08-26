<?php 
require("includes/auth.inc.php");
require("includes/mysql.inc.php");
require("includes/parameters.php");
require("PHPMailer/class.phpmailer.php"); // Gestione email 
require("PHPMailer/class.smtp.php"); // Gestione email 
require_once 'libraries/PHPExcel.php';
require_once 'libraries/PHPExcel/IOFactory.php';
require_once 'libraries/PHPExcel/Writer/Excel2007.php';

if($_POST["action"]=="importa_codici"){

$id_convenzione_prodotto=$_POST["id_convenzione_prodotto"];

$inputFileName="uploads/importazioni/files/".$_POST["file"];
	//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
} catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) 
    . '": ' . $e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

//  Loop through each row of the worksheet in turn
for ($row = 2; $row <= $highestRow; $row++) {
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . 'B' . $row, 
    NULL, TRUE, FALSE);
    $pratica=array();
	foreach($rowData[0] as $k=>$v){
        array_push($pratica,$v);
	}

	if($pratica[0]!=NULL) {
		$sql="INSERT INTO pratiche (id_prodotto_convenzione, data_inserimento, codice_attivazione, pagato,attivo) VALUES ('$id_convenzione_prodotto','".date("Y-m-d H:i",strtotime("now"))."','$pratica[0]','$pratica[1]','1')";
		$res=mysql_query($sql);
		
	}
}
echo "DONE";
exit;
}	
?>