<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>
$(document).ready(function(){


   $('.table-striped').DataTable({
            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100,"Tutte"]],
            columnDefs: [
             { type: 'date-eu', targets: 5 }
           ],
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
           $(".edit").bind("click", function(){
                $("#contenitore").empty().load("form/clienti/cliente_modifica.php?id_cliente="+$(this).attr('data-id'));
            }); 
    } );
    $(".edit").bind("click", function(){
        $("#contenitore").empty().load("form/clienti/cliente_modifica.php?id_cliente="+$(this).attr('data-id'));
    }); 

});



</script>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
      <td>Cliente</td>
      <td>Agente</td>
      <td>Telefono</td>
      <td>Email</td>
      <td>Comune</td>
      <td>Provincia</td>
      <td></td>
		</tr>	     	
	</thead>
	<tbody>
	<?php 


        $sql="SELECT clienti.id_cliente AS id_cliente, clienti.cognome AS cognome, clienti.nome AS nome, pratiche.id_cliente AS id_cliente,utenti.nome AS agente,clienti.email AS email, clienti.telefono AS telefono, clienti.citta AS citta  FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE  pratiche.id_cliente <> '0' AND clienti.cognome <> '' ";

          if($_SESSION["id_ruolo"]!="01"){
              $sql.="AND utenti.id_utente='$_SESSION[id_utente]'";
          }
        $sql.=" GROUP BY clienti.id_cliente ";
        $sql.=" ORDER BY cognome, nome DESC";
        $res=mysql_query($sql);
        $num=mysql_num_rows($res);
       
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
			      <tr>
    	           <td><?php echo utf8_encode($rows["cognome"]." ".$rows["nome"]);?></td>
                 <td><?php echo $rows["agente"];?></td>
                 <td><?php echo $rows["telefono"];?></td>
                 <td><?php echo $rows["email"];?></td>

                 <?php $sql1="SELECT * FROM comuni_gl LEFT JOIN province_gl ON province_gl.cod_provincia= comuni_gl.cod_provincia WHERE cod_istat='$rows[citta]'";
                       $res1=mysql_query($sql1);
                       $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
                       ?>
                 <td><?php echo utf8_encode($rows1["comune"]);?></td> 
                 <td><?php echo utf8_encode($rows1["sigla"]);?></td>
                 <td><button title="Modifica" data-id="<?php echo $rows['id_cliente'];?>" class="btn btn-warning edit"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Modifica"></i></button></td>     
            </tr>
		<?php }?>
	</tbody>	
</table>