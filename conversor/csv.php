<!DOCTYPE html>
<html>
<head>
	<title>Gerador de CSV</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>

<body>
			
	<form id="csv" name="csv" action="csv.php" method="post">
		<select name="selectcsv" id="selectcsv">
			<option value="embratel1">Embratel ASC</option>
			<option value="embratel2">Embratel DESC</option>
			<option value="extract">Extract</option>
			<option value="oivende">Oi-Vende</option>
			<option value="oicep">Oi-Cep</option>
			<option value="cep2">Oi-Cep Google</option>
			<option value="segundavia">Segundavia</option>
			<option value="segundaviaAdmin">Segundavia Admin</option>
			<option value="clarotv">Claro TV</option>
			<option value="clarotvadmin">Claro TV Admin Interna</option>
			<option value="clarotvadmin2">Claro TV Admin Externa</option>
			<option value="clarotvadmin3">Claro TV Admin TODAS</option>
			<option value="preanalise">Pré-Análise INTERNA</option>
			<option value="preanalise2">Pré-Análise EXTERNA</option>
			<option value="preanaliseFinal">Pré-Análise INTERNA Final</option>
			<option value="preanaliseFinal2">Pré-Análise EXTERNA Final</option>
			
		</select>
		
		<label>Digite seu o prefixo</label>
		<input type="text" name="prefixo" id="prefixo"/>
		<input type="submit" name="enviar" id="enviar"/>
	</form>

	<?php
	
	if($_POST){
		mb_internal_encoding("UTF-8"); 
		
		include('conexao.php');
		$opt =$_POST['selectcsv'];
		//seleciona e gera csv para a embratel ASC
		if($opt=="embratel1"){
			$sql="SELECT * FROM spider WHERE obs_embratel ='' OR obs_embratel IS NULL AND cep !='' AND cep  !='CEP NÃO ENCONTRADO' AND obs_oi NOT LIKE '%já possui Velox%'";
			$resutado = mysql_query($sql);
			
			$csv="";
			
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$csv .='"'.$arraycsv['cpf'].'"'.','; 
				$csv .='"'.$arraycsv['cep'].'"'."\n"; 
				
				
			}
			$embratel= $csv;
			if(isset($embratel)){
				$fp = fopen("embratel.csv","w");
				fwrite($fp,$embratel);
				fclose($fp);
				echo "<a href='embratel.csv'>Clique aqui para baixar arquivo embratel.csv</a>";
			}
				
		}
		//seleciona e gera csv para a embratel ASC
		if($opt=="embratel2"){
			$sql="SELECT * FROM spider WHERE obs_embratel ='' OR obs_embratel IS NULL AND cep !='' AND cep  !='CEP NÃO ENCONTRADO' AND obs_oi NOT LIKE '%já possui Velox.%' ORDER BY id_cliente DESC	";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$csv .='"'.$arraycsv['cpf'].'"'.','; 
				$csv .='"'.$arraycsv['cep'].'"'."\n"; 
				
				
			}
			$embratel= $csv;
			if(isset($embratel)){
				$fp = fopen("embratel.csv","w");
				fwrite($fp,$embratel);
				fclose($fp);
				echo "<a href='embratel.csv'>Clique aqui para baixar arquivo embratel.csv</a>";
			}
				
		}
		//seleciona e gera csv extract
		if($opt=="extract"){
				echo "<a href='extract.csv'>Clique aqui para baixar arquivo extract.csv</a>";		
		}
		
		//seleciona e gera csv para o sinweb
		if($opt=="oicep"){
			$sql="SELECT * FROM spider WHERE cep ='' or cep IS NULL AND cpf NOT LIKE '%TRACT%' AND obs_oi NOT LIKE '%já possui Velox%'";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$csv .='"'.$arraycsv['cpf'].'"'.','; 
				$csv .='"'.$arraycsv['telefone'].'"'."\n"; 
				
				
			}
			$oicep= $csv;
			if(isset($oicep)){
				$fp = fopen("oicep.csv","w");
				fwrite($fp,$oicep);
				fclose($fp);
				echo "<a href='oicep.csv'>Clique aqui para baixar arquivo oicep.csv</a>";
			}
				
		}
		//seleciona e gera csv para o google
		if($opt=="cep2"){
			$sql="SELECT * FROM spider WHERE cep ='' or cep IS NULL AND cpf NOT LIKE '%TRACT%' AND obs_oi NOT LIKE '%já possui Velox%' and endereco like '%NIU%'";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$endaux=explode('NIU',$arraycsv['endereco']);
				$end= $endaux[0].' Nova Iguacu'.$endaux[1];
				$csv .='"'.$arraycsv['cpf'].'"'.','; 
				$csv .='"'.$end.'"'."\n"; 
				
				
			}
			$oicep= $csv;
			if(isset($oicep)){
				$fp = fopen("oicep2.csv","w");
				fwrite($fp,$oicep);
				fclose($fp);
				echo "<a href='oicep2.csv'>Clique aqui para baixar arquivo oicep2.csv</a>";
			}
				
		}	
		//seleciona e gera csv para segundavia oi
		if($opt=="segundavia"){
			$sql="SELECT * FROM spider WHERE segundavia_oi ='' or segundavia_oi IS NULL AND cpf NOT LIKE '%TRACT%' AND obs_oi LIKE '%possui Velox%'";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$tel = substr($arraycsv['telefone'],2);
				$ddd = substr($arraycsv['telefone'],0,2);
				$csv .='"'.$arraycsv['cpf'].'"'.','; 
				$csv .='"'.$tel .'"'.","; 
				$csv .='"'.$ddd .'"'."\n"; 
				
			}
			$oicep= $csv;
			if(isset($oicep)){
				$fp = fopen("oicep.csv","w");
				fwrite($fp,$oicep);
				fclose($fp);
				echo "<a href='oicep.csv'>Clique aqui para baixar arquivo segundavia.csv</a>";
			}
				
		}
		//seleciona e gera csv para clarotv
		if($opt=="clarotv"){
			$sql="SELECT * FROM spider WHERE obs_embratel LIKE '%Redirecionar para os Planos Aprovados%' AND obs_oi NOT LIKE '%já possui Velox%' AND (obs_clarotv ='' or obs_clarotv IS NULL )";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$tel = substr($arraycsv['telefone'],2);
				$ddd = substr($arraycsv['telefone'],0,2);
				$cepaux=explode('-', $arraycsv['cep']);
				$cep=$cepaux[0].$cepaux[1];
				$csv .='"'.$arraycsv['cpf'].'"'.','; 
				$csv .='"'.$arraycsv['nome'].'"'.','; 
				$csv .='"'.$cep .'"'.","; 
				$csv .='"'.$tel .'"'.","; 
				$csv .='"'.$ddd .'"'."\n"; 
				
			}
			$clarotv= $csv;
			if(isset($clarotv)){
				$fp = fopen("clarotv.csv","w");
				fwrite($fp,$clarotv);
				fclose($fp);
				echo "<a href='clarotv.csv'>Clique aqui para baixar arquivo clarotv.csv</a>";
			}
				
		}
		//seleciona e gera csv para clarotv admin vendas internas
		if($opt=="clarotvadmin"){
			$sql="SELECT id, nome, telefone, cpf, cep, numero FROM vendas_clarotv WHERE produto=3 AND status='REDIRECIONADO' AND obs_preanailise='' AND obs='' and tipoVenda='INTERNA' ORDER BY id DESC LIMIT 50";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$tel = substr($arraycsv['telefone'],5);
				$telaux=explode('-',$tel );
				$tel=$telaux[0].$telaux[1];
				$ddd = substr($arraycsv['telefone'],1,2);
				$id=$arraycsv['id'];
				$cpf=$arraycsv['cpf'];
				$cpfaux=explode('.', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1].$cpfaux[2];
				$cpfaux=explode('-', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1];
				$cepaux=explode('-', $arraycsv['cep']);
				$cep=$cepaux[0].$cepaux[1];
				$numero=$arraycsv['numero'];
				$csv .='"'.$cpf.'"'.','; 
				$csv .='"'.$arraycsv['nome'].'"'.','; 
				$csv .='"'.$tel .'"'.","; 
				$csv .='"'.$ddd .'"'.","; 
				$csv .='"'.$cep .'"'.","; 
				$csv .='"'.$id .'"'.","; 
				$csv .='"'.$numero .'"'."\n"; 
				
			}
			$clarotv= $csv;
			if(isset($clarotv)){
				$fp = fopen("clarotvadmin.csv","w");
				fwrite($fp,$clarotv);
				fclose($fp);
				echo "<a href='clarotvadmin.csv'>Clique aqui para baixar arquivo clarotvadmin.csv</a>";
			}
				
		}
		
