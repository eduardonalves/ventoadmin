<!DOCTYPE html>
<html>
<head>
	<title>Atualiza Conversor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
			
	<form id="conversor" name="conversor" action="atualizaclarotvmailing.php" method="post">
		<label>cpf</label><input type="text" name="cpf" id="cpf"/><br />
		<label>obs credito</label><input type="text" name="obs_credito" id="obs_credito"/><br />
		<label>contratotv</label><input type="text" name="contratotv" id="contratotv"/><br />
		<input type="submit" name="enviar" id="enviar"/>
	</form>

	<?php
	if($_POST){
		mb_internal_encoding("UTF-8"); 
		
		$conexao = mysql_connect("db498864657.db.1and1.com","dbo498864657","MysqlLogOn") or die("Erro na conexão");
		$banco = mysql_select_db("dbo498864657");
		mysql_set_charset("UTF8", $conexao);

	
		$cpf=$_POST['cpf'];
		$obs_credito=$_POST['obs_credito'];
		$os=$_POST['contratotv'];
	

		$hoje=date("Ymd");
		$sql="UPDATE  spider SET obs_clarotv='".$obs_credito."', contrato_clarotv='".$os."', modificado='".$hoje."' WHERE cpf='".$cpf."'";
		$result=mysql_query($sql);
		if($result){
			echo '<p id="cpf">'.$cpf.'</p>';
			echo "<br/> Os:";
			echo $os;
		}
		
		

		mysql_close($conexao) ; 
	}
	
	?>