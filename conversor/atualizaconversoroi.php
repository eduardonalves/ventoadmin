<!DOCTYPE html>
<html>
<head>
	<title>Atualiza Conversor OI</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
			
	<form id="conversor" name="conversor" action="atualizaconversoroi.php" method="post">
		<label>conversor</label><input type="text" name="segundavia" id="segundavia"/><br />
		<input type="submit" name="enviar" id="enviar"/>
	</form>
	<?

	
	if($_POST){

		mb_internal_encoding("UTF-8"); 
		
		$conexao = mysql_connect("db498864657.db.1and1.com","dbo498864657","MysqlLogOn") or die("Erro na conexão");
		$banco = mysql_select_db("dbo498864657");
		mysql_set_charset("UTF8", $conexao);
		$conversor = explode('[EXTRACT]',$_POST['segundavia']);
		$cpf = $conversor[0];
		$segundaviaoi = $conversor[1];
		$debitos=$conversor[2];
		if($segundaviaoi==''){
			$segundaviaoi='LINHA COM DÉBITOS';
		}
		if($debitos!=''){
			$segundaviaoi='LINHA COM DÉBITOS';
		}
		$sql = "UPDATE spider SET segundavia_oi='".$segundaviaoi."' WHERE cpf='".$cpf."';";
		$result=mysql_query($sql);
		if($result){
			echo '<p id="cpf">'.$cpf.'</p>';
		}
		mysql_close($conexao) ; 
	}
	
	?>
	
</body>
</html>