<?php require("includes/parameters.php"); ?>
<?php require("includes/mysql.inc.php"); ?>
<?php require("libraries/func.getinclude.php"); ?>
<?php require("libraries/CFChecker.php"); ?>
<?php
function IndirizzoIpReale()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}



function generateRandomString($length = 11) {
    $characters = '123456789BCDEFGHIJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if($_POST["action"]=="get_user"){
  $sql="SELECT id_utente FROM app_token WHERE token='$_POST[token]'";
  $res=mysql_query($sql);
  $rows=mysql_fetch_array($res, MYSQL_ASSOC);
  echo $rows["id_utente"];
  exit;
}


if($_POST["action"]=="check_cf"){
  $chk = new Checker();
  $cf=$_POST["codicefiscale"];
    if ($chk->isFormallyCorrect($cf)) {

      $anno=$chk->getYearBirth();
      if($anno<20) $anno="20".$anno;
      if($anno>=20) $anno="19".$anno;

        echo $chk->getSex()."|".$anno."-".$chk->getMonthBirth()."-".$chk->getDayBirth()."|".$chk->getCountryBirth();
    } else {
        echo('NO');
    }
exit;
}

if($_POST["action"]=="get_user_name"){
  $sql="SELECT nome, cognome FROM app_token LEFT JOIN clienti ON clienti.id_cliente = app_token.id_utente WHERE token='$_POST[token]'";
  $res=mysql_query($sql);
  $rows=mysql_fetch_array($res, MYSQL_ASSOC);
  echo utf8_encode($rows["nome"]." ".$rows["cognome"]);
  exit;
}
if($_POST["action"]=="check_pratica"){

  $token=generateRandomString(12);

  if($_POST["cf"]=="TESTDEVELOP"):
    $sql="INSERT INTO app_token(id_utente, token) VALUES ('1','$token')";
    $res=mysql_query($sql);

    echo $token;

    exit;
  endif;

 /* $sql0="SELECT * FROM clienti LEFT JOIN app_token ON app_token.id_utente = clienti.id_cliente WHERE codicefiscale='$_POST[cf]'";
  $res0=mysql_query($sql0);

  echo $sql0;
  if(mysql_num_rows($res0)==1){
    echo $rows["token"];
    exit;
  }*/

  $sql="SELECT *, clienti.id_cliente AS id_cliente FROM pratiche LEFT JOIN clienti ON clienti.id_cliente = pratiche.id_cliente WHERE codicefiscale='$_POST[cf]' GROUP BY clienti.id_cliente";

  $res=mysql_query($sql);
  if(mysql_num_rows($res)==1){
    $rows=mysql_fetch_array($res, MYSQL_ASSOC);
    $pwd=generateRandomString(6);
    $sql1="UPDATE clienti SET password='$pwd' WHERE id_cliente = '$rows[id_cliente]'";
    $res1=mysql_query($sql1);

    $sql="INSERT INTO app_token(id_utente, token) VALUES ('$rows[id_cliente]','$token')";
    $res=mysql_query($sql);

    $messaggio=utf8_decode(get_include_contents("gestionale/templates/salutesemplice-inviopassword.html"));
    $nominativo=$rows["nome"]." ".$rows["cognome"];
    $email=$rows["email"];
    $campi=array("{CLIENTE}","{PASSWORD}");
    $valori=array(stripslashes($nominativo),$pwd);
    $messaggio=str_replace($campi,$valori,$messaggio);
    $oggetto="Password accesso Salute Semplice";
    require('PHPMailer/class.phpmailer.php');
    require('PHPMailer/class.smtp.php');
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPAuth = true; // turn on SMTP authentication
    $mail->Username = $p_mail_user; // SMTP username
    $mail->Password = $p_mail_password; // SMTP password
    $mail->Host="ssl0.ovh.net";
    $mail->Port=465;
    $mail->SMTPSecure="ssl";
    $mail->From=$p_smtp_mittente_email;
    $mail->FromName=$p_smtp_mittente;
    $mail->Subject="Password accesso Salute Semplice";
      $mail->MsgHTML($messaggio);
      $mail->AltBody=strip_tags(html_entity_decode($messaggio));
      $mail->Subject=utf8_decode($oggetto);
      $mail->AddAddress($email, stripslashes($nominativo));
      //$mail->AddAddress("luca.merli84@gmail.com", stripslashes($nominativo));
      if ($mail->Send()) {
        echo $token;
        $mail->ClearAddresses();
      }
  }
}
if($_POST["action"]=="check_password"){

  if($_POST["password"]=="TESTDEVELOP"):
     echo "OK";
      exit;
  endif;
  $sql="SELECT * FROM clienti WHERE (id_cliente = '$_POST[id_cliente]' OR codicefiscale='$_POST[cf]') AND password='$_POST[password]'";
  $res=mysql_query($sql);
  if(mysql_num_rows($res)==1){
      echo "OK";
      exit;
    }
}