//seleciona e gera csv para clarotv admin vendas externas
		if($opt=="clarotvadmin2"){
			$sql="SELECT id, nome, telefone, cpf, cep, numero, esn FROM vendas_clarotv WHERE produto=3 AND status='REDIRECIONADO' AND obs_preanailise='' AND obs='' and tipoVenda='EXTERNA' ORDER BY id DESC LIMIT 50";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$tel = substr($arraycsv['telefone'],5);
				$telaux=explode('-',$tel );
				$tel=$telaux[0].$telaux[1];
				$ddd = substr($arraycsv['telefone'],1,2);
				$id=$arraycsv['id'];
				$cpf=$arraycsv['cpf'];
				$cpfaux=explode('.', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1].$cpfaux[2];
				$cpfaux=explode('-', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1];
				$cepaux=explode('-', $arraycsv['cep']);
				$cep=$cepaux[0].$cepaux[1];
				$numero=$arraycsv['numero'];
				$esn=$arraycsv['esn'];
				if($esn ==""){
					$esn= "3EEBF232";
				}
				$csv .='"'.$cpf.'"'.','; 
				$csv .='"'.$arraycsv['nome'].'"'.','; 
				$csv .='"'.$tel .'"'.","; 
				$csv .='"'.$ddd .'"'.","; 
				$csv .='"'.$cep .'"'.","; 
				$csv .='"'.$id .'"'.","; 
				$csv .='"'.$numero .'"'.",";
				$csv .='"'.$esn .'"'."\n";	
				
			}
			$clarotv= $csv;
			if(isset($clarotv)){
				$fp = fopen("clarotvadmin.csv","w");
				fwrite($fp,$clarotv);
				fclose($fp);
				echo "<a href='clarotvadmin.csv'>Clique aqui para baixar arquivo clarotvadmin.csv</a>";
			}
				
		}
