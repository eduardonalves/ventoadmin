<?php

class Qualidade extends VentoAdmin{
	
	//protected $conexao;

	protected $planilhas = array (

									0=> array(
											
											'label' => "N.A."
											),
									
									1=> array(
											
											'label' => "INTENÇÕES",
											'status' => 'INTENCIONADA',
											'colunas' => array('G' => 'status_data', 'M' => 'os', 'N' => 'novo_numero')
											),
									
									2=> array(
											
											'label' => "VENDAS CONFIRMADAS",
											'status' => 'VENDA CONFIRMADA',
											'colunas' => array('G' => 'status_data', 'M' => 'os', 'N' => 'novo_numero')
											),
									
									3=> array(
											
											'label' => "ATIVAÇÕES",
											'status' => 'ATIVADA',
											'colunas' => array('G' => 'status_data', 'N' => 'os', 'O' => 'novo_numero', 'P' => 'status_xerox')
											),
									
									4=> array(
											
											'label' => "COMISSÕES",
											'status' => 'COMISSIONADA',
											'colunas' => array('C' => 'status_data', 'K' => 'novo_numero', 'L' => 'os')
											),
									
									5=> array(
											
											'label' => "ESTORNOS",
											'status' => 'ESTORNADA',
											'colunas' => array('C' => 'status_data', 'K' => 'novo_numero')
											)

									);
	
	public function __construct(){
		
		parent::__construct();
		
		echo "a";
	}

	public function getTiposPlanilhas()
	{
		
		return json_decode( json_encode($this->planilhas), true);
	}
	
	public function getPlanilha($planilhaId)
	{
		
		return json_decode( json_encode($this->planilhas[$planilhaId]), true);
		
	}
	
	public function save(array $data){

		if( isset( $data['Qualidade'] ) )
		{

			$camposTabela = $this->conexao->query('SHOW COLUMNS FROM qualidades FROM ' . $this->conexao->dbName);
			
			$sqlString = "INSERT INTO qualidades (";
			
			$virgula = "";

			while( $campo = mysql_fetch_assoc($camposTabela) )
			{
				$sqlString .= $virgula . "" . $campo['Field'] . "";
				$virgula = ",";
			}
			
			$sqlString .= ") VALUES (";
			
			for ($i=0; $i<count($data['Qualidade']); $i++)
			{
				
				$sqlString .= ( $i == 0 ) ? '' : ',(';
				$virgula = "";
				
				mysql_data_seek($camposTabela, 0);
				
				while( $campo = mysql_fetch_assoc($camposTabela) )
				{
					
					if ( strtolower( $campo['Field'] ) != 'created' )
					{

						if ( isset($data['Qualidade'][$i][$campo['Field']] ) )
						{
							$sqlString .= $virgula . "'" . $data['Qualidade'][$i][$campo['Field']] . "'";
							$virgula = ",";
						}else{
							
							$sqlString .= $virgula . "''";
							$virgula = ",";
							
						}
						

					}else{
						
						$sqlString .= $virgula . "'" . date("Y-m-d H:i:s") . "'";
						$virgula = ",";
					}
				}

				$sqlString .= ")";
				
			}
			
			$saveSql = $this->conexao->query($sqlString);
			
			return mysql_insert_id($this->conexao->connection);
			
		}
		
	}
	
	public function getVendaStatus($vendaId)
	{

		if(! is_int($vendaId) )
		{
			trigger_error("Qualidade::getStatusVenda() - Impossível carregar venda. Id não informado ou inválido.", E_USER_ERROR);
		}

		$venda = new Venda($vendaId);
echo "a.";
		$novoNumero = $venda->novoNumero;
		$os = $venda->os;
		$novoNumero = '(21) 4748-3647';
		$os = '15693380';
		$statusFind = $this->conexao->query("Select * from qualidades where (os='" . $os . "' || os = '') && novo_numero='" . $novoNumero . "' order by status_portal desc, qualidade_id desc");
		
		
		//$statusFind = $this->conexao->query("Select * from qualidades where (os='" . $os . "' || os = '') && novo_numero='" . $novoNumero . "' order by status_portal desc, qualidade_id desc");
		//$statusFind = $this->conexao->query("Select novoNumero, (Select status_portal from qualidades where novo_numero = novoNumero) as statusaa from vendas_clarotv order by statusaa LIMIT 0,100");
		
		$statusFind = $this->conexao->query("Select novoNumero, q.status_portal from vendas_clarotv left join qualidades q on (vendas_clarotv.novoNumero=(Select status_portal from qualidades where novo_numero=vendas_clarotv.novoNumero LIMIT 1) ) LIMIT 0,30");
		
		while( $line = mysql_fetch_assoc($statusFind) )
		{
			echo "<pre>";
			print_r($line);
			
			echo "</pre>";
			
		}
		
		return $novoNumero;

	}
	
	public static function maskTel(&$numero)
	{
		$numLenght = strlen($numero);
		
		if ($numLenght == 10)
		{
			$return = "(" . substr($numero, 0, 2) . ") " . substr($numero, 2, 4) . "-" . substr($numero, 6, 4);
		
		}elseif  ($numLenght == 11)
		
		{
			$return = "(" . substr($numero, 0, 2) . ") " . substr($numero, 2, 5) . "-" . substr($numero, 7, 4);
		
		}else
		{
			return false;
		}
		
		$numero = $return;
	}
	
	public static function toFullData(&$shortData)
	{
		$numLenght = strlen($shortData);
		
		if ($numLenght!=8) { return false; }
		
		$return = substr($shortData, 0, 4) . "-" . substr($shortData, 4, 2) . "-" . substr($shortData, 6, 2) . " 00:00:00";
		$shortData = $return;
	}
	

	public static function toShortData(&$longData)
	{
		$numLenght = strlen($longData);
		
		if ($numLenght!=19) { return false; }
		
		$return = substr($longData, 0, 4) . substr($longData, 5, 2) . substr($longData, 8, 2);
		$longData = $return;
	}

}


?>
