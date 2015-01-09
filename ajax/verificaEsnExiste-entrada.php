<?php
include_once "../conexao.php";

$origem = strtolower($_GET['origem']);
$esn = strtoupper($_GET['esn']);

if ( $origem=='claro' ){

	$query = "Select count(*) as count from ESNsEntradas where esn='" . $esn . "'";

	$contagem = $conexao->query($query);
	echo mysql_result($contagem,0,'count');
	
} elseif ( $origem=='parceiro' ) {
	
	$qry = "Select count(esn.esn) as count,esn.id_esnssaida, itens.* from ESNsSaida esn
	INNER JOIN itenssaida itens ON (itens.id_itenssaida=esn.id_saida)
	WHERE esn='$esn' && (status='Vendido' OR status='Em Estoque')";
			
	$cont_qry  = $conexao->query($qry);
	
	if ( mysql_result($cont_qry,0,'count') > 0 ){
		echo "0";
	} else {
		
		echo "DEV_FAIL";
	}

}
?>

