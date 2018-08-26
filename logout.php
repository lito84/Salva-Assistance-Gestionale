<?php include("includes/setup.php");
session_name("Migliorsalute");
session_start();
?>
<body>

<div data-role="page" id="home_page">
<?php
$_SESSION = array();
session_destroy();

$url=$p_sito;
echo '<script>window.location = "'.$url.'";</script>';
?>
</div>
</body>
</html>
