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
				status='CONECTADO' &&
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
			data_instalacao != '' && status='CANCELADO'";
		
		$churn = $this->conexao->query($queryChurn);
		
		$queryConectadas = "select count(id) as totalConectadas from vendas_clarotv where produto=10 && 
			(data_venda >= '" . $minDate . "' && data_venda <= '" . $maxDate . "') && 
			status='CONECTADO'";
			
		$conectadas = $this->conexao->query($queryConectadas);

		$myResult['nome'] = 'Churn 120';
		$myResult['meta'] = mysql_result($conectadas, 0 , 'totalConectadas');		
		$myResult['atingida'] = $myResult['meta'] - mysql_result($churn, 0 , 'totalChurn');
		$myResult['porcentagem'] = ($myResult['meta'] == 0) ? 0 : 100 - round( ($myResult['atingida'] * 100) / $myResult['meta'] );

		if($myResult['porcentagem'] <= 2.95){
			
			$myResult['cor'] = "#90EE90";
			
		}elseif ($myResult['porcentagem'] > 2.95 && $myResult['porcentagem'] <= 4.65){
			
			$myResult['cor'] = "yellow";
			
		}else{
			
			$myResult['cor'] = "red";
		}
		
		return $myResult;
		
	}

	public function getBonusVolumeNd($date){
	
		//$metaNd = $this->getMetaND($date);	

		$myResult = array();

		
		$query = "select count(id) as totalNd from vendas_clarotv where produto='10' && 
				netTipoContrato = 'VENDA' && 
				netPerfil != 'COLETIVO' &&
				status='CONECTADO' &&
				data_venda like '" . $date . "%'";
	
		$metaNdAtingida = $this->conexao->query($query);
			
		$myResult['meta_id'] = mysql_result($metaNd, 0 , 'meta_id');
		$myResult['nome'] = 'Meta ND';
		$myResult['atingida'] = mysql_result($metaNdAtingida, 0 , 'totalNd');
			
		$metaNd = $myResult;

		$myReturn = array();		

		if ($metaNd === false){
			
			$myReturn['totalNd'] = 0;
			$myReturn['cor'] = "red";

		} else {

			$cor = "";

			if ($metaNd['atingida'] <= 100) {
				
				$cor = "red";

			} elseif($metaNd['atingida'] > 100 && $metaNd['atingida'] <= 250) {
				
				$cor = "#CFCA16";

			}else{
				$cor = "#90EE90";
			}
			
			$myReturn['totalNd'] = $metaNd['atingida'];
			$myReturn['cor'] = $cor;
			$myReturn['atingida'] = $metaNd['atingida'];
			$myReturn['porcentagem'] = ($myReturn['atingida']*100)/250;
				
		}
		
		return $myReturn;
		
	}
	
	public function getBonusCelular($date){

		$myResult = array();

		$metaQuery = "select * from metasnet where nome='Celular' && periodo='" . $date . "'";
		$metaCelular = $this->conexao->query($metaQuery);
		
		if (mysql_num_rows($metaCelular) > 0 ){
		
			$query = "select count(id) as totalCelular from vendas_clarotv where produto='10' && 
				netPerfil = 'COMBO MULTI' &&
				status='CONECTADO' &&
				data_venda like '" . $date . "%'";
	
			$metaCelularAtingida = $this->conexao->query($query);
			
			$myResult['meta_id'] = mysql_result($metaCelular, 0 , 'meta_id');
			$myResult['nome'] = 'Celular';
			$myResult['meta'] = mysql_result($metaCelular, 0 , 'meta');		
			$myResult['atingida'] = mysql_result($metaCelularAtingida, 0 , 'totalCelular');
			$myResult['porcentagem'] = round( ($myResult['atingida'] * 100) / $myResult['meta'] );
			
			return $myResult;

		}else{
		
			return false;	
		}

	}

	public function inserirBonusCelular($date, $meta){
		
		$hasMeta = $this->getBonusCelular($date);
		
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
			
			$query = "insert into metasnet(nome, periodo, meta, data) VALUES('Celular', '" . $date . "', '" . $meta . "', 
				'" . date("Y-m-d H:i:s") . "')";

			if ($this->conexao->query($query)){
				
				return mysql_insert_id();
				
			}else{
			
				return false;
					
			}
		}
		
	}
	
	public function getMetaEmpresa($date){

		$myResult = array();

		$metaQuery = "select * from metasnet where nome='Meta Empresa' && periodo='" . $date . "'";
		$metaEmpresa = $this->conexao->query($metaQuery);
		
		if (mysql_num_rows($metaEmpresa) > 0 ){
		
			$query = "select count(id) as totalEmpresa from vendas_clarotv where produto='10' && 
				netTipoContrato = 'PME' &&
				status='CONECTADO' &&
				data_venda like '" . $date . "%'";
	
			$metaEmpresaAtingida = $this->conexao->query($query);
			
			$myResult['meta_id'] = mysql_result($metaEmpresa, 0 , 'meta_id');
			$myResult['nome'] = 'Meta Empresa';
			$myResult['meta'] = mysql_result($metaEmpresa, 0 , 'meta');
			$myResult['atingida'] = mysql_result($metaEmpresaAtingida, 0 , 'totalEmpresa');
			$myResult['porcentagem'] = round( ($myResult['atingida'] * 100) / $myResult['meta'] );
			
			return $myResult;

		}else{
		
			return false;	
		}

	}

	public function inserirMetaEmpresa($date, $meta){
		
		$hasMeta = $this->getMetaEmpresa($date);
		
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
			
			$query = "insert into metasnet(nome, periodo, meta, data) VALUES('Meta Empresa', '" . $date . "', '" . $meta . "', 
				'" . date("Y-m-d H:i:s") . "')";

			if ($this->conexao->query($query)){
				
				return mysql_insert_id();
				
			}else{
			
				return false;
					
			}
		}
		
	}
	

	public function getMetaPersonalizada($date, $meta){
		
		$myResult = array();
		$porcentagem = 0;

		$metaQuery = "select * from metasnet where nome='" . $meta . "' && periodo='" . $date . "'";
		$metap = $this->conexao->query($metaQuery);
		
		if ( mysql_num_rows($metap) <= 0 ){
			
			return false;
		}
		
		$fields = json_decode(mysql_result($metap, 0 , 'meta'), true);

		if ( mysql_result($metap, 0 , 'meta') == "" ){
			
			return false;
		}
		
		$sumoffields = 0;
		
		
		foreach ($fields as $field => $value) {
			
			if ($field === 'sumoffields'){ 	continue;	}
			
			if ($value['sinal'] == 'tem'){
				
				$value['sinal']  = " like ";
				$value['valor'] = "%" . $value['valor'] . "%";

			}
			
			$query = "select count(id) as totalfield from vendas_clarotv where produto='10' && 
				" . $field . $value['sinal'] . "'" . $value['valor'] . "' &&
				status='CONECTADO' &&
				data_venda like '" . $date . "%'";

			$fieldSql = $this->conexao->query($query);
			$fieldCount = mysql_result($fieldSql, 0 , 'totalfield');
			
			$sumoffields += $fieldCount;
			
			$fields[$field] = array ( 'meta' => $value['quantidade'], 'atingida' => $fieldCount, 'porcentagem' => round(($fieldCount*100) / $value['quantidade']));
			$porcentagem = $porcentagem + $fields[$field]['porcentagem'];
			$perCont++;
			
		}
		
		if ( array_key_exists('sumoffields', $fields) && $fields['sumoffields'] != '' ){
			
			$fields['sumoffields'] = array('meta'=> $fields['sumoffields'], 'atingida' => $sumoffields, 'porcentagem' => round(($sumoffields*100) / $fields['sumoffields']));
			
			$fields['batida'] = ($fields['sumoffields']['porcentagem'] >= 100) ? true : false;
			
		}else{
			
			$batida = true;
			
			foreach ($fields as $field) {
				
				$batida = ($batida === true && $field['porcentagem'] >= 100) ? true : false;
				
			}
			
			$fields['batida'] = $batida;
		}
		
		$fields['meta_id'] = mysql_result($metap, 0 , 'meta_id');
		$fields['porcentagem'] = ($perCont != 0) ? round(($porcentagem / $perCont)) : 0;

		return $fields;

	}
	
	public function inserirMetaPersonalizada($nome, $date, $metas){
		
		if ( $metas == "" || $metas == NULL ){
			
			$metas = "";
			
			$this->conexao->query ("delete from metasnet where nome='" . $nome . "' && periodo='" . $date . "'");
			return true;
			
		}else{
			
			$metas = json_encode($metas);
			
		}

		$hasMeta = $this->getMetaPersonalizada($date, $nome);
		
		if (count($hasMeta) > 0 && $hasMeta !== false){
			
			$metaId = $hasMeta['meta_id'];	
			$hasMeta = true;

		}else{
			
			$hasMeta = false;
		}
		
		if ($hasMeta){
			
			$query = "update metasnet set meta='" . $metas . "', data='" . date("Y-m-d H:i:s") . "' where
				meta_id = " . $metaId;

			if ($this->conexao->query($query)){
				
				return mysql_affected_rows();
				
			}else{
			
				return false;
					
			}
			
		}else{
			
			$query = "insert into metasnet(nome, periodo, meta, data) VALUES('" . $nome . "', '" . $date . "', '" . $metas . "', 
				'" . date("Y-m-d H:i:s") . "')";

			if ($this->conexao->query($query)){
				
				return mysql_insert_id();
				
			}else{
			
				return false;
					
			}
		}
		
		
	}
	
	public function getCamposFromMeta($date, $meta){
		
		$metaQuery = "select * from metasnet where nome='" . $meta . "' && periodo='" . $date . "'";
		$metap = $this->conexao->query($metaQuery);

		$campos = json_decode( mysql_result($metap, 0 , 'meta'));
		
		return $campos;
		
	}


}

?>
