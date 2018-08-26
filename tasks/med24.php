<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/getinclude.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php include("../libraries/PHPExcel.php");?>
<?php require("../PHPMailer/class.phpmailer.php"); // Gestione email ?>
<?php require("../PHPMailer/class.smtp.php"); // Gestione email ?>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

<?php
$yesterday=date("Y-m-d", strtotime("now -1 day"));

$sql="SELECT *, utenti.id_utente AS id_utente FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente WHERE pagato='1' AND data_attivazione LIKE '".$yesterday."%' AND convenzioni_prodotti.id_convenzione_prodotto IN (SELECT id_prodotto_convenzione FROM prodotti_convenzione_meta WHERE chiave = 'Servizio' AND valore IN (064,065,066,067)) GROUP BY id_pratica";

$res=mysql_query($sql);

if($num=mysql_num_rows($res)>0){



// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 


    //Intestazione file	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'IDPratica');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'DataInserimento');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Codice Fiscale');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Cognome');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Nome'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Indirizzo');
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Comune');
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Cap');
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Provincia');
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Email');
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Telefono');
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Pacchetto');
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Tipo Card');
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Beneficiario 1');
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Beneficiario 2');
	$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Beneficiario 3');
	$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Beneficiario 4');
	$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Beneficiario 5');
	$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Beneficiario 6');
	$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Beneficiario 7');
	$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'Data Scadenza');

	

// Initialise the Excel row number
$rowCount = 2; 
// Iterate through each result from the SQL query in turn
// We fetch each database result row into $row in turn
while($rows = mysql_fetch_array($res,MYSQL_ASSOC)){ 

	$now = time(); // or your date as well
    $your_date = strtotime(date("Y-m-d", strtotime($rows["data_scadenza"])));
    $datediff =  $your_date-$now;
    $giorni=floor($datediff/(60*60*24));

	$attivo = ($rows['attivo'] == '1') ? $attivo_label="Attivata" : $attivo_label="Non attivata";
	$colore = ($rows['attivo'] == '1') ? $colore_label="Blue" : $colore_label="Red";
	$stato = ($rows['attivo'] == '1') ? $stato_label="6" : $stato_label="8";
	$paypal = ($rows['pagato'] == '1' && $rows["tipo_pagamento"]=="PayPal") ? $paypal_status="Pagato" : $paypal_status="Non pagato";
	$pagamento = ($rows['pagato'] == '1') ? $pagamento_status="Pagato" : $pagamento_status="Non pagato";
	$data_richiesta = ($rows['data_richiesta_attivazione'] == '') ? $data_label="" : $data_label=date("d-m-Y", strtotime($rows["data_richiesta_attivazione"]));
	
	$sql1="SELECT * FROM clienti LEFT JOIN comuni_gl ON comuni_gl.cod_istat = clienti.citta LEFT JOIN province_gl ON comuni_gl.cod_provincia = province_gl.cod_provincia WHERE id_cliente = '$rows[id_cliente]'";
	$res1=mysql_query($sql1);
	$rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

	$sqlcap="SELECT cap FROM cap_gl WHERE comune = '".addslashes($rows1["comune"])."'";
	$rescap=mysql_query($sqlcap);
	$rowscap=mysql_fetch_array($rescap, MYSQL_ASSOC);
	$cap=$rowscap["cap"];

	$sql2="SELECT * FROM prodotti WHERE prodotti.id_prodotto ='$rows[id_prodotto]'";
	
	$res2=mysql_query($sql2);
	$rows2=mysql_fetch_array($res2, MYSQL_ASSOC);

    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $rows["id_pratica"]); 
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, date("d-m-Y", strtotime($rows["data_attivazione"])));
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $rows1["codicefiscale"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $rows1["cognome"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $rows1["nome"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $rows1["indirizzo"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $rows1["comune"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $cap);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $rows1["sigla"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $rows1["email"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $rows1["telefono"]);

    $sqlp="SELECT * FROM aree_servizi LEFT JOIN prodotti_convenzione_meta ON aree_servizi.id_area = prodotti_convenzione_meta.valore WHERE prodotti_convenzione_meta.id_prodotto_convenzione='$rows[id_prodotto_convenzione]' AND chiave = 'Servizio' AND aree_servizi.id_pacchetto='03'";
    $resp=mysql_query($sqlp);
    $rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $rowsp["area"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $rows2["prodotto"]);
    
    $beneficiari=array();
    $sqlb="SELECT * FROM beneficiari WHERE id_pratica = '$rows[id_pratica]'";
    $resb=mysql_query($sqlb);
    while($rowsb=mysql_fetch_array($resb, MYSQL_ASSOC)){
    	array_push($beneficiari,$rowsb["nome"]." ".$rowsb["cognome"]);
    }
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, utf8_encode($beneficiari[0]));
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, utf8_encode($beneficiari[1]));
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, utf8_encode($beneficiari[2]));
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, utf8_encode($beneficiari[3]));
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, utf8_encode($beneficiari[4]));
    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, utf8_encode($beneficiari[5]));
    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, utf8_encode($beneficiari[6]));
    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, date("d-m-Y", strtotime($rows["data_scadenza"])));
    
    // Increment the Excel row counter
    $rowCount++; 
} 

// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 
// Write the Excel file to filename some_excel_file.xlsx in the current directory
$objWriter->save('MS'.$yesterday.'.xlsx'); 

	
	$mail=new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = $p_smtp_user; // SMTP username
	$mail->Password = $p_smtp_password; // SMTP password
	$mail->Host=$p_smtp_server;
	$mail->From=$p_smtp_mittente_email;
	$mail->FromName=$p_smtp_mittente;
	$mail->MsgHTML("Attivazioni BMC ".$yesterday);
	$mail->Subject="Attivazioni BMC ".$yesterday;
	$mail->AddAddress("info@assistenzamedicah24.it", "Convenzioni BMC");
	//$mail->AddAddress("luca.merli84@gmail.com", "Med24");
	$mail->AddAttachment('MS'.$yesterday.'.xlsx');
	$mail->AddBCC("amministrazione@migliorsalute.it", "Amministrazione Migliorsalute");
	$mail->Send();

}		
?>