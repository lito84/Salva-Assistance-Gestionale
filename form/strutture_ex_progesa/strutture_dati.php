<?php include("../../includes/mysql.inc.php");?>
<?php 

$aColumns=array('RagioneSocialeStruttura','CittaOperativaStruttura','ProvinciaOperativaStruttura','EmailStruttura','Telefono1Struttura','RegioneStruttura','Provenienza','stato','action','IdAnagraficaStruttura');
$output = array(
		"aaData" => array()
	);

$sql="SELECT * FROM anagraficastruttura WHERE migliorsalute AND attivo AND convenzione_confermata='0' AND da_cancellare='0'  ORDER BY RagioneSocialeStruttura";
$res=mysql_query($sql);
$num=mysql_num_rows($res);

    $counter=0;
    while($rows=mysql_fetch_array($res,MYSQL_ASSOC)) {
    	$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "RagioneSocialeStruttura" )
			{
				$row[]=utf8_encode($rows[ $aColumns[$i] ]);
			}
			elseif ( $aColumns[$i] == "EmailStruttura" )
			{
				/* Special output formatting for 'Email' column */
				$row[] = "<a href='mailto:".$rows[$aColumns[3]]."' target='_blank'>".$rows[$aColumns[3]]."</a>";
			}elseif ( $aColumns[$i] == "Telefono1Struttura" )
			{
				/* Special output formatting for 'Email' column */
				$row[] = "<a href='tel:".$rows[$aColumns[4]]."' target='_blank'>".$rows[$aColumns[4]]."</a>";
			}elseif ( $aColumns[$i] == "action" )
			{
				/* Special output formatting for 'action' column */
				$row[] = "<a href='strutture_dettaglio.php?id_struttura=".$rows[$aColumns[9]]."' target='_blank'><button data-id=".$rows[$aColumns[9]]." class='btn btn-warning'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></a>";
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