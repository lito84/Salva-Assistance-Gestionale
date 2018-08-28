<?php include("../../includes/auth.inc.php");?>
<?php include("../../includes/mysql.inc.php");?>
<?php 
  $url="form/pratiche/server_processing.php";
  $parametro="";
  if(isset($_GET["pagato"])) $parametro="pagato";
  if(isset($_GET["secondo"])) $parametro="secondo";

  if($parametro!="") $url.="?".$parametro;

  if(isset($_GET["dal"])) $url.="?dal=".$_GET["dal"];
  if(isset($_GET["al"])) $url.="&al=".$_GET["al"];
  if(isset($_GET["oggi"])) $url.="?oggi";
?>
<script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script>


$(document).ready(function(){


  var url = '/gestionale/uploads/documenti/index.php';

    $('#contratto').fileupload({
        url: url,
        dataType: 'json',
        
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {

            $.post("actions/vendite.php",{codice_attivazione:$("#codice_pratica").val(), contratto:file.name, action:"carica_contratto"});
             $('<p/>').text(file.name).appendTo('#files');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

  
   var dataTable=$('.table-striped').DataTable({
    
    
    "bInfo" : false,
    "processing": true,
        "serverSide": true,
        "ajax": "<?php echo $url;?>",

            "lengthMenu": [[25, 50, 100, -1], [25, 50, 100,"Tutte"]],
             "bSort": true,
             
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



      $('.elimina_pratica').on('click', function () {
       $.post("actions/vendite.php",{codice_attivazione:$("#elimina-pratica").val(), action:"richiesta_eliminazione"}, function(data){
           $("#contenitore").empty().load("form/pratiche/pratiche.php");
        });
      });

     $(".upload").bind("click", function(){
      $("#codice_pratica").val($(this).attr("data-codice"));
    });

        $(".visualizza").bind("click", function(){
            window.open("pdf/download.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
          });


        $(".contratto").bind("click", function(){
            window.open("uploads/documenti/files/"+$(this).attr("data-url"),"_blank");
        });

       $(".stampa").bind("click", function(){
           window.open("pdf/download.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
            $("#contenitore").empty().load("form/pratiche/pratiche.php");
        });

        $(".copertina").bind("click", function(){
           window.open("pdf/copertina.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
        });


          $(".eliminazione").bind("click", function(){
            $("#rif_pratica").append($(this).attr("data-codice"));
            $("#elimina-pratica").val($(this).attr("data-codice"));
          });

     
        <?php if($_SESSION["livello"]=="10"):?>
            $(".pagato").bind("click", function(){

               $.post("actions/pratiche.php",{id_pratica:$(this).attr("data-id"), action:"pagato"}, function(data){
                 $("#contenitore").empty().load("form/pratiche/pratiche.php");
               })
            });

            $(".invio").bind("click", function(){
               $.post("actions/pratiche.php",{id_pratica:$(this).attr("data-id"), action:"invia_card"}, function(data){
                 $("#contenitore").empty().load("form/pratiche/pratiche.php");
               });
            });

          $(".attivo").bind("click", function(){
            $.post("actions/vendite.php",{codice_attivazione:$(this).attr("data-codice"), action:"attivazione_pratica"}, function(data){
              $("#contenitore").empty().load("form/pratiche/pratiche.php");
            });             
          });
         <?php endif;?>
  } );


  $('.pratiche-input').on( 'keyup click change', function () {
     
      var i =$(this).attr('id');  // getting column index
      var v =$(this).val();  // getting search input value
      dataTable.columns(i).search(v).draw();
  } );


  $(".visualizza").bind("click", function(){
    window.open("pdf/download.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
  });


  $(".upload").bind("click", function(){
    $("#codice_pratica").val($(this).attr("data-codice"));
  });


  $(".eliminazione").bind("click", function(){
    $("#rif_pratica").append($(this).attr("data-codice"));
    $("#elimina-pratica").val($(this).attr("data-codice"));
  });


   $(".contratto").bind("click", function(){
            window.open("uploads/documenti/files/"+$(this).attr("data-url"),"_blank");
        });


  $(".stampa").bind("click", function(){+
         $.post("actions/vendite.php",{codice_attivazione:$(this).attr("data-codice"), action:"stampa"}, function(data){
           $("#contenitore").empty().load("form/pratiche/pratiche.php");
            window.open("pdf/download.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
        });
  });

  $(".copertina").bind("click", function(){
           window.open("pdf/copertina.php?codice_attivazione="+$(this).attr("data-codice"),"_blank");
        });

  $('#upload_contratto').on('hidden.bs.modal', function () {
       $("#contenitore").empty().load("form/pratiche/pratiche.php");
  });

});
</script>
<table class="table table-striped table-bordered">
  <thead>

    <tr>
     <th class="agente">Numero contratto</th>
     <th class="agente">Invitato</th>
     <th class="agente">Invitante</th>
     <?php if($_SESSION["livello"]==10):?>
        <th class="agente">Agente</th>
     <?php endif;?>
     <th class="agente">Prodotto</th>
     <th class="data">Importo</th>
     <th class="data">Inserimento</th>
     <th class="actions">&nbsp;</th>
    </tr> 
    <tr>
        <th><input type="text" id="0"  class="pratiche-input form-control pratica"></th>
        <th><input type="text" id="1" class="pratiche-input form-control agente"></th>
        <th><input type="text" id="2" class="pratiche-input form-control agente" ></th>
        <?php if($_SESSION["livello"]==10):?>
        <th><input type="text" id="2" class="pratiche-input form-control agente" ></th>
     <?php endif;?>
        <th><input type="text" id="3" class="pratiche-input form-control" ></th>
        <th><input type="text" id="4" class="pratiche-input form-control data" ></th>
        <th><input type="text" id="5" class="pratiche-input form-control data" ></th>
        <th></th>
    </tr>
  </thead>  
</table>

<hr />

<div id="upload_contratto" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload contratto firmato</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label>Contratto firmato</label> 
        <span class="btn btn-success fileinput-button form-control">
            <i class="glyphicon glyphicon-plus"></i>
            <span>Trascina file qui...</span>
            <!-- The file input field used as target for the file upload widget -->
            <input id="contratto" type="file" name="files[]" class="fileupload" multiple>

            <input type="hidden" id="codice_pratica" name="codice_pratica" />
          </span>

          <div class="col-xs-12">
            <hr />
            <div id="progres" class="progress">
                  <div class="progress-bar progress-bar-success"></div>
                  
              </div>
               <div id="files" class="files"></div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary carica" data-dismiss="modal">Conferma e chiudi</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>


<div id="elimina_pratica" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Elimina pratica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label>Confermi richiesta eliminazione pratica <span id="rif_pratica"></span> ?</label> 
        
        <input type="hidden" id="elimina-pratica" value="elimina-pratica" value="" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary elimina_pratica" data-dismiss="modal">Conferma e chiudi</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>
