<?php include("../includes/parameters.php");?>
<?php include("../includes/functions.php");?>
<?php include("../includes/mysql.inc.php");?>
<?php 
$giorno=date("d", strtotime("now"));


if($giorno=="01"): //creo record decade 1-10
	$codice="DEC".date("Ym")."01";


	$inizio=date("Y-m-d", strtotime("now"));
	$fine=date("Y-m-", strtotime("now"));
	$fine.="10";

	$sql="INSERT INTO decadi (decade, inizio, fine) VALUES ('$codice','$inizio','$fine')";
	$res=mysql_query($sql);

endif;


if($giorno=="11"): //creo record decade 11-20
	$codice="DEC".date("Ym")."02";


	$inizio=date("Y-m-d", strtotime("now"));
	$fine=date("Y-m-", strtotime("now"));
	$fine.="20";

	$sql="INSERT INTO decadi (decade, inizio, fine) VALUES ('$codice','$inizio','$fine')";
	$res=mysql_query($sql);
	
endif;

if($giorno=="21"): //creo record decade 21-fine mese
	$codice="DEC".date("Ym")."03";


	$inizio=date("Y-m-d", strtotime("now"));
	$fine=date("Y-m-t", strtotime("now"));
	
	$sql="INSERT INTO decadi (decade, inizio, fine) VALUES ('$codice','$inizio','$fine')";
	$res=mysql_query($sql);
	
endif;