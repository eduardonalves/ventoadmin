
<?php
$esns = array('3EE40D6C','3EE40CF7','3EE40CFE','3EE8BA2C','3EE90675','3EE9084B','3EE8BAF1','3EEB08A8','3EEAF153','3EE9B753','3EE9B2C5','3EEB6B8E','3EEB46E6','A100002666B8D6','3EE9B24B','3EEB57E4','3EEB424A','3EE9B24A','3EEAF280','3EEB5807','3EEB1E5E','A1000026677375','3EE9B787','3EEB335A','3EEB060C');

foreach($esns as $esn):
	$query = "Select * from ESNsEntradas esn
			INNER JOIN itensEntrada itens ON (esn.id_entrada=itens.id_itensEntrada)
			INNER JOIN entradas ON (itens.id_entrada=entradas.id_entrada)
			WHERE esn.esn='$esn'";
	
	$result = mysql_fetch_array($conexao->query($query));
	
	echo $esn . ": " . $result['nf'] . "<br>";
	
endforeach;


?>
