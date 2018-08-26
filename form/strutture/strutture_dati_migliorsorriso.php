<?php include("../../includes/mysql.inc.php");?>
<?php 

$aColumns=array('RagioneSocialeStruttura','CittaOperativaStruttura','ProvinciaOperativaStruttura','Telefono1Struttura','RegioneStruttura','action','IdAnagraficaStruttura');
$output = array(
		"aaData" => array()
	);

$sql="SELECT * FROM anagraficastruttura WHERE migliorsorriso AND attivo";
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
			}elseif ( $aColumns[$i] == "action" )
			{
				/* Special output formatting for 'action' column */
				$row[] = "<a href='strutture_dettaglio_migliorsorriso.php?id_struttura=".$rows[$aColumns[6]]."' target='_blank'><button data-id=".$rows[$aColumns[6]]." class='btn btn-warning'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button></a>";
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