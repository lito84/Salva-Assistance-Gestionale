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
//$yesterday=date("Y-m-d", strtotime("now"));


/*$sql="SELECT *, utenti.id_utente AS id_utente FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente WHERE pagato='1' AND data_attivazione LIKE '".$yesterday."%' AND convenzioni_prodotti.id_convenzione_prodotto NOT IN ( '00069','00061','000119')";*/

$sql="SELECT *, utenti.id_utente AS id_utente FROM pratiche LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente WHERE pagato='1' AND id_cliente <> '0' AND data_attivazione LIKE '".$yesterday."%' AND convenzioni_prodotti.id_convenzione_prodotto IN (SELECT id_prodotto_convenzione FROM prodotti_convenzione_meta WHERE chiave = 'Pacchetto'  AND valore='02' ) AND pratiche.attivo='1'";

$res=mysql_query($sql);

if($num=mysql_num_rows($res)>0){



// Instantiate a new PHPExcel object
$objPHPExcel = new PHPExcel(); 
// Set the active Excel worksheet to sheet 0
$objPHPExcel->setActiveSheetIndex(0); 


    //Intestazione file	
	$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'IDPratica');
	$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'DataInserimento');
	$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Agente');
	$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Icona');
	$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Codice Fiscale');
	$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Cognome');
	$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Nome'); 
	$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Indirizzo');
	$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Comune');
	$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Cap');
	$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Provincia');
	$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'IDCliente');
	$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'IDTipoCard');
	$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Stato');
	$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'ColoreStato');
	$objPHPExcel->getActiveSheet()->SetCellValue('P1', 'IDUtente');
	$objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Card');
	$objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Scadenza');
	$objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Email');
	$objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Telefono');
	$objPHPExcel->getActiveSheet()->SetCellValue('U1', 'ColoreCard');
	$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'PrezzoVendita');
	$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'IDStato');
	$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'GiorniScadenza');
	$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'IDAcquisto');
	$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Attivata');
	$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'PayPalStatus');
	$objPHPExcel->getActiveSheet()->SetCellValue('AB1', 'Pagata');
	$objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'CodiceProdotto');
	$objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'CodiceAttivazione');
	$objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'Prenotata');
	$objPHPExcel->getActiveSheet()->SetCellValue('AF1', 'DataAttivazione');
	$objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'IDLottoPrenotazioni');
	$objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'ConfermataCliente');
	$objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'CodiceSalus');
	$objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'IDEstrazione');
	$objPHPExcel->getActiveSheet()->SetCellValue('AK1', 'Provenienza');
	$objPHPExcel->getActiveSheet()->SetCellValue('AL1', 'RinnovoAvviato');
	$objPHPExcel->getActiveSheet()->SetCellValue('AM1', 'DataAttivazione');
	$objPHPExcel->getActiveSheet()->SetCellValue('AN1', 'Beneficiario1');
	$objPHPExcel->getActiveSheet()->SetCellValue('AO1', 'Beneficiario2');
	$objPHPExcel->getActiveSheet()->SetCellValue('AP1', 'Beneficiario3');
	$objPHPExcel->getActiveSheet()->SetCellValue('AQ1', 'Beneficiario4');
	$objPHPExcel->getActiveSheet()->SetCellValue('AR1', 'Beneficiario5');
	$objPHPExcel->getActiveSheet()->SetCellValue('AS1', 'Beneficiario6');
	$objPHPExcel->getActiveSheet()->SetCellValue('AT1', 'Beneficiario7');
	$objPHPExcel->getActiveSheet()->SetCellValue('AU1', 'Beneficiario8');
	

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
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $rows["nome"]);
    //$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, "");
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $rows1["codicefiscale"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $rows1["cognome"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $rows1["nome"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $rows1["indirizzo"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $rows1["comune"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $cap);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $rows1["sigla"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $rows1["id_cliente"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $rows2["id_prodotto"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $attivo_label);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $colore_label);
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $rows["id_utente"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $rows2["prodotto"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, date("d-m-Y", strtotime($rows["data_scadenza"])));
    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $rows1["email"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $rows1["telefono"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $colore);
    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $rows["prezzo_cliente"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $stato);
    $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $giorni);
    $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $rows["id_pratica"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $attivo_label);
    $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $paypal_status);
    $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, $pagamento_status);
    $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $rows["codice_attivazione"]);
    $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount, $rows["codice_attivazione"]);
    //$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, "");
    $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, date("d-m-Y", strtotime($rows["data_attivazione"])));
    $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, $rows["id_lotto"]);
    //$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$rowCount, "");
    //$objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, "");
    //$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$rowCount, "");
    $objPHPExcel->getActiveSheet()->SetCellValue('AK'.$rowCount, "GES");
    $objPHPExcel->getActiveSheet()->SetCellValue('AL'.$rowCount, "FALSO");
    $objPHPExcel->getActiveSheet()->SetCellValue('AM'.$rowCount, $data_label);

    $sql3="SELECT * FROM beneficiari WHERE id_pratica='$rows[id_pratica]'";
    $res3=mysql_query($sql3);
    $num3=mysql_num_rows($res3);
    $indice_lettera="AM";
    while($rows3=mysql_fetch_array($res3, MYSQL_ASSOC)){
    	$indice_lettera++;
    	$objPHPExcel->getActiveSheet()->SetCellValue($indice_lettera.$rowCount, $rows3["cognome"]." ".$rows3["nome"]);
    }
    
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
	$mail->MsgHTML("Attivazioni migliorsalute - migliorsorriso ".$yesterday);
	$mail->Subject="Attivazioni migliorsalute - migliorsorriso ".$yesterday;
	$mail->AddAddress("segreteria@adegroup.eu", "Segreteria ADE Group");
	//$mail->AddAddress("luca.merli84@gmail.com", "Segreteria ADE Group");
	$mail->AddAttachment('MS'.$yesterday.'.xlsx');
	$mail->AddBCC("amministrazione@migliorsalute.it", "Amministrazione Migliorsalute");
	$mail->Send();

}		
?>