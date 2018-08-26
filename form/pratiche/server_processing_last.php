<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<?php include("../../includes/functions.php");?>
<?php 

if(isset($_GET["dal"])) $dal=convertiDataUS_IT($_GET["dal"]);
if(isset($_GET["al"])) $al=convertiDataUS_IT($_GET["al"]);
$requestData= $_REQUEST;

$aColumns=array('codice_attivazione','cliente', 'agente','prodotto','data_inserimento','actions'); 
$output = array(
		"aaData" => array()
	);
$sql="SELECT codice_attivazione, clienti.cognome AS cognome, clienti.nome AS nome, pratiche.id_cliente AS id_cliente, data_inserimento, data_pagamento, data_attivazione AS dataAttivazione, data_stampa, pagato, pratiche.attivo, fatturato, fattura, pratiche.id_pratica,	 prezzo_cliente, pratiche.esportazione_pagamento, prodotti.id_prodotto AS id_prodotto, pratiche.id_agente AS id_agente  FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE data_richiesta_attivazione = '' AND data_attivazione <> '' AND pratiche.id_cliente <> '0' ";

        if($_SESSION["id_ruolo"]!="01"){
            $sql.="AND pratiche.id_agente='$_SESSION[id_utente]' ";
        }
        /*
        // getting records as per search parameters
		if( !empty($requestData['columns'][0]['search']['value']) ){   //name
		    $sql.=" AND codice_attivazione LIKE '".$requestData['columns'][0]['search']['value']."%' ";
		}
		
		if( !empty($requestData['columns'][1]['search']['value']) ){   //name
		    $sql.=" AND (clienti.cognome LIKE '".$requestData['columns'][1]['search']['value']."%' OR clienti.nome LIKE '".$requestData['columns'][1]['search']['value']."%') ";
		}
		if( !empty($requestData['columns'][2]['search']['value']) ){   //name
		    $sql.=" AND utenti.nome LIKE '".$requestData['columns'][2]['search']['value']."%' ";
		}
		if( !empty($requestData['columns'][4]['search']['value']) ){   //name
		    $sql.=" AND prodotto LIKE '".$requestData['columns'][3]['search']['value']."%' ";
		}
		if( !empty($requestData['columns'][5]['search']['value']) ){   //name
		    $sql.=" AND data_inserimento LIKE '%".$requestData['columns'][4]['search']['value']."%' ";
		}
		if( !empty($requestData['columns'][6]['search']['value']) ){   //name
		    $sql.=" AND data_pagamento LIKE '%".$requestData['columns'][5]['search']['value']."%' ";
		}
		if( !empty($requestData['columns'][7]['search']['value']) ){   //name
		    $sql.=" AND data_attivazione LIKE '%".$requestData['columns'][6]['search']['value']."%' ";
		}*/

		if(isset($_GET["pagato"])){
			$sql.="AND pagato='0' ";
		}
		
		if(isset($_GET["dal"])){
			$sql.="AND data_attivazione>='$dal' AND data_attivazione<='$al'";
		}
        $sql.=" ORDER BY dataAttivazione DESC ";
        $sql.="LIMIT 0,10";
       

        $res=mysql_query($sql);
        $num=mysql_num_rows($res);	




    $counter=0;
    while($rows=mysql_fetch_array($res,MYSQL_ASSOC)) {
    	$data_pagamento = ($rows['data_pagamento'] != '') ? $data_pagamento=date("d-m-y", strtotime($rows["data_pagamento"])) : $data_pagamento="";
        $data_inserimento = ($rows['data_inserimento'] != '') ? $data_inserimento=date("d-m-y", strtotime($rows["data_inserimento"])) : $data_inserimento="";
        $data_attivazione = ($rows['dataAttivazione'] != '') ? $data_attivazione=date("d-m-y", strtotime($rows["dataAttivazione"])) : $data_attivazione="";
        $data_stampa = ($rows['data_stampa'] != '') ? $data_stampa=date("d-m-y", strtotime($rows["data_stampa"])) : $data_stampa="";

    	$pagato = ($rows['pagato'] == '1') ? $pagato_classe="btn-success" : $pagato_classe="btn-danger";
        $attivo = ($rows['attivo'] == '1') ? $attivo_classe="btn-success" : $attivo_classe="btn-danger";
        $fatturato = ($rows['fatturato'] == '1') ? $fatturato_classe="btn-success" : $fatturato_classe="btn-danger";

    	$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			
			$sqla="SELECT nome FROM utenti WHERE id_utente = '$rows[id_agente]'";
            $resa=mysql_query($sqla);
            $rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);

			$sql1="SELECT valore FROM pratiche_meta WHERE id_pratica = '$rows[id_pratica]' AND chiave = 'Codice incaricato'";
            $res1=mysql_query($sql1);
            $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);


            $sqlp="SELECT tipo_pagamento FROM pratiche WHERE id_pratica='$rows[id_pratica]'";
            $resp=mysql_query($sqlp);
            $rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);

			

			if ( $aColumns[$i] == "cliente" )
			{
				$row[]="<a href='cliente_dettaglio.php?id_cliente=".$rows["id_cliente"]."' target='_blank'>".$rows["cognome"]." ".$rows["nome"]."</a>";
				//$row[] = $sql;
			}elseif ( $aColumns[$i] == "agente" )
			{
				$row[]=$rowsa["nome"];
				//$row[] = $sql;
			}elseif ( $aColumns[$i] == "data_inserimento" )
			{
				$row[]=$data_inserimento;
				
			}

			elseif ( $aColumns[$i] == "prodotto" )
			{
				if($rows["id_prodotto"]=='001') $prodotto="Mezzi Sussistenza";
   				if($rows["id_prodotto"]=='002') $prodotto="Spese sanitarie";
    			if($rows["id_prodotto"]=='003') $prodotto="Mezzi Sussistenza + Spese sanitarie";
				$row[]=$prodotto;
				
			}
			elseif ( $aColumns[$i] == "codice_attivazione" )
			{
				$codice_attivazione=$rows["codice_attivazione"];
				
				$row[]=$codice_attivazione;
				
			}
			
			
			elseif ( $aColumns[$i] == "data_pagamento" )
			{	

				if($rows["prezzo_cliente"]!="0.00"){
					$row[]=$data_pagamento;
				}else{
					$row[]="Pag. Div.";
				}
				
				
			}elseif ( $aColumns[$i] == "dataAttivazione" )
			{
				$row[]=$data_attivazione;
				
			}

			elseif ( $aColumns[$i] == "data_stampa" )
			{
				$row[]=$data_stampa;
				
			}
			elseif ( $aColumns[$i] == "actions" )
			{

				$invio="";
				$fattura="";
				$extra="";
				

				$attivazione="<button title='Stato attivazione' data-id='".$rows['id_pratica']."' class='btn_grid ".$attivo_classe." attivo'><i class='fa fa-check' aria-hidden='true' title='Attivo'></i></button>";    
              
				if($data_stampa!=""):
				$visualizza="<button title='Visualizza PDF' data-id='".$rows['id_pratica']."' data-codice='".$rows["codice_attivazione"]."' class='btn_grid btn-info visualizza'><i class='fa fa-address-card' aria-hidden='true'></i></button>";	
				endif;

				if($data_stampa=="" && $rows["attivo"]):
				$stampa="<button title='Genera stampa' data-id='".$rows['id_pratica']."' data-codice='".$rows["codice_attivazione"]."' class='btn_grid btn-info stampa'><i class='fa fa-print' aria-hidden='true'></i></button>";	
				endif;

				$row[]=$attivazione.$visualizza.$stampa;
			}
			

			else{
				$row[] = $rows[ $aColumns[$i] ];
				//$row[] = $sql;
			}
				
			
		}
		$counter++;
		$output['aaData'][] = $row;
		$output['draw'] = $requestData["draw"];
		$output['recordsTotal'] = intval($counter);


	}
echo json_encode($output);
?>