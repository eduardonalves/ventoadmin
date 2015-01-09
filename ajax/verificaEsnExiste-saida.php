<?php
header ('Content-type: text/html; charset=UTF-8');

include_once "../conexao.php";

$aparelho = strtoupper($_GET['aparelho']);
$esn = strtoupper($_GET['esn']);

$qry = "Select ESNsEntradas.esn, ESNsEntradas.status, itensEntrada.id_aparelho from ESNsEntradas
					INNER JOIN itensEntrada ON (ESNsEntradas.id_entrada=itensEntrada.id_itensEntrada && itensEntrada.id_aparelho='$aparelho' )
					where ESNsEntradas.esn='$esn' order by ESNsEntradas.id_esnsentrada desc LIMIT 1";
	
	$contagem = $conexao->query($qry);
	$count = mysql_num_rows($contagem);
	
	if ( $count >= 1 ){

		if ( strtolower(mysql_result($contagem,0,'status')) == 'em estoque' ){
			
			echo "1";
		
		} elseif ( strtolower(mysql_result($contagem,0,'status')) == 'com parceiro' ){
			
			echo "Impossível adicionar. Já consta uma saída para a esn $esn";
		
		} else {
			
			echo "Impossível adicionar. Já consta uma saída para a esn $esn. \n\nStatus: " . mysql_result($contagem,0,'status') ;
		
		}
	
	} else {
		
		echo "Não foi encontrada nenhuma entrada no estoque para a esn " . $esn . "\n\nVerifique se a esn está correta e se foi dada entrada, se sim verifique o modelo do aparelho.";
	}


?>