//seleciona e gera csv para clarotv admin vendas Todas
		if($opt=="clarotvadmin3"){
			$limitdeData = date('Ymd', strtotime("-7 days"));
			$sql="SELECT id, nome, telefone, cpf, cep, numero, esn FROM vendas_clarotv WHERE produto=3 AND status='REDIRECIONADO' AND obs_procmacro='AGUARDANDO PROCESSO CLARO-TV' and data >= ".$limitdeData." ORDER BY id DESC LIMIT 1";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$tel = substr($arraycsv['telefone'],5);
				$telaux=explode('-',$tel );
				$tel=$telaux[0].$telaux[1];
				$ddd = substr($arraycsv['telefone'],1,2);
				$id=$arraycsv['id'];
				$cpf=$arraycsv['cpf'];
				$cpfaux=explode('.', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1].$cpfaux[2];
				$cpfaux=explode('-', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1];
				$cepaux=explode('-', $arraycsv['cep']);
				$cep=$cepaux[0].$cepaux[1];
				$numero=$arraycsv['numero'];
				$esn=$arraycsv['esn'];
				if($esn ==""){
					$esn= "3EEBF232";
				}
				$csv .='"'.$cpf.'"'.','; 
				$csv .='"'.$arraycsv['nome'].'"'.','; 
				$csv .='"'.$tel .'"'.","; 
				$csv .='"'.$ddd .'"'.","; 
				$csv .='"'.$cep .'"'.","; 
				$csv .='"'.$id .'"'.","; 
				$csv .='"'.$numero .'"'.",";
				$csv .='"'.$esn .'"'."\n";	
				
			}
			$clarotv= $csv;
			if($clarotv == ""){
				$clarotv='"50752162004","Edmar Penha","26938783","21","26510660","56873","88","898989898"';
			}
			if(isset($clarotv)){
				$fp = fopen("clarotvadmin.csv","w");
				fwrite($fp,$clarotv);
				fclose($fp);
				echo "<a href='clarotvadmin.csv'>Clique aqui para baixar arquivo clarotvadmin.csv</a>";
			}
				
		}
		//seleciona e gera csv para segundavia oi Admin
		if($opt=="segundaviaAdmin"){
			$sql="SELECT nome, telefone, cpf, cep FROM vendas_clarotv WHERE produto=1 AND status='RESTRIÇÃO'";
			$resutado = mysql_query($sql);
			$csv="";
			while ($arraycsv = mysql_fetch_array($resutado)) {
				$tel = substr($arraycsv['telefone'],5);
				$telaux=explode('-',$tel );
				$tel=$telaux[0].$telaux[1];
				$cpf=$arraycsv['cpf'];
				$cpfaux=explode('.', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1].$cpfaux[2];
				$cpfaux=explode('-', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1];
				$cepaux=explode('-', $arraycsv['cep']);
				$cep=$cepaux[0].$cepaux[1];
				$nome=$arraycsv['nome'];
				
				$csv .='"'.$cpf.'"'.','; 
				$csv .='"'.$tel .'"'.","."\n";  
				
				
			}
			$oicep= $csv;
			if(isset($oicep)){
				$fp = fopen("oicep.csv","w");
				fwrite($fp,$oicep);
				fclose($fp);
				echo "<a href='oicep.csv'>Clique aqui para baixar arquivo segundavia.csv</a>";
			}
				
		}		
		//seleciona e gera csv para Pré-Análise Admin Interna
		if($opt=="preanalise"){
			$sql="SELECT id, cpf, cep, numero, sexo FROM vendas_clarotv WHERE produto=3 AND (status='PRE-ANALISE' OR status='Internal Server Error' OR status='APROVADO') and tipoVenda='INTERNA' ;";
			$resutado = mysql_query($sql);

			while ($arraycsv = mysql_fetch_array($resutado)) {
				$id=$arraycsv['id'];
				$cpf=$arraycsv['cpf'];
				$cpfaux=explode('.', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1].$cpfaux[2];
				$cpfaux=explode('-', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1];
				$cep = $arraycsv['cep'];
				$numero=$arraycsv['numero'];
				$sexo=$arraycsv['sexo'];
				
				if($sexo=="Masculino"){
					$sexo="M";
				}else{
					$sexo="F";
				}
				if($numero=="S/N"){
					$numero=0;
				}
				$csv .='"'.$cpf.'"'.','; 
				$csv .='"'.$cep.'"'.','; 
				$csv .='"'.$numero.'"'.',';
				$csv .='"'.$sexo.'"'.',';
				$csv .='"'.$id.'"'."\n"; 
			}
			$preanalise= $csv;
			if($preanalise==""){
				$preanalise='"00000000","23073-640","76","M","56873"';
			}
			if(isset($preanalise)){
				$fp = fopen("preanalise.csv","w");
				fwrite($fp,$preanalise);
				fclose($fp);
			echo "<a href='preanalise.csv'>Clique aqui para baixar arquivo preanalise.csv</a>";		
			echo "<br />";
			$csv="";
			}
				
		}			
		//seleciona e gera csv para Pré-Análise Admin EXTERNA
		if($opt=="preanalise2"){
			$sql="SELECT id, cpf, cep, numero, sexo, esn FROM vendas_clarotv WHERE produto=3 AND (status='PRE-ANALISE' OR status='Internal Server Error' OR status='APROVADO') and tipoVenda='EXTERNA' ;";
			$resutado = mysql_query($sql);

			while ($arraycsv = mysql_fetch_array($resutado)) {
				$id=$arraycsv['id'];
				$cpf=$arraycsv['cpf'];
				$cpfaux=explode('.', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1].$cpfaux[2];
				$cpfaux=explode('-', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1];
				$cep = $arraycsv['cep'];
				$numero=$arraycsv['numero'];
				$sexo=$arraycsv['sexo'];
				$esn=$arraycsv['esn'];
				if($esn ==""){
					$esn= "3EEBF232";
				}
				
				if($sexo=="Masculino"){
					$sexo="M";
				}else{
					$sexo="F";
				}
				if($numero=="S/N"){
					$numero=0;
				}
				$csv .='"'.$cpf.'"'.','; 
				$csv .='"'.$cep.'"'.','; 
				$csv .='"'.$numero.'"'.',';
				$csv .='"'.$sexo.'"'.',';
				$csv .='"'.$id.'"'.',';
				$csv .='"'.$esn.'"'."\n"; 
			}
			$preanalise2= $csv;
			if($preanalise2==""){
				$preanalise2='"000000","23073-640","76","M","56873"';
			}
			if(isset($preanalise2)){
				$fp = fopen("preanalise2.csv","w");
				fwrite($fp,$preanalise2);
				fclose($fp);
			echo "<a href='preanalise2.csv'>Clique aqui para baixar arquivo preanalise2.csv</a>";		
			echo "<br />";
			$csv="";
			}
				
		}	
		
		
		//seleciona e gera csv para Pré-Análise Admin Interna
		if($opt=="preanaliseFinal"){
			$sql="SELECT id, cpf, cep, numero, sexo FROM vendas_clarotv WHERE produto=3 AND (status='PRE-ANALISE' OR status='Internal Server Error' OR status='APROVADO') and tipoVenda='INTERNA' and obs_preanailise='APROVADO' ;";
			$resutado = mysql_query($sql);

			while ($arraycsv = mysql_fetch_array($resutado)) {
				$id=$arraycsv['id'];
				$cpf=$arraycsv['cpf'];
				$cpfaux=explode('.', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1].$cpfaux[2];
				$cpfaux=explode('-', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1];
				$cep = $arraycsv['cep'];
				$numero=$arraycsv['numero'];
				$sexo=$arraycsv['sexo'];
				
				if($sexo=="Masculino"){
					$sexo="M";
				}else{
					$sexo="F";
				}
				if($numero=="S/N"){
					$numero=0;
				}
				$csv .='"'.$cpf.'"'.','; 
				$csv .='"'.$cep.'"'.','; 
				$csv .='"'.$numero.'"'.',';
				$csv .='"'.$sexo.'"'.',';
				$csv .='"'.$id.'"'."\n"; 
			}
			$preanaliseFinal= $csv;
			if($preanaliseFinal==""){
				$preanaliseFinal='"00000000","23073-640","76","M","56873"';
			}
			if(isset($preanaliseFinal)){
				$fp = fopen("preanaliseFinal.csv","w");
				fwrite($fp,$preanaliseFinal);
				fclose($fp);
			echo "<a href='preanaliseFinal.csv'>Clique aqui para baixar arquivo preanaliseFinal.csv</a>";		
			echo "<br />";
			$csv="";
			}
				
		}			
		//seleciona e gera csv para Pré-Análise Admin EXTERNA
		if($opt=="preanaliseFinal2"){
			$sql="SELECT id, cpf, cep, numero, sexo, esn FROM vendas_clarotv WHERE produto=3 AND (status='PRE-ANALISE' OR status='Internal Server Error' OR status='APROVADO') and tipoVenda='EXTERNA' and obs_preanailise='APROVADO' ;";
			$resutado = mysql_query($sql);

			while ($arraycsv = mysql_fetch_array($resutado)) {
				$id=$arraycsv['id'];
				$cpf=$arraycsv['cpf'];
				$cpfaux=explode('.', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1].$cpfaux[2];
				$cpfaux=explode('-', $cpf);
				$cpf=$cpfaux[0].$cpfaux[1];
				$cep = $arraycsv['cep'];
				$numero=$arraycsv['numero'];
				$sexo=$arraycsv['sexo'];
				$esn=$arraycsv['esn'];
				if($esn ==""){
					$esn= "3EEBF232";
				}
				
				if($sexo=="Masculino"){
					$sexo="M";
				}else{
					$sexo="F";
				}
				if($numero=="S/N"){
					$numero=0;
				}
				$csv .='"'.$cpf.'"'.','; 
				$csv .='"'.$cep.'"'.','; 
				$csv .='"'.$numero.'"'.',';
				$csv .='"'.$sexo.'"'.',';
				$csv .='"'.$id.'"'.',';
				$csv .='"'.$esn.'"'."\n"; 
			}
			$preanaliseFinal2= $csv;
			if($preanaliseFinal2==""){
				$preanaliseFinal2='"000000","23073-640","76","M","56873"';
			}
			if(isset($preanaliseFinal2)){
				$fp = fopen("preanaliseFinal2.csv","w");
				fwrite($fp,$preanaliseFinal2);
				fclose($fp);
			echo "<a href='preanaliseFinal2.csv'>Clique aqui para baixar arquivo preanaliseFinal2.csv</a>";		
			echo "<br />";
			$csv="";
			}
				
		}
		//seleciona e gera csv para oi vende
		if($opt=="oivende"){
			$prefixo = $_POST['prefixo'];
			$sql="SELECT * FROM spider WHERE telefone LIKE '%".$prefixo."%' ORDER BY id_cliente DESC  LIMIT 1;";
			$resutado = mysql_query($sql, $conexao);
			
			while ($arraytelefone= mysql_fetch_array($resutado)){
				$telefone= $arraytelefone['telefone'];
					$i=substr($telefone,6,10);		
			}
			 
			for ($j=$i; $j <= 9999; $j++){
				if($j < 10){
					if($j==''){
						$j=0;
					}
					$csv.=$prefixo.'000'.$j."\n";
				}else if($j < 100){
					$csv.=$prefixo.'00'.$j."\n";
				}else if($j < 1000){
					$csv.=$prefixo.'0'.$j."\n";
				}else{
					$csv.=$prefixo.$j."\n";
				}
				
				
			}
			$oivende= $csv;
			if(isset($oivende)){
				$fp = fopen("oivende.csv","w");
				fwrite($fp,$oivende);
				fclose($fp);
				echo "<a href='oivende.csv'>Clique aqui para baixar arquivo oivende.csv</a>";
			}
			echo $i;
		}
		mysql_close($conexao->connection) ; 
	}
	?>
	
</body>
</html>
