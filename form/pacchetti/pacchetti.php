<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){
        $('.table-striped').DataTable({
             "bSort": false,
            "language": 
          {
    "sEmptyTable":     "Nessun dato presente nella tabella",
    "sInfo":           "Vista da _START_ a _END_ di _TOTAL_ elementi",
    "sInfoEmpty":      "Vista da 0 a 0 di 0 elementi",
    "sInfoFiltered":   "(filtrati da _MAX_ elementi totali)",
    "sInfoPostFix":    "",
    "sInfoThousands":  ",",
    "sLengthMenu":     "Visualizza _MENU_ elementi",
    "sLoadingRecords": "Caricamento...",
    "sProcessing":     "Elaborazione...",
    "sSearch":         "Cerca:",
     "sPrint":         "Stampa",
    "sZeroRecords":    "La ricerca non ha portato alcun risultato.",
    "oPaginate": {
        "sFirst":      "Inizio",
        "sPrevious":   "Precedente",
        "sNext":       "Successivo",
        "sLast":       "Fine"
    },
    "oAria": {
        "sSortAscending":  ": attiva per ordinare la colonna in ordine crescente",
        "sSortDescending": ": attiva per ordinare la colonna in ordine decrescente"
    }
    }
        });

$('.table-striped').on( 'draw.dt', function () {
           
    $(".pacchetti").bind("click", function(){
        $("#contenitore").empty().load("form/pacchetti/pacchetti_servizi.php?id_pacchetto="+$(this).attr('data-id'));
    });  
    $(".edit").bind("click", function(){
        $("#contenitore").empty().load("form/pacchetti/pacchetto_modifica.php?id_pacchetto="+$(this).attr('data-id'));
    });

    $(".edit_area").bind("click", function(){
        $("#contenitore").empty().load("form/pacchetti/pacchetto_modifica_servizio.php?id_area="+$(this).attr('data-id'));
    });

} );



$(".pacchetti").bind("click", function(){
    $("#contenitore").empty().load("form/pacchetti/pacchetti_servizi.php?id_pacchetto="+$(this).attr('data-id'));
});

$(".edit").bind("click", function(){
    $("#contenitore").empty().load("form/pacchetti/pacchetto_modifica.php?id_pacchetto="+$(this).attr('data-id'));
});

$(".edit_area").bind("click", function(){
    $("#contenitore").empty().load("form/pacchetti/pacchetto_modifica_servizio.php?id_area="+$(this).attr('data-id'));
});

});



</script>
<table class="table table-striped table-bordered">
<thead>
	<tr>  
        <th>ID</th>
        <th>Pacchetto</th>
        <th>&nbsp;</th>
        
	</tr>	
</thead>
<tbody>
<?php 
$sql="SELECT * FROM pacchetti WHERE master";
$res=mysql_query($sql);       
while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
    <tr class="master">
        <td><?php echo $rows["id_pacchetto"];?></td> 
        <td><?php echo utf8_encode($rows["pacchetto"]);?></td>                
        <td><button data-id="<?php echo $rows['id_pacchetto'];?>" class="btn btn-warning edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
        
    </tr>
<?php $sql1="SELECT * FROM aree_servizi WHERE id_pacchetto = '$rows[id_pacchetto]'";
$res1=mysql_query($sql1);
while($rows1=mysql_fetch_array($res1, MYSQL_ASSOC)){?>
    <tr>
        <td><?php echo $rows1["id_area"];?></td> 
        <td><?php echo utf8_encode($rows1["area"]);?></td>
        <td><button data-id="<?php echo $rows1['id_area'];?>" class="btn btn-warning edit_area"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
    </tr>
<?php } ?>
<?php }?>
</tbody>	
</table>