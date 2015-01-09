<?php

date_default_timezone_set("Brazil/East");
if(!isset($_SESSION)){ session_start(); }

include_once "conexao.php";

if(!isset($_SESSION['usuario'])){
?>	
	<script type="text/javascript">

	alert('Usuário não logado. Impossível efetuar reposição.');
	window.close();

	</script>	

<?php
} else {
	
	$v1 = "Select esn, status from ESNsSaida 
	INNER JOIN saidas ON (saidas.id_parceiro='" . $_POST['monitor_venda'] . "' && (saidas.id_saida=ESNsSaida.id_saida))
	WHERE esn='" . $_POST['esn_antiga'] . "' && status='Vendido'";
	
	$checkData = $conexao->query($v1);
	
	if (mysql_num_rows($checkData) <= 0 ){
		
		echo "A esn \"" . $_POST['esn_antiga'] . "\" não consta como vendida no estoque do parceiro selecionado.";
				
	} else {

		$v2 = "Select esn, status, id_aparelho from ESNsSaida 
		INNER JOIN saidas ON (saidas.id_parceiro='" . $_POST['monitor_venda'] . "' && (saidas.id_saida=ESNsSaida.id_saida))
		INNER JOIN itenssaida ON (itenssaida.id_itenssaida=saidas.id_saida)
		WHERE esn='" . $_POST['esn_nova'] . "' && status='Em Estoque' order by id_esnssaida desc limit 1";
		
		$checkData2 = $conexao->query($v2);
		
		if (mysql_num_rows($checkData2) <= 0 ){
		
			echo "A esn \"" . $_POST['esn_nova'] . "\" não consta no estoque do parceiro selecionado.";
		
		} else {

			$sq = "INSERT INTO reposicoes_clarofixo(id_venda, id_aparelho, monitor_venda, operador_venda, esn_antiga, esn_nova, usuario, data) VALUES ('".$_POST['id_venda']."', '".mysql_result($checkData2, 0, 'id_aparelho')."', '".$_POST['monitor_venda']."', '".$_POST['operador_venda']."', '".$_POST['esn_antiga']."',  '".$_POST['esn_nova']."',  '".$_POST['usuario']."', '" . date('Y-m-d H:i:s') . "')";
			$insert = $conexao->query($sq);
			
			$up = "update vendas_clarotv set esn='".$_POST['esn_nova']."' where id= '".$_POST['id_venda']."'";
			$update = $conexao->query($up);
			
			$upesn = "update ESNsSaida set status='Reposição' where esn='". $_POST['esn_antiga'] ."' && status='Vendido'";
			$updatesn = $conexao->query($upesn);
			
			$upesn2 = "update ESNsSaida set status='Vendido' where esn='". $_POST['esn_nova'] ."' && status='Em Estoque'";
			$updatesn2 = $conexao->query($upesn2);
			
			$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".date('Y-m-d H:i:s')."','".$_POST['usuario']."','Reposição de esn de " . strtoupper($_POST['esn_antiga']) . " para " . strtoupper($_POST['esn_nova']) . " (ID: ".$_POST['id_venda'].").')");

			echo "1";
		}
		
	}
	
}

//print_r($_POST);


?>
