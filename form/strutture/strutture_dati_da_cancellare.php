<?php include("../../includes/mysql.inc.php");?>
<?php 

$aColumns=array('RagioneSocialeStruttura','CittaOperativaStruttura','ProvinciaOperativaStruttura','Contatti','Circuiti','NominativoConvenzioneStruttura','Provenienza','stato','NoteStruttura','action','IdAnagraficaStruttura');
$output = array(
		"aaData" => array()
	);

$sql="SELECT * FROM anagraficastruttura WHERE migliorsalute AND da_cancellare='1' AND attivo";
$res=mysql_query($sql);
$num=mysql_num_rows($res);

    $counter=0;
    while($rows=mysql_fetch_array($res,MYSQL_ASSOC)) {
    	$data_stato="";
    	if($rows["data_stato"]!=""){
    		$data_stato=date("d/m/Y H:i", strtotime($rows["data_stato"]));
    	}
    	$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "Circuiti" )
			{
				$circuito="";
				$sql0="SELECT * FROM circuiti_strutture LEFT JOIN circuiti ON circuiti.id_circuito = circuiti_strutture.id_circuito WHERE id_struttura = '$rows[IdAnagraficaStruttura]' GROUP BY circuiti.id_circuito ";
				$res0=mysql_query($sql0);
				while($rows0=mysql_fetch_array($res0, MYSQL_ASSOC)){
					$circuito.="<a href='circuiti.php'>".$rows0["circuito"]."</a>";
				}
				$row[]=utf8_encode($circuito);
			}elseif ( $aColumns[$i] == "RagioneSocialeStruttura" )
			{
				$row[]=utf8_encode($rows[ $aColumns[$i] ]);
			}elseif ( $aColumns[$i] == "ProvinciaOperativaStruttura" )
			{
				$row[]=utf8_encode($rows["ProvinciaOperativaStruttura"]." - ".$rows["RegioneStruttura"]);
			}elseif ( $aColumns[$i] == "stato" )
			{
				$row[]=utf8_encode($rows["stato"]." <br/> ".$data_stato);
			}
			elseif ( $aColumns[$i] == "Contatti" )
			{
				$row[]="<a href='tel:".$rows["Telefono1Struttura"]."'>".utf8_encode($rows["Telefono1Struttura"]."</a><br/> "."<a href='mailto:".$rows["EmailStruttura"]."'>".$rows["EmailStruttura"])."</a>";
			}elseif ( $aColumns[$i] == "action" )
			{
				/* Special output formatting for 'action' column */
				$row[] = "<a href='strutture_dettaglio.php?id_struttura=".$rows[$aColumns[10]]."' target='_blank'><button data-id=".$rows[$aColumns[10]]." class='btn btn-warning'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></a>";
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = $rows[ $aColumns[$i] ];
			}
		}
		$output['aaData'][] = $row;

	}
echo json_encode($output);
?>