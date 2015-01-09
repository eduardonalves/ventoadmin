<?php

class metasNet {
	
	private $meta = array();
	private $conexao;
	private $data;

	
	public function __construct(Connection &$conexao){
		
		$this->conexao =& $conexao;

	}
	
	public function getMetaND($date){
		
		$myResult = array();

		$metaQuery = "select * from metasnet where nome='Meta ND' && periodo='" . $date . "'";
		$metaNd = $this->conexao->query($metaQuery);
		
		if (mysql_num_rows($metaNd) > 0 ){
		
			$query = "select count(id) as totalNd from vendas_clarotv where produto='10' && 
				netTipoContrato = 'VENDA' && 
				netPerfil != 'COLETIVO' &&
				data_venda like '" . $date . "%'";
	
			$metaNdAtingida = $this->conexao->query($query);
			
			$myResult['meta_id'] = mysql_result($metaNd, 0 , 'meta_id');
			$myResult['nome'] = 'Meta ND';
			$myResult['meta'] = mysql_result($metaNd, 0 , 'meta');		
			$myResult['atingida'] = mysql_result($metaNdAtingida, 0 , 'totalNd');
			$myResult['porcentagem'] = round( ($myResult['atingida'] * 100) / $myResult['meta'] );
			
			return $myResult;

		}else{
		
			return false;	
		}
				
			
	}
	
	public function inserirMetaND($date, $meta){
		
		$hasMeta = $this->getMetaND($date);
		
		if (count($hasMeta) > 0 && $hasMeta !== false){
			
			$metaId = $hasMeta['meta_id'];	
			$hasMeta = true;

		}else{
			
			$hasMeta = false;
		}
		
		if ($hasMeta){
			
			$query = "update metasnet set meta='" . $meta . "', data='" . date("Y-m-d H:i:s") . "' where
				meta_id = " . $metaId;

			if ($this->conexao->query($query)){
				
				return mysql_affected_rows();
				
			}else{
			
				return false;
					
			}
			
		}else{
			
			$query = "insert into metasnet(nome, periodo, meta, data) VALUES('Meta ND', '" . $date . "', '" . $meta . "', 
				'" . date("Y-m-d H:i:s") . "')";

			if ($this->conexao->query($query)){
				
				return mysql_insert_id();
				
			}else{
			
				return false;
					
			}
		}
		
	}
	
	public function getChurn120($date=""){
	
		$myResult = array();
		
		$date = ($date == "" || strlen($date) != 8) ? date("Ymd") : $date;
		
		$date = substr($date, 0, 4) . "-" . substr($date, 4, 2) . "-" . substr($date, 6, 2);
		
		$minDate = date("Ymd", strtotime($date . " -120 days"));
		$maxDate = date("Ymd", strtotime($date));
		
		$queryChurn = "select count(id) as totalChurn from vendas_clarotv where produto=10 && 
			(data_venda >= '" . $minDate . "' && data_venda <= '" . $maxDate . "') && 
			status='CANCELADO'";
		
		$churn = $this->conexao->query($queryChurn);
		
		$queryConectadas = "select count(id) as totalConectadas from vendas_clarotv where produto=10 && 
			(data_venda >= '" . $minDate . "' && data_venda <= '" . $maxDate . "') && 
			status='CONECTADO'";
			
		$conectadas = $this->conexao->query($queryConectadas);

		$myResult['nome'] = 'Churn 120';
		$myResult['meta'] = mysql_result($conectadas, 0 , 'totalConectadas');		
		$myResult['atingida'] = $myResult['meta'] - mysql_result($churn, 0 , 'totalChurn');
		$myResult['porcentagem'] = ($myResult['meta'] == 0) ? 0 : round( ($myResult['atingida'] * 100) / $myResult['meta'] );
		
		if($myResult['porcentagem'] <= 2.95){
			
			$myResult['cor'] = "green";
			
		}elseif ($myResult['porcentagem'] > 2.95 && $myResult['porcentagem'] <= 4.65){
			
			$myResult['cor'] = "yellow";
			
		}else{
			
			$myResult['cor'] = "red";
		}
		
		return $myResult;
	}

	public function getBonusVolumeNd($date){
	
		$metaNd = $this->getMetaND($date);	

		$myReturn = array();		

		if ($metaNd === false){
			
			$myReturn['totalNd'] = 0;
			$myReturn['cor'] = "red";

		} else {

			$cor = "";

			if ($metaNd['atingida'] <= 100) {
				
				$cor = "red";

			} elseif($metaNd['atingida'] > 100 && $metaNd['atingida'] <= 250) {
				
				$cor = "yellow";

			}else{
				$cor = "green";
			}
			
			$myReturn['totalNd'] = $metaNd['atingida'];
			$myReturn['cor'] = $cor;
				
		}
		
		return $myReturn;
		
	}
	
}

?>
