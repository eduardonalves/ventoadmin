<?php

$conexao30 = mysql_connect("localhost","root","v3nt0adm") or die("erro");
$db30 = mysql_select_db("vento");

$con30 = "SELECT * FROM vendas_clarotv";
$res30 = mysql_query($con30,$conexao30)or die ("line erro");

	
$i=0;

while($lin30 = mysql_fetch_array($res30)){
 
 
if($lin30['produto'] == '1'){

 
//CLARO TV

$operador = addslashes ($lin30['operador']);
$monitor = addslashes ($lin30['monitor']);
$auditor = addslashes($lin30['auditor']);
$tecnico = addslashes ($lin30['tecnico_id']);
$gravacao = addslashes ($lin30['gravacao']);
$obsGravacao = addslashes ($lin30['obs_gravacao']);
$os = addslashes ($lin30['os']);
$proposta = addslashes ($lin30['proposta']);
$contrato = addslashes ($lin30['contrato']);
$status = addslashes ($lin30['status']);
$obs = addslashes ($lin30['obs']);
$plano = addslashes ($lin30['plano']);
$pontos = addslashes ($lin30['pontos']);
$os2 = addslashes ($lin30['os2']);
$os3 = addslashes ($lin30['os3']);
$vencimento = addslashes ($lin30['vencimento']);
$valor = addslashes ($lin30['valor']);
$pagamento = addslashes ($lin30['pagamento']);
$banco = addslashes ($lin30['banco']);
$agencia = addslashes ($lin30['agencia']);
$contaCorrente = addslashes ($lin30['conta_corrente']);
$dataVendaSistema = addslashes ($lin30['data_venda']);
$dataVendaOperador = addslashes ($lin30['data_venda']);
$dataDesejada = addslashes ($lin30['data_desejada']);
$tipoInstalacao = addslashes ($lin30['tipo_instalacao']);
$pagamentoInstalacao = addslashes ($lin30['pagamento_instalacao']);
$cep = addslashes ($lin30['cep']);
$endereco = addslashes ($lin30['endereco']);
$numero = addslashes ($lin30['numero']);
$lote = addslashes ($lin30['lote']);
$quadra = addslashes ($lin30['quadra']);
$complemento = addslashes ($lin30['complemento']);
$bairro = addslashes ($lin30['bairro']);
$uf = addslashes ($lin30['uf']);
$cidade = addslashes ($lin30['cidade']);
$pontoReferencia = addslashes ($lin30['ponto_referencia']);


$conexao31 = mysql_connect("172.16.0.31","admin","v3nt0adm") or die ('<h1>ERRO</h1>');
$db31 = mysql_select_db("vento_zend");

$select31 = mysql_query ("SELECT * FROM clientes WHERE cpf = '".$lin30['cpf']."' && nome = '".addslashes($lin30['nome'])."'",$conexao31) or die ("claro tv select");
$query = mysql_fetch_array($select31);

//echo $query['cpf'];


if($query != 0){
	
$cliente = $query['id'];

$insertTV = mysql_query("INSERT INTO vendasClaroTv VALUES (null,'".$cliente."','".$operador."','".$monitor."','".$auditor."','".$tecnico."','".$gravacao."','".$obsGravacao."','-','-','".$os."','".$proposta."','".$contrato."','".$status."','".$obs."','".$plano."','-','".$pontos."','".$os2."','".$os3."','".$vencimento."','".$valor."','".$pagamento."','".$banco."','".$agencia."','".$contaCorrente."','".$dataVendaSistema."','".$dataVendaOperador."','".$dataDesejada."','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','".$tipoInstalacao."','".$pagamentoInstalacao."','-','".$endereco."','".$numero."','".$lote."','".$quadra."','".$complemento."','".$bairro."','".$cidade."','".$uf."','".$cep."','".$pontoReferencia."')",$conexao31)or die ("L70");

$i++;

}
}


 //CLARO 3G
 
else if($lin30['produto'] == '2'){

$operador = addslashes ($lin30['operador']);
$monitor = addslashes ($lin30['monitor']);
$auditor = addslashes ($lin30['auditor']);
$tecnico = addslashes ($lin30['tecnico_id']);
$gravacao = addslashes ($lin30['gravacao']);
$obsGravacao = addslashes ($lin30['obs_gravacao']);
$proposta = addslashes ($lin30['proposta']);
$contrato = addslashes ($lin30['contrato']);
$status = addslashes ($lin30['status']);
$obs = addslashes ($lin30['obs']);
$plano = addslashes ($lin30['plano']);
$pontos = addslashes ($lin30['pontos']);
$vencimento = addslashes ($lin30['vencimento']);
$valor = addslashes ($lin30['valor']);
$pagamento = addslashes ($lin30['pagamento']);
$banco = addslashes ($lin30['banco']);
$agencia = addslashes ($lin30['agencia']);
$contaCorrente = addslashes ($lin30['conta_corrente']);
$dataVendaSistema = addslashes ($lin30['data_venda']);
$dataVendaOperador = addslashes ($lin30['data_venda']);
$dataDesejada = addslashes ($lin30['data_desejada']);
$tipoInstalacao = addslashes ($lin30['tipo_instalacao']);
$pagamentoInstalacao = addslashes ($lin30['pagamento_instalacao']);
$cep = addslashes ($lin30['cep']);
$endereco = addslashes ($lin30['endereco']);
$numero = addslashes ($lin30['numero']);
$lote = addslashes ($lin30['lote']);
$quadra = addslashes ($lin30['quadra']);
$complemento = addslashes ($lin30['complemento']);
$bairro = addslashes ($lin30['bairro']);
$uf = addslashes ($lin30['uf']);
$cidade = addslashes ($lin30['cidade']);
$pontoReferencia = addslashes ($lin30['ponto_referencia']);

	
$select31 = mysql_query ("SELECT * FROM clientes WHERE cpf = '".$lin30['cpf']."' && nome = '".addslashes($lin30['nome'])."'",$conexao31) or die ("claro 3g select");
$query = mysql_fetch_array($select31);

$cliente = $query['id'];

if($query != 0){

$insert3g = mysql_query("INSERT INTO vendasClaro3g VALUES (null,'".$cliente."','".$operador."','".$monitor."','".$auditor."','".$gravacao."','".$obsGravacao."','-','-','".$proposta."','-','-','-','-','".$status."','".$obs."','".$plano."','".$vencimento."','".$valor."','".$pagamento."','".$banco."','".$agencia."','".$contaCorrente."','".$dataVendaSistema."','-','-','-','-','-','".$endereco."','".$numero."','".$lote."','".$quadra."','".$complemento."','".$bairro."','".$cidade."','".$uf."','".$cep."','".$pontoReferencia."')",$conexao31)or die ("line erro 3g");
$i++;

}

}

else if($lin30['produto'] == '3'){
//CLARO Fixo
				  
$operador = addslashes ($lin30['operador']);
$monitor = addslashes ($lin30['monitor']);
$auditor = addslashes ($lin30['auditor']);
$tecnico = addslashes ($lin30['tecnico_id']);
$gravacao = addslashes ($lin30['gravacao']);
$obsGravacao = addslashes ($lin30['obs_gravacao']);
$os = addslashes ($lin30['os']);
$proposta = addslashes ($lin30['proposta']);
$contrato = addslashes ($lin30['contrato']);
$status = addslashes ($lin30['status']);
$obs = addslashes ($lin30['obs']);
$plano = addslashes ($lin30['plano']);
$pontos = addslashes ($lin30['pontos']);
$os2 = addslashes ($lin30['os2']);
$os3 = addslashes ($lin30['os3']);
$vencimento = addslashes ($lin30['vencimento']);
$valor = addslashes ($lin30['valor']);
$pagamento = addslashes ($lin30['pagamento']);
$banco = addslashes ($lin30['banco']);
$agencia = addslashes ($lin30['agencia']);
$contaCorrente = addslashes ($lin30['conta_corrente']);
$dataVendaSistema = addslashes ($lin30['data_venda']);
$dataVendaOperador = addslashes ($lin30['data_venda']);
$dataDesejada = addslashes ($lin30['data_desejada']);
$tipoInstalacao = addslashes ($lin30['tipo_instalacao']);
$pagamentoInstalacao = addslashes ($lin30['pagamento_instalacao']);
$cep = addslashes ($lin30['cep']);
$endereco = addslashes ($lin30['endereco']);
$numero = addslashes ($lin30['numero']);
$lote = addslashes ($lin30['lote']);
$quadra = addslashes ($lin30['quadra']);
$complemento = addslashes ($lin30['complemento']);
$bairro = addslashes ($lin30['bairro']);
$uf = addslashes ($lin30['uf']);
$cidade = addslashes ($lin30['cidade']);
$pontoReferencia = addslashes ($lin30['ponto_referencia']);
				  
$select31 = mysql_query ("SELECT * FROM clientes WHERE cpf = '".$lin30['cpf']."' && nome = '".addslashes($lin30['nome'])."'",$conexao31) or die ("claro fixo select");
$query = mysql_fetch_array($select31);

$cliente = $query['id'];


if($query != 0){
	
$insertFIXO = mysql_query("INSERT INTO vendasClaroFixo VALUES (null,'".$cliente."','".$operador."','".$monitor."','".$auditor."','".$gravacao."','".$obsGravacao."','-','-','".$os."','-','-','-','".$status."','".$obs."','".$plano."','-','-','-','-','".$vencimento."','-','".$pagamento."','".$banco."','".$agencia."','".$contaCorrente."','".$dataVendaSistema."','-','-','-','-','-','-','-','-','-','-','".$endereco."','".$numero."','".$lote."','".$quadra."','".$complemento."','".$bairro."','".$cidade."','".$uf."','".$cep."','".$pontoReferencia."')",$conexao31)or die ("FIXO");


$i++;

} 
} 

 

}

echo "Dados inseridos: ".$i;
?>
	
	



