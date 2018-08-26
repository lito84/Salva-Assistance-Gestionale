<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<?php 
$requestData= $_REQUEST;
$aColumns=array('cod_catastale','comune');
$output = array(
		"aaData" => array()
	);
$sql="SELECT * FROM comuni_2017 WHERE comune LIKE '$_GET[query]%' ";

        $res=mysql_query($sql);
        $num=mysql_num_rows($res);

    $counter=0;
    while($rows=mysql_fetch_array($res,MYSQL_ASSOC)) {
    	
    	$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			
			
				$row[] = $rows[ $aColumns[$i] ];
				//$row[] = $sql;
				
			
		}
		$counter++;
		$output['aaData'][] = $row;
	

	}
echo json_encode($output);
?>