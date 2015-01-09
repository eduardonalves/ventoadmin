<?php
header("Content-type: application/json");

include_once "../../conexao.php";
include_once "../../lib/class.protectionFipe.php";

//$conexao = new Connection("localhost","root","vento","extrair");
$protectionFipe = new protectionFipe($conexao);

if ( $_GET['action'] == 'marcas' ) {

	$tipoVeiculo = $_GET['tipo'];

	$marcasVeiculos = $protectionFipe->getMarcas($tipoVeiculo);

	echo json_encode($marcasVeiculos);

}elseif ( $_GET['action'] == 'modelos' ) {

	$marcaVeiculo = $_GET['marca'];

	$modelos = $protectionFipe->getModelos($marcaVeiculo);

	echo json_encode($modelos);

	
}elseif ( $_GET['action'] == 'anos' ) {

	$anoModeloVeiculo = $_GET['modelo'];

	$anosModelos = $protectionFipe->getAnos($anoModeloVeiculo);

	echo json_encode($anosModelos);
	
	
}
?>