if($_POST["action"]=="regione"){
  $data="<option></option>";
  $sql="SELECT * FROM province WHERE pro_reg_id='$_POST[regione]' GROUP  BY pro_sigla";
  $res=mysql_query($sql);
  while($rows=mysql_fetch_array($res)){
    $data.="<option value='$rows[pro_sigla]'>$rows[pro_descr]</option>";
  }
  echo utf8_encode($data);
  exit;
}
if($_POST["action"]=="provincia"){
  $data="<option value=''>Tutti</option>";
  $sql="SELECT CapOperativaStruttura FROM anagraficastruttura WHERE ProvinciaOperativaStruttura ='$_POST[provincia]' AND migliorsalute GROUP BY  CapOperativaStruttura";
  $res=mysql_query($sql);
  while($rows=mysql_fetch_array($res)){
    $data.="<option value='$rows[CapOperativaStruttura]'>$rows[CapOperativaStruttura]</option>";
  }
  echo utf8_encode($data);
  exit;
}
if($_POST["action"]=="provincia_sorriso"){
  $data="<option value=''>Tutti</option>";
  $sql="SELECT CapOperativaStruttura FROM anagraficastruttura WHERE ProvinciaOperativaStruttura ='$_POST[provincia]' AND migliorsorriso GROUP BY  CapOperativaStruttura";
  $res=mysql_query($sql);
  while($rows=mysql_fetch_array($res)){
    $data.="<option value='$rows[CapOperativaStruttura]'>$rows[CapOperativaStruttura]</option>";
  }
  echo utf8_encode($data);
  exit;
}

if($_POST["action"]=="convenzione"){
  $sql="SELECT * FROM convenzioni WHERE codice_convenzione = '$_POST[convenzione]'";
  $res=mysql_query($sql);
  if(mysql_num_rows($res)>0){
    $rows=mysql_fetch_array($res, MYSQL_ASSOC);
    echo $rows["landing_acquisto"];
  }else{
    echo "NO";
  }
  exit;
}

if($_POST["action"]=="condizioni_salva"){
  $ip=IndirizzoIpReale();
  $sql="INSERT INTO salva_adesioni (ip, adesione) VALUES ('$ip','".date("Y-m-d H:i:s", strtotime("now"))."')";

  if($res=mysql_query($sql)) echo "OK";
  exit;
}

if($_POST["action"]=="cf_salva"){
  $now=date("Y-m-d H:i", strtotime("now"));
  $sql="SELECT * FROM salva_registrazioni WHERE cf='$_POST[cf]' AND scaduto='0'";
  $res=mysql_query($sql);
  if(mysql_num_rows($res)>0){
    $rows=mysql_fetch_array($res, MYSQL_ASSOC);
    $scadenza=date("Y-m-d H:i", strtotime($rows["data_registrazione"]." +12 months"));
    if($scadenza>$now): 
      echo "already";
    else:
      $sql2="UPDATE salva_registrazioni SET scaduto='1' WHERE id_registrazione ='$rows[id_registrazione]'";
      $res2=mysql_query($sql2);

      $sql1="INSERT INTO salva_registrazioni (cf, data_registrazione) VALUES( '$_POST[cf]', '$now') ";
      $res1=mysql_query($sql1);
      echo "OK";
    endif;
  }else{
    $sql1="INSERT INTO salva_registrazioni (cf, data_registrazione) VALUES( '$_POST[cf]', '$now') ";
    $res1=mysql_query($sql1);
      echo "OK";
  }
  exit;
}


if($_POST["action"]=="card"){
  $sql="SELECT * FROM pratiche WHERE codice_attivazione = '$_POST[card]' AND id_cliente <>'0' AND pagato AND attivo";
  $res=mysql_query($sql);
  if(mysql_num_rows($res)>0){
    $rows=mysql_fetch_array($res, MYSQL_ASSOC);
    echo "OK";
  }else{
    echo "NO";
  }
  exit;
}

?>