<?php

class Qualidade extends VentoAdmin{
	
	//protected $conexao;

	protected $planilhas = array (

									0=> array(
											
											'label' => "N.A.",
											'status' => "N.A."
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
											'colunas' => array('G' => 'status_data', 'M' => 'os', 'N' => 'novo_numero', 'O' => 'status_xerox')
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
	
	public function getVendaStatus(Venda $venda)
	{

		$novoNumero = $venda->novoNumero;
		$os = $venda->os;
		//$novoNumero = '(21) 4748-3647';
		//return $novoNumero;
		//$os = '15693380';

		//**************antigo ***************
		$statusFind = $this->conexao->query("SELECT DISTINCT(status_portal), (Select MAX( status_data ) as status_data from qualidades q where q.status_portal=qualidades.status_portal && qualidades.novo_numero=q.novo_numero) AS status_data,
			(Select MAX(status_xerox) from qualidades qx where qx.novo_numero='" . $novoNumero . "' && qx.os='" . $os . "') as status_xerox
			FROM `qualidades`
			WHERE (novo_numero = '" . $novoNumero . "' && os='" . $os . "') || (novo_numero = '" . $novoNumero . "' && os='') order by status_portal desc, status_data desc, created desc");
		//************************************

		$data_venda  = substr($venda->data,0,4) . "-" . substr($venda->data,4,2) . "-" . substr($venda->data,6,2) . " 00:00:00";

		$statusFind = $this->conexao->query("SELECT DISTINCT(status_portal), 
		(Select status_data from qualidades q where q.status_portal=qualidades.status_portal && 
		qualidades.novo_numero=q.novo_numero && q.status_data>='" . $data_venda . "' order by q.qualidade_id desc limit 1) AS status_data, 
		(Select status_xerox from qualidades qx where qx.novo_numero='" . $novoNumero . "' && qx.os='" . $os . "' && qx.status_data>='" . $data_venda . "' 
		order by qx.status_xerox desc limit 1) as status_xerox FROM `qualidades` WHERE ((novo_numero = '" . $novoNumero . "' && os='" . $os . "') || 
		(novo_numero = '" . $novoNumero . "' && os='')) && qualidades.status_data>='" . $data_venda . "' order by status_portal desc,
		 status_data desc, created desc");
		
		
		//$statusFind = $this->conexao->query("Select * from qualidades where (os='" . $os . "' || os = '') && novo_numero='" . $novoNumero . "' order by status_portal desc, qualidade_id desc");

		//$statusFind = $this->conexao->query("Select * from qualidades where (os='" . $os . "' || os = '') && novo_numero='" . $novoNumero . "' order by status_portal desc, qualidade_id desc");
		//$statusFind = $this->conexao->query("Select novoNumero, (Select status_portal from qualidades where novo_numero = novoNumero) as statusaa from vendas_clarotv order by statusaa LIMIT 0,100");

		//$statusFind = $this->conexao->query("Select novoNumero, q.status_portal from vendas_clarotv left join qualidades q on (vendas_clarotv.novoNumero=(Select status_portal from qualidades where novo_numero=vendas_clarotv.novoNumero LIMIT 1) ) LIMIT 0,30");
		
		$statusReturn = array();
		
		while( $line = mysql_fetch_assoc($statusFind) )
		{
			$statusReturn[$line['status_portal']] = $line;
		}
		
		if ( count($statusReturn) < 1 )
		{
			foreach ( $this->planilhas as $key=>$value )
			{
				
				$statusReturn[$key]['status_portal'] = $this->planilhas[$key]['status'];
				$statusReturn[$key]['status_data'] = '-';
				$statusReturn[$key]['status_xerox'] = 'SEM DOCUMENTAÇÃO';
			}
		
		}else{

			list($k, $v) = each($statusReturn);

			$xerox = ($statusReturn[$k]['status_xerox']==NULL || $statusReturn[$k]['status_xerox']==0) ? 'SEM DOCUMENTAÇÃO' : 'OK';

			foreach ( $this->planilhas as $key=>$value )
			{
				
				if (! array_key_exists($key, $statusReturn) )
				{

					$statusReturn[$key]['status_portal'] = $this->planilhas[$key]['status'];
					$statusReturn[$key]['status_data'] = '-';
					$statusReturn[$key]['status_xerox'] = $xerox;
					
				}else{

					$statusReturn[$key]['status_portal'] = $this->planilhas[$key]['status'];
					$statusReturn[$key]['status_data'] = date('d/m/Y', strtotime($statusReturn[$key]['status_data']));
					$statusReturn[$key]['status_xerox'] = $xerox;

				}
			}


			$statusReturn['atual']['status_portal'] = $this->planilhas[$k]['status'];
			$statusReturn['atual']['status_data'] = date('d/m/Y', strtotime(trim($statusReturn[$k]['status_data'])));
			$statusReturn['atual']['status_xerox'] = $xerox;
			
		}

		$statusReturn['atual'] = $statusReturn[array_shift(array_keys($statusReturn))];		
		
		ksort($statusReturn);

		return $statusReturn;
		

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
	
	public function fixDate(&$originalDate) {
		
		$datePart = explode('-', $originalDate);
		
		if ( count($datePart) == 3 ) {
			
			$originalDate =  "data";
			
		}else{
			
			$originalDate = "doto";
			
		}
		
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
