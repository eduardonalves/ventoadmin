<?php

class Usuarios {
	
	
	private $usuario;
	private $conexao;
	
	function __construct(){
		
		global $USUARIO;
		global $conexao;
		
		$this->usuario = $USUARIO;
		$this->conexao = $conexao;

	}
	
	public function __get($propriedade){
		
		$functionName = 'getProperty' . ucwords($propriedade);
		
		if (method_exists($this, $functionName)){
			
			return $this->$functionName();
		
		}else{
			
			return $this->usuario[$propriedade];
			
		}
		
	}


	private function getPropertyGrupos(){
		
		return explode('|', $this->usuario['grupo']);
		
	}
	
	
	public function &getGrupo($id){

		return (object) mysql_fetch_assoc( $this->conexao->query("Select * from menu where grupo='" . $id . "'"));
		
	}
	
	private function calcFat($number){

		$i = $number;
		$calc = 1;
		
		while ($i > 1){
			$calc *= $i;
			$i--;
		}
		
		return $calc;
		
	}
	public function getGruposCombinados(){
	$grupos = $this->__get('grupos');
	$grupos = array('0001', '0003', '0004');

	$menu = array();

	for ($z=0; $z<count($grupos)-1; $z++){

		//echo "Grupo ->".$grupos[$z] ."<br />";
		
		for ($i=$z; $i <= (count($grupos) -1) - $z; $i++){
			//echo $this->calcFat(count($grupos) - $z) ."<br/>";
			echo $i;
			echo "=====Grupos J INICI ====" . $z ."<br/>";
			for($j=$z; $j<=$i; $j++){
				$menu[$z.$i] = $grupos[$j];
				echo $grupos[$j]. "<br />";
			}
			echo "=====Grupos J FIM ====" . $z  ."<br/>";
			
		}

		 
	}
		
		return count($grupos);
		
		/*
		$grupos = $this->__get('grupos');
		
		foreach($grupos as $grupo){
			
			
			
		}
		*/
	}
	
}

?>
