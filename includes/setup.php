<?php 
error_reporting(0);
setlocale (LC_TIME, "it_IT");

include("parameters.php");
include("mysql.inc.php");
include("functions.php");
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo utf8_encode($p_ragione_sociale);?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="<?php echo $p_sito;?>js/jquery-ui.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo $p_sito;?>apple-touch-icon.png">
<link rel="icon" type="image/png" href="<?php echo $p_sito;?>favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="<?php echo $p_sito;?>favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="<?php echo $p_sito;?>manifest.json">
<link rel="mask-icon" href="<?php echo $p_sito;?>safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>


<script src="<?php echo $p_sito;?>js/jquery.mask.js"></script>
<script src="<?php echo $p_sito;?>js/fileinput.js"></script>
<script src="<?php echo $p_sito;?>js/fileinput-it.js"></script>
<script src="<?php echo $p_sito;?>js/utils.js"></script>
<script src="<?php echo $p_sito;?>js/global.js"></script>
<script src="<?php echo $p_sito;?>js/bootstrap-show-password.js"></script>
<script src="<?php echo $p_sito;?>js/bootstrap-colorpicker.js"></script>
<script src="<?php echo $p_sito;?>js/chosen.js"></script>
<script src="<?php echo $p_sito;?>js/bootbox.min.js"></script>
<script src="<?php echo $p_sito;?>js/selectize/js/standalone/selectize.min.js"></script>
<script src="<?php echo $p_sito;?>js/pdfobject.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>
<script src="<?php echo $p_sito;?>js/jquery.fileupload.js"></script>
<script src="<?php echo $p_sito;?>js/jquery.fileupload-process.js"></script>
<link rel="stylesheet" href="<?php echo $p_sito;?>js/jquery-ui.css" />
<link rel="stylesheet" href="<?php echo $p_sito;?>css/fileinput.css" />
<link rel="stylesheet" href="<?php echo $p_sito;?>css/colorpicker.css" />
<link rel="stylesheet" href="<?php echo $p_sito;?>css/chosen.css" />
<link rel="stylesheet" href="<?php echo $p_sito;?>css/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

<link rel="stylesheet" href="<?php echo $p_sito;?>css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo $p_sito;?>js/selectize/css/selectize.bootstrap3.css">

<script src="<?php echo $p_sito;?>/js/js-webshim/minified/polyfiller.js"></script> 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.bootstrap.min.css"/>
 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

    <script> 
        webshim.activeLang('it');
        webshims.polyfill('forms');
        webshims.cfg.no$Switch = true;
    </script>

</head>