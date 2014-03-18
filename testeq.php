<?php
include "lib/class.Qualidade.php";

$q = new Qualidade;

$data = array();
$data['Qualidade'] = array();

$reg1 = array ('modified'=>'mod', 'novo_numero'=>'nno', 'os'=>'osn');

array_push ($data['Qualidade'], $reg1);

echo $q->save($data);
echo "<br><br>";
echo date("Y-m-d H:i:s",  strtotime("+1 days"));
?>
