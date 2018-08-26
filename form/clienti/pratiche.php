<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>
$(document).ready(function(){


   $('.tabella-pratiche').DataTable({
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

$('.tabella-pratiche').on( 'draw.dt', function () {
        <?php if($_SESSION["livello"]=="10"){?>
            $(".pagato").bind("click", function(){
               $.post("actions/pratiche.php",{id_pratica:$(this).attr("data-id"), action:"pagato"}, function(data){
                
               })
            })
        $(".fattura").bind("click", function(){
        window.open("pdf/fattura_cliente.php?codice_attivazione="+$(this).attr("data-id"),"_blank");
        });

         $(".visualizza").bind("click", function(){
            window.open("pdf/download.php?codice_attivazione="+$(this).attr("data-id"),"_blank");
            });

        <?php }?>
} );


<?php if($_SESSION["livello"]=="10"){?>
    $(".pagato").bind("click", function(){
       $.post("actions/pratiche.php",{id_pratica:$(this).attr("data-id"), action:"pagato"}, function(data){
        
       })
    });

     $(".invio").bind("click", function(){
       $.post("actions/pratiche.php",{id_pratica:$(this).attr("data-id"), action:"invia_card"}, function(data){
         
       });
    });
<?php }?>




$(".fattura").bind("click", function(){
    window.open("pdf/fattura_cliente.php?codice_attivazione="+$(this).attr("data-id"),"_blank");
});

 $(".visualizza").bind("click", function(){
            window.open("pdf/download.php?codice_attivazione="+$(this).attr("data-id"),"_blank");
            });

});



</script>

<table class="table table-striped table-bordered tabella-pratiche">
	<thead>
		<tr>
			     <th>N.</th>
          <th>Codice Pratica</th>
           <th>Prodotto</th>
			<th>Agente</th>
            <th>Data inserimento</th>
            <th>Data pagamento</th>
            <th>Data attivazione</th>

            <th>&nbsp;</th>
		</tr>	
	</thead>
	<tbody>
	<?php 


        $sql="SELECT codice_attivazione, pratiche.id_cliente AS id_cliente,utenti.nome AS agente, data_inserimento, data_pagamento, data_attivazione AS dataAttivazione, pagato, pratiche.attivo, fatturato, fattura, pratiche.id_pratica, pratiche.id_prodotto_convenzione AS idProdottoConvenzione FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN utenti ON convenzioni.id_utente = utenti.id_utente WHERE  pratiche.id_cliente = '$_GET[id_cliente]' ";
        $sql.=" ORDER BY dataAttivazione DESC";

        $res=mysql_query($sql);
        $num=mysql_num_rows($res);  
       
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)){?>
			
            <?php 
                $pagato = ($rows['pagato'] == '1') ? $pagato_classe="btn-success" : $pagato_classe="btn-danger";
                $attivo = ($rows['attivo'] == '1') ? $attivo_classe="btn-success" : $attivo_classe="btn-danger";
                $fatturato = ($rows['fatturato'] == '1') ? $fatturato_classe="btn-success" : $fatturato_classe="btn-danger";


                $data_pagamento = ($rows['data_pagamento'] != '') ? $data_pagamento=date("d/m/Y", strtotime($rows["data_pagamento"])) : $data_pagamento="";
                $data_inserimento = ($rows['data_inserimento'] != '') ? $data_inserimento=date("d/m/Y", strtotime($rows["data_inserimento"])) : $data_inserimento="";
                $data_attivazione = ($rows['dataAttivazione'] != '') ? $data_attivazione=date("d/m/Y", strtotime($rows["dataAttivazione"])) : $data_attivazione="";
            ?>

            <tr>
				       <td><?php echo $num--;?></td> 
              <td><?php echo $rows["codice_attivazione"];?></td>
               
				<td><?php $sqlp="SELECT * FROM convenzioni_prodotti LEFT JOIN prodotti  ON convenzioni_prodotti.id_prodotto = prodotti.id_prodotto WHERE convenzioni_prodotti.id_convenzione_prodotto='$rows[idProdottoConvenzione]'";
            $resp=mysql_query($sqlp);
            $rowsp=mysql_fetch_array($resp, MYSQL_ASSOC);?>
            <?php echo $rowsp["prodotto"];?>
        </td>
        <td><?php echo $rows["agente"];?></td>
                <td><?php echo $data_inserimento;?></td>
                <td><?php echo $data_pagamento;?></td>
                <?php $sql1="SELECT data_richiesta_attivazione FROM pratiche WHERE id_pratica = '$rows[id_pratica]'";
                      $res1=mysql_query($sql1);
                      $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
                      if($rows1["data_richiesta_attivazione"]!="") $classe="class='cliente'"; else $classe="";
                      ?>

                <td <?php echo $classe;?>><?php echo $data_attivazione;?></td>
				<td>
                <button title="Stato pagamento" data-id="<?php echo $rows['id_pratica'];?>" class="btn_grid <?php echo $pagato_classe;?> pagato"><i class="fa fa-money" aria-hidden="true" title="Pagamento"></i></button>

                <button title="Stato attivazione" data-id="<?php echo $rows['id_pratica'];?>" class="btn_grid <?php echo $attivo_classe;?> attivo"><i class="fa fa-check" aria-hidden="true" title="Attivo"></i></button>    
              
                <button title="Stato fatturazione" data-id="<?php echo $rows['id_pratica'];?>" class="btn_grid <?php echo $fatturato_classe; ?> fatturato"><i class="fa fa-external-link-square" aria-hidden="true"></i></button>  
                 <?php if($_SESSION["livello"]==10){?>
                    <button title="Reinvia prodotto" data-id="<?php echo $rows['id_pratica'];?>" class="btn_grid btn-info invio"><i class="fa fa-envelope" aria-hidden="true"></i></button>  
                 <?php } ?> 
                 <button title="Visualizza prodotto" data-id="<?php echo $rows['codice_attivazione'];?>" class="btn_grid btn-info visualizza"><i class="fa fa-address-card" aria-hidden="true"></i></button>  
                <?php if($_SESSION["livello"]==10 && $rows["fattura"]!=0){?>
                 <button title="Fattura" data-id="<?php echo $rows['id_pratica'];?>" data-codice="<?php echo $rows["codice_attivazione"];?>" class="btn_grid btn-info fattura"><i class="fa fa-file-text" aria-hidden="true"></i></button>

                <?php } ?>
               
                </td>
			</tr>
		<?php }?>
	</tbody>	
</table>