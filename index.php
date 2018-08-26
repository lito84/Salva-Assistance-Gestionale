<?php include("includes/setup.php");

session_name("Migliorsalute");
session_start();
if ($_SESSION["user_authorized"]==true) {
	header("Location:".$p_sito."main.php");
	exit;
}
?>
<body>
	
<div class="home">
<div class="container">
	<div class="col-xs-12 col-sm-6 col-sm-push-3">
		<div class="login">
			<?php include("includes/header-login.php");?>
			<?php include("form/login.php");?>
		</div>
	</div>
</div>
</div>
</body>
</html>
