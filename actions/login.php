<?php include("../includes/setup.php");?>
<body>

<div class="container">
<?php if($_POST["action"]=="login"){
	$complete=0;
	$login=$_POST["login"];
	$password=$_POST["password"];
	
	$now=date("Y-m-d", strtotime("now"));

	$sql="SELECT * FROM utenti LEFT JOIN tipo_utenti ON utenti.id_ruolo=tipo_utenti.id_tipo_contatto WHERE login='$login' AND (password = MD5('$password') OR password ='$password') LIMIT 0,1";
	$res=mysql_query($sql);
	if($num=mysql_num_rows($res)>0){
		
		$rows=mysql_fetch_array($res, MYSQL_ASSOC);
				session_name("Salva");
				session_start();
				$_SESSION["user_authorized"]=true;
				$_SESSION["user_name"]=$rows["nome"];
				$_SESSION["id_ruolo"]=$rows["id_ruolo"];
				$_SESSION["id_utente"]=$rows["id_utente"];
				$_SESSION["livello"]=$rows["livello"];
				$_SESSION["user_logindate"]=date("d/m/Y H:i:s");
				$_SESSION["user_ip"]=$_SERVER["REMOTE_ADDR"];


				$sqld="SELECT decade FROM decadi WHERE inizio<='$now' AND fine >='$now' LIMIT 0,1";
				$resd=mysql_query($sqld);
				$rowsd=mysql_fetch_array($resd, MYSQL_ASSOC);
				
				$_SESSION["decade"]=$rowsd["decade"];
				
				$sql1="UPDATE utenti SET ultimo_accesso ='".date("Y-m-d H:i:s")."' WHERE id_utente='$rows[id_utente]'";
				$res1=mysql_query($sql1);
				$complete=1;
			

	}
}?>

<?php if($complete==1){
	$url=$p_sito."main.php";
	echo '<script>window.location = "'.$url.'";</script>';
    //header("Location:".$p_sito."main.php");
	exit;
?>

    	
<?php }else{ ?>
<div class="row">
 <div class="bs-callout bs-callout-danger">
 	<h4>Errore</h4>
 	<p>Ripetere la procedura</p>
</div>
		
<?php } ?>

</div>
</body>