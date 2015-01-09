<?php
date_default_timezone_set("Brazil/East");

include_once "conexao.php";
/*
PekeUpload
Copyright (c) 2013 Pedro Molina
*/

// Define a destination
$targetFolder = 'upload/techinmove/'; // Relative to the root


if (!empty($_FILES)) {
	$tempFile = $_FILES['file']['tmp_name'];
	$targetPath = dirname(__FILE__) . '/' . $targetFolder;
	
	$time = time();

	// Validate the file type
	$fileTypes = array('jpg', 'jpeg', 'gif', 'png', 'pdf'); // File extensions
	$fileParts = pathinfo($_FILES['file']['name']);
		
	//$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['file']['name'];
	$filename = $_POST["data"] . "." .$fileParts['extension'];
	$targetFile = rtrim($targetPath,'/') . '/' . $filename;
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		
		$vendaSql = $conexao->query("Select documentos from vendas_techinmove where id='" . $_POST['venda_id'] . "'");
		$linha = $conexao->query("Select * from vendas_techinmove where id='" . $_POST['venda_id'] . "'");
		
		$arrayGrav = array();
		
		$venda = mysql_fetch_assoc($vendaSql);
		
		if ($venda['documentos'] == '') 
		{
			array_push($arrayGrav, $filename);
		}else{
			
			if( substr($venda['documentos'], 0,1) != '[' )
			{
				array_push($arrayGrav, $venda['documentos']);
				array_push($arrayGrav, $filename);
			
			}else{
				
				$arrayGrav = json_decode($venda['documentos'], true);
				array_push($arrayGrav, $filename);
			}
		}
		
		$jDocs = json_encode($arrayGrav);
		
		$conexao->query("UPDATE vendas_techinmove SET documentos='"  .$jDocs . "', auditor='"  .$_POST['user_id'] . "' where id='" . $_POST['venda_id'] . "'");
		$ultimo_envio_documentos = date('Y-m-d');
	
		echo '1';
	} else {
		echo 'Tipo de arquivo inv&aacute;lido.';
	}
}
?>
