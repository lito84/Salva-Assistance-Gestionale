<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<?php include("../../includes/functions.php");?>
<?php 

if(isset($_GET["dal"])) $dal=convertiDataUS_IT($_GET["dal"]);
if(isset($_GET["al"])) $al=convertiDataUS_IT($_GET["al"]);
$requestData= $_REQUEST;
$now=date("Y-m-d", strtotime("now"));

$aColumns=array('codice_decade','periodo','incasso','imponibile','provvigioni','iva_provvigione','ritenuta','versare','actions'); 
$output = array(
	"aaData" => array()
);
$sql="SELECT codice_decade, inizio, fine FROM decadi_pratiche LEFT JOIN pratiche ON pratiche.codice_attivazione = decadi_pratiche.codice_pratica LEFT JOIN decadi ON decadi.decade = decadi_pratiche.codice_decade WHERE decadi.fine<'$now' ";
if($_SESSION["livello"]<10):
	$sql.=" AND pratiche.id_agente = '$_SESSION[id_utente]' ";
endif;
$sql.=" GROUP BY codice_decade ORDER BY decadi.fine DESC";
$sql.=" LIMIT $_GET[start], $_GET[length]";
$res=mysql_query($sql);
$num=mysql_num_rows($res);

$counter=0;
$importo_tot=0;
$incasso_tot=0;
$provvigione_tot=0;
$ritenuta_tot=0;
$versare_tot=0;
$iva_provv_tot=0;

//Prelevo percentuale ed aliquota collegata all'agente
$sqla="SELECT percentuale, aliquote_agenti.aliquota AS aliquota FROM utenti LEFT JOIN aliquote_agenti ON aliquote_agenti.id_aliquota = utenti.aliquota WHERE id_utente='$_SESSION[id_utente]'";
//Prezzo prodotto 
$resa=mysql_query($sqla);
$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);
$percentuale=$rowsa["percentuale"];
$aliquota=$rowsa["aliquota"];
while($rows=mysql_fetch_array($res,MYSQL_ASSOC)) {


	$sqlp="SELECT * FROM pratiche WHERE id_agente='$_SESSION[id_utente]' AND codice_attivazione IN (SELECT codice_pratica FROM decadi_pratiche WHERE codice_decade='$rows[codice_decade]')";
	$resp=mysql_query($sqlp);

	while($rowsp=mysql_fetch_array($resp, MYSQL_ASSOC)):
		$importo=$rowsp["importo"];
		$netto=$importo/1.22;	
		$provvigione=$netto*$percentuale/100;
		$iva_provv=$provvigione*0.22;

		$ritenuta=$provvigione*$aliquota;
		$versare=$importo-($provvigione+$iva_provv-$ritenuta);
		
		$importo_tot=number_format($importo_tot+$importo,2);
		$incasso_tot=number_format($incasso_tot+$netto,2);
		$provvigione_tot=number_format($provvigione_tot+$provvigione,2);
		$versare_tot=number_format($versare_tot+$versare,2);
		$ritenuta_tot=number_format($ritenuta_tot+$ritenuta,2);
		$iva_provv_tot=number_format($iva_provv_tot+$iva_provv,2);




	endwhile;
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$importo_tot=str_replace(".",",",$importo_tot);
			$incasso_tot=str_replace(".",",",$incasso_tot);
			$provvigione_tot=str_replace(".",",",$provvigione_tot);
			$versare_tot=str_replace(".",",",$versare_tot);
			$ritenuta_tot=str_replace(".",",",$ritenuta_tot);
			$iva_provv_tot=str_replace(".",",",$iva_provv_tot);
			
			$periodo="Decade ".date("d/m", strtotime($rows["inizio"]))." - ".date("d/m/y", strtotime($rows["fine"]));

			if ( $aColumns[$i] == "incasso" )
			{
				$row[]=$importo_tot;
			}elseif ($aColumns[$i] == "imponibile"){
				$row[] = $incasso_tot;
			}
			elseif ($aColumns[$i] == "provvigioni"){
				$row[] = $provvigione_tot;
			}
			elseif ($aColumns[$i] == "iva_provvigione"){
				$row[] = $iva_provv_tot;

			}elseif ($aColumns[$i] == "ritenuta"){
				$row[] = $ritenuta_tot;
			}elseif ($aColumns[$i] == "periodo"){
				$row[] = $periodo;
			}elseif ($aColumns[$i] == "versare"){
				$row[] = $versare_tot;
			}elseif ( $aColumns[$i] == "actions" )
			{

				$dettaglio="";
				

				$dettaglio="<button title='Dettaglio decade' data-decade='".$rows['codice_decade']."' data-agente='".$_SESSION["id_utente"]."' class='btn_grid btn-primary visualizza'><i class='fa fa-list' aria-hidden='true' title='Attivo'></i></button>";   
				$pdf="<button title='Stampa estratto conto' data-decade='".$rows['codice_decade']."' data-agente='".$_SESSION["id_utente"]."' class='btn_grid btn-success stampa'><i class='fa fa-file-pdf' aria-hidden='true' title='Attivo'></i></button>";    
              
				$row[]=$dettaglio.$pdf;
			}
			
			else{
				$row[] = $rows[ $aColumns[$i] ];
			}
		}
	$counter++;
	$output['aaData'][] = $row;
	$output['draw'] = $requestData["draw"];
	$output['recordsTotal'] = intval($num);


}
echo json_encode($output);
?>