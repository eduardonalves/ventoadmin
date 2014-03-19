<?php
include "conexao.php";

class Qualidade{
	
	protected $conexao;
	
	public function __construct(&$conexao){
		
		$this->conexao =& $conexao;
		
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
			
			
			
			return $sqlString;
			
		}
		
	}
	
	
}


?>
