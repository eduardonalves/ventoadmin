<!DOCTYPE html>
<html>
<head>
	<title>Atualiza Conversor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>

<body>
			
	<form id="conversor" name="conversor" action="atualizaconversorggl.php" method="post">
		
		<label>cpf</label><input type="text" name="cpf" id="cpf"/>
		<label>conversor</label><input type="text" name="converter" id="converter"/>
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
		$conversor =$_POST['converter'];
		$extract= explode(',', $conversor);
		$cep=$extract[1];
		$cpf=$_POST['cpf'];
		if($cep ==''){
			$cep="NULL";
		}
		$sql="UPDATE spider SET cep='".$cep."' WHERE cpf='".$cpf."'";
		$result=mysql_query($sql);
		if($result){
			echo '<p id="cpf">'.$cpf.'</p>';
		}
		mysql_close($conexao) ; 
	}
	
	?>
	
</body>
</html>