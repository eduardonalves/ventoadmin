<?php

$esns = array('A10000266A4FA2','A1000026695125','A10000266A4FA3','A10000266951CF','A10000266950BB','A10000266A4FD4','A10000266A4FD5',
'A1000026695082','A10000266951BF','A10000266950D4','A1000026695131','A1000026695139','A1000026695132','A10000266A4F82','A10000266A4F84',
'A10000266A4F7B','A10000266950CB');



	foreach($esns as $esn)
	{

	$query = "Select * from vendas_clarotv INNER JOIN usuarios ON (usuarios.id=vendas_clarotv.monitor) WHERE esn='$esn' && vendas_clarotv.status='FINALIZADA'";

	$result = $conexao->query($query);
	
		
		if(mysql_num_rows($result)>0)
		{
			
			$sql_up="UPDATE ESNsSaida SET status = 'Vendido' WHERE esn = '$esn'";
            $t = mysql_query($sql_up);
			
			echo (mysql_affected_rows(>0) ? "<br>ESN: $esn / OK" : "<br>ESN: $esn / FAIL";
		}
	}
?>
