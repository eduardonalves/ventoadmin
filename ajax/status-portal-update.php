<?php
ini_set('max_input_vars', 3000);
ini_set('max_input_nesting_level', 3000);
ini_set('post_max_size', '2000');

require_once '../conexao.php';

spl_autoload_register("autoload");

function autoload($class) {
    
    
    include_once "../lib/class." . $class . ".php";

}

$objPlanilhas = new Qualidade($conexao);

$data = array( 'Qualidade' => array() );

$data['Qualidade'] = $_POST['Qualidade'];

$objPlanilhas->save( $data );

if ( mysql_affected_rows($conexao->connection) > 0 )
{
	//echo count($data['Qualidade']) . " / " . count($_POST['Qualidade']);
	//print_r($data);
	echo '1';
}else{
	
	echo '0';
}

?>
