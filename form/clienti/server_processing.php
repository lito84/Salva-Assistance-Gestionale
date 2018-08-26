<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<?php 
$requestData= $_REQUEST;
$aColumns=array('cliente','agente','telefono','email','actions');
$output = array(
		"aaData" => array()
	);
$sql="SELECT clienti.id_cliente AS id_cliente, clienti.cognome AS cognome, clienti.nome AS nome,clienti.email AS email, clienti.telefono AS telefono, utenti.nome AS agente FROM clienti LEFT JOIN pratiche ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON convenzioni_prodotti.id_convenzione_prodotto = pratiche.id_prodotto_convenzione LEFT JOIN convenzioni ON convenzioni_prodotti.id_convenzione= convenzioni.id_convenzione LEFT JOIN utenti ON utenti.id_utente = convenzioni.id_utente WHERE clienti.cognome <> '' ";

          if($_SESSION["id_ruolo"]=="02"){ //Area manager
              $sql.="AND (convenzioni.id_utente='$_SESSION[id_utente]' OR convenzioni.id_utente IN (SELECT id_utente FROM utenti WHERE agente_superiore = '$_SESSION[id_utente]') ";
          }

          if($_SESSION["id_ruolo"]=="04"){ //Convenzionato I livello
              $sql.="AND convenzioni.id_utente='$_SESSION[id_utente]' ";
          }
        

        // getting records as per search parameters
		if( !empty($requestData['columns'][0]['search']['value']) ){   //name
		    $sql.=" AND (clienti.cognome LIKE '".$requestData['columns'][0]['search']['value']."%' OR clienti.nome LIKE '".$requestData['columns'][0]['search']['value']."%') ";
		}
		if( !empty($requestData['columns'][2]['search']['value']) ){   //name
		    $sql.=" AND clienti.email LIKE '".$requestData['columns'][2]['search']['value']."%' ";
		}
		if( !empty($requestData['columns'][3]['search']['value']) ){   //name
		    $sql.=" AND clienti.telefono LIKE '%".$requestData['columns'][3]['search']['value']."%' ";
		}
		$sql.=" GROUP BY clienti.id_cliente ";
        $sql.=" ORDER BY cognome, nome DESC ";

        $sql.="LIMIT $_GET[start], $_GET[length]";
       	
        $res=mysql_query($sql);
        $num=mysql_num_rows($res);

    $counter=0;
    while($rows=mysql_fetch_array($res,MYSQL_ASSOC)) {
    	
    	$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			
			if ( $aColumns[$i] == "cliente" )
			{
				$row[]=$rows["cognome"]." ".$rows["nome"];
				//$row[] = $sql;
			}
			elseif ( $aColumns[$i] == "actions" )
			{

				$modifica="<button title='Modifica' data-id='".$rows['id_cliente']."' class='btn btn-warning edit'><i class='fa fa-pencil-square-o' aria-hidden='true' title='Modifica'></i></button>";

				$row[]=$modifica;
			}
			else{
				$row[] = $rows[ $aColumns[$i] ];
				//$row[] = $sql;
			}
				
			
		}
		$counter++;
		$output['aaData'][] = $row;
		$output['draw'] = $requestData["draw"];
		$output['recordsTotal'] = intval($num);


	}
echo json_encode($output);
?>