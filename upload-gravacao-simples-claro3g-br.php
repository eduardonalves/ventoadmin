<?
date_default_timezone_set("Brazil/East");

ini_set('upload_max_filesize', '40M');  

ini_set('post_max_size', '40M');  

ini_set('max_input_time', 300);  

ini_set('max_execution_time', 300);


$uploaded = 0;

if(isset($_POST['upload'])){

	$status = "GRAVADO";	
/*
if($_POST['proposta'] != ''){

	

$status = "GRAVADO";	

} else {

	

$status = "PRE-ANALISE";	



}

*/

$auditorpost = $_POST['auditor'];



$arquivo = date('YmdHis').'-'.$_GET['id'].'.mp3';



$pasta = "../audio/claro3g/orig/";		



foreach($_FILES["gravacao"]["error"] as $key => $error){

	

	if($error == UPLOAD_ERR_OK){



$tmp_name = $_FILES["gravacao"]["tmp_name"][$key];

$gravacao = $_FILES["gravacao"]["name"][$key];





$uploadfile = $pasta . $arquivo;





if(move_uploaded_file($tmp_name, $uploadfile)){ 

$uploaded = 1;

}

			$data = date("Y-m-d");
			
			$backupGravacoes = "gravacoes/claro3g/" . $data;
			
			if(! is_dir($backupGravacoes) )
			{
				mkdir($backupGravacoes);
				chmod($backupGravacoes, 0777);
			}
			
			copy($uploadfile, $backupGravacoes . "/" . $arquivo);
			chmod($backupGravacoes . "/" . $arquivo, 0777);







}}





	

	}



?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>UpLoad Gravação</title>

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>

<script type="text/javascript">

$(document).ready( function() {

	$("[name='gravacoes']").trigger("submit");

});

</script>

</head>

<body style="font-family:Arial, Helvetica, sans-serif">

<form name="gravacoes" action="http://vem.vento-consulting.com/upload-gravacao-simples-claro3g.php?id=<?php echo $_GET["id"]; ?>" enctype="multipart/form-data" method="post">

<input type="hidden" name="uploaded" value="<?php echo $uploaded; ?>" />
<input type="hidden" size="40" name="msisdn" value="<?= $_POST['msisdn'];?>" />
<input type="hidden" size="40" name="numordem" value="<?= strtoupper($_POST['numordem']);?>" />
<input type="hidden" size="40" name="cliente" value="<?= $_POST['cliente'];?>" />
<input type="hidden" name="proposta" value="<?php echo $_POST["proposta"];?>" />
<input type="hidden" name="telefone" value="<?php echo $_POST["telefone"];?>" />
<input type="hidden" name="auditor" value="<?php echo $_POST["auditor"];?>" />
<input type="hidden" name="nome_arquivo" value="<?php echo $arquivo;?>" />
<input type="hidden" name="upload" value="Enviar" />
</form>


</body>

</html>
