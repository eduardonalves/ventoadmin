<!DOCTYPE html>
<html>
<head>
	<title>Atualiza Conversor</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>

<body>
			
	<form id="conversor" name="conversor" action="atualizaconversorpreanalise.php" method="post">
		<label>cpf</label><input type="text" name="cpf" id="cpf"/><br />
		<label>obs</label><input type="text" name="obs_embratel" id="obs_embratel"/><br />
		<label>id</label><input type="text" name="id" id="id"/><br />
		<input type="submit" name="enviar" id="enviar"/>
	</form>

	<?php
	if($_POST){
		mb_internal_encoding("UTF-8"); 
		
		include('conexao.php');
		
		$id=$_POST['id'];
		$cpfaux=$_POST['cpf'];
		$cpf1=substr($cpfaux, 0,3);
		$cpf2=substr($cpfaux, 3,3);
		$cpf3=substr($cpfaux, 6,3);
		$cpf4=substr($cpfaux, 9,2);
		$cpf=$cpf1.'.'.$cpf2.'.'.$cpf3.'-'.$cpf4;
		$obs_embratel_aux= explode('[EXTRACT]',$_POST['obs_embratel']);
		$obs_embratel=$obs_embratel_aux[1];
		$aprovado=$obs_embratel_aux[1];
		$esnAux=$obs_embratel_aux[1];
		$os_aux=explode('Nro. OS:',$_POST['obs_embratel']);
		$os=$os_aux[1];
		
		$esnAuxVend = substr($esnAux, 0, 24);
		
		$cobertura = $obs_embratel_aux[0];
		if($aprovado=="Aleatório"){
			$obs_embratel="Gravar";
		}else{
			
			if($obs_embratel == "Redirecionar para os Planos Aprovados."){
				$obs_embratel="REDIRECIONADO";
			}if($esnAuxVend == "Redirecionar para os Pla"){
				$obs_embratel="REDIRECIONADO";
			}else if($obs_embratel == "Redirecionar para os Pla"){
				$obs_embratel="SEM COBERTURA";
			}else if($obs_embratel == "Não foram habilitados planos e forma de pagamento."){
				$obs_embratel="RESTRIÇÃO";
			}else if($obs_embratel =='Quantidade de linhas ativas no endereço de instalação ultrapassa o limite maximo permitido. Venda não pode ser efetuada neste endereço.'){
				$obs_embratel="SEM COBERTURA";
			} else if($obs_embratel =='CPF/CNPJ é obrigatório.'){
				$obs_embratel="DEVOLVIDO";
			}else if($obs_embratel =='O documento (CPF/CNPJ) do cliente é inválido.'){
				$obs_embratel="DEVOLVIDO";
			}elseif($obs_embratel==""){
				$obs_embratel="PRE-ANALISE";
			}else if($obs_embratel==" ESN/MEID/ICCID não pode ser vazio."){
				$obs_embratel="DEVOLVIDO";
			}elseif($obs_embratel==" ESN/MEID/ICCID informado não existe."){
				$obs_embratel="DEVOLVIDO";
			}elseif($cobertura == "Não existe endereço coberto pelo serviço."){
				$obs_embratel="SEM COBERTURA";
			}elseif($esnAux =="ESN/MEID/ICCID informado não existe."){
				$obs_embratel="DEVOLVIDO";
			}elseif($esnAuxVend =="O código ESN/MEID/ICCID"){
				//esn vendida
				$obs_embratel="DEVOLVIDO";
			}elseif($esnAuxVend =="Quantidade de linhas ati"){
				//esn vendida
				$obs_embratel="SEM COBERTURA";
			}elseif($esnAuxVend =="ESN/MEID/ICCID não pode"){
				//esn vazia
				$obs_embratel="DEVOLVIDO";
				
			}elseif($esnAuxVend =="Num. Endereço é obriga"){
				//sem numero
				$obs_embratel="DEVOLVIDO";
				
			}elseif($esnAuxVend =="Não foram habilitados p"){
				//sem numero
				$obs_embratel="RESTRIÇÃO";
				
			}else{
				$obs_embratel="PRE-ANALISE";
			}
			
		}
		if($os == "#EANF# "){
			$os="";
		}
		$hoje=date("Ymd");
		$sql="UPDATE  vendas_clarotv SET status='".$obs_embratel."', os='".$os."' WHERE id='".$id."'";
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
	print_r($obs_embratel_aux);
	?>
	
</body>
</html>