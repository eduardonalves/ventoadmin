<?php
header("Content-type: application/json");
date_default_timezone_set("Brazil/East");

include_once "../../conexao.php";
include_once "../../lib/class.ProtectionAgendamento.php";

if( (! isset($_GET['data'])) || ($_GET['data']=='') ) {

	$horarios = array();

	echo json_encode($horarios);

} else {

	$data = $_GET['data'];

	//$dataAgendamento = DateTime::createFromFormat('d/m/Y', $data);
	//$dataAtual = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));

	$data = explode("/", $data);

	$dataAgendamento = new DateTime($data[2]."-".$data[1]."-".$data[0]);
	$dataAtual = new DateTime(date('Y-m-d'));
	
	if ( strtotime($dataAgendamento->format('Y-m-d')) >= strtotime($dataAtual->format('Y-m-d') )) {
		
		//$protectionAgendamento = protectionAgendamentoFactory::Create($dataAgendamento, $conexao);
	
		$horarios = protectionAgendamento::getHorariosLivres($dataAgendamento, $conexao);
	
	}

	echo json_encode($horarios);

}
?>
