<?php
date_default_timezone_set("Brazil/East");
class protectionAgendamento {

	const HORARIO_MINIMO = '09:00:00';
	const HORARIO_MAXIMO =  '18:00:00';
	const INTERVALO_ATENDIMENTO = '3 hours';
	const INTERVALO_HORARIOS = '+30 minutes';

	private $conexao;
	private $objData;

	public function __construct(DateTime $date, Connection $conexao) {

		$this->objData = $date;
		$this->conexao = $conexao;

	}
	
	public static function getAgendamentos(Venda $venda, Connection $conexao) {
		
		$sqlString = "Select * from protectionAgendamentos where id_venda='" . $venda->id . "' order by id_agendamento desc";
		
		$sqlAgendamentos = $conexao->query($sqlString);
		
		$agendamentos = array();

		while ( $sqlAgendamento = mysql_fetch_object($sqlAgendamentos) ) {
			
			array_push($agendamentos, $sqlAgendamento);
			
		}

		return ( count($agendamentos) < 1 ) ?  false : $agendamentos ;
	}
	
	public function novoAgendamento(DateTime $data, Venda $venda) {
		
		$dataAtual = new DateTime(date("Y-m-d H:i:s"));
		
		if ( ( strtotime($data->format("Y-m-d H:i:s")) > strtotime($dataAtual->format("Y-m-d H:i:s")) ) && self::checarHorario($data, $this->conexao) ) {

			$sqlAgendamento = "INSERT INTO protectionAgendamentos(id_venda, dataAgendamento, created) VALUES ('" . $venda->id . "','" . $data->format('Y-m-d H:i:s') . "','" . date("Y-m-d h:i:s") . "')";
			$updVendaAgendamento = "Update vendas_clarotv set protectionDataVisita='" . $data->format('Y-m-d H:i:s') . "' where id='" . $venda->id . "'";
			
			$this->conexao->query($sqlAgendamento);
			$this->conexao->query($updVendaAgendamento);
			
			return true;
			
		} else {
			
			return false;
		}
		
	}
	
	public static function getHorariosLivres(DateTime $date, Connection $conexao) {
		
		$horarios = array();

		$data = new DateTime($date->format('Y-m-d'));

		$sqlString = "Select count(*) as count from protectionAgendamentos where dataAgendamento like '" . $date->format('Y-m-d') . "%'";

		$result = $conexao->query($sqlString);
		
		$temAgendamento  = (mysql_result($result, 0, 'count') == 0 ) ? false : true;

		$dateTimeInicio = new DateTime($data->format('Y-m-d') . self::HORARIO_MINIMO);
		$dateTimeFim = new DateTime($data->format('Y-m-d') . self::HORARIO_MAXIMO);

		$dataAtual = new DateTime(date('Y-m-d H:i:s'));
		$dataAtual->modify('+'.self::INTERVALO_ATENDIMENTO);


		if ( $temAgendamento ) {
			
			while ( ( strtotime($dateTimeInicio->format('Y-m-d H:i:s')) <= strtotime($dateTimeFim->format('Y-m-d H:i:s')) ) ) {

				if ( (self::checarHorario($dateTimeInicio, $conexao)) && ( strtotime($dateTimeInicio->format('Y-m-d H:i:s')) >= strtotime($dataAtual->format('Y-m-d H:i:s')) ) ) {
					
					array_push( $horarios, $dateTimeInicio->format('H:i') );

				}
				
				$dateTimeInicio->modify(self::INTERVALO_HORARIOS);

			}
			
		} else {

			while ( ( strtotime($dateTimeInicio->format('Y-m-d H:i:s')) <= strtotime($dateTimeFim->format('Y-m-d H:i:s')) ) ) {

				if ( ( strtotime($dateTimeInicio->format('Y-m-d H:i:s')) >= strtotime($dataAtual->format('Y-m-d H:i:s')) ) ) {

					array_push( $horarios, $dateTimeInicio->format('H:i') );

				}
				
				$dateTimeInicio->modify(self::INTERVALO_HORARIOS);
				
			}
			
		}

		return ($horarios);
		
	}
	
	public static function checarHorario(DateTime $date, Connection &$conexao) {

		$dateIntervalOne = new DateTime($date->format('Y-m-d H:i:s'));
		$dateIntervalTwo = new DateTime($date->format('Y-m-d H:i:s'));

		$dateIntervalOne->modify('-'.self::INTERVALO_ATENDIMENTO);
		$dateIntervalOne->modify('+1 second');
		
		$dateIntervalTwo->modify('+'.self::INTERVALO_ATENDIMENTO);
		$dateIntervalTwo->modify('-1 second');

		$horarioPretendido = $date->format('Y-m-d H:i:s');

		$intervalo1 = $dateIntervalOne->format('Y-m-d H:i:s');
		$intervalo2 = $dateIntervalTwo->format('Y-m-d H:i:s');
		
		
		$sql1 = "Select count(*) as count, 
		(Select count(*) as count from vendas_clarotv where (produto='7')
		 && protectionDataVisita != '0000-00-00 00:00:00' 
		 && protectionDataVisita BETWEEN '" . $horarioPretendido . "' AND '" . $intervalo2 . "') as count2 
		 from vendas_clarotv where (produto='7') && protectionDataVisita != '0000-00-00 00:00:00' 
		 && protectionDataVisita BETWEEN '" . $intervalo1 . "' AND '" . $horarioPretendido . "'";

		$sql1 = "Select count(*) as count, 
		(Select count(*) as count from ptrc_datas_admin where protectionDataVisita BETWEEN '" . $horarioPretendido . "' AND '" . $intervalo2 . "') as count2 
		 from ptrc_datas_admin where protectionDataVisita BETWEEN '" . $intervalo1 . "' AND '" . $horarioPretendido . "'";
		
		$sql1 = "select count(*) as count from protectionAgendamentos where id_agendamento IN 
		(select max(protectionAgendamentos.id_agendamento) from protectionAgendamentos 
		 group by id_venda) &&
		((dataAgendamento BETWEEN '" . $horarioPretendido . "' and '" . $intervalo2 . "') || 
		(dataAgendamento BETWEEN '" . $intervalo1 . "' and '" . $horarioPretendido . "'))";

		$checkAgendInterval = $conexao->query($sql1);

		$ctAgendamentos = mysql_fetch_object($checkAgendInterval);

		//if ( ($ctAgendamentos->count == 0 && $ctAgendamentos->count2 == 0) ) {
		if ( ($ctAgendamentos->count == 0) ) {

			return true;

		} else {
			
			return false;
			
		}
	}

}

class protectionAgendamentoFactory {

	public static function Create(DateTime $date, Connection $conexao) {

		$DTi = new protectionAgendamento($date, $conexao);
		
		return $DTi;
	}

}

?>
