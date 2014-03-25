<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Gerador de CSV</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
</head>

<body>
			
	<form id="csv" name="csv" action="csvmacrodinamica.php" method="post">
		<select name="selectcsv" id="selectcsv">
			<option value="preanalise">Preanalise</option>
			<option value="preanalise2">Preanalise Externa</option>
			<option value="preanaliseInterna2">Preanalise Interna Maquina 2</option>
			<option value="preanaliseExterna2">Preanalise Externa Maquina2</option>
		</select>
		<input type="submit" name="enviar" id="enviar"/>
	</form>

	<?php
	
	if($_POST){
		mb_internal_encoding("UTF-8"); 
		
		include('conexao.php');
		$opt =$_POST['selectcsv'];
		
		if($opt=="preanalise"){
			$sql="SELECT * FROM vendas_clarotv WHERE produto=3 AND (status='PRE-ANALISE' OR status='Internal Server Error' OR status='APROVADO') and tipoVenda='INTERNA' AND ((obs_procmacro='') OR (obs_procmacro IS NULL)) ORDER BY id DESC LIMIT 1;";
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
				$obs_procmacro=$arraycsv['obs_procmacro'];
				if($esn==""){
					$esn="3EEBF232";
				}
				if($esn=="AGARDANDO ESN"){
					$esn="3EEBF232";
				}
				
				if($sexo=="Masculino"){
					$sexo="M";
				}else{
					$sexo="F";
				}
				if($numero=="S/N"){
					$numero=0;
				}
				if($numero=="s/n"){
					$numero=0;
				}
				if($numero=="SN"){
					$numero=0;
				}
				if($numero=="sn"){
					$numero=0;
				}
				if($numero=="S/n"){
					$numero=0;
				}
				//$csv .='"'.$cpf.'"'.','; 
				//$csv .='"'.$cep.'"'.','; 
				//$csv .='"'.$numero.'"'.',';
				//$csv .='"'.$sexo.'"'.',';
				//$csv .='"'.$id.'"'."\n";
				$obs_procmacro="PROCESSANDO CLARO-FIXO";
				$sql="UPDATE  vendas_clarotv SET obs_procmacro ='".$obs_procmacro."' WHERE id='".$id."'";
				$result=mysql_query($sql);
				if($result){
					echo '<p id="cpf">'.$cpf.'</p>';
				}			
				



				$csv .= "VERSION BUILD=9002379"."\n";
				$csv .= "SET !EXTRACT_TEST_POPUP NO"."\n";
				$csv .="SET !ERRORIGNORE YES"."\n";
				$csv .="TAB T=1"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=https://agente.embratel.com.br/CookieAuth.dll?GetLogon?curl=Z2FLivrefe&reason=0&formdir=3"."\n";
				$csv .="TAG POS=2 TYPE=INPUT:RADIO FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:trusted CONTENT=YES"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:username CONTENT=T3VTRCD"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:PASSWORD FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:password CONTENT=Pumk9108"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:SubmitCreds"."\n";
				$csv .= "TAB T=2"."\n";
				$csv .= "FRAME NAME=LivreFEBodyFrame"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:authenticateUserForm ATTR=NAME:j_username CONTENT=t3vtrcd"."\n";
				$csv .="SET !ENCRYPTION NO"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:PASSWORD FORM=NAME:authenticateUserForm ATTR=NAME:j_password CONTENT=Embratel21"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:authenticateUserForm ATTR=CLASS:button"."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "ONDIALOG POS=1 BUTTON=OK CONTENT="."\n";
				if($arraycsv['tipoEntrega'] != "EMBRATEL"){
					$csv .= "TAG POS=1 TYPE=A ATTR=ID:menuitem_29"."\n";
				}else{
					$csv .= "TAG POS=1 TYPE=A ATTR=ID:menuitem_6"."\n";
				}
				$csv .="WAIT SECONDS=4"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:formattedCpfCnpj CONTENT=".$cpf.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.zip CONTENT=".$cep.""."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.zip CONTENT=".$cep.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.number CONTENT=".$numero.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:referencia CONTENT=N"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				
				if((isset($arraycsv['lote'])) || (isset($arraycsv['quadra'])) || (isset($arraycsv['sala'])) || (isset($arraycsv['apto'])) || (isset($arraycsv['bloco'])) || (isset($arraycsv['fundos'])) || (isset($arraycsv['loja']))){
					$csv .="TAG POS=1 TYPE=IMG ATTR=SRC:https://agente.embratel.com.br/livrefe/images/bt_popup.gif"."\n";
					$csv .="WAIT SECONDS=5"."\n";
					$selectAtual=0;
					if(isset($arraycsv['lote']) && $arraycsv['lote'] !=""){
						//$selectCurrent=14;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~14"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['lote'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['quadra']) && $arraycsv['quadra'] !=""){
						//$selectCurrent=12;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~12"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['quadra'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					
					if(isset($arraycsv['sala']) && $arraycsv['sala'] !=""){
						//$selectCurrent=10;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~10"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['sala'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['apto'])  && $arraycsv['apto'] !=""){
						//$selectCurrent=4;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~4"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['apto'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['bloco']) && $arraycsv['bloco'] !=""){
						//$selectCurrent=2;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~2"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['bloco'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['fundos'])  && $arraycsv['fundos'] !=""){
						//$selectCurrent=11;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~11"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['fundos'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['loja'])  && $arraycsv['loja'] !=""){
						//$selectCurrent=11;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~15"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['loja'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					
					if(isset($arraycsv['casa'])  && $arraycsv['casa'] !=""){
						//$selectCurrent=20;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~20"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['casa'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
				}
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=NAME:confirmar"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btretrieveCoverage"."\n";
				$csv .="TAG POS=1 TYPE=A ATTR=TXT:".$cep.""."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:salesForm ATTR=ID:gender CONTENT=%".$sexo.""."\n";
				$csv .= "WAIT SECONDS=3"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.contractTypeId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planTypeId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=3 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.paymentMethodId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.installmentId CONTENT=YES"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .= "FRAME NAME=LivreFEBodyFrame"."\n";
				if($arraycsv['obs_embratel'] != 'APROVADO'){
					$csv .="TAG POS=4 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planId CONTENT=YES"."\n";
				}else{
					$csv .="TAG POS=5 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planId CONTENT=YES"."\n";
				}
				$csv .= "WAIT SECONDS=5"."\n";
				if($arraycsv['tipoEntrega'] != "EMBRATEL"){
					$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=NAME:salesTO.esnTemp CONTENT=".$esn.""."\n";
					$csv .= "WAIT SECONDS=5"."\n";
					$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btVerify"."\n";
					$csv .= "WAIT SECONDS=5"."\n";
				}
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:submitBtn"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=LABEL ATTR=TXT:Aleatório EXTRACT=TXT"."\n";
				$csv .="TAG POS=1 TYPE=TD ATTR=CLASS:textoDivMensagem EXTRACT=TXT"."\n";
				$csv .="TAG POS=1 TYPE=TD ATTR=ID:divWarningMsg EXTRACT=TXT"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=ID:reservation.form ATTR=ID:btn.list"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=SELECT FORM=ID:reservation.form ATTR=ID:select.numbers CONTENT=#1"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="DS CMD=CLICK X=40 Y=375"."\n";
				$csv .="DS CMD=CLICK X=40 Y=400"."\n";
				$csv .="WAIT SECONDS=4"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=ID:reservation.form ATTR=ID:btn.confirm"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=TABLE ATTR=CLASS:tableContent"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=R1 TYPE=* ATTR=TXT:*"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=R1 TYPE=TD ATTR=TXT:* EXTRACT=TXT"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=http://vem.vento-consulting.com//conversor/atualizaconversorpreanalise.php"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:conversor ATTR=NAME:cpf CONTENT=".$cpf.""."\n"; 
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:conversor ATTR=NAME:obs_embratel CONTENT={{!EXTRACT}}"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=ID:conversor ATTR=ID:id CONTENT=".$id.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:conversor ATTR=NAME:enviar"."\n";
				$csv .="WAIT SECONDS=60"."\n";
				$csv .="TAB CLOSE"."\n"; 
			}
			$preanalise= $csv;
			if($preanalise==""){
				$csv .= "VERSION BUILD=9002379"."\n";
				$csv .= "SET !EXTRACT_TEST_POPUP NO"."\n";
				$csv .="SET !ERRORIGNORE YES"."\n";
				$csv .="TAB T=1"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=https://agente.embratel.com.br/CookieAuth.dll?GetLogon?curl=Z2FLivrefe&reason=0&formdir=3"."\n";
				$csv .="WAIT SECONDS=10"."\n";
				$csv .="TAB CLOSE"."\n"; 
				$preanalise=$csv;
			}
			if(isset($preanalise)){
				$fp = fopen("preanalise_interna.iim","w");
				fwrite($fp,$preanalise);
				fclose($fp);
			echo "<a href='preanalise_interna.iim'>Clique aqui para baixar arquivo preanalise_interna.iim</a>";		
			echo "<br />";
			$csv="";
			}
				
		}		
		
		if($opt=="preanaliseInterna2"){
			$sql="SELECT * FROM vendas_clarotv WHERE produto=3 AND (status='PRE-ANALISE' OR status='Internal Server Error' OR status='APROVADO') and tipoVenda='INTERNA' AND ((obs_procmacro !='PROCESSANDO CLARO-FIXO') OR (obs_procmacro='') OR (obs_procmacro IS NULL)) ORDER BY id ASC LIMIT 1;";
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
				$obs_procmacro=$arraycsv['obs_procmacro'];
				if($esn==""){
					$esn="3eeBF232";
				}
				if($esn=="AGARDANDO ESN"){
					$esn="3eeBF232";
				}
				if($sexo=="Masculino"){
					$sexo="M";
				}else{
					$sexo="F";
				}
				if($numero=="S/N"){
					$numero=0;
				}
				if($numero=="s/n"){
					$numero=0;
				}
				if($numero=="SN"){
					$numero=0;
				}
				if($numero=="sn"){
					$numero=0;
				}
				if($numero=="S/n"){
					$numero=0;
				}
				//$csv .='"'.$cpf.'"'.','; 
				//$csv .='"'.$cep.'"'.','; 
				//$csv .='"'.$numero.'"'.',';
				//$csv .='"'.$sexo.'"'.',';
				//$csv .='"'.$id.'"'."\n";
				$obs_procmacro="PROCESSANDO CLARO-FIXO";
				$sql="UPDATE  vendas_clarotv SET obs_procmacro ='".$obs_procmacro."' WHERE id='".$id."'";
			
				$csv .= "VERSION BUILD=9002379"."\n";
				$csv .= "SET !EXTRACT_TEST_POPUP NO"."\n";
				$csv .="SET !ERRORIGNORE YES"."\n";
				$csv .="TAB T=1"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=https://agente.embratel.com.br/CookieAuth.dll?GetLogon?curl=Z2FLivrefe&reason=0&formdir=3"."\n";
				$csv .="TAG POS=2 TYPE=INPUT:RADIO FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:trusted CONTENT=YES"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:username CONTENT=T3VTGDR"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:PASSWORD FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:password CONTENT=Y84en918"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:SubmitCreds"."\n";
				$csv .= "TAB T=2"."\n";
				$csv .= "FRAME NAME=LivreFEBodyFrame"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:authenticateUserForm ATTR=NAME:j_username CONTENT=t3vtgdr"."\n";
				$csv .="SET !ENCRYPTION NO"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:PASSWORD FORM=NAME:authenticateUserForm ATTR=NAME:j_password CONTENT=Embratel2014"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:authenticateUserForm ATTR=CLASS:button"."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "ONDIALOG POS=1 BUTTON=OK CONTENT="."\n";
				if($arraycsv['tipoEntrega'] != "EMBRATEL"){
					$csv .= "TAG POS=1 TYPE=A ATTR=ID:menuitem_29"."\n";
				}else{
					$csv .= "TAG POS=1 TYPE=A ATTR=ID:menuitem_6"."\n";
				}
				$csv .="WAIT SECONDS=4"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:formattedCpfCnpj CONTENT=".$cpf.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.zip CONTENT=".$cep.""."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.zip CONTENT=".$cep.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.number CONTENT=".$numero.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:referencia CONTENT=N"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				
				if((isset($arraycsv['lote'])) || (isset($arraycsv['quadra'])) || (isset($arraycsv['sala'])) || (isset($arraycsv['apto'])) || (isset($arraycsv['bloco'])) || (isset($arraycsv['fundos'])) || (isset($arraycsv['loja']))){
					$csv .="TAG POS=1 TYPE=IMG ATTR=SRC:https://agente.embratel.com.br/livrefe/images/bt_popup.gif"."\n";
					$csv .="WAIT SECONDS=5"."\n";
					$selectAtual=0;
					if(isset($arraycsv['lote']) && $arraycsv['lote'] !=""){
						//$selectCurrent=14;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~14"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['lote'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['quadra']) && $arraycsv['quadra'] !=""){
						//$selectCurrent=12;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~12"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['quadra'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					
					if(isset($arraycsv['sala']) && $arraycsv['sala'] !=""){
						//$selectCurrent=10;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~10"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['sala'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['apto'])  && $arraycsv['apto'] !=""){
						//$selectCurrent=4;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~4"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['apto'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['bloco']) && $arraycsv['bloco'] !=""){
						//$selectCurrent=2;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~2"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['bloco'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['fundos'])  && $arraycsv['fundos'] !=""){
						//$selectCurrent=11;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~11"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['fundos'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['loja'])  && $arraycsv['loja'] !=""){
						//$selectCurrent=11;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~15"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['loja'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
					
					if(isset($arraycsv['casa'])  && $arraycsv['casa'] !=""){
						//$selectCurrent=20;
						//$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~20"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['casa'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						//$selectAtual= $selectAtual+1;
					}
				}
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=NAME:confirmar"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btretrieveCoverage"."\n";
				$csv .="TAG POS=1 TYPE=A ATTR=TXT:".$cep.""."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:salesForm ATTR=ID:gender CONTENT=%".$sexo.""."\n";
				$csv .= "WAIT SECONDS=3"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.contractTypeId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planTypeId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=3 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.paymentMethodId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.installmentId CONTENT=YES"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .= "FRAME NAME=LivreFEBodyFrame"."\n";
				if($arraycsv['obs_embratel'] != 'APROVADO'){
					$csv .="TAG POS=4 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planId CONTENT=YES"."\n";
				}else{
					$csv .="TAG POS=5 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planId CONTENT=YES"."\n";
				}
				$csv .= "WAIT SECONDS=5"."\n";
				if($arraycsv['tipoEntrega'] != "EMBRATEL"){
					$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=NAME:salesTO.esnTemp CONTENT=".$esn.""."\n";
					$csv .= "WAIT SECONDS=5"."\n";
					$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btVerify"."\n";
					$csv .= "WAIT SECONDS=5"."\n";
				}
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:submitBtn"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=LABEL ATTR=TXT:Aleatório EXTRACT=TXT"."\n";
				$csv .="TAG POS=1 TYPE=TD ATTR=CLASS:textoDivMensagem EXTRACT=TXT"."\n";
				$csv .="TAG POS=1 TYPE=TD ATTR=ID:divWarningMsg EXTRACT=TXT"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=ID:reservation.form ATTR=ID:btn.list"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=SELECT FORM=ID:reservation.form ATTR=ID:select.numbers CONTENT=#1"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="DS CMD=CLICK X=40 Y=375"."\n";
				$csv .="DS CMD=CLICK X=40 Y=400"."\n";
				$csv .="WAIT SECONDS=4"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=ID:reservation.form ATTR=ID:btn.confirm"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=TABLE ATTR=CLASS:tableContent"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=R1 TYPE=* ATTR=TXT:*"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=R1 TYPE=TD ATTR=TXT:* EXTRACT=TXT"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=http://vem.vento-consulting.com//conversor/atualizaconversorpreanalise.php"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:conversor ATTR=NAME:cpf CONTENT=".$cpf.""."\n"; 
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:conversor ATTR=NAME:obs_embratel CONTENT={{!EXTRACT}}"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=ID:conversor ATTR=ID:id CONTENT=".$id.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:conversor ATTR=NAME:enviar"."\n";
				$csv .="WAIT SECONDS=60"."\n";
				$csv .="TAB CLOSE"."\n"; 
			}
			$preanalise= $csv;
			if($preanalise==""){
				$csv .= "VERSION BUILD=9002379"."\n";
				$csv .= "SET !EXTRACT_TEST_POPUP NO"."\n";
				$csv .="SET !ERRORIGNORE YES"."\n";
				$csv .="TAB T=1"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=https://agente.embratel.com.br/CookieAuth.dll?GetLogon?curl=Z2FLivrefe&reason=0&formdir=3"."\n";
				$csv .="WAIT SECONDS=10"."\n";
				$csv .="TAB CLOSE"."\n"; 
				$preanalise=$csv;
			}
			if(isset($preanalise)){
				$fp = fopen("preanalise_interna2.iim","w");
				fwrite($fp,$preanalise);
				fclose($fp);
			echo "<a href='preanalise_interna2.iim'>Clique aqui para baixar arquivo preanalise_interna2.iim</a>";		
			echo "<br />";
			$csv="";
			}
				
		}
		
		if($opt=="preanalise2"){
			$sql="SELECT * FROM vendas_clarotv WHERE produto=3 AND (status='PRE-ANALISE' OR status='Internal Server Error' OR status='APROVADO') and tipoVenda='EXTERNA' AND ( (obs_procmacro='') OR (obs_procmacro IS NULL)) ORDER BY id DESC LIMIT 1;";
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
				$obs_procmacro=$arraycsv['obs_procmacro'];
				if($esn==""){
					$esn="3EEBF232";
				}
				if($esn=="AGARDANDO ESN"){
					$esn="3eeBF232";
				}
				if($sexo=="Masculino"){
					$sexo="M";
				}else{
					$sexo="F";
				}
				if($numero=="S/N"){
					$numero=0;
				}
				if($numero=="s/n"){
					$numero=0;
				}
				if($numero=="SN"){
					$numero=0;
				}
				if($numero=="sn"){
					$numero=0;
				}
				if($numero=="S/n"){
					$numero=0;
				}
				//$csv .='"'.$cpf.'"'.','; 
				//$csv .='"'.$cep.'"'.','; 
				//$csv .='"'.$numero.'"'.',';
				//$csv .='"'.$sexo.'"'.',';
				//$csv .='"'.$id.'"'."\n";
				$obs_procmacro="PROCESSANDO CLARO-FIXO";
				$sql="UPDATE  vendas_clarotv SET obs_procmacro ='".$obs_procmacro."' WHERE id='".$id."'";
				
				$csv .= "VERSION BUILD=9002379"."\n";
				$csv .= "SET !EXTRACT_TEST_POPUP NO"."\n";
				$csv .="SET !ERRORIGNORE YES"."\n";
				$csv .="TAB T=1"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=https://agente.embratel.com.br/CookieAuth.dll?GetLogon?curl=Z2FLivrefe&reason=0&formdir=3"."\n";
				$csv .="TAG POS=2 TYPE=INPUT:RADIO FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:trusted CONTENT=YES"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:username CONTENT=T3VTPSM"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:PASSWORD FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:password CONTENT=Gpqthxh7"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:SubmitCreds"."\n";
				$csv .= "TAB T=2"."\n";
				$csv .= "FRAME NAME=LivreFEBodyFrame"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:authenticateUserForm ATTR=NAME:j_username CONTENT=t3vtpsm"."\n";
				$csv .="SET !ENCRYPTION NO"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:PASSWORD FORM=NAME:authenticateUserForm ATTR=NAME:j_password CONTENT=Embratel2014"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:authenticateUserForm ATTR=CLASS:button"."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "ONDIALOG POS=1 BUTTON=OK CONTENT="."\n";
				if($arraycsv['tipoEntrega'] != "EMBRATEL"){
					$csv .= "TAG POS=1 TYPE=A ATTR=ID:menuitem_29"."\n";
				}else{
					$csv .= "TAG POS=1 TYPE=A ATTR=ID:menuitem_6"."\n";
				}
				$csv .="WAIT SECONDS=4"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:formattedCpfCnpj CONTENT=".$cpf.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.zip CONTENT=".$cep.""."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.zip CONTENT=".$cep.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.number CONTENT=".$numero.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:referencia CONTENT=N"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				
				if((isset($arraycsv['lote'])) || (isset($arraycsv['quadra'])) || (isset($arraycsv['sala'])) || (isset($arraycsv['apto'])) || (isset($arraycsv['bloco'])) || (isset($arraycsv['fundos'])) || (isset($arraycsv['loja']))){
					$csv .="TAG POS=1 TYPE=IMG ATTR=SRC:https://agente.embratel.com.br/livrefe/images/bt_popup.gif"."\n";
					$csv .="WAIT SECONDS=5"."\n";
					$selectAtual=0;
					if(isset($arraycsv['lote']) && $arraycsv['lote'] !=""){
						$selectCurrent=14;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['lote'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['quadra']) && $arraycsv['quadra'] !=""){
						$selectCurrent=12;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['quadra'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					
					if(isset($arraycsv['sala']) && $arraycsv['sala'] !=""){
						$selectCurrent=10;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['sala'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['apto'])  && $arraycsv['apto'] !=""){
						$selectCurrent=4;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['apto'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['bloco']) && $arraycsv['bloco'] !=""){
						$selectCurrent=2;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['bloco'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['fundos'])  && $arraycsv['fundos'] !=""){
						$selectCurrent=11;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['fundos'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['loja'])  && $arraycsv['loja'] !=""){
						$selectCurrent=11;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['loja'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					
					if(isset($arraycsv['casa'])  && $arraycsv['casa'] !=""){
						$selectCurrent=20;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['casa'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
				}
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=NAME:confirmar"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btretrieveCoverage"."\n";
				$csv .="TAG POS=1 TYPE=A ATTR=TXT:".$cep.""."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:salesForm ATTR=ID:gender CONTENT=%".$sexo.""."\n";
				$csv .= "WAIT SECONDS=3"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.contractTypeId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planTypeId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=3 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.paymentMethodId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.installmentId CONTENT=YES"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .= "FRAME NAME=LivreFEBodyFrame"."\n";
				if($arraycsv['obs_embratel'] != 'APROVADO'){
					$csv .="TAG POS=4 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planId CONTENT=YES"."\n";
				}else{
					$csv .="TAG POS=5 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planId CONTENT=YES"."\n";
				}
				
				
				
				$csv .= "WAIT SECONDS=5"."\n";
				if($arraycsv['tipoEntrega'] != "EMBRATEL"){
					$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=NAME:salesTO.esnTemp CONTENT=".$esn.""."\n";
					$csv .= "WAIT SECONDS=5"."\n";
					$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btVerify"."\n";
					$csv .= "WAIT SECONDS=5"."\n";
				}
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:submitBtn"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=LABEL ATTR=TXT:Aleatório EXTRACT=TXT"."\n";
				$csv .="TAG POS=1 TYPE=TD ATTR=CLASS:textoDivMensagem EXTRACT=TXT"."\n";
				$csv .="TAG POS=1 TYPE=TD ATTR=ID:divWarningMsg EXTRACT=TXT"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=ID:reservation.form ATTR=ID:btn.list"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=SELECT FORM=ID:reservation.form ATTR=ID:select.numbers CONTENT=#1"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="DS CMD=CLICK X=40 Y=375"."\n";
				$csv .="DS CMD=CLICK X=40 Y=400"."\n";
				$csv .="WAIT SECONDS=4"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=ID:reservation.form ATTR=ID:btn.confirm"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=TABLE ATTR=CLASS:tableContent"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=R1 TYPE=* ATTR=TXT:*"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=R1 TYPE=TD ATTR=TXT:* EXTRACT=TXT"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=http://vem.vento-consulting.com//conversor/atualizaconversorpreanalise.php"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:conversor ATTR=NAME:cpf CONTENT=".$cpf.""."\n"; 
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:conversor ATTR=NAME:obs_embratel CONTENT={{!EXTRACT}}"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=ID:conversor ATTR=ID:id CONTENT=".$id.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:conversor ATTR=NAME:enviar"."\n";
				$csv .="WAIT SECONDS=60"."\n";
				$csv .="TAB CLOSE"."\n"; 
			}
			$preanalise= $csv;
			if($preanalise==""){
				$csv .= "VERSION BUILD=9002379"."\n";
				$csv .= "SET !EXTRACT_TEST_POPUP NO"."\n";
				$csv .="SET !ERRORIGNORE YES"."\n";
				$csv .="TAB T=1"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=https://agente.embratel.com.br/CookieAuth.dll?GetLogon?curl=Z2FLivrefe&reason=0&formdir=3"."\n";
				$csv .="WAIT SECONDS=10"."\n";
				$csv .="TAB CLOSE"."\n"; 
				$preanalise=$csv;
			}
			if(isset($preanalise)){
				$fp = fopen("preanalise_externa.iim","w");
				fwrite($fp,$preanalise);
				fclose($fp);
			echo "<a href='preanalise_externa.iim'>Clique aqui para baixar arquivo preanalise_externa.iim</a>";		
			echo "<br />";
			$csv="";
			}
				
		}
		if($opt=="preanaliseExterna2"){
			$sql="SELECT * FROM vendas_clarotv WHERE produto=3 AND (status='PRE-ANALISE' OR status='Internal Server Error' OR status='APROVADO') and tipoVenda='EXTERNA' AND ((obs_procmacro !='PROCESSANDO CLARO-FIXO') OR (obs_procmacro='') OR (obs_procmacro IS NULL)) ORDER BY id ASC LIMIT 1;";
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
				$obs_procmacro=$arraycsv['obs_procmacro'];
				if($esn==""){
					$esn="3EEBF232";
				}
				if($esn=="AGARDANDO ESN"){
					$esn="3EEBF232";
				}
				if($sexo=="Masculino"){
					$sexo="M";
				}else{
					$sexo="F";
				}
				if($numero=="S/N"){
					$numero=0;
				}
				if($numero=="s/n"){
					$numero=0;
				}
				if($numero=="SN"){
					$numero=0;
				}
				if($numero=="sn"){
					$numero=0;
				}
				if($numero=="S/n"){
					$numero=0;
				}
				//$csv .='"'.$cpf.'"'.','; 
				//$csv .='"'.$cep.'"'.','; 
				//$csv .='"'.$numero.'"'.',';
				//$csv .='"'.$sexo.'"'.',';
				//$csv .='"'.$id.'"'."\n";
				
				$obs_procmacro="PROCESSANDO CLARO-FIXO";
				$sql="UPDATE  vendas_clarotv SET obs_procmacro ='".$obs_procmacro."' WHERE id='".$id."'";
			
				$csv .= "VERSION BUILD=9002379"."\n";
				$csv .= "SET !EXTRACT_TEST_POPUP NO"."\n";
				$csv .="SET !ERRORIGNORE YES"."\n";
				$csv .="TAB T=1"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=https://agente.embratel.com.br/CookieAuth.dll?GetLogon?curl=Z2FLivrefe&reason=0&formdir=3"."\n";
				$csv .="TAG POS=2 TYPE=INPUT:RADIO FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:trusted CONTENT=YES"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:username CONTENT=T3VTRCA"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:PASSWORD FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:password CONTENT=Natan2014"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=ACTION:/CookieAuth.dll?Logon ATTR=NAME:SubmitCreds"."\n";
				$csv .= "TAB T=2"."\n";
				$csv .= "FRAME NAME=LivreFEBodyFrame"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:authenticateUserForm ATTR=NAME:j_username CONTENT=t3mrndb"."\n";
				$csv .="SET !ENCRYPTION NO"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:PASSWORD FORM=NAME:authenticateUserForm ATTR=NAME:j_password CONTENT=Embratel2014"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:authenticateUserForm ATTR=CLASS:button"."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "ONDIALOG POS=1 BUTTON=OK CONTENT="."\n";
				if($arraycsv['tipoEntrega'] != "EMBRATEL"){
					$csv .= "TAG POS=1 TYPE=A ATTR=ID:menuitem_29"."\n";
				}else{
					$csv .= "TAG POS=1 TYPE=A ATTR=ID:menuitem_6"."\n";
				}
				$csv .="WAIT SECONDS=4"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:formattedCpfCnpj CONTENT=".$cpf.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.zip CONTENT=".$cep.""."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.zip CONTENT=".$cep.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:salesTO.address.number CONTENT=".$numero.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=ID:referencia CONTENT=N"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				
				if((isset($arraycsv['lote'])) || (isset($arraycsv['quadra'])) || (isset($arraycsv['sala'])) || (isset($arraycsv['apto'])) || (isset($arraycsv['bloco'])) || (isset($arraycsv['fundos'])) || (isset($arraycsv['loja']))){
					$csv .="TAG POS=1 TYPE=IMG ATTR=SRC:https://agente.embratel.com.br/livrefe/images/bt_popup.gif"."\n";
					$csv .="WAIT SECONDS=5"."\n";
					$selectAtual=0;
					if(isset($arraycsv['lote']) && $arraycsv['lote'] !=""){
						$selectCurrent=14;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['lote'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['quadra']) && $arraycsv['quadra'] !=""){
						$selectCurrent=12;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['quadra'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					
					if(isset($arraycsv['sala']) && $arraycsv['sala'] !=""){
						$selectCurrent=10;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['sala'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['apto'])  && $arraycsv['apto'] !=""){
						$selectCurrent=4;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['apto'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['bloco']) && $arraycsv['bloco'] !=""){
						$selectCurrent=2;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['bloco'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['fundos'])  && $arraycsv['fundos'] !=""){
						$selectCurrent=11;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['fundos'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					if(isset($arraycsv['loja'])  && $arraycsv['loja'] !=""){
						$selectCurrent=11;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['loja'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
					
					if(isset($arraycsv['casa'])  && $arraycsv['casa'] !=""){
						$selectCurrent=20;
						$novoSelect=$selectCurrent-$selectAtual;
						$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:tmpComplement ATTR=ID:complement CONTENT=%1~".$novoSelect.""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:tmpComplement ATTR=ID:complementDesc CONTENT=".$arraycsv['casa'].""."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=ID:insertBt"."\n";
						$csv .="WAIT SECONDS=2"."\n";
						$selectAtual= $selectAtual+1;
					}
				}
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:tmpComplement ATTR=NAME:confirmar"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btretrieveCoverage"."\n";
				$csv .="TAG POS=1 TYPE=A ATTR=TXT:".$cep.""."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "TAG POS=1 TYPE=SELECT FORM=NAME:salesForm ATTR=ID:gender CONTENT=%".$sexo.""."\n";
				$csv .= "WAIT SECONDS=3"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:btProceed"."\n";
				$csv .= "WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.contractTypeId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planTypeId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .= "TAG POS=3 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.paymentMethodId CONTENT=YES"."\n";
				$csv .= "WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.installmentId CONTENT=YES"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .= "FRAME NAME=LivreFEBodyFrame"."\n";
				if($arraycsv['obs_embratel'] != 'APROVADO'){
					$csv .="TAG POS=4 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planId CONTENT=YES"."\n";
				}else{
					$csv .="TAG POS=5 TYPE=INPUT:RADIO FORM=NAME:salesForm ATTR=NAME:salesTO.planId CONTENT=YES"."\n";
				}
				
				
				
				$csv .= "WAIT SECONDS=5"."\n";
				if($arraycsv['tipoEntrega'] != "EMBRATEL"){
					$csv .= "TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:salesForm ATTR=NAME:salesTO.esnTemp CONTENT=".$esn.""."\n";
					$csv .= "WAIT SECONDS=5"."\n";
					$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=NAME:salesForm ATTR=ID:btVerify"."\n";
					$csv .= "WAIT SECONDS=5"."\n";
				}
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:salesForm ATTR=ID:submitBtn"."\n";
				$csv .="WAIT SECONDS=5"."\n";
				$csv .="TAG POS=1 TYPE=LABEL ATTR=TXT:Aleatório EXTRACT=TXT"."\n";
				$csv .="TAG POS=1 TYPE=TD ATTR=CLASS:textoDivMensagem EXTRACT=TXT"."\n";
				$csv .="TAG POS=1 TYPE=TD ATTR=ID:divWarningMsg EXTRACT=TXT"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=ID:reservation.form ATTR=ID:btn.list"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=SELECT FORM=ID:reservation.form ATTR=ID:select.numbers CONTENT=#1"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="DS CMD=CLICK X=40 Y=375"."\n";
				$csv .="DS CMD=CLICK X=40 Y=400"."\n";
				$csv .="WAIT SECONDS=4"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:BUTTON FORM=ID:reservation.form ATTR=ID:btn.confirm"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=TABLE ATTR=CLASS:tableContent"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .= "TAG POS=R1 TYPE=* ATTR=TXT:*"."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=R1 TYPE=TD ATTR=TXT:* EXTRACT=TXT"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=http://vem.vento-consulting.com//conversor/atualizaconversorpreanalise.php"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:conversor ATTR=NAME:cpf CONTENT=".$cpf.""."\n"; 
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=NAME:conversor ATTR=NAME:obs_embratel CONTENT={{!EXTRACT}}"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:TEXT FORM=ID:conversor ATTR=ID:id CONTENT=".$id.""."\n";
				$csv .="WAIT SECONDS=2"."\n";
				$csv .="TAG POS=1 TYPE=INPUT:SUBMIT FORM=NAME:conversor ATTR=NAME:enviar"."\n";
				$csv .="WAIT SECONDS=60"."\n";
				$csv .="TAB CLOSE"."\n"; 
			}
			$preanalise= $csv;
			if($preanalise==""){
				$csv .= "VERSION BUILD=9002379"."\n";
				$csv .= "SET !EXTRACT_TEST_POPUP NO"."\n";
				$csv .="SET !ERRORIGNORE YES"."\n";
				$csv .="TAB T=1"."\n";
				$csv .="TAB CLOSEALLOTHERS"."\n";
				$csv .="URL GOTO=https://agente.embratel.com.br/CookieAuth.dll?GetLogon?curl=Z2FLivrefe&reason=0&formdir=3"."\n";
				$csv .="WAIT SECONDS=10"."\n";
				$csv .="TAB CLOSE"."\n"; 
				$preanalise=$csv;
			}
			if(isset($preanalise)){
				$fp = fopen("preanalise_externa2.iim","w");
				fwrite($fp,$preanalise);
				fclose($fp);
			echo "<a href='preanalise_externa2.iim'>Clique aqui para baixar arquivo preanalise_externa2.iim</a>";		
			echo "<br />";
			$csv="";
			}
				
		}			
				mysql_close($conexao->connection) ; 
	}
	?>
	
</body>
</html>
