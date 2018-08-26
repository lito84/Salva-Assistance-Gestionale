<?php include("../../includes/mysql.inc.php");?>
<script>
$(document).ready(function(){
		$('.table-striped').DataTable({
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
           $(".new").bind("click", function(){
                $("#contenitore").empty().load("form/prodotti/prodotto_nuovo.php");
            });
            $(".edit").bind("click", function(){
                $("#contenitore").empty().load("form/prodotti/prodotto_modifica.php?id_prodotto="+$(this).attr('data-id'));
            });

            $(".tariffario").bind("click", function(){
                $("#contenitore").empty().load("form/prodotti/prodotto_tariffario.php?id_prodotto="+$(this).attr('data-id'));
            });

             $(".btn-pdf").bind("click", function(){
              window.open("<?php echo $p_sito;?>pdf/prodotto_singolo.php?id_prodotto="+$(this).attr("data-id"));
            });

        } );


 $(".new").bind("click", function(){
    $("#contenitore").empty().load("form/prodotti/prodotto_nuovo.php");
});
$(".edit").bind("click", function(){
    $("#contenitore").empty().load("form/prodotti/prodotto_modifica.php?id_prodotto="+$(this).attr('data-id'));
});

$(".tariffario").bind("click", function(){
                $("#contenitore").empty().load("form/prodotti/prodotto_tariffario.php?id_prodotto="+$(this).attr('data-id'));
            });
            
 $(".btn-pdf").bind("click", function(){
          window.open("<?php echo $p_sito;?>pdf/prodotto_singolo.php?id_prodotto="+$(this).attr("data-id"));
        });
});



</script>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Id</th>
			<th>Prodotto</th>
			<th>Categoria</th>
            <th>&nbsp;</th>
		</tr>	
	</thead>
	<tbody>
	<?php $sql="SELECT * FROM prodotti LEFT JOIN prodotti_categorie ON prodotti_categorie.id_categoria = prodotti.categoria WHERE attivo";
		$res=mysql_query($sql);
		while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
			<tr>
				<td><?php echo $rows["id_prodotto"];?></td>
				<td><?php echo utf8_encode($rows["prodotto"]);?></td>
				<td><?php echo $rows["categoria"];?></td>
				<td><button data-id="<?php echo $rows['id_prodotto'];?>" class="btn_grid btn-warning edit"><i class="fa fa-edit" aria-hidden="true"></i></button>

                    <?php 
                        $sql1="SELECT * FROM prodotti_meta WHERE chiave='Modello' AND id_prodotto='$rows[id_prodotto]'";
                        $res1=mysql_query($sql1);
                        if(mysql_num_rows($res1)>0){
                            $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);?>
                           <button title="Visualizza prodotto" data-id="<?php echo $rows["id_prodotto"];?>" class="btn_grid btn-primary btn-pdf"><i class="fa fa-file" aria-hidden="true"></i></button>
                   <?php } ?>

                   <button data-id="<?php echo $rows['id_prodotto'];?>" class="btn_grid btn-success tariffario"><i class="fa fa-euro-sign" aria-hidden="true"></i></button>

                </td>
			</tr>
		<?php }?>
	</tbody>	
</table>


<button type="button" class="btn btn-primary new">Nuovo prodotto</button>