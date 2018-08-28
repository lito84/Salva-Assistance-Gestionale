<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<?php

$sql="SELECT id_agente, codice_attivazione, clienti.cognome AS cognome, clienti.nome AS nome, pratiche.id_cliente AS id_cliente, data_inserimento, data_pagamento, data_attivazione AS dataAttivazione, data_stampa, pagato, pratiche.attivo, fatturato, fattura, pratiche.id_pratica,  prezzo_cliente, pratiche.esportazione_pagamento, prodotti.id_prodotto AS id_prodotto, pratiche.id_agente AS id_agente, id_invitante FROM pratiche LEFT JOIN clienti ON pratiche.id_cliente = clienti.id_cliente LEFT JOIN convenzioni_prodotti ON pratiche.id_prodotto_convenzione = convenzioni_prodotti.id_convenzione_prodotto LEFT JOIN convenzioni ON convenzioni.id_convenzione = convenzioni_prodotti.id_convenzione LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE richiesta_eliminazione='1' ORDER BY dataAttivazione DESC";

$res=mysql_query($sql);
$num=mysql_num_rows($res);

if($num>0 && $_SESSION["livello"]==10):

?>


<h3 class="table_title table_title_eliminare">Contratti da eliminare</h3>

<table class="table table-striped table-bordered-none">
  <thead>

    <tr>
     <th class="data">Data</th>
     <th class="agente">Invitante</th>
     <th class="agente">Invitato</th>
     <th>Prodotto</th>
     <th></th>
    </tr> 
  </thead>  
  <tbody>
    <?php 
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
          <td><?php echo $prodotto."<br />".$rows["codice_attivazione"];?></td>
          <td><button class="btn btn-danger elimina" data-codice='<?php echo $rows["codice_attivazione"];?>'><i class="fa fa-trash"></i></button></td>
        </tr>
    <?php endwhile;?>
  </tbody>
</table>
</div>

<?php endif; ?>

<script>
$(document).ready(function(){
  $(".elimina").on("click", function(){
      $.post("actions/vendite.php",{codice_attivazione:$(this).attr("data-codice"), action:"elimina_admin"}, function(){
        $(".pratiche_da_eliminare").empty().load("form/pratiche/pratiche_da_eliminare.php")
      })
  });
});
</script>