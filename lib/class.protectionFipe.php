<?php

class protectionFipe {
	
	private $conexao;
	
	const TABLE_MARCAS = 'fipe_marca';
	const TABLE_MODELOS = 'fipe_modelo';
	const TABLE_ANOS = 'fipe_ano_modelo';

	public function __construct(Connection $conexao) {
		
		$this->conexao = $conexao;

	}

	public function getMarca($marcaId) {
		
		$con = $this->conexao;
		$sqlString = "Select id, nome from " . self::TABLE_MARCAS . " where id='" . $marcaId . "'";
		$sqlMarca = $this->conexao->query($sqlString);

		return mysql_fetch_assoc($sqlMarca);
	}

	
	public function getMarcas($tipoVeiculo) {
		
		$con = $this->conexao;
		$sqlString = "Select id, nome from " . self::TABLE_MARCAS . " where tipo='" . $tipoVeiculo . "'";
		$sqlMarcas = $this->conexao->query($sqlString);

		$marcasVeiculos = array();

		while ( $linha = mysql_fetch_assoc($sqlMarcas) )
		{
			array_push($marcasVeiculos, $linha);
		}

		return $marcasVeiculos;
	}

	public function getModelo($modeloId) {
		
		$sqlString = "Select id, nome from " . self::TABLE_MODELOS . " where id='" . $modeloId . "'";
		$sqlModelo = $this->conexao->query($sqlString);

		return mysql_fetch_assoc($sqlModelo);
	}


	public function getModelos($marcaVeiculo) {
		
		$sqlString = "Select id, nome from " . self::TABLE_MODELOS . " where marca='" . $marcaVeiculo . "'";
		$sqlModelos = $this->conexao->query($sqlString);

		$modelos = array();

		while ( $linha = mysql_fetch_assoc($sqlModelos) )
		{
			array_push($modelos, $linha);
		}

		return $modelos;
	}

	public function getAno($anoModelo) {
		
		$sqlString = "Select id, nome, modelo, valor from " . self::TABLE_ANOS . " where id='" . $anoModelo . "'";
		$sqlAnoModelo = $this->conexao->query($sqlString);

		return mysql_fetch_assoc($sqlAnoModelo);

	}

	
	public function getAnos($anoModeloVeiculo) {
		
		$sqlString = "Select id, nome, modelo, valor from " . self::TABLE_ANOS . " where modelo='" . $anoModeloVeiculo . "'";
		$sqlAnosModelos = $this->conexao->query($sqlString);

		$anosModelos = array();

		while ( $linha = mysql_fetch_assoc($sqlAnosModelos) )
		{
			array_push($anosModelos, $linha);
		}

		return $anosModelos;
	}

}

?>
