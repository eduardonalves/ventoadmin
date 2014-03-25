<!DOCTYPE html>
<html>
<head>
	<title>Conversor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>

<body>
			
	<form id="conversor" name="conversor" action="conversor.php" method="post">
		<label>CPF</label><input type="text" name="cpf" id="cpf"/><br/>
		<label>Nome</label><input type="text" name="nome" id="nome"/><br/>
		<label>endereco</label><input type="text" name="endereco" id="endereco"/><br/>
		<label>telefone</label><input type="text" name="telefone" id="telefone"/><br/>
		<label>obs_oi</label><input type="text" name="obs_oi" id="obs_oi"/><br/>
		<label>cep</label><input type="text" name="cep" id="cep"/><br/>
		<input type="submit" name="enviar" id="enviar"/>
	</form>
	<?


	?>
	<?php
	if($_POST){
		mb_internal_encoding("UTF-8"); 
		
		$conexao = mysql_connect("db498864657.db.1and1.com","dbo498864657","MysqlLogOn") or die("Erro na conexão");
		$banco = mysql_select_db("dbo498864657");
		mysql_set_charset("UTF8", $conexao);
		$cpf = substr($_POST['cpf'],3);
		$telefone=$_POST['telefone'];
		$nome=$_POST['nome'];
		$endereco=$_POST['endereco'];
		$obs_oi=$_POST['obs_oi'];
		$obs_oi=$_POST['cep'];
		$hoje = date("Y-m-d");
		if($nome==""){
			$obs_oi="NUMERO NÃO EXISTE!";
		}else{
			$sql="INSERT INTO spider (nome, cpf, endereco,telefone, cep, obs_oi, data) VALUES ('".$nome."', '".$cpf."', '".$endereco."','".$telefone."', '".$cep."','".$obs_oi."','".$hoje."')";
			$result=mysql_query($sql);
			if($result){
				
			}
		}
		if(isset($cpf)){ echo '<p id="cpf">'.$cpf.'</p>';}
		mysql_close($conexao) ; 
	}
	?>
	
</body>
</html>
