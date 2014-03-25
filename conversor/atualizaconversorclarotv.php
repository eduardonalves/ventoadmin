<!DOCTYPE html>
<html>
<head>
	<title>Atualiza Conversor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
			
	<form id="conversor" name="conversor" action="atualizaconversorclarotv.php" method="post">
		<label>cpf</label><input type="text" name="cpf" id="cpf"/><br />
		<label>Status</label><input type="text" name="obs_embratel" id="obs_embratel"/><br />
		<label>obs</label><input type="text" name="obs_embratel2" id="obs_embratel2"/><br />
		<label>id</label><input type="text" name="id" id="id"/><br />
		<input type="submit" name="enviar" id="enviar"/>
	<?php
	if($_POST){
		
		
		include('conexao.php');
		
		
		$id=$_POST['id'];
		
		$obs_embratel_aux= explode('[EXTRACT]',$_POST['obs_embratel']);
		$status=$obs_embratel_aux[0];
		$obs=$obs_embratel_aux[1];
		
		if($status=='APROVADO'){
			$sql="UPDATE  vendas_clarotv SET status='PRE-ANALISE', obs_preanailise='".$status."', obs_embratel='".$status."', obs_procmacro='PASSADO NO CLARO TV' WHERE id='".$id."'";
			$result=mysql_query($sql);
			if($result){
				echo 'PRÉ-ANÁLISE';
			}
		}else{
			if($obs=="#EANF#"){
				$obs="Reprovado pela análise automática";
			}
			if($obs==""){
				$obs="Reprovado pela análise automática";
			}
			
			$sql="UPDATE  vendas_clarotv SET obs_preanailise='".$obs."', obs_procmacro='PASSADO NO CLARO TV' WHERE id='".$id."'";
			$result=mysql_query($sql);
			if($result){
				echo 'REPROVADO';
			}
		}
		echo $id;
		echo "<br/>";
		echo "status".$status;
		echo "<br/>";
		echo "obs".$obs;
		echo "<br/>";
		mysql_close($conexao->connection) ; 
	}
	
	?>
	
</body>
</html>