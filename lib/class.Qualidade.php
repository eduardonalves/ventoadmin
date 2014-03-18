<?php
include "conexao.php";

class Qualidade{
	
	private $conexao;
	
	public function __construct(){
		
		global $conexao;
		
		$this->conexao =& $conexao;
		
	}
	
	public function save(array $data){

		if( isset( $data['Qualidade'] ) )
		{

			$camposTabela = $this->conexao->query('SHOW COLUMNS FROM qualidades FROM ' . $this->conexao->dbName);
			
			$sqlString = "INSERT INTO 'Qualidades'(";
			
			$virgula = "";
			while( $campo = mysql_fetch_assoc($camposTabela) )
			{
				$sqlString .= "'" . $campo['Field'] . "'";
			}
			
			$sqlString .= ") VALUES (";
			$virgula = "";
			
			mysql_data_seek($camposTabela, 0);
			
			for ($i=0; $i<count($data['Qualidade']); $i++)
			{

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

				
			}
			
			return $sqlString;
			
		}
		
	}
	
	
}


?>
