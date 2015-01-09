<option value=""></option>
<? 

include "conexao.php";

$monitor = $_GET['m'];
$aparelho = $_GET['ap'];


$conESNS = $conexao->query("Select esns.esn from ESNsSaida esns
								INNER JOIN saidas ON ((esns.id_saida = saidas.id_saida) && saidas.id_parceiro = '". $monitor ."')
								INNER JOIN itenssaida ON ( (saidas.id_saida=itenssaida.id_saida) && itenssaida.id_aparelho='". $aparelho ."')
								where esns.status='Em Estoque' order by esns.esn");

while($esn = mysql_fetch_array($conESNS)){

?>

<option value="<?= $esn['esn'];?>"><?= $esn['esn'];?></option>

<? } ?>



