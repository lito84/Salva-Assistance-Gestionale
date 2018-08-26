<?php 
error_reporting(E_ALL); 
include("../includes/mysql.inc.php");
	$file=$_FILES["logo"]["name"];
	$sql="UPDATE utenti SET logo ='$file' WHERE id_utente='$_POST[id]'";
	$res=mysql_query($sql);
	$response="";
	if(move_uploaded_file($_FILES["logo"]["tmp_name"], "http://www.pilcrow.it/migliorsalute/uploads/utenti/".$file){
		$response="1";
	};
	echo json_encode($response);
	exit;
?>
