<?php
session_start();
if( (!isset($_SESSION['usuario'])) && (!isset($_SESSION['operador'])) ){ 
	
header("Location: index.php");

	?>

	

<script type="text/javascript">

window.location = 'index.php'

</script>	

	

	

<? } 

include "../conexao.php";

$table = ( (isset($_GET['produto'])) && ($_GET['produto']=='net') ) ? 'tecnicosnet' : 'tecnicos';

if ( (! empty($_GET['tecid'])) && isset($_GET['tecid'] ) ){
	
	$conexao->query('update ' . $table . ' set status=\'DESLIGADO\' where tecnico_id=\'' . $_GET['tecid'] . '\'');
	
	echo mysql_affected_rows();
	
}else{
	
	echo "0";
}

?>
