<?php
require("../includes/mysql.inc.php");


$sql = "SELECT cod_catastale, comune FROM comuni_2017 WHERE comune LIKE '".utf8_decode($_GET["q"])."%' ORDER BY comune"; 
$res = mysql_query($sql);


$json = [];
while($row = mysql_fetch_array($res, MYSQL_ASSOC)){
     $json[] = ['id'=>$row['cod_catastale'], 'text'=>utf8_encode($row['comune'])];
}


echo json_encode($json);
?>