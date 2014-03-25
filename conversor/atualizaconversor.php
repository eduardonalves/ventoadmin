<!DOCTYPE html>
<html>
<head>
	<title>Atualiza Conversor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>

<body>
			
	<form id="conversor" name="conversor" action="atualizaconversor.php" method="post">
		<input type="text" name="converter" id="converter"/>
		<input type="submit" name="enviar" id="enviar"/>
	</form>
	<?php
	if($_POST){
		mb_internal_encoding("UTF-8"); 
		
		$conexao = mysql_connect("db498864657.db.1and1.com","dbo498864657","MysqlLogOn") or die("Erro na conexão");
		$banco = mysql_select_db("dbo498864657");
		mysql_set_charset("UTF8", $conexao);
		$conversor =$_POST['converter'];
		$extract= explode('[EXTRACT]', $conversor);
		$cpfaux=$extract[0];
		$cpfaux2=explode('-',$cpfaux);
		$cpfaux3=$cpfaux2[0].$cpfaux2[1];
		$cpfaux4=explode('.',$cpfaux3);
		$cpf=$cpfaux4[0].$cpfaux4[1].$cpfaux4[2];
		$cep=$extract[1];
		if($cep ==''){
			$cep="CEP NÃO ENCONTRADO";
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