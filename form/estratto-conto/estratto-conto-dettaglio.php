<?php include("../../includes/mysql.inc.php");
include("../../includes/auth.inc.php");

//Prelevo percentuale ed aliquota collegata all'agente
$sqla="SELECT percentuale, aliquote_agenti.aliquota AS aliquota FROM utenti LEFT JOIN aliquote_agenti ON aliquote_agenti.id_aliquota = utenti.aliquota WHERE id_utente='$_SESSION[id_utente]'";
//Prezzo prodotto 
$resa=mysql_query($sqla);
$rowsa=mysql_fetch_array($resa, MYSQL_ASSOC);
$percentuale=$rowsa["percentuale"];
$aliquota=$rowsa["aliquota"];

?>


<h4>Dettaglio decade <?php echo $_GET["codice_decade"];?></h4>


<table class="table table-striped table-bordered">
  <thead>
    <tr>
     <th class="agente">Codice Pratica</th>
     <th class="agente">Prodotto</th>
     <th class="agente">Cliente</th>
     <th class="agente">Incasso</th>
      <th class="agente">Imponibile</th>
     <th class="provvigioni">Provvigioni</th>
     <th class="ritenuta">Ritenuta</th>
     <th class="ritenuta">Da Versare</th>
     <th class="ritenuta">Data stampa</th>
    </tr> 
    <thead>


    <tbody>
      <?php $sql="SELECT * FROM pratiche LEFT JOIN clienti ON clienti.id_cliente = pratiche.id_cliente WHERE id_agente='$_SESSION[id_utente]' AND codice_attivazione IN (SELECT codice_pratica FROM decadi_pratiche WHERE codice_decade='$_GET[codice_decade]') ORDER BY data_stampa DESC";
        $res=mysql_query($sql);
        while($rows=mysql_fetch_array($res, MYSQL_ASSOC)):


          $sql1="SELECT *, prodotti.id_prodotto AS id_prodotto FROM convenzioni_prodotti LEFT JOIN prodotti ON prodotti.id_prodotto = convenzioni_prodotti.id_prodotto WHERE  id_convenzione_prodotto='$rows[id_prodotto_convenzione]'";
           $res1=mysql_query($sql1);
           $rows1=mysql_fetch_array($res1, MYSQL_ASSOC);
           $id_prodotto=$rows1["id_prodotto"];

          if($rows1["id_prodotto"]=='001') $prodotto="Mezzi Sussistenza";
          if($rows1["id_prodotto"]=='002') $prodotto="Spese sanitarie";
          if($rows1["id_prodotto"]=='003') $prodotto="Mezzi Sussistenza + Spese sanitarie";

          $importo=$rows["importo"];
          $netto=$importo/1.22; 
          $provvigione=$netto*$percentuale/100;    
          $ritenuta=$provvigione*$aliquota;
          $versare=$importo-($provvigione-$ritenuta);

          $importo=number_format($importo,2,",",".");
          $netto=number_format($netto,2,",",".");
          $provvigione=number_format($provvigione,2,",",".");
          $ritenuta=number_format($ritenuta,2,",",".");
          $versare=number_format($versare,2,",",".");?>

          <tr>
            <td><?php echo $rows["codice_attivazione"];?></td>
            <td><?php echo $prodotto;?></td>
            <td><?php echo utf8_encode($rows["cognome"]." ".$rows["nome"]);?></td>
            
            <td><?php echo $importo;?></td>
            <td><?php echo $netto;?></td>
            <td><?php echo $provvigione;?></td>
            <td><?php echo $ritenuta;?></td>
            <td><?php echo $versare;?></td>
            <td><?php echo date("d-m-Y", strtotime($rows["data_stampa"]));?></td>
          </tr>
      <?php  
      endwhile;
      ?>

    </tbody>

</table>
<button class="btn btn-primary back">Torna all'estratto conto</button>

<script type="text/javascript">
  $(document).ready(function(){
    $(".back").on("click", function(){
       $("#contenitore").empty().load("form/estratto-conto/estratto-conto.php");
    })
  });
</script>