<?php
date_default_timezone_set("Brazil/East");
/*
PekeUpload
Copyright (c) 2013 Pedro Molina
*/

// Define a destination
$targetFolder = 'upload/'; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['file']['tmp_name'];
	$targetPath = dirname(__FILE__) . '/' . $targetFolder;
	
	$time = time();

	// Validate the file type
	$fileTypes = array('xls'); // File extensions
	$fileParts = pathinfo($_FILES['file']['name']);
		
	//$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['file']['name'];
	$filename = $_POST["data"] . "." .$fileParts['extension'];
	$targetFile = rtrim($targetPath,'/') . '/' . $filename;
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		echo '1';
	} else {
		echo 'Tipo de arquivo inv&aacute;lido.';
	}
}
?>
