<?php
header("Content-type: application/json");

include_once "../../conexao.php";
include_once "../../lib/class.ProtectionAgendamento.php";

if( (! isset($_GET['data'])) || ($_GET['data']=='') ) {

	$horarios = array();

	echo json_encode($horarios);

} else {

	$data = $_GET['data'];

	$dataAgendamento = DateTime::createFromFormat('d/m/Y', $data);
	$dataAtual = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));
	
	if ( $dataAgendamento->getTimestamp() >= $dataAtual->getTimestamp() ) {
		
		//$protectionAgendamento = protectionAgendamentoFactory::Create($dataAgendamento, $conexao);
	
		$horarios = protectionAgendamento::getHorariosLivres($dataAgendamento, $conexao);
	
	}

	echo json_encode($horarios);

}
?>
