<?php header('Content-Type: text/html; charset=UTF-8'); ?>
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
		$obs_embratel=$obs_embratel_aux[2];
		$aprovado=$obs_embratel_aux[1];
		$esnAux=$obs_embratel_aux[1];
		$os_aux=explode('Nro. OS:',$_POST['obs_embratel']);
		$os=$os_aux[1];
		
		$esnAuxVend = substr($esnAux, 0, 24);
		
		$cobertura = $obs_embratel_aux[0];
		if($aprovado == "Aleatório"){
			$obs_embratel="Gravar";
			$obs_procmacro="FINAL";
			$obs_macro="PROCESSO DA MACRO ENCERRADO";
		}else{
			
			if($obs_embratel == "Redirecionar para os Planos Aprovados."){
				
				$obs_embratel="REDIRECIONADO";
				$obs_procmacro="AGUARDANDO PROCESSO CLARO-TV";
				$obs_macro="AGUARDANDO PROCESSO CLARO-TV";
				
			}else if($esnAuxVend == "Redirecionar para os Pla"){
				$obs_embratel="REDIRECIONADO";
				$obs_procmacro="AGUARDANDO PROCESSO CLARO-TV";
				$obs_macro="AGUARDANDO PROCESSO CLARO-TV";
			}else if($obs_embratel == "Redirecionar para os Pla"){
				$obs_embratel="REDIRECIONADO";
				$obs_procmacro="AGUARDANDO PROCESSO CLARO-TV";
				$obs_macro="AGUARDANDO PROCESSO CLARO-TV";
			}else if($obs_embratel == "Não foram habilitados planos e forma de pagamento."){
				$obs_embratel="RESTRIÇÃO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="Não foram habilitados planos e forma de pagamento.";
			}else if($obs_embratel =='Quantidade de linhas ativas no endereço de instalação ultrapassa o limite maximo permitido. Venda não pode ser efetuada neste endereço.'){
				$obs_embratel="SEM COBERTURA";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="Quantidade de linhas ativas no endereço de instalação ultrapassa o limite maximo permitido. Venda não pode ser efetuada neste endereço.";
			} else if($obs_embratel =='CPF/CNPJ é obrigatório.'){
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="CPF INVÁLIDO";
			}else if($obs_embratel =='O documento (CPF/CNPJ) do cliente é inválido.'){
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="CPF INVÁLIDO";
			}else if($obs_embratel=="ESN/MEID/ICCID não pode ser vazio."){
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="ESN INVÁLIDA";
			}else if($obs_embratel==" ESN/MEID/ICCID informado não existe."){
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="ESN INVÁLIDA";
			}else if($cobertura == "Não existe endereço coberto pelo serviço."){
				$obs_embratel="SEM COBERTURA";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="Não existe endereço coberto pelo serviço.";
			}else if($esnAux =="ESN/MEID/ICCID informado não existe."){
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="ESN INVÁLIDA";
			}else if($obs_embratel =="Nome é obrigatório."){
				$obs_procmacro="ENCAMINHAR PARA ANÁLISE MANUAL";
				$obs_embratel="PRE-ANALISE";
				$obs_macro="ENCAMINHAR PARA ANÁLISE MANUAL";
			}else if($esnAuxVend =="O código ESN/MEID/ICCID"){
				//esn vendida
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="ESN INVÁLIDA";
			}else if($esnAuxVend =="Quantidade de linhas ati"){
				//esn vendida
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_embratel="SEM COBERTURA";
				$obs_macro="Quantidade de linhas ativas no endereço de instalação ultrapassa o limite maximo permitido. Venda não pode ser efetuada neste endereço.";
			}else if($esnAuxVend =="ESN/MEID/ICCID não pode"){
				//esn vazia
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="ESN INVÁLIDA";
			}else if($esnAuxVend =="Num. Endereço é obriga"){
				//sem numero
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="ERRO: ENDEREÇO DEVE CONTER O NÚMERO, OU s/n";
			}else if($esnAuxVend =="Não foram habilitados p"){
				//sem numero
				$obs_embratel="RESTRIÇÃO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="Não foram habilitados planos e forma de pagamento.";
			}else if($esnAux =="O documento (CPF/CNPJ) do cliente é inválido."){
				
				$obs_embratel="DEVOLVIDO";
				$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
				$obs_macro="O documento (CPF/CNPJ) do cliente é inválido.";
			}else if($obs_embratel==""){
				echo "passou1";
				$obs_embratel="PRE-ANALISE";
				$obs_procmacro="";
				$obs_macro="";
				echo $obs_embratel_aux[4];
				if($obs_embratel_aux[4] == "Serviço Equipamento - Contratável ")
				{
					echo "passou2";
					$obs_embratel="SEM COBERTURA";
					$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
					$obs_macro="Quantidade de linhas ativas no endereço de instalação ultrapassa o limite maximo permitido";
				}
				
				
			}else{
				echo "passou2";
				$obs_embratel="PRE-ANALISE";
				$obs_procmacro="";
				$obs_macro="";
				if($obs_embratel_aux[3] == "Serviço Equipamento - Contratável ")
				{
					echo "passou2";
					$obs_embratel="SEM COBERTURA";
					$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
					$obs_macro="Quantidade de linhas ativas no endereço de instalação ultrapassa o limite maximo permitido";
				}
				if($obs_embratel_aux[2] == "Internal Server Error")
				{
					echo "passou2";
					$obs_embratel="PRE-ANALISE";
					$obs_procmacro="";
					$obs_macro="";
				}
				if($obs_embratel_aux[1] == "Internal Server Error")
				{
					echo "passou2";
					$obs_embratel="PRE-ANALISE";
					$obs_procmacro="";
					$obs_macro="";
				}
				if($obs_embratel_aux[1] =="Nome é obrigatório."){
					$obs_embratel="PRE-ANALISE";
					$obs_procmacro="ENCAMINHAR PARA ANÁLISE MANUAL";
					$obs_macro="ENCAMINHAR PARA ANÁLISE MANUAL";
				}
				if($obs_embratel_aux[1] =="Data Nascimento é obrigatório."){
					$obs_embratel="PRE-ANALISE";
					$obs_procmacro="ENCAMINHAR PARA ANÁLISE MANUAL";
					$obs_macro="ENCAMINHAR PARA ANÁLISE MANUAL";
				}
				
				if($obs_embratel_aux[0] =="Aleatório"){
					$obs_embratel="Gravar";
					$obs_procmacro="FINAL";
					$obs_macro="PROCESSO DA MACRO ENCERRADO";
				}
				if($obs_embratel_aux[1] =="Não existe endereço coberto pelo serviço."){
					$obs_embratel="SEM COBERTURA";
					$obs_procmacro="AGUARDANDO AÇÃO DO USUÁRIO";
					$obs_macro="Não existe endereço coberto pelo serviço.";
				}
			}
			
		}
		if($os == "#EANF# "){
			$os="";
		}
		$hoje=date("Ymd");
		if($id==56873){
			$obs_procmacro="";
			$obs_embratel="SEM COBERTURA";
			$obs_macro="VENDA TESTE";
		}
		$sql="UPDATE  vendas_clarotv SET status='".$obs_embratel."', obs_preanailise='".$obs_macro."', obs_procmacro='".$obs_procmacro."', os='".$os."' WHERE id='".$id."'";
		$result=mysql_query($sql);
		if($result){
			echo '<p id="cpf">'.$cpf.'</p>';
		}
		echo "<br/>";
		if($obs_embratel_aux==''){
			$obs_embratel_aux="vazio";
		}
		
		
		echo "<br/>";
		echo $hoje;
		echo "<br/>";
		echo $id;
		echo "<br/> Os:";
		echo print_r($obs_embratel_aux);
		
		echo "<br/>";
		echo $obs_embratel;
		
		mysql_close($conexao->connection) ;  
	}
	
	print_r($os);
	
	?>
	
</body>
</html>