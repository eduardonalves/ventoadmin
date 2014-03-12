<!DOCTYPE html>
<html>
<head>
	<title>Atualiza Conversor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
			
	<form id="conversor" name="conversor" action="atualizaconversorpreanalisetv.php" method="post">
		<label>cpf</label><input type="text" name="cpf" id="cpf"/><br />
		<label>obs</label><input type="text" name="obs_embratel" id="obs_embratel"/><br />
		<label>obs credito</label><input type="text" name="obs_credito" id="obs_credito"/><br />
		<label>contratotv</label><input type="text" name="contratotv" id="contratotv"/><br />
		<label>id</label><input type="text" name="id" id="id"/><br />
		<input type="submit" name="enviar" id="enviar"/>
	</form>

	<?php
	if($_POST){
		mb_internal_encoding("UTF-8"); 
		
		include('conexao.php');
		mysql_set_charset("UTF8", $conexao);

		$id=$_POST['id'];
		$cpfaux=$_POST['cpf'];
		$cpf1=substr($cpfaux, 0,3);
		$cpf2=substr($cpfaux, 3,3);
		$cpf3=substr($cpfaux, 6,3);
		$cpf4=substr($cpfaux, 9,2);
		$cpf=$cpf1.'.'.$cpf2.'.'.$cpf3.'-'.$cpf4;
		$obs_embratel_aux= explode('[EXTRACT]',$_POST['obs_embratel']);
		$obs_embratel=$obs_embratel_aux[1];
		$aprovado=$obs_embratel_aux[0];
		$obs_credito=$_POST['obs_credito'];
		$os_aux=explode('Nro. OS:',$_POST['obs_embratel']);
		$os=$os_aux[1];

		$hoje=date("Ymd");
		$sql="UPDATE  spider SET obs_clarotv='".$obs_embratel."', contrato_clarotv='".$os."' WHERE cpf='".$cpf."'";
		$result=mysql_query($sql);
		if($result){
			echo '<p id="cpf">'.$cpf.'</p>';
		}
		echo "<br/>";
		if($obs_embratel_aux==''){
			$obs_embratel_aux="vazio";
		}
		
		echo $obs_embratel;
		echo "<br/>";
		echo $hoje;
		echo "<br/>";
		echo $id;
		echo "<br/> Os:";
		echo $os;
		mysql_close($conexao->connection) ; 
	}
	
	?>
	
</body>
</html>