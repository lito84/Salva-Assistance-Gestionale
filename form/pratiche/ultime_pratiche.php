<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>


<?php if($_SESSION["livello"]<10):?>
<h3 class="table_title">Gli ultimi contratti</h3>
<?php else: ?>
<h3 class="table_title">Contratti da attivare</h3>
<?php endif;?>
<table class="table table-striped table-bordered-none">
  <thead>

    <tr>
     <th class="data">Data</th>
     <th class="agente">Invitante</th>
     <th class="agente">Invitato</th>
     <?php if($_SESSION["livello"]==10):?>
      <th class="agente">Agente</th>
     <?php endif;?>
     <th>Prodotto</th>
     <th></th>
    </tr> 
  </thead>  
  <tbody>
    <?php 
    $sql="SELECT id_agente, codice_attivazione, clienti.cognome AS cognome, clienti.nome AS nome, pratiche.id_cliente AS id_cliente, data_inserimento, data_pagamento, data_attivazione AS dataAttivazione, data_stampa, pagato, pratiche.attivo, fatturato, fattura, pratiche.id_pratica,  prezzo_cliente, pratiche.esportazione_pagamento, prodotti.id_prodotto AS id_prodotto, pratiche.id_agente AS id_agente, id_invitante FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE data_richiesta_attivazione = '' AND data_attivazione <> '' AND pratiche.id_cliente <> '0' ";

      if($_SESSION["livello"]<10):
      $sql.="AND pratiche.id_agente='$_SESSION[id_utente]' ";
      endif;


      if($_SESSION["livello"]==10):
      $sql.="AND pratiche.attivo='0' ";
      endif;
      $sql.=" ORDER BY dataAttivazione DESC ";
      if($_SESSION["livello"]<10):
        $sql.="LIMIT 0,10";
      endif;

        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)):
          $sql1="SELECT cognome, nome FROM invitanti WHERE id_invitante = '$rows[id_invitante]'";
          $res1=mysql_query($sql1);
          $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);

          $sqla="SELECT  nome FROM utenti WHERE id_utente = '$rows[id_agente]'";
          $resa=mysql_query($sqla);
          $rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);

          if($rows["id_prodotto"]=='001') $prodotto="Mezzi Sussistenza";
          if($rows["id_prodotto"]=='002') $prodotto="Spese sanitarie";
          if($rows["id_prodotto"]=='003') $prodotto="Mezzi Sussistenza + Spese sanitarie";


          $data_inserimento = ($rows['data_inserimento'] != '') ? $data_inserimento=date("d-m-y", strtotime($rows["data_inserimento"])) : $data_inserimento="";?>
        <tr>
          <td><?php echo $data_inserimento;?></td>
           <td><?php echo utf8_encode($rows1["cognome"]." ".$rows1["nome"]);?></td>
           <td><?php echo utf8_encode($rows["cognome"]." ".$rows["nome"]);?></td>
            <?php if($_SESSION["livello"]==10):?>
            <td><?php echo utf8_encode($rowsa["nome"]);?></td>
            <?php endif;?>
            <td><?php echo $prodotto."<br />".$rows["codice_attivazione"];?></td>
            <td>
              
              <?php if($_SESSION["livello"]==10):?>
                <button class="btn btn_grid btn-primary visualizza" data-toggle='modal' data-target='#visualizza_contratto' data-codice="<?php echo $rows["codice_attivazione"];?>"><i class="fa fa-search"></i></button>
              <?php endif;?>

            </td>
        </tr>

    <?php endwhile;?>

  </tbody>
</table>
</div>

<hr />


<div id="visualizza_contratto" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="anteprima_contratto"></div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success attivazione_pratica">Attiva</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
        <input type="hidden" name="codice_attivazione_admin" id="codice_attivazione_admin" value="" />
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $(".visualizza").on("click", function(){
     $(".attivazione_pratica").show();
    $("h5.modal-title").empty().append("Contratto "+$(this).attr("data-codice"));
    $("#codice_attivazione_admin").val($(this).attr("data-codice"));
    $(".anteprima_contratto").empty().load("/gestionale/form/vendite/anteprima_pratica_admin.php?codice_attivazione="+$(this).attr("data-codice"));
  });

  $(".attivazione_pratica").on("click", function(){
    $.post("/gestionale/actions/vendite.php",{codice_attivazione:$("#codice_attivazione_admin").val(), action:"attivazione_pratica"}, function(){
      $(".attivazione_pratica").hide();
    })
  });

  $('#visualizza_contratto').on('hidden.bs.modal', function () {
      $(".ultime_pratiche").load("form/pratiche/ultime_pratiche.php");
  });
});
</script>