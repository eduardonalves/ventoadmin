<!DOCTYPE html>
<html>
<head>
	<title>Atualiza Conversor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
			
	<form id="conversor" name="conversor" action="atualizaconversorembratel.php" method="post">
		<label>cpf</label><input type="text" name="cpf" id="cpf"/><br />
		<label>obs</label><input type="text" name="obs_embratel" id="obs_embratel"/><br />
		<input type="submit" name="enviar" id="enviar"/>
	</form>

	<?php

	if($_POST){

		mb_internal_encoding("UTF-8"); 
		
		$conexao = mysql_connect("db498864657.db.1and1.com","dbo498864657","MysqlLogOn") or die("Erro na conexão");
		$banco = mysql_select_db("dbo498864657");
		mysql_set_charset("UTF8", $conexao);
		$cpf=$_POST['cpf'];
		$obs_embratel=$_POST['obs_embratel'];
		if($obs_embratel==""){
			$obs_embratel="SEM COBERTURA";
		}
		if($obs_embratel=="Aleatório"){
			$obs_embratel=="Aprovado";
		}
		$modificado=date("Y-m-d");
		$sql="UPDATE spider SET obs_embratel='".$obs_embratel."', modificado='".$modificado."' WHERE cpf='".$cpf."'";
		$result=mysql_query($sql);
		if($result){
			echo '<p id="cpf">'.$cpf.'</p>';
		}
		mysql_close($conexao) ; 
	}
	
	?>
	
</body>
</html>