<?php

$_POST['serial12'] = 1;
$_POST['serial13'] = 2;
$_POST['serial14'] = 3;
$_POST['serial15'] = 4;
$_POST['serial16'] = "3f";
$_POST['serial17'] = "jajjh*(9jm";
$_POST['serial18'] = 7;
$_POST['SerIal18'] = 8;
$_POST['serial19'] = 8;

	
foreach($_POST as $key=>$value)
{
	if(strstr(strtolower($key),'serial'))
	{
		$_POST[$key] = strtoupper($_POST[$key]);

	}
	if ("tt"=="tt")
	{
		echo "eeq";
	}
	
}
//print_r(array_change_key_case($_POST, CASE_UPPER));

print_r($_POST);
?>
