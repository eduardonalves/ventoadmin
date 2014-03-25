<?php
date_default_timezone_set("Brazil/East");
/*
include "lib/class.Qualidade.php";

$q = new Qualidade;

$data = array();
$data['Qualidade'] = array();

$reg1 = array ('modified'=>'mod', 'novo_numero'=>'nno', 'os'=>'osn');

array_push ($data['Qualidade'], $reg1);
array_push ($data['Qualidade'], $reg1);
array_push ($data['Qualidade'], $reg1);
echo $q->save($data);
echo "<br><br>";*/
//echo date("iH",  strtotime("+1 days"));

include "conexao.php";

include "lib/class.VentoAdmin.php";
include "lib/class.VendaStatus.php";
include "lib/class.Venda.php";
include "lib/class.Qualidade.php";
include "lib/class.Usuarios.php";


$q = new Qualidade($conexao);


//echo "N: " . $q->getVendaStatus(51939);
$conexao->query("CREATE TEMPORARY TABLE temp_tb

(

cd_Prod INTEGER NOT NULL,

nome VARCHAR(100) NOT NULL,
status VARCHAR(100) NOT NULL

)
");

//$conexao->query("INSERT INTO `temp_tb`(`cd_Prod`, `Nome`) VALUES ('1','aas'), ('2','sdjs')");
//$conexao->query("INSERT INTO `temp_tb`(`cd_Prod`, `nome`, `status`) Select id, nome, (Select status_portal from qualidades where qualidades.novo_numero=vendas_clarotv.novoNumero order by qualidade_id desc limit 1) as status from vendas_clarotv limit 0,200");
//$conexao->query("INSERT INTO `temp_tb`(`cd_Prod`, `nome`, `status`) Select id, nome, MAX(status_portal) from vendas_clarotv left join qualidades ON (qualidades.novo_numero=vendas_clarotv.novoNumero) limit 0,12000");

$results = $conexao->query('Select * from temp_tb order by status desc');
echo "aas";
while($line = mysql_fetch_assoc($results) )
{
	$i++;
	echo "<pre>$i: ";
	print_r($line);
	echo "</pre>";
}
?>
