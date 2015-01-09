<?php

class protectionAgendamento {

	const HORARIO_MINIMO = '09:00:00';
	const HORARIO_MAXIMO =  '18:00:00';
	const INTERVALO_ATENDIMENTO = 'PT3H';
	const INTERVALO_HORARIOS = 'PT30M';
	
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
		
		$dataAtual = DateTime::createFromFormat('Y-m-d H:i:s', date("Y-m-d H:i:s"));
		
		if ( ( $data->getTimestamp() > $dataAtual->getTimestamp() ) && self::checarHorario($data, $this->conexao) ) {

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

		$data = DateTime::createFromFormat('Y-m-d', $date->format('Y-m-d'));

		$sqlString = "Select count(*) as count from protectionAgendamentos where dataAgendamento like '" . $date->format('Y-m-d') . "%'";

		$result = $conexao->query($sqlString);
		
		$temAgendamento  = (mysql_result($result, 0, 'count') == 0 ) ? false : true;

		$dateTimeInicio = DateTime::createFromFormat('Y-m-d H:i:s', $data->format('Y-m-d') . self::HORARIO_MINIMO);
		$dateTimeFim = DateTime::createFromFormat('Y-m-d H:i:s', $data->format('Y-m-d') . self::HORARIO_MAXIMO);

		$dataAtual = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
		$dataAtual->add(new DateInterval(self::INTERVALO_ATENDIMENTO));

		if ( $temAgendamento ) {
			
			while ( ($dateTimeInicio->getTimestamp() <= $dateTimeFim->getTimestamp()) ) {

				if ( (self::checarHorario($dateTimeInicio, $conexao)) && ($dateTimeInicio->getTimestamp() >= $dataAtual->getTimestamp()) ) {
					
					array_push( $horarios, $dateTimeInicio->format('H:i') );
				
				}
				
				$dateTimeInicio->add(new DateInterval(self::INTERVALO_HORARIOS));

			}
			
		} else {

			while ( ($dateTimeInicio->getTimestamp() <= $dateTimeFim->getTimestamp()) ) {
				
				if ( ($dateTimeInicio->getTimestamp() >= $dataAtual->getTimestamp()) ) {

					array_push( $horarios, $dateTimeInicio->format('H:i') );

				}
				
				$dateTimeInicio->add(new DateInterval(self::INTERVALO_HORARIOS));
				
			}
			
		}

		return ($horarios);
		
	}
	
	public static function checarHorario(DateTime $date, Connection &$conexao) {

		$dateIntervalOne = DateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d H:i:s'));
		$dateIntervalTwo = DateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d H:i:s'));

		$dateIntervalOne->sub(new DateInterval(self::INTERVALO_ATENDIMENTO));
		$dateIntervalOne->add(new DateInterval("PT1S"));
		
		$dateIntervalTwo->add(new DateInterval(self::INTERVALO_ATENDIMENTO));
		$dateIntervalTwo->sub(new DateInterval("PT1S"));

		$horarioPretendido = $date->format('Y-m-d H:i:s');

		$intervalo1 = $dateIntervalOne->format('Y-m-d H:i:s');
		$intervalo2 = $dateIntervalTwo->format('Y-m-d H:i:s');
		
		
		//$sql1 = "Select count(*) as count, (Select count(*) as count from protectionAgendamentos where dataAgendamento BETWEEN '" . $horarioPretendido . "' AND '" . $intervalo2 . "') as count2 from protectionAgendamentos where dataAgendamento BETWEEN '" . $intervalo1 . "' AND '" . $horarioPretendido . "'";
		$sql1 = "Select count(*) as count, (Select count(*) as count from vendas_clarotv where produto='7' && protectionDataVisita != '0000-00-00 00:00:00' && protectionDataVisita BETWEEN '" . $horarioPretendido . "' AND '" . $intervalo2 . "') as count2 from vendas_clarotv where produto='7' && protectionDataVisita != '0000-00-00 00:00:00' && protectionDataVisita BETWEEN '" . $intervalo1 . "' AND '" . $horarioPretendido . "'";
		
		$checkAgendInterval = $conexao->query($sql1);
		$ctAgendamentos = mysql_fetch_object($checkAgendInterval);
		
		if ( ($ctAgendamentos->count == 0 && $ctAgendamentos->count2 == 0) ) {

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
