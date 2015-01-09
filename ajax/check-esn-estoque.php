<?php

include_once "../conexao.php"; 

$esn = $_GET['esn'];
$monitor = $_GET['monitor'];
$aparelho = $_GET['aparelho'];

$queryEntrada = $conexao->query('Select * from ESNsEntradas where esn=\'' . $esn . '\' order by id_esnsentrada desc LIMIT 1');

if(mysql_num_rows($queryEntrada)<=0) {
	
	echo "A ESN informada não foi encontrado no estoque interno da Vento. Verifique se o código está correto. \n\n Em caso de duvida entre em contato com nosso estoquista.";

}else{

	$esnStatus = strtolower( mysql_result($queryEntrada, 0, 'status') );
	
	if ($esnStatus == 'em estoque' || $esnStatus == 'devolvido') {
	
		echo "Não consta nenhuma saída para a ESN informada no estoque interno da Vento. Verifique se o código está correto. \n\n Em caso de duvida entre em contato com nosso estoquista.";
	
	}else{
		
		$querySaida = $conexao->query('Select * from ESNsSaida where esn=\'' . $esn . '\' order by id_esnssaida desc LIMIT 1');
		
		$esnStatus = strtolower( mysql_result($querySaida, 0, 'status') );
		
		if ($esnStatus == 'vendido'){
			
			echo "Esta ESN consta como vendida no estoque. Entre em contato com o responsável pelo BackOffice.";
		
		}elseif ($esnStatus == 'devolvido'){
			
			echo "Esta ESN consta como devolvida no estoque. Entre em contato com o responsável pelo BackOffice.";
			
		}else{
			
			$idSaida = mysql_result($querySaida, 0, 'id_saida');

			$querySaidaInfos = $conexao->query('Select saidas.id_parceiro, itenssaida.id_aparelho from saidas INNER JOIN itenssaida ON (itenssaida.id_itenssaida=saidas.id_saida) where saidas.id_saida = \'' . $idSaida . '\'');

			$idParceiro = mysql_result($querySaidaInfos, 0, 'id_parceiro');
			$idAparelho = mysql_result($querySaidaInfos, 0, 'id_aparelho');

			if ( $idParceiro != $monitor ) {
				
				echo "Esta ESN consta com saída para outro parceiro. Entre em contato com o estoquista.";

			}else{
				
				if ( $idAparelho != $aparelho ) {
					
					echo "Esta ESN consta no estoque com um modelo de aparelho diferente da venda. Verifique se está correto. \n\nEm caso de dúvidas contate o estoquista.";
					
				}else{
					
					echo "1";
				}
			}
			
			
		}
		
	}
	
}

?>
sds
