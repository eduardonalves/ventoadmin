<?
date_default_timezone_set("Brazil/East");
include "conexao.php";
include_once "lib/class.Usuarios.php";
include_once "lib/class.VentoAdmin.php";
include_once "lib/class.Venda.php";
include_once "lib/class.VendaStatus.php";

session_start();

// Verificar se está logado

if(!isset($_SESSION['usuario'])){ ?>


<script type="text/javascript">

window.location = 'index.php'

</script>


<? } 





$consulta = $conexao->query("SELECT * FROM vendas_clarotv WHERE id = '".$_GET['id']."'");

$linha = mysql_fetch_array($consulta);





$conUSUARIO = $conexao->query("SELECT * FROM usuarios WHERE id = '".$_SESSION['usuario']."'");

$USUARIO = mysql_fetch_array($conUSUARIO);

if($_GET['e'] == '1' && $USUARIO['editar_dados'] == '1'){ $editar = '1';}


if($_GET['e'] == '1' && $USUARIO['editar_instalacao'] == '1'){ $editar_instalacao = '1';}

///////////////////////////////////


if(isset($_POST['nome'])){



$proposta = $_POST['proposta'];

$os = $_POST['os'];

$contrato = $_POST['contrato'];


// Dados Pessoais

$nome = $_POST['nome'];

$nascimento = $_POST['nascd'].'/'.$_POST['nascm'].'/'.$_POST['nasca'];

$cpf = $_POST['icpf'];

$rg = $_POST['rg'];

$org_exp = $_POST['orgexp'];

$profissao = $_POST['profissao'];

$sexo = $_POST['sexo'];

$estado_civil = $_POST['estadocivil'];

$email = $_POST['email'];

$telefone = $_POST['itelefone'];

$tipo_tel1 = $_POST['tipotel1'];

$telefone2 = $_POST['itelefone2'];

$tipo_tel2 = $_POST['tipotel2'];

$telefone3 = $_POST['itelefone3'];

$tipo_tel3 = $_POST['tipotel3'];





// Endereço Instalação

$endereco = $_POST['endereco'];	

$numero = $_POST['numero'];	

$lote = $_POST['lote'];	

$quadra = $_POST['quadra'];	



$complemento = $_POST['complemento'];	

$bairro = $_POST['bairro'];	

$cidade = $_POST['cidade'];	

$uf = $_POST['uf'];

$cep = $_POST['icep'];

$ponto_referencia = $_POST['pontoref'];





// Dados da Venda

$operador = $_POST['operador'];
$monitor = $_POST['monitor'];
$data0 = explode('/',$_POST['idata']);
$data = $data0[2].$data0[1].$data0[0];
$plano = $_POST['plano'];
$pontos = $_POST['pontos'];
$os2 = $_POST['os2'];
$os3 = $_POST['os3'];
$vencimento = $_POST['vencimento'];

$comboServicos = $_POST['servicos'];
$comboFonePlano = $_POST['planofone'];
$comboInternetPlano = $_POST['planointernet'];
$comboFonePlanoPreco = $_POST['FonePlanoPreco'];
$comboInternetPlanoPreco = $_POST['InternetPlanoPreco'];
$comboTotalPlanos = $_POST['totalplanos'];
$comboPortabilidade = $_POST['portabilidade'];
$comboNumeroPortado = $_POST['numeroportado'];
$comboRoteador = $_POST['roteador'];
$comboRoteadorPreco = $_POST['precoroteador'];
$comboClienteTv = $_POST['clientetv'];

// Agendamento gravação


if($_POST['agendagravacao']){

$diaGravacao = explode('/',$_POST['agendagravacao']);

$agendGravacao = $diaGravacao[2].'-'.$diaGravacao[1].'-'.$diaGravacao[0].' '.$_POST['agendagravacaohora'].':'.$_POST['agendagravacaominutos'].':00';

} else {
	
$agendGravacao = $linha['agendagravacao'];
	
}


// Dados da Instalação

$data_marcada0 = explode('/',$_POST['datamarcada']);

$data_marcada = $data_marcada0[2].$data_marcada0[1].$data_marcada0[0];




//// reagendamento ////
if($_POST['reagendamento'] != ''){

$reagendamento0 = explode('/',$_POST['reagendamento']);
$reagendamento = $reagendamento0[2].$reagendamento0[1].$reagendamento0[0];
$obsreagendamento = $_POST['obsreagendamento'];

$insert_reagendamento = $conexao->query("INSERT INTO reagendamentoinstalacao (venda,produto,usuario,data,agendamento,obs) VALUES ('".$_GET['id']."','9','".$USUARIO['id']."','".date("Y-m-d H:i:s")."', '".$reagendamento."','".$obsreagendamento."')");


$numreagendamentos = ceil($linha['reagendamentos']+1);
	
	} else { $numreagendamentos = ceil($linha['reagendamentos']); }


//// fim reagendamento ////



$tipo_instalacao = $_POST['tipoinstalacao'];


$qs = $_POST['qs'];

$nivel = $_POST['nivel'];

$decoder = $_POST['decoder'];

$certidao = $_POST['certidao'];

$smart = $_POST['smart'];

$quality_nota = $_POST['qualitynota'];





$decoder2 = $_POST['decoder2'];

$certidao2 = $_POST['certidao2'];

$smart2 = $_POST['smart2'];





$decoder3 = $_POST['decoder3'];

$certidao3 = $_POST['certidao3'];

$smart3 = $_POST['smart3'];


if($tipo_instalacao == 'EXTERNA'){
	
$tecnico_id = '1';
	
	} 

else {

$tecnico_id = $_POST['tecnico'];

}

// Motivos
$motivo_cancelamento = $_POST['motivocancelamento'];
$motivo_analise = $_POST['motivoanalise'];


if($_POST['status'] == 'RECUPERADO'){

$obs_recuperacao = $_POST['obsrecuperacao'];

if($obs_recuperacao){
	
$usuario_recuperacao = $USUARIO['id'];	
$data_recuperacao = date('Y-m-d H:i:s');

	
} }


// Observações

if(strlen($_POST['obsgravacao']) > 3){
$obs1 = $_POST['obsgravacao'];	
	
$insertOBS1 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','9','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','1','".$obs1."')");
		
}

if(strlen($_POST['obsentrega']) > 3){
$obs2 = $_POST['obsentrega'];	
	
$insertOBS2 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','9','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','2','".$obs2."')");
		
}

if(strlen($_POST['obsfinalizada']) > 3){
$obs3 = $_POST['obsfinalizada'];	
	
$insertOBS3 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','9','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','3','".$obs3."')");
		
}


// Pagamento

$pagamento = $_POST['pagamento'];

$pagamento_instalacao = $_POST['pagamentoinstalacao'];



if($pagamento == 'DÉBITO'){ $valor = '80.00';



$banco = $_POST['banco'];

$agencia = $_POST['agencia'];

$conta_corrente = $_POST['contacorrente'];



} else{



$valor = str_replace(',','.',$_POST['valor']);

}


if($pagamento_instalacao == "DEPÓSITO")
{

	$banco_deposito = $_POST['banco_deposito'];

	$agencia_deposito = $_POST['agencia_deposito'];

	$contacorrente_deposito = $_POST['contacorrente_deposito'];

	
}


// Cartão

$titularCartao = $_POST['titularCartao'];

if(strstr($_POST['numcartao'],'XXXX-XXXX')){
$numCar = $linha['numCar'];

} else {

$numCar = base64_encode($_POST['numcartao']);

}


if(strstr($_POST['numcodseguranca'],'XX')){

$codSeg = $linha['codSeg'];

} else {
$codSeg = $_POST['numcodseguranca'];
}

$carVal = $_POST['mesval'].'/'.$_POST['anoval'];

$carBan= $_POST['carbandeira'];


$numParcelas = $_POST['numparcelas'];


// Cartão Instalacao

$titularCartao_i = $_POST['titularCartao_i'];

if(strstr($_POST['numcartao_i'],'XXXX-XXXX')){
$numCar_i = $linha['numCar_i'];

} else {

$numCar_i = base64_encode($_POST['numcartao_i']);

}


if(strstr($_POST['numcodseguranca_i'],'XX')){

$codSeg_i = $linha['codSeg_i'];

} else {
$codSeg_i = $_POST['numcodseguranca_i'];
}

$carVal_i = $_POST['mesval_i'].'/'.$_POST['anoval_i'];

$carBan_i = $_POST['carbandeira_i'];


$numParcelas_i = $_POST['numparcelas_i'];





if($_POST['status'] == ''){ $status = $linha['status'];} 

else if($_POST['status'] == 'APROVADO' && $linha['proposta'] == ''){ $status = 'PRE-ANALISE'; }

else if($_POST['status'] == 'APROVADO' && $linha['gravacao'] == ''){ $status = 'GRAVAR'; }

else if($_POST['status'] == 'GRAVAR' && $linha['gravacao'] != ''){ $status = 'APROVADO'; }

else if($_POST['status'] == 'RECUPERADO'){ $linha['auditor'] = ''; $linha['gravacao'] = '';  $status = 'PRE-ANALISE'; $conexao->query("UPDATE vendas_clarotv SET gravacao = '' WHERE id = '".$_GET['id']."'");	}

else { $status = $_POST['status']; }



////////////////////////
// Salvar Instalação //
//////////////////////
/*if($editar == '1' && $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && $_POST['datainstalacao']!='')
{

	if($_POST['status'] == 'CONECTADO')
	{

		$data_instalacao = $_POST['datainstalacao'];

	}else{

		$data_instalacao = '';

	}

}else{

	if($linha['data_instalacao'] == '' && $_POST['status'] == 'CONECTADO')
	{

		$data_instalacao = date("Ymd");

	}else{

		$data_instalacao = '';

	}
}


/* *** antigo ********/
if($status == 'CONECTADO'){


if(strlen($_POST['datainstalacao']) >= 8){ 

$data_instalacao0 = explode('/',$_POST['datainstalacao']);
$data_instalacao = $data_instalacao0[2].$data_instalacao0[1].$data_instalacao0[0];

}

else{

if($linha['data_instalacao'] == ''){ $data_instalacao = date("Ymd"); } else { $data_instalacao = $linha['data_instalacao']; } 


}


}

else { $data_instalacao = $linha['data_instalacao']; } 



//////////////////////
// Atualizar Dados //
////////////////////



$update = $conexao->query("UPDATE vendas_clarotv SET comboServicos = '".$comboServicos."', comboFonePlano = '".$comboFonePlano."', comboInternetPlano = '".$comboInternetPlano."', comboFonePlanoPreco = '".$comboFonePlanoPreco."', comboInternetPlanoPreco = '".$comboInternetPlanoPreco."', comboTotalPlanos = '".$comboTotalPlanos."', comboPortabilidade = '".$comboPortabilidade."', comboNumeroPortado = '".$comboNumeroPortado."', comboRoteador = '".$comboRoteador."', comboRoteadorPreco = '".$comboRoteadorPreco."', comboClienteTv = '".$comboClienteTv."', proposta = '".$proposta."', os = '".$os."', contrato = '".$contrato."', nome = '".$nome."', nascimento = '".$nascimento."', cpf = '".$cpf."', rg = '".$rg."', org_exp = '".$org_exp."', profissao = '".$profissao."', sexo = '".$sexo."', estado_civil = '".$estado_civil."', email = '".$email."', telefone = '".$telefone."', tipo_tel1 = '".$tipo_tel1."', telefone2 = '".$telefone2."', tipo_tel2 = '".$tipo_tel2."', telefone3 = '".$telefone3."', tipo_tel3 = '".$tipo_tel3."', endereco = '".$endereco."', numero = '".$numero."', lote = '".$lote."', quadra = '".$quadra."', complemento = '".$complemento."', bairro = '".$bairro."', cidade = '".$cidade."', uf = '".$uf."', cep = '".$cep."', ponto_referencia = '".$ponto_referencia."', operador = '".$operador."', monitor = '".$monitor."', status = '".$status."', valor = '".$valor."', pagamento = '".$pagamento."', banco = '".$banco."', agencia = '".$agencia."', conta_corrente = '".$conta_corrente."', banco_deposito = '".$banco_deposito."', agencia_deposito = '".$agencia_deposito."', contacorrente_deposito = '".$contacorrente_deposito."', data = '".$data."', plano = '".$plano."', pontos = '".$pontos."', os2 = '".$os2."', os3 = '".$os3."', vencimento = '".$vencimento."', agendGravacao = '".$agendGravacao."', data_marcada = '".$data_marcada."',numerosReagendPendentes = '".$numerosReagendPendentes."', reagendamentos = '".$numreagendamentos."', motivo_cancelamento = '".$motivo_cancelamento."', motivo_analise = '".$motivo_analise."', obs_recuperacao = '".$obs_recuperacao."', usuario_recuperacao = '".$usuario_recuperacao."', data_recuperacao = '".$data_recuperacao."', data_instalacao = '".$data_instalacao."', qs = '".$qs."', nivel = '".$nivel."', decoder = '".$decoder."', certidao = '".$certidao."', smart = '".$smart."', quality_nota = '".$quality_nota."', decoder2 = '".$decoder2."', certidao2 = '".$certidao2."', smart2 = '".$smart2."', decoder3 = '".$decoder3."', certidao3 = '".$certidao3."', smart3 = '".$smart3."', tipo_instalacao = '".$tipo_instalacao."', pagamento_instalacao = '".$pagamento_instalacao."', tecnico_id = '".$tecnico_id."', titularCartao = '".$titularCartao."', numCar = '".$numCar."', codSeg = '".$codSeg."', carVal = '".$carVal."', carBan = '".$carBan."', numParcelas = '".$numParcelas."', titularCartao_i = '".$titularCartao_i."', numCar_i = '".$numCar_i."', codSeg_i = '".$codSeg_i."', carVal_i = '".$carVal_i."', carBan_i = '".$carBan_i."', numParcelas_i = '".$numParcelas_i."' WHERE id = '".$_GET['id']."' ") or die('Ocorreu um Erro ao inserir os dados!');





/////////////////
// Insert LOG //
///////////////



$data = date("Y-m-d H:i:s");

$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$_SESSION['usuario']."','Atualizou um dado no sistema (ID: ".$_GET['id'].").')");



?>





<script type="text/javascript">



window.alert('Dados atualizados com sucesso!');

window.location = '?id=<?= $_GET['id'];?>'



</script>



<?

}

////////////////////////////////////
////// EXCLUIR GRAVAÇÃO ///////////
//////////////////////////////////



if(isset($_POST['excluirgravacao'])){
	
$excluirgravacao = $conexao->query("UPDATE vendas_clarotv SET auditor = '', gravacao = '', status = 'GRAVAR' WHERE id = '".$_GET['id']."'");

/////////////////
// Insert LOG //
///////////////

$data = date("Y-m-d H:i:s");

$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$_SESSION['usuario']."','Excluiu uma gravação: [".$linha['gravacao']."] (ID: ".$_GET['id'].") .')");


	?>
	
<script type="text/javascript">

window.alert('Gravação excluída com sucesso!');

window.location = '?e=1&id=<?= $_GET['id'];?>'


</script>    	


<?	
}
?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Detalhes Venda Claro TV</title>



<style type="text/css">



body{margin: 0 0 0 0; font-family:Arial, Helvetica, sans-serif;}



#topo{position:relative; background:url(img/topo-bg.png) repeat-x; top:0px; height:120px; width:100%;}



</style>



</head>



<!-- <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>-->
 
 <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>

<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>

<script type="text/javascript">

	$(document).ready( function(){
		
		$("#portabilidade").bind("change", function() {
	
		if($(this).val()=='SIM'){
			
			$('#tr-numeroportado').css('display', 'table-row');

		}else{

			$('#tr-numeroportado').css('display', 'none');
			$('#tr-numeroportado').val('');
			
		}
	
	});

	$(".calculaPrecoRoteador").bind("change", function() {
/*
		$("#precoroteador").val('');
		$("[name='precoroteador']").val('');

		var portabilidade = $("#portabilidade").val();
		var roteador = $("#roteador").val();
		var clientetv = $("#clientetv").val();

		if( portabilidade == '' || roteador == '' || clientetv == ''){

			return false;

		}
		
		var pagamento = $('#pagamento').val();
		
		if( roteador == 'SIM' ) {
			
			$("#tr-precoroteador").css('display', 'table-row');
			
			if ( clientetv == 'SIM' ) {

				$("#precoroteador").html('Grátis');
				$("[name='precoroteador']").val('Grátis');

			} else {
				
				if ( pagamento == 'BOLETO' ) {
				
					if( portabilidade == 'SIM' ){
						
						$("#precoroteador").html('R$ 79,00');
						$("[name='precoroteador']").val('R$ 79,00');
						
					}else{
						
						$("#precoroteador").html('R$ 199,00');
						$("[name='precoroteador']").val('R$ 199,00');
					}
					
				
				}else{

					if( portabilidade == 'SIM' ){
						
						$("#precoroteador").html('R$ 49,00 em até 10x s/ Juros');
						$("[name='precoroteador']").val('R$ 49,00');
						
					}else{
						
						$("#precoroteador").html('R$ 79,00 em até 10x s/ Juros');
						$("[name='precoroteador']").val('R$ 79,00');
					}
					
					
					
				}
				
			}

		}else{

			$("#tr-precoroteador").css('display', 'none');

		}
*/


		$("#precoroteador").val('');
		$("[name='precoroteador']").val('');

		var portabilidade = $("#portabilidade option:selected").val();
		var roteador = $("#roteador").val();
		var clientetv = $("#clientetv").val();
		var servico = $('#servicos option:selected').val();

		if( portabilidade == '' || roteador == '' || clientetv == ''){

			return false;

		}
		
		var pagamento = $('#pagamento').val();
		
		if( roteador == 'SIM' ) {
			
			$("#tr-precoroteador").css('display', 'table-row');
			
			if ( clientetv == 'SIM' && portabilidade == 'NAO' ) {

				$("#precoroteador").html('Grátis');
				$("[name='precoroteador']").val('Grátis');

			} else if ( clientetv == 'SIM' && portabilidade == 'SIM' ) {
				
				$("#precoroteador").html('R$ 49,00');
				$("[name='precoroteador']").val('R$ 49,00');
				
			} else {
				
				
				if ( servico == 'Fone') {
					
					if ( pagamento == 'BOLETO' || pagamento == 'DÉBITO' ) {
					
						if( portabilidade == 'SIM' ){
							
							$("#precoroteador").html('R$ 179,00');
							$("[name='precoroteador']").val('R$ 179,00');
							
						}else{
							
							$("#precoroteador").html('R$ 199,00');
							$("[name='precoroteador']").val('R$ 199,00');
						}
						
					
					}else{

						if( portabilidade == 'SIM' ){
							
							$("#precoroteador").html('R$ 179,00 em até 10x s/ Juros');
							$("[name='precoroteador']").val('R$ 179,00');
							
						}else{
							
							$("#precoroteador").html('R$ 199,00 em até 10x s/ Juros');
							$("[name='precoroteador']").val('R$ 199,00');
						}
						
						
						
					}
				
				} else if ( servico == 'Fone + Internet' ) {
					
					if ( pagamento == 'BOLETO' || pagamento == 'DÉBITO' ) {
					
						if( portabilidade == 'SIM' ){
							
							$("#precoroteador").html('R$ 49,00');
							$("[name='precoroteador']").val('R$ 49,00');
							
						}else{
							
							$("#precoroteador").html('R$ 79,00');
							$("[name='precoroteador']").val('R$ 79,00');
						}
						
					
					}else{

						if( portabilidade == 'SIM' ){
							
							$("#precoroteador").html('R$ 49,00 em até 10x s/ Juros');
							$("[name='precoroteador']").val('R$ 49,00');
							
						}else{
							
							$("#precoroteador").html('R$ 79,00 em até 10x s/ Juros');
							$("[name='precoroteador']").val('R$ 79,00');
						}
						
						
						
					}

				}
			}

		}else{

			$("#tr-precoroteador").css('display', 'none');

		}


	});
	
	$("#servicos").bind("change", function() {

		var servico = $('option:selected', this).val();

		$('#totalplanos').html('');
		
		if( servico == 'Fone' ){
			
			var opcoes = '<option value=""></option>\
						<option value="Fav Local com DDD" data-preco-plano="29,90">Fav Local com DDD</option>\
						<option value="Fav Local e DDD" data-preco-plano="39,90">Fav Local e DDD</option>\
						<option value="Fav Local e DDD com Movel" data-preco-plano="49,90">Fav Local e DDD com Movel</option>';

			$('#tr-planointernet').css('display', 'none');
			$('#tr-planotv').css('display', 'none');
			$('#tr-planofone').css('display', 'table-row');
			$('#tr-portabilidade').css('display', 'table-row');
			$('#portabilidade').val('');
			
			$('#planofone').html(opcoes);
			$('#planointernet').val("");
			$("#plano").val('');
			
		}else if ( servico == 'Internet'){

			var opcoes = '<option value=""></option>\
						<option value="4GB" data-preco-plano="64,90">4GB</option>\
						<option value="6GB" data-preco-plano="71,90">6GB</option>\
						<option value="12GB" data-preco-plano="99,90">12GB</option>';
						
			$('#tr-planointernet').css('display', 'table-row');
			$('#tr-planotv').css('display', 'none');
			$('#tr-planofone').css('display', 'none');
			$('#tr-portabilidade').css('display', 'none');
			$('#portabilidade').val('NAO');
			
			$('#planointernet').html(opcoes);
			$('#planofone').val("");
			$("#plano").val('');
			
		}else if ( servico == 'Fone + Internet'){

			var opcoes_fone = '<option value=""></option>\
						<option value="Fav Local com DDD" data-preco-plano="19,90">Fav Local com DDD</option>\
						<option value="Fav Local e DDD" data-preco-plano="29,90">Fav Local e DDD</option>\
						<option value="Fav Local e DDD com Movel" data-preco-plano="39,90">Fav Local e DDD com Movel</option>';

			var opcoes_internet = '<option value=""></option>\
						<option value="4GB" data-preco-plano="55,10">4GB</option>\
						<option value="6GB" data-preco-plano="61,10">6GB</option>\
						<option value="12GB" data-preco-plano="85,10">12GB</option>';


			$('#tr-planotv').css('display', 'none');
			$('#tr-planointernet').css('display', 'table-row');
			$('#tr-planofone').css('display', 'table-row');
			$('#tr-portabilidade').css('display', 'table-row');
			$('#portabilidade').val('');
			$("#plano").val('');

			$('#planofone').html(opcoes_fone);
			$('#planointernet').html(opcoes_internet);

		}else if ( servico == 'TV + Fone'){

			var opcoes_fone = '<option value=""></option>\
						<option value="Fav Local com DDD" data-preco-plano="19,90">Fav Local com DDD</option>\
						<option value="Fav Local e DDD" data-preco-plano="29,90">Fav Local e DDD</option>\
						<option value="Fav Local e DDD com Movel" data-preco-plano="39,90">Fav Local e DDD com Movel</option>';

			var opcoes_internet = '<option value=""></option>\
						<option value="4GB" data-preco-plano="55,10">4GB</option>\
						<option value="6GB" data-preco-plano="61,10">6GB</option>\
						<option value="12GB" data-preco-plano="85,10">12GB</option>';


			$('#tr-planotv').css('display', 'table-row');
			$('#tr-planointernet').css('display', 'none');
			$('#tr-planofone').css('display', 'table-row');
			$('#tr-portabilidade').css('display', 'table-row');
			$('#portabilidade').val('');

			$('#planofone').html(opcoes_fone);
			$('#planointernet').html(opcoes_internet);
			
		}else if ( servico == 'TV + Internet'){

			var opcoes_fone = '<option value=""></option>\
						<option value="Fav Local com DDD" data-preco-plano="19,90">Fav Local com DDD</option>\
						<option value="Fav Local e DDD" data-preco-plano="29,90">Fav Local e DDD</option>\
						<option value="Fav Local e DDD com Movel" data-preco-plano="39,90">Fav Local e DDD com Movel</option>';

			var opcoes_internet = '<option value=""></option>\
						<option value="4GB" data-preco-plano="55,10">4GB</option>\
						<option value="6GB" data-preco-plano="61,10">6GB</option>\
						<option value="12GB" data-preco-plano="85,10">12GB</option>';


			$('#tr-planotv').css('display', 'table-row');
			$('#tr-planointernet').css('display', 'table-row');
			$('#tr-planofone').css('display', 'none');
			$('#tr-portabilidade').css('display', 'none');
			$('#portabilidade').val('NAO');
			
			$('#planointernet').html(opcoes_internet);
			$('#planofone').val("");
			
		}else if ( servico == 'TV + Fone + Internet'){

			var opcoes_fone = '<option value=""></option>\
						<option value="Fav Local com DDD" data-preco-plano="19,90">Fav Local com DDD</option>\
						<option value="Fav Local e DDD" data-preco-plano="29,90">Fav Local e DDD</option>\
						<option value="Fav Local e DDD com Movel" data-preco-plano="39,90">Fav Local e DDD com Movel</option>';

			var opcoes_internet = '<option value=""></option>\
						<option value="4GB" data-preco-plano="55,10">4GB</option>\
						<option value="6GB" data-preco-plano="61,10">6GB</option>\
						<option value="12GB" data-preco-plano="85,10">12GB</option>';


			$('#tr-planotv').css('display', 'table-row');
			$('#tr-planointernet').css('display', 'table-row');
			$('#tr-planofone').css('display', 'table-row');
			$('#tr-portabilidade').css('display', 'table-row');
			$('#portabilidade').val('');

			$('#planofone').html(opcoes_fone);
			$('#planointernet').html(opcoes_internet);
			
		}
	});

	$(".item-plano").bind("change", function() {	
	
		totalPlanos = 0.0;
		
		$(".item-plano").each ( function() {
			
			if( $(this).val() != '' ){
				
				valorPlano = parseFloat($('option:selected', this).attr('data-preco-plano').replace(',','.'));

				totalPlanos += valorPlano;
				
			}
			
		});
		
		totalPlanos = totalPlanos.toFixed(2);
		
		totalPlanos = 'R$ ' + totalPlanos.replace('.',',');;

		if ( $(this).attr('id') == 'planofone' ){
			
			$("[name='FonePlanoPreco']").val('R$ ' + $("#planofone option:selected").attr('data-preco-plano'));
			
		}else if ( $(this).attr('id') == 'planointernet' ){
			
			$("[name='InternetPlanoPreco']").val('R$ ' + $("#planointernet option:selected").attr('data-preco-plano'));
			
		}
		
		$('#totalplanos').html(totalPlanos);
		$("[name='totalplanos']").val(totalPlanos);
	
	});

		
	});



 /*Cria uma função de nome mascara, onde o primeiro argumento passado é um dos

     objetos input O segundo é especificando o tipo de método no qual será tratado*/

    function mascara(o,f){

        v_obj=o;

        v_fun=f;

        setTimeout("execmascara()",1);

    }

    

    function execmascara(){

        /*Pegue o valor do objeto e atribua o resultado da função v_fun; cujo o conteúdo

        da mesma é a função que foi referida e que será utilizada para tratar dos dados*/

        v_obj.value=v_fun(v_obj.value);

    }

    

    function soNumeros(v){

        return v.replace(/\D/g,"");//Exclua tudo que não for numeral e retorne o valor

    }

    

    function telefone(v){

        //Remove tudo o que não é dígito

        v=v.replace(/\D/g,"");

        //Coloca parênteses em volta dos dois primeiros dígitos

        v=v.replace(/^(\d\d)(\d)/g,"($1) $2");

        //Coloca hífen entre o quarto e o quinto dígitos

        v=v.replace(/(\d{4})(\d)/,"$1-$2");

        //retorne o resultado

        return v;

    }

	



    function cpf(v){

        //Remove tudo o que não é dígito

        v=v.replace(/\D/g,"");

        //Coloca parênteses em volta dos dois primeiros dígitos

        v=v.replace(/^(\d{3})(\d)/g,"$1.$2");

        //Coloca hífen entre o quarto e o quinto dígitos

        v=v.replace(/(\d{3})(\d)/,"$1.$2");

        //retorne o resultado

		v=v.replace(/(\d{3})(\d)/,"$1-$2");

        return v;

    }

	

	

    function cep(v){

        //Remove tudo o que não é dígito

        v=v.replace(/\D/g,"");

        //Coloca hífen entre o quarto e o quinto dígitos

        v=v.replace(/(\d{5})(\d)/,"$1-$2");

        //retorne o resultado

        return v;

    }	

	

    function data(v){

        //Remove tudo o que não é dígito

        v=v.replace(/\D/g,"");

        //Coloca parênteses em volta dos dois primeiros dígitos

        v=v.replace(/^(\d{2})(\d)/g,"$1/$2");

        //Coloca hífen entre o quarto e o quinto dígitos

        v=v.replace(/(\d{2})(\d)/,"$1/$2");

        return v;

    }	
	
	    function cartaocredito(v){

        //Remove tudo o que não é dígito
        v=v.replace(/\D/g,"");
        //Coloca parênteses em volta dos dois primeiros dígitos
        v=v.replace(/^(\d{4})(\d)/g,"$1-$2");
        //Coloca hífen entre o quarto e o quinto dígitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2");
        v=v.replace(/(\d{4})(\d)/,"$1-$2");

        return v;

    }

//////////////////////////////////


function verificapagamento(v, str){
	if(v == "DÉBITO"){ 
		
		$("#idbanco").css('display', 'table-row');
		
	}else{
		
		$("#idbanco").css('display', 'none');
	}
	var elementos, i;
	if(v == "DINHEIRO"){
		
		document.getElementById('idbancodep').value = '';
		document.getElementById('idbancodep').style.display = 'none';
		$(".idcartaocredito_i").css('display', 'none');
		elementos = document.querySelectorAll('.idcartaocredito');
		for ( i = 0, length = elementos.length; i < length; i++) {
			elementos[i].style.display = 'none';
		}
		
		}
		
	else if(v == "BOLETO"){
		
		document.getElementById('idbanco').value = '';
		document.getElementById('idbanco').style.display = 'none';
		document.getElementById('idbancodep').value = '';
		document.getElementById('idbancodep').style.display = 'none';
		document.getElementById('idpagamentoinstalacao').style.display = '';
		$("[name='pagamentoinstalacao']").val('');
		//$(".idcartaocredito_i").css('display', 'table-row');
		
		elementos = document.querySelectorAll('.idcartaocredito');
		for ( i = 0, length = elementos.length; i < length; i++) {
			elementos[i].style.display = 'none';
		}
		}
		
	else if(v == "DÉBITO"){ 

	document.getElementById('valor').value = '80,00';
	document.getElementById('valor').disabled = true;
	document.getElementById('idbanco').style.display = '';
	document.getElementById('idbancodep').style.display = 'none';
	//document.getElementById('idpagamentoinstalacao').value = '';
	$("[name='pagamentoinstalacao']").val('');
	document.getElementById('idpagamentoinstalacao').style.display = 'none';
	$(".idcartaocredito").css("display", "none");
	$(".idcartaocredito_i").css("display", "none");
	//$(".idcartaocredito_i").css('display', '.idcartaocredito');
	//$(".idcartaocredito_i").css('display', 'none');
	}
	else if (v == "DEPÓSITO"){

	document.getElementById('idbancodep').style.display = '';
	$(".idcartaocredito_i").css('display', 'none');
	elementos = document.querySelectorAll('.idcartaocredito');
		for ( i = 0, length = elementos.length; i < length; i++) {
			elementos[i].style.display = 'none';
		}
		
	} else if (str == 'fpagamento' && v == "CARTÃO DE CRÉDITO"){ 
	
	document.getElementById('valor').disabled = false;

	document.getElementById('idbanco').style.display = 'none';
	document.getElementById('idbancodep').style.display = 'none';
	document.getElementById('idpagamentoinstalacao').style.display = 'none';

	$("[name='pagamentoinstalacao']").val('');
	$(".idcartaocredito_i").css('display', 'none');
	
	var elementos = document.querySelectorAll('.idcartaocredito');
	for (var i = 0, length = elementos.length; i < length; i++) {
		elementos[i].style.display = '';
  }
  }
	else if (str == 'instalacao' && v == "CARTÃO DE CRÉDITO"){ 
	
	document.getElementById('valor').disabled = false;

	document.getElementById('idbanco').style.display = 'none';
	document.getElementById('idbancodep').style.display = 'none';
	document.getElementById('idpagamentoinstalacao').style.display = '';

	$(".idcartaocredito").css('display', 'none');
		
	var elementos = document.querySelectorAll('.idcartaocredito_i');
	for (var i = 0, length = elementos.length; i < length; i++) {
		elementos[i].style.display = '';
  }
  }
}

/////////////////////////////


function mostrar(id){ document.getElementById(id).style.display = '' }


function esconder(id){ document.getElementById(id).style.display = 'none' }


function checkstatus(v){


if(v == 'CANCELADO'){ document.getElementById('mcancel').style.display = ''; 

					  document.getElementById('manalise').style.display = 'none';
					  document.getElementById('motivoanalise').value = '';
					  
					  document.getElementById('obsrecupe').style.display = 'none';
					  document.getElementById('obsrecuperacao').value = '';
					  }
					  
else if(v == 'ANÁLISE'){ document.getElementById('mcancel').style.display = 'none';
						 document.getElementById('motivocancelamento').value = '';
						 
						 document.getElementById('manalise').style.display = '';
						 
    					 document.getElementById('obsrecupe').style.display = 'none';
						 document.getElementById('obsrecuperacao').value = '';  } 					  

else if(v == 'RECUPERADO'){ document.getElementById('mcancel').style.display = 'none';
                            document.getElementById('motivocancelamento').value = '';

							document.getElementById('manalise').style.display = 'none';
							document.getElementById('motivoanalise').value = '';
							
							document.getElementById('obsrecupe').style.display = '';
							document.getElementById('obsrecuperacao').value = '';  } 


else{ document.getElementById('mcancel').style.display = 'none';
	  document.getElementById('motivocancelamento').value = '';
	  
	  document.getElementById('manalise').style.display = 'none';
	  document.getElementById('motivoanalise').value = '';
	  
	  document.getElementById('obsrecupe').style.display = 'none';
	  document.getElementById('obsrecuperacao').value = ''; }	

	

}


///////////////////////////////////
///////// CHECAR CONTRATOS////////
/////////////////////////////////



function checkpropostas(p){

	

	$('#loadpropostas').load('check-propostas.php?p='+p+'&o=<?= $linha['proposta']?>');

	

	

	}



function checkcontratos(c){

	

	$('#loadcontratos').load('check-contratos.php?c='+c+'&o=<?= $linha['contrato']?>');

	

	

	}	

	

	

function checkoperador(m,op){

	

	

	$('#loadoperadores').load('check-operadores.php?m=' + m + '&o=' + op);

	

	

	}	

	

	

///////////////////////////////////////////

/////////////// VALIDAÇÃO ////////////////

/////////////////////////////////////////

function validacpf(cpf){
	digitos_iguais = 1;
	cpf = cpf.toString().replace(/\.|\-/g,"");
	if (cpf.length < 11)
		return false;
	for (i = 0; i < cpf.length - 1; i++){
		if (cpf.charAt(i) != cpf.charAt(i + 1))
			{
				digitos_iguais = 0;
				break;
				}}
				if (!digitos_iguais)
						{
						numeros = cpf.substring(0,9);
						digitos = cpf.substring(9);
						soma = 0;
						for(i = 10; i > 1; i--)
							soma += numeros.charAt(10 - i) * i;
						resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
						if (resultado != digitos.charAt(0))
							  return false;
						numeros = cpf.substring(0,10);
						soma = 0;
						for (i = 11; i > 1; i--)
							  soma += numeros.charAt(11 - i) * i;
						resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
						if (resultado != digitos.charAt(1))
							  return false;
						return true;
						}
}

function validar(){


cpf = $('input[name="icpf"]').val();

gravacao = '<?= $linha['gravacao'];?>';

//tecnico = $('select[name="tecnico"]').val();

dataagendamento = $('input[name="datamarcada"]').val();


//////////

status = $('select[name="status"]').val();

erro = 0;


if(status!='DEVOLVIDO')
{

	if(!validacpf(cpf))
	{
	alert("CPF Inválido");

	$('input[name="icpf"]').focus();

	erro = erro+1;

	window.location.reload();

	}
}
///// Se APROVADO /////

if(status == 'APROVADO'){

// Verificar se existe gravação
if(erro == 0){

if(gravacao == '')

{

alert("Status não permitido sem gravação!");

erro = erro+1;

window.location.reload();

}}

}


//////// Se INSTALAR	/////////

if(status == 'INSTALAR'){


// Verificar se o CPF é válido

if(!validacpf(cpf))
{
alert("CPF Inválido");

$('input[name="icpf"]').focus();

erro = erro+1;

window.location.reload();

}

// Verificar a se exite data de agendamento

if(erro == 0){

if(dataagendamento.length < 10)

{

alert("Agendamento Inválido!");
$('input[name="datamarcada"]').focus();

erro = erro+1;
}}


// Verificar se existe gravação
if(erro == 0){

if(gravacao == '')

{

alert("Status não permitido sem gravação!");

erro = erro+1;


}}


}

// Se CONECTADO

if(status == 'CONECTADO'){


if(!validacpf(cpf))
{
alert("CPF Inválido");

$('input[name="icpf"]').focus();

erro = erro+1;

window.location.reload();

}


if(erro == 0){

if(gravacao == '')

{



alert("Status não permitido sem gravação!");

erro = erro+1;



}}



if(erro == 0){

/*if(tecnico == ''){



alert("Favor selecionar o técnico que fez a instalação!");

$('input[select="tecnico"]').focus();

erro = erro+1;

}*/
}


}

// Se Nada estiver errado:

if(erro == 0){ document.forms.editar.submit(); }


}

// Fim function


function validadata(val,id){

tam = val.length;
datastr = val.split("/");
novadata = datastr[2]+datastr[1]+datastr[0];

var dt = new Date();
ano = dt.getFullYear();
if((dt.getMonth() + 1) < 10){ mes = '0'+ (dt.getMonth() + 1); } else { mes = (dt.getMonth() + 1);}
if((dt.getDate() + 1) < 10){ dia = '0'+ dt.getDate(); } else { dia = dt.getDate();}

hoje = ano + "" + mes + "" + dia;

if(tam < 10 || novadata < hoje){

 $(id).stop().animate({backgroundColor: '#ffcece', border:"1px solid #ABABAB", padding:'1px', color:'#9a0000'},2000);	
	
	} else if(tam < 1 || tam >= 10) {
		
 $(id).stop().animate({backgroundColor: '#a2ff4f', color:'#428c00'},800, function(){
 $(id).animate({backgroundColor: '#ffffff', color:'#000000'},1200);
	 
	 });
	
	
	}
	
	
	}


function excluir(){if(confirm("Tem certeza que deseja excluir esta gravação?")){
	
	document.forms.excluirgravacao.submit();
	
	} }

</script>



<body onLoad="checkoperador('<?= $linha['monitor'];?>','<?= $linha['operador'];?>');">

<form name="excluirgravacao" action="" method="post">

<input type="hidden" name="excluirgravacao" />

</form>


<div id="topo">

<img src="img/LOGO-VENTO-p.png" />

</div>



<table border="0" width="100%" style="font-size:14px;">



<form name="editar" action="" method="post">



<tr align="center" style="color:#999; font-size:18px; font-weight:bold;\">

<td colspan="2"><? if($editar == '1'){?> Editar Venda <? } else { ?>Detalhes da Venda <? } ?> <hr size="1" color="#ccc" /></td>

</tr>


<? if($linha['protocolo']) {?>
<tr align="center" style="color:#999; font-size:16px;">

<td colspan="2"><b>Protocolo:</b>
<?= $linha['protocolo']; ?></td>
</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>
<? } ?>

<tr>

<td><b>Proposta:</b></td>

<td>

<? if($editar == '1') {?>

<span id="loadpropostas" style="font-size:12px;"></span>

<input type="text" name="proposta" size="40" maxlength="10" value="<?= $linha['proposta']; ?>" onKeyUp="checkpropostas(this.value)" onChange="checkpropostas(this.value)" />

<? } else { ?>



<?= $linha['proposta']; ?>

<input type="hidden" name="proposta" size="40" value="<?= $linha['proposta']; ?>" />



</td>



<? } ?>

</tr>





<tr>

<td><b>Nº Contrato:</b></td>

<td>

<? if($editar == '1') {?>

<span id="loadcontratos" style="font-size:12px;"></span>

<input type="text" name="contrato" size="40" maxlength="10" value="<?= $linha['contrato']; ?>" onKeyUp="checkcontratos(this.value)" onChange="checkcontratos(this.value)" />

<? } else { ?>



<?= $linha['contrato']; ?>

<input type="hidden" name="contrato" size="40" value="<?= $linha['contrato']; ?>" />



</td>



<? } ?>

</tr>



<tr>

<td><b>O.S.:</b></td>

<td>

<? if($editar_instalacao == '1') {?>

<input type="text" name="os" size="40" maxlength="12" value="<?= $linha['os']; ?>" />

<? } else { ?>



<?= $linha['os']; ?>

<input type="hidden" name="os" size="40" value="<?= $linha['os']; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>



<tr>

<td><b>Cliente:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="nome" size="40" value="<?= $linha['nome']; ?>" />

<? } else { ?>



<?= ucwords($linha['nome']); ?>

<input type="hidden" name="nome" size="40" value="<?= $linha['nome']; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr>

<td><b>Nascimento:</b></td>

<td>

<? 

$linhanascimento = explode('/',$linha['nascimento']);	



if($editar == '1') {

	

	

?>

<select name="nascd" id="nascd">

<option value=""></option>

<? $d = 1; while($d <= 31){ $dn = $d++;?>

<option value="<?= sprintf("%02d", $dn); ?>" <? if($linhanascimento[0] == sprintf("%02d", $dn)){?> selected="selected"<? } ?>> <?= sprintf("%02d", $dn); ?></option>

<? } ?>

</select>



<select name="nascm" id="nascm">

<option value=""></option>

<? $m = 1; while($m <= 12){ $mn = $m++;?>

<option value="<?= sprintf("%02d", $mn); ?>"  <? if($linhanascimento[1] == sprintf("%02d", $mn)){?> selected="selected"<? } ?>> <?= sprintf("%02d", $mn); ?></option>

<? } ?>

</select>



<select name="nasca" id="nasca">

<option value=""></option>

<? $a = date('Y'); while($a > 1900){ $an = $a--;?>

<option value="<?= $an; ?>" <? if($linhanascimento[2] == $an){?> selected="selected"<? } ?>> <?= $an; ?></option>

<? } ?>

</select>

<? } else { ?>



<?= ucwords($linha['nascimento']); ?>

<input type="hidden" name="nascd" value="<?= $linhanascimento[0]; ?>" />

<input type="hidden" name="nascm" value="<?= $linhanascimento[1]; ?>" />

<input type="hidden" name="nasca" value="<?= $linhanascimento[2]; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr>

<td><b>CPF/CNPJ:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="icpf" size="40" onKeyPress="mascara(this,cpf)" maxlength="14" value="<?= $linha['cpf']; ?>" />

<? } else { ?>



<?= $linha['cpf']; ?>

<input type="hidden" name="icpf" size="40" onKeyPress="mascara(this,cpf)" maxlength="14" value="<?= $linha['cpf']; ?>" />



</td>



<? } ?>

</td>

</tr>





<tr>

<td><b>RG:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="rg" size="40" maxlength="12" value="<?= $linha['rg']; ?>" />

<? } else { ?>



<?= $linha['rg']; ?>

<input type="hidden" name="rg" size="40" value="<?= $linha['rg']; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr>

<td><b>Org. Exp.:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="orgexp" size="40" value="<?= $linha['org_exp']; ?>" />

<? } else { ?>



<?= $linha['org_exp']; ?>

<input type="hidden" name="orgexp" size="40"  value="<?= $linha['org_exp']; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr>

<td><b>Profissão:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="profissao" size="40" value="<?= $linha['profissao']; ?>" />

<? } else { ?>



<?= $linha['profissao']; ?>

<input type="hidden" name="profissao" size="40" value="<?= $linha['profissao']; ?>" />



</td>



<? } ?>

</td>

</tr>





<tr>

<td><b>Sexo:</b></td>

<td>

<? if($editar == '1') {?>

<input type="radio" name="sexo" id="sexo1" <? if($linha['sexo'] == 'Masculino'){?> checked="checked" <? } ?> value="Masculino" /> Masculino 

<input type="radio" name="sexo" id="sexo2" <? if($linha['sexo'] == 'Feminino'){?> checked="checked" <? } ?> value="Feminino" /> Feminino

<? } else { ?>



<?= $linha['sexo']; ?>

<input type="hidden" name="sexo" size="40" value="<?= $linha['sexo']; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr>

<td><b>Estado Civil:</b></td>

<td>

<? if($editar == '1') {?>

<select name="estadocivil" id="estadocivil" >

<option value="Solteiro" <? if($linha['estado_civil'] == 'Solteiro'){?> selected="selected" <? } ?>>Solteiro</option>

<option value="Casado" <? if($linha['estado_civil'] == 'Casado'){?> selected="selected" <? } ?>>Casado</option>

<option value="Desquitado" <? if($linha['estado_civil'] == 'Desquitado'){?> selected="selected" <? } ?>>Desquitado</option>

<option value="Separado" <? if($linha['estado_civil'] == 'Separado'){?> selected="selected" <? } ?>>Separado</option>

<option value="Divorciado" <? if($linha['estado_civil'] == 'Divorciado'){?> selected="selected" <? } ?>>Divorciado</option> 

<option value="Viúvo" <? if($linha['estado_civil'] == 'Viúvo'){?> selected="selected" <? } ?>>Viúvo</option> 

</select>

<? } else { ?>



<?= $linha['estado_civil']; ?>

<input type="hidden" name="estadocivil" size="40" maxlength="14" value="<?= $linha['estado_civil']; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr>

<td><b>Email:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="email" size="40" value="<?= $linha['email']; ?>" />

<? } else { ?>



<?= strtolower($linha['email']); ?>

<input type="hidden" name="email" size="40" value="<?= $linha['email']; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr>

<td><b>Telefone:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="itelefone" size="20" onKeyPress="mascara(this,telefone)" maxlength="14" value="<?= $linha['telefone']; ?>" />

<select name="tipotel1">

<option value=""></option>

<option value="Residencial" <? if($linha['tipo_tel1'] == 'Residencial'){?> selected="selected" <? } ?>>Residencial</option> 

<option value="Celular" <? if($linha['tipo_tel1'] == 'Celular'){?> selected="selected" <? } ?>>Celular</option>

<option value="Comercial" <? if($linha['tipo_tel1'] == 'Comercial'){?> selected="selected" <? } ?>>Comercial</option>

</select>

<? } else { ?>



<?= $linha['telefone'].' <span style="color:#343434; font-size: 12px;">('.$linha['tipo_tel1'].')</span>'; ?>

<input type="hidden" name="itelefone" value="<?= $linha['telefone']; ?>" />

<input type="hidden" name="tipotel1" value="<?= $linha['tipo_tel1']?>" />

</td>



<? } ?>

</td>

</tr>



<? if($linha['telefone2'] != '' || $editar == '1' ){?>

<tr>

<td><b>Telefone2:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="itelefone2" size="20" onKeyPress="mascara(this,telefone)" maxlength="14" value="<?= $linha['telefone2']; ?>" />



<select name="tipotel2">

<option value=""></option>

<option value="Residencial" <? if($linha['tipo_tel2'] == 'Residencial'){?> selected="selected" <? } ?>>Residencial</option> 

<option value="Celular" <? if($linha['tipo_tel2'] == 'Celular'){?> selected="selected" <? } ?>>Celular</option>

<option value="Comercial" <? if($linha['tipo_tel2'] == 'Comercial'){?> selected="selected" <? } ?>>Comercial</option>

</select>

<? } else { ?>



<?= $linha['telefone2'].' <span style="color:#343434; font-size: 12px;">('.$linha['tipo_tel2'].')</span>'; ?>

<input type="hidden" name="itelefone2" value="<?= $linha['telefone2']; ?>" />

<input type="hidden" name="tipotel2" value="<?= $linha['tipo_tel2']?>" />



</td>

<? } ?>

</td>

</tr>

<? } ?>







<? if($linha['telefone3'] != '' || $editar == '1' ){?>

<tr>

<td><b>Telefone3:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="itelefone3" size="20" onKeyPress="mascara(this,telefone)" maxlength="14" value="<?= $linha['telefone3']; ?>" />



<select name="tipotel3">

<option value=""></option>

<option value="Residencial" <? if($linha['tipo_tel3'] == 'Residencial'){?> selected="selected" <? } ?>>Residencial</option> 

<option value="Celular" <? if($linha['tipo_tel3'] == 'Celular'){?> selected="selected" <? } ?>>Celular</option>

<option value="Comercial" <? if($linha['tipo_tel3'] == 'Comercial'){?> selected="selected" <? } ?>>Comercial</option>

</select>

<? } else { ?>



<?= $linha['telefone3'].' <span style="color:#343434; font-size: 12px;">('.$linha['tipo_tel3'].')</span>'; ?>

<input type="hidden" name="itelefone3" value="<?= $linha['telefone3']; ?>" />

<input type="hidden" name="tipotel3" value="<?= $linha['tipo_tel3']?>" />





</td>



<? } ?>

</td>

</tr>

<? } ?>



<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>





<tr>

<td><b>Endereço:</b></td>

<td>



<? if($editar == '1') {?>

<input type="text" size="27" name="endereco" value="<?= $linha['endereco']; ?>" /> Nº: <input type="text" size="5" name="numero" value="<?= $linha['numero']; ?>" /> <br /> Lote: <input type="text" size="5" name="lote" value="<?= $linha['lote']; ?>" /> Quadra: <input type="text" size="5" name="quadra" value="<?= $linha['quadra']; ?>" />

<? } else { ?>



<? echo ucwords($linha['endereco']); if($linha['numero']){echo ', '.$linha['numero'];} if($linha['lote']){echo ' - Lote: '.$linha['lote'];} if($linha['quadra']){echo ' - Quadra: '.$linha['quadra'];} ?>

<input type="hidden" size="40" name="endereco" value="<?= $linha['endereco']; ?>" />

<input type="hidden" size="40" name="numero" value="<?= $linha['numero']; ?>" />

<input type="hidden" size="40" name="lote" value="<?= $linha['lote']; ?>" />

<input type="hidden" size="40" name="quadra" value="<?= $linha['quadra']; ?>" />



</td>



<? } ?>

</td>

</tr>



<tr>

<td><b>Complemento:</b></td>

<td>



<? if($editar == '1') {?>

<input type="text" size="40" name="complemento" value="<?= $linha['complemento']; ?>" />

<? } else { ?>



<?= ucwords($linha['complemento']); ?>

<input type="hidden" size="40" name="complemento" value="<?= $linha['complemento']; ?>" />



</td>



<? } ?>

</td>

</tr>





<tr>

<td><b>Bairro:</b></td>

<td>



<? if($editar == '1') {?>

<input type="text" size="40" name="bairro" value="<?= $linha['bairro']; ?>" />

<? } else { ?>



<?= ucwords($linha['bairro']); ?>

<input type="hidden" size="40" name="bairro" value="<?= $linha['bairro']; ?>" />



</td>



<? } ?>

</td>

</tr>





<tr>

<td><b>Cidade:</b></td>

<td>



<? if($editar == '1') {

	

$uf = $linha['uf'];	

?>



<input type="text" size="26" name="cidade" value="<?= $linha['cidade']; ?>" /> - <select name="uf">

<option value="AC" <? if($uf == 'AC'){ echo 'selected="selected"'; } ?>>AC</option>  

<option value="AL" <? if($uf == 'AL'){ echo 'selected="selected"'; } ?>>AL</option>  

<option value="AM" <? if($uf == 'AM'){ echo 'selected="selected"'; } ?>>AM</option>  

<option value="AP" <? if($uf == 'AP'){ echo 'selected="selected"'; } ?>>AP</option>  

<option value="BA" <? if($uf == 'BA'){ echo 'selected="selected"'; } ?>>BA</option>  

<option value="CE" <? if($uf == 'CE'){ echo 'selected="selected"'; } ?>>CE</option>  

<option value="DF" <? if($uf == 'DF'){ echo 'selected="selected"'; } ?>>DF</option>  

<option value="ES" <? if($uf == 'ES'){ echo 'selected="selected"'; } ?>>ES</option>  

<option value="GO" <? if($uf == 'GO'){ echo 'selected="selected"'; } ?>>GO</option>  

<option value="MA" <? if($uf == 'MA'){ echo 'selected="selected"'; } ?>>MA</option>  

<option value="MG" <? if($uf == 'MG'){ echo 'selected="selected"'; } ?>>MG</option>  

<option value="MS" <? if($uf == 'MS'){ echo 'selected="selected"'; } ?>>MS</option>  

<option value="MT" <? if($uf == 'MT'){ echo 'selected="selected"'; } ?>>MT</option>  

<option value="PA" <? if($uf == 'PA'){ echo 'selected="selected"'; } ?>>PA</option>  

<option value="PB" <? if($uf == 'PB'){ echo 'selected="selected"'; } ?>>PB</option>  

<option value="PE" <? if($uf == 'PE'){ echo 'selected="selected"'; } ?>>PE</option>  

<option value="PI" <? if($uf == 'PI'){ echo 'selected="selected"'; } ?>>PI</option>  

<option value="PR" <? if($uf == 'PR'){ echo 'selected="selected"'; } ?>>PR</option>  

<option value="RJ" <? if($uf == 'RJ' || $uf == ''){ echo 'selected="selected"'; } ?>>RJ</option>  

<option value="RN" <? if($uf == 'RN'){ echo 'selected="selected"'; } ?>>RN</option>  

<option value="RO" <? if($uf == 'RO'){ echo 'selected="selected"'; } ?>>RO</option>  

<option value="RR" <? if($uf == 'RR'){ echo 'selected="selected"'; } ?>>RR</option>  

<option value="RS" <? if($uf == 'RS'){ echo 'selected="selected"'; } ?>>RS</option>  

<option value="SC" <? if($uf == 'SC'){ echo 'selected="selected"'; } ?>>SC</option>  

<option value="SE" <? if($uf == 'SE'){ echo 'selected="selected"'; } ?>>SE</option>  

<option value="SP" <? if($uf == 'SP'){ echo 'selected="selected"'; } ?>>SP</option>  

<option value="TO" <? if($uf == 'TO'){ echo 'selected="selected"'; } ?>>TO</option> 

</select>

<? } else { ?>





<?= ucwords($linha['cidade'].' - '.$linha['uf']); ?>

<input type="hidden" size="26" name="cidade" value="<?= $linha['cidade']; ?>" />

<input type="hidden" size="26" name="uf" value="<?= $linha['uf']; ?>" />



</td>



<? } ?>

</td>

</tr>





<tr>

<td><b>CEP:</b></td>

<td>



<? if($editar == '1') {?>

<input type="text" size="40" name="icep" onKeyPress="mascara(this,cep)" maxlength="9" value="<?= $linha['cep']; ?>" />

<? } else { ?>



<?= $linha['cep']; ?>

<input type="hidden" size="40" name="icep" onKeyPress="mascara(this,cep)" maxlength="9" value="<?= $linha['cep']; ?>" />



</td>



<? } ?>

</td>

</tr>





<tr>

<td><b>Ponto Ref.:</b></td>

<td><? if($editar == '1') {?>

<textarea name="pontoref" rows="3" cols="30"><?= $linha['ponto_referencia']; ?></textarea>

<? } else { ?>



<?= $linha['ponto_referencia']; ?>

<input type="hidden" name="pontoref" value="<?= $linha['ponto_referencia']; ?>" />





<? } ?></td>

</tr>



<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>



<tr align="left">

<td><b>Monitor:</b></td>

<td>

<? if($editar == '1') {?>

<select type="text" id="monitor" name="monitor" onChange="checkoperador(this.value,'<?= $linha['operador'];?>')">

<option value=""></option>

<? 



$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE grupo LIKE '%0009%' && tipo_usuario = 'MONITOR' ORDER BY nome ASC");

while($MONITORES = mysql_fetch_array($conMONITORES)){



?>

<option value="<?= $MONITORES['id'];?>" <? if($linha['monitor'] == $MONITORES['id']){?> selected="selected" <? } ?>><?= $MONITORES['nome'];?></option>

<? } ?>



</select> 



<? } else {



$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE id = '".$linha['monitor']."' ORDER BY nome ASC");

$MONITORES = mysql_fetch_array($conMONITORES);	

	?>



<?= $MONITORES['nome']; ?>

<input type="hidden" name="monitor" value="<?= $linha['monitor']; ?>" />



<? } ?>



</td>

</tr>





<tr align="left">

<td><b>Operador:</b></td>

<td>



<? 

$conOPERADORES1 = $conexao->query("SELECT * FROM operadores WHERE operador_id = '".$linha['operador']."' ORDER BY nome ASC");

$OPERADORES1 = mysql_fetch_array($conOPERADORES1);	



if($editar == '1' && $USUARIO['tipo_usuario'] == 'ADMINISTRADOR') {

	



?>

<!--

<div id="loadoperadores" style="position:relative"></div> 

-->

<select type="text" id="operador" name="operador">

<option value="<?= $linha['operador']; ?>"><?= $OPERADORES1['nome'];?></option>

<option value="<?= $linha['operador']; ?>"></option>

<? 



$conOPERADORES = $conexao->query("SELECT * FROM operadores WHERE grupo LIKE '%0009%' && status != 'DESLIGADO' ORDER BY nome ASC");

while($OPERADORES = mysql_fetch_array($conOPERADORES)){



?>



<option value="<?= $OPERADORES['operador_id'];?>" <? if($linha['operador'] == $OPERADORES['operador_id']){?> selected="selected" <? } ?>>

<?= $OPERADORES['nome'];?>

</option>



<? } ?>



</select>

<? } else {

		

	?>



<?= $OPERADORES1['nome']; ?>

<input type="hidden" name="operador" value="<?= $linha['operador']; ?>" />



<? } ?>



</td>

</tr>



<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>



<tr>

<td><b>Data da Venda:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="idata" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<?= substr($linha['data'],6,2)."/".substr($linha['data'],4,2)."/".substr($linha['data'],0,4); ?>" />

<? } else { ?>



<?= substr($linha['data'],6,2)."/".substr($linha['data'],4,2)."/".substr($linha['data'],0,4); ?>



<input type="hidden" name="idata" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<?= substr($linha['data'],6,2)."/".substr($linha['data'],4,2)."/".substr($linha['data'],0,4); ?>" />



<? } ?>



</td>

</tr>

<tr>

<td><b>Pontos Adi.:</b></td>

<td>

<? if($editar == '1') {?>



<input type="radio" name="pontos" value="0" <? if($linha['pontos'] == '0'){?>checked="checked" <? } ?>/> 0

<input type="radio" name="pontos" value="1" <? if($linha['pontos'] == '1'){?>checked="checked" <? } ?>/> 1

<input type="radio" name="pontos" value="2" <? if($linha['pontos'] == '2'){?>checked="checked" <? } ?>/> 2

<input type="radio" name="pontos" value="3" <? if($linha['pontos'] == '3'){?>checked="checked" <? } ?>/> 3







<? } else { ?>



<?= $linha['pontos']; ?>

<input type="hidden" name="pontos" value="<?= $linha['pontos']; ?>" />





<? } ?>



</td>

</tr>



<? if($linha['pontos'] > 0) {?>

<tr>

<td><b>OS Ponto 1:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="os2" size="40" value="<?= $linha['os2']; ?>" />





<? } else { ?>



<?= $linha['os2']; ?>

<input type="hidden" name="os2" value="<?= $linha['os2']; ?>" />





<? } ?>



</td>

</tr>

<? } ?>



<? if($linha['pontos'] > 1) {?>

<tr>

<td><b>OS Ponto 2:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="os3" size="40" value="<?= $linha['os3']; ?>" />





<? } else { ?>



<?= $linha['os3']; ?>

<input type="hidden" name="os3" value="<?= $linha['os3']; ?>" />





<? } ?>



</td>

</tr>

<? } ?>



<tr>

<td><b>Vencimento:</b></td>

<td>

<? if($editar == '1') {?>



<input type="text" name="vencimento" size="4" value="<?=$linha['vencimento'];?>" /> 



<? } else { ?>



<?= $linha['vencimento']; ?>

<input type="hidden" name="vencimento" size="4" value="<?=$linha['vencimento'];?>" /> 





<? } ?>



</td>

</tr>





<tr>

<td><b>Agendamento:</b></td>

<td>

<? if($editar == '1' && $linha['data_marcada']== '') {?>

<input type="text" name="datamarcada" id="datamarcada" size="20" onKeyUp="validadata(this.value,datamarcada)" onKeyPress="mascara(this,data)" maxlength="10" />

<? } else { ?>



<?= substr($linha['data_marcada'],6,2)."/".substr($linha['data_marcada'],4,2)."/".substr($linha['data_marcada'],0,4); ?>

<input type="hidden" name="datamarcada" size="20" onKeyUp="validadata(this.value,datamarcada)" onKeyPress="mascara(this,data)" maxlength="10" value="<?= substr($linha['data_marcada'],6,2)."/".substr($linha['data_marcada'],4,2)."/".substr($linha['data_marcada'],0,4); ?>" />



<? } ?>

</td>

</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>



<?

$conReagendamentos = $conexao->query("SELECT *,
												DATE_FORMAT(reagendamentoinstalacao.data, '%d/%m/%Y às %H:%i:%s') AS dataevento,
												DATE_FORMAT(reagendamentoinstalacao.agendamento, '%d/%m/%Y') AS dataagendamento,
												usuarios.nome AS nomeusuario
												FROM reagendamentoinstalacao 
												INNER JOIN usuarios 
												ON usuarios.id = reagendamentoinstalacao.usuario
												WHERE reagendamentoinstalacao.venda = '".$_GET['id']."'
												ORDER BY reagendamentoinstalacao.id ASC
												
												");
$qntReagendamentos = mysql_num_rows($conReagendamentos);
$i = 0;												
while($Reagendamentos = mysql_fetch_array($conReagendamentos)){

$i++;
?>

<tr <? if($i < $qntReagendamentos){?> style="color:#CCC" <? } ?>>
<td><b>Reagendamento<?= $i;?>:</b></td>
<td><?= $Reagendamentos['dataagendamento'];?></td>
</tr>

<tr <? if($i < $qntReagendamentos){?> style="color:#CCC" <? } ?>>
<td><b>Obs.:</b></td>
<td>
<span style=" <? if($i < $qntReagendamentos){?>color:#CCC; <? } else { ?>color:#787878; <? } ?>font-size:11px;">
<b><?= $Reagendamentos['nomeusuario'];?></b> - <?= $Reagendamentos['dataevento'];?>
</span><br />
<?= $Reagendamentos['obs'];?>

</td>
</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<? } ?>


<? if($linha['data_marcada'] != '' && ($editar == '1')){?>

<tr id="re1">

<td><b>Reagendamento:</b></td>

<td>


<input type="text" name="reagendamento" id="reagendamento" size="20" onKeyUp="validadata(this.value,reagendamento)" onKeyPress="mascara(this,data)" maxlength="10"  />


</td>

</tr>


<tr id="ob1">

<td><b>Obs. Reagend.:</b></td>

<td>

<textarea name="obsreagendamento" rows="3" cols="30"></textarea>

</td>

</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<? }

$conGravacaoRetirada = $conexao->query("SELECT *, 
												usuarios.nome AS nome,
												DATE_FORMAT(log_sistema.data, '%d/%m/%Y às %H:%i:%s') AS dataevento
												FROM log_sistema 
												INNER JOIN usuarios
												ON usuarios.id = log_sistema.usuario
												WHERE  
												log_sistema.evento LIKE '%Excluiu uma gravação%' && 
												log_sistema.evento LIKE '%(ID: ".$_GET['id'].")%' 
												ORDER BY log_sistema.id ASC
										");
										
while($GravacaoRetirada = mysql_fetch_array($conGravacaoRetirada)){										

$gravacaoRE = explode('[',$GravacaoRetirada['evento']);
$gravacaoRE = explode(']',$gravacaoRE[1]);
$gravacaoRE = $gravacaoRE[0];

?>

<tr>
<td><b>Gravação retirada:</b></td>
<td>
<img src="img/play-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Ouvir Gravação" onClick="javascript:window.location = 'http://172.16.0.30/audio/clarocombo/orig/<?= $gravacaoRE;?>'" /> <span style="font-size:13px;">Ouvir Gravação </span>
<br />
<span style="color:#787878; font-size:11px;">
<b>Retirada por:</b> <?= $GravacaoRetirada['nome'];?>&nbsp;
em <?= $GravacaoRetirada['dataevento'];?>
</span>
</td>
</tr>


<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<? } ?>



<tr>

<td><b>Gravação:</b></td>

<td>

<? if($linha['gravacao'] == '' && $USUARIO['inserir_gravacao'] == '1'){?>



<img src="img/record.png" width="20" align="absmiddle" style="cursor:pointer" title="Inserir Gravação" onClick="window.location = 'upload-gravacao-simples-clarocombo.php?id=<?= $linha['id'];?>&u=<?= $USUARIO['id'];?>'" /> <span style="font-size:13px;">Inserir Gravação </span>



<? } else if($linha['gravacao'] != '') {?>



<img src="img/play-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Ouvir Gravação" onClick="javascript:window.location = 'http://172.16.0.30/audio/clarocombo/orig/<?= $linha['gravacao'];?>'" /> <span style="font-size:13px;">Ouvir Gravação </span>
&nbsp; &nbsp; &nbsp;


<? if($editar == 1){?>
<img src="img/delete-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Excluir Gravação" onClick="javascript:excluir();" /> <span style="font-size:13px;">Excluir Gravação </span>
<? } ?>




<? } ?>

</td>

</tr>



<tr>

<td><b>Auditor:</b></td>

<td>

<? 

$conAUDITOR = $conexao->query("SELECT * FROM usuarios WHERE id='".$linha['auditor']."'");

$AUDITOR = mysql_fetch_array($conAUDITOR);



echo $AUDITOR['nome'];

?></td>

</tr>





<? if($USUARIO['inserir_gravacao'] == '1' || $USUARIO['tipo_usuario'] == 'LOGISTICA' || $USUARIO['tipo_usuario'] == 'MONITOR' || $USUARIO['tipo_usuario'] == 'COMERCIAL'){?>

<? 
$tipoOBS = '1';
include "includes/observacoes-combo.php";
?>


<? if($linha['obs_gravacao']){?>
<tr><td colspan="2"><hr size="1" style="border-bottom: 1px dashed #EDEDED;" color="#FFF" /></td></tr>		

<tr>
<td><b>Obs.:</b></td>
<td>
<?= $linha['obs_gravacao'];?>
</td>
</tr>
<? }} ?>


<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<tr>
<td><b>Agend. Gravação:</b></td>
<td>
<? 

$dataAgendada0 = explode('-',$linha['agendGravacao']);
$dataAgendada = substr($dataAgendada0[2],0,2).'/'.$dataAgendada0[1].'/'.$dataAgendada0[0];

$horaAgendada0 = explode(':',$linha['agendGravacao']);
$horaAgendada = substr($horaAgendada0[0],-2,2);
$minutoAgendado = $horaAgendada0[1];

if($_GET['e'] == '1' && $USUARIO['inserir_gravacao'] == '1'){
	
?>

<input type="text" name="agendagravacao"  onKeyUp="validadata(this.value,agendagravacao)" onKeyPress="mascara(this,data)" maxlength="10" value="<? if($dataAgendada != '00/00/0000' && $dataAgendada != ''){ echo $dataAgendada;}?>" /> às 
<select name="agendagravacaohora">
<option></option>
<? for($h=8;$h<22;$h++){?>
<option <? if($horaAgendada == sprintf("%02d", $h) && $dataAgendada != '00/00/0000' && $dataAgendada != ''){?>selected="selected"<? } ?>><?= sprintf("%02d", $h); ?></option>
<? } ?>

</select>
<b>:</b>
<select name="agendagravacaominutos">
<option></option>
<? for($m = 00;$m<60;$m++){?>
<option <? if($minutoAgendado == sprintf("%02d", $m) && $dataAgendada != '00/00/0000' && $dataAgendada != ''){?>selected="selected"<? } ?>><?= sprintf("%02d", $m); ?></option>
<? } ?>
</select>

<? } else{?>

<? if($dataAgendada != '00/00/0000'){ echo $dataAgendada; }?> <? if($horaAgendada > 7){ echo ' às '.$horaAgendada.':'.$minutoAgendado; }?>

<? } ?>

</td>
</tr>




<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>



<tr>

<td><b>Tipo de Instalação:</b></td>

<td>



<? if($editar == '1') {?>



<select name="tipoinstalacao">

<option value=""></option>

<option value="INTERNA" <? if($linha['tipo_instalacao'] == 'INTERNA'){?>selected="selected"<? } ?>>Interna</option>

<option value="EXTERNA" <? if($linha['tipo_instalacao'] == 'EXTERNA'){?>selected="selected"<? } ?>>Externa</option>

</select>

<? } else { ?>



<?= $linha['tipo_instalacao']; ?>

<input type="hidden" name="tipoinstalacao" value="<?= $linha['tipo_instalacao'];?>" />



</td>



<? } ?>



</td>

</tr>





<tr>
<td><b>Data Instalada:</b></td>
<td>



<? if($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'ADMINISTRADOR') {?>

<input type="text" name="datainstalacao" size="40" onKeyPress="mascara(this,data)" maxlength="10"  value="<? if($linha['data_instalacao'] != ''){ echo substr($linha['data_instalacao'],6,2)."/".substr($linha['data_instalacao'],4,2)."/".substr($linha['data_instalacao'],0,4); } ?>" />

<? } else { ?>

<? if($linha['data_instalacao'] != ''){ echo substr($linha['data_instalacao'],6,2)."/".substr($linha['data_instalacao'],4,2)."/".substr($linha['data_instalacao'],0,4);} ?>
<? } ?>

</td>

</tr>

<?php /*** NAO EXISTE NO COMBO

<tr>

<td><b>Técnico:</b></td>

<td>

<? if($editar_instalacao == '1') { ?>



<select name="tecnico">   

<option value=""></option>    

<?    

$conTEC = $conexao->query("SELECT * FROM tecnicos WHERE status='ATIVO' ORDER BY nome ASC");

while($TEC = mysql_fetch_array($conTEC)){

?>

<option value="<?= $TEC['tecnico_id'];?>" <? if($linha['tecnico_id'] == $TEC['tecnico_id']){ ?> selected="selected" <? } ?>><?= $TEC['nome'];?></option>    





<?

} ?>



</select>



<?

} else {

 

$conTEC = $conexao->query("SELECT * FROM tecnicos WHERE tecnico_id = '".$linha['tecnico_id']."'");

$TEC = mysql_fetch_array($conTEC);



echo strtoupper($TEC['nome']); 

?>

<input type="hidden" name="tecnico" value="<?= $linha['tecnico_id']?>" />

<?

}

?>

</td>

</tr>



<tr>

<td><b>QS:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="qs" value="<?= $linha['qs'];?>" size="40" />



<? } else { ?>



<?= $linha['qs'];?>

<input type="hidden" name="qs" value="<?= $linha['qs'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Nível:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="nivel" value="<?= $linha['nivel'];?>" size="40" />



<? } else { ?>



<?= $linha['nivel'];?>

<input type="hidden" name="nivel" value="<?= $linha['nivel'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Decoder:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="decoder" value="<?= $linha['decoder'];?>" size="40" />



<? } else { ?>



<?= $linha['decoder'];?>

<input type="hidden" name="decoder" value="<?= $linha['decoder'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Certidão:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="certidao" value="<?= $linha['certidao'];?>" size="40" />



<? } else { ?>



<?= $linha['certidao'];?>

<input type="hidden" name="certidao" value="<?= $linha['certidao'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Smart:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="smart" value="<?= $linha['smart'];?>" size="40" />



<? } else { ?>



<?= $linha['smart'];?>

<input type="hidden" name="smart" value="<?= $linha['smart'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Quality Nota:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="qualitynota" value="<?= $linha['quality_nota'];?>" size="40" />



<? } else { ?>



<?= $linha['quality_nota'];?>

<input type="hidden" name="qualitynota" value="<?= $linha['quality_nota'];?>" size="40" />



<? } ?>

</td>

</tr>
*/ ?>

<? 
$tipoOBS = '3';
include "includes/observacoes-combo.php";
?>



<? if($linha['obs']){ ?>
<tr><td colspan="2"><hr size="1" style="border-bottom: 1px dashed #EDEDED;" color="#FFF" /></td></tr>		

<tr>

<td><b>Obs.:</b></td>
<td>
<?= $linha['obs']; ?>

</td>
</tr>
<? } ?>




<? if($linha['pontos'] >= 1){?>



<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>



<tr>

<td colspan="2" style="color:#999;">Ponto Adicional 1</td>

</tr>



<tr>

<td><b>Decoder:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="decoder2" value="<?= $linha['decoder2'];?>" size="40" />



<? } else { ?>



<?= $linha['decoder2'];?>

<input type="hidden" name="decoder2" value="<?= $linha['decoder2'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Certidão:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="certidao2" value="<?= $linha['certidao2'];?>" size="40" />



<? } else { ?>



<?= $linha['certidao2'];?>

<input type="hidden" name="certidao2" value="<?= $linha['certidao2'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Smart:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="smart2" value="<?= $linha['smart2'];?>" size="40" />



<? } else { ?>



<?= $linha['smart2'];?>

<input type="hidden" name="smart2" value="<?= $linha['smart2'];?>" size="40" />



<? } ?>

</td>

</tr>



<? } ?>









<? if($linha['pontos'] >= 2){ ?>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>



<tr>

<td colspan="2" style="color:#999;">Ponto Adicional 2</td>

</tr>



<tr>

<td><b>Decoder:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="decoder3" value="<?= $linha['decoder3'];?>" size="40" />



<? } else { ?>



<?= $linha['decoder3'];?>

<input type="hidden" name="decoder3" value="<?= $linha['decoder3'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Certidão:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="certidao3" value="<?= $linha['certidao3'];?>" size="40" />



<? } else { ?>



<?= $linha['certidao3'];?>

<input type="hidden" name="certidao3" value="<?= $linha['certidao3'];?>" size="40" />



<? } ?>

</td>

</tr>



<tr>

<td><b>Smart:</b></td>

<td>

<? if($editar_instalacao == '1') {?>



<input type="text" name="smart3" value="<?= $linha['smart3'];?>" size="40" />



<? } else { ?>



<?= $linha['smart3'];?>

<input type="hidden" name="smart3" value="<?= $linha['smart3'];?>" size="40" />



<? } ?>

</td>

</tr>



<? } ?>



<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<?php /*

<tr>

<td><b>Valor:</b></td>

<td>

<? if($editar == '1') {?>

R$ <input type="text" name="valor" id="valor" <? if($linha['pagamento'] == 'DÉBITO'){?>disabled="disabled"<? } ?> size="30" value="<?= str_replace('.',',',$linha['valor']); ?>" />

<? } else { ?>



R$ <?= str_replace('.',',',$linha['valor']); ?>

<input type="hidden" name="valor" id="valor" value="<?= str_replace('.',',',$linha['valor']); ?>" />



</td>



<? } ?>



</td>

</tr>

*/ ?>

<tr align="left">
<td><b>Serviços:</b></td>
<? if($editar == '1') {?>
<td>

<select name="servicos" id="servicos">

<option value=""></option>
<option value="Fone" <?php if ($linha['comboServicos'] =='Fone'){ echo 'selected="selected"'; };?>>Fone</option>
<option value="Internet" <?php if ($linha['comboServicos'] =='Internet'){ echo 'selected="selected"'; };?>>Internet</option>
<option value="Fone + Internet" <?php if ($linha['comboServicos'] =='Fone + Internet'){ echo 'selected="selected"'; };?>>Fone + Internet</option>
<option value="TV + Fone" <?php if ($linha['comboServicos'] =='TV + Fone'){ echo 'selected="selected"'; };?>>TV + Fone</option>
<option value="TV + Internet" <?php if ($linha['comboServicos'] =='TV + Internet'){ echo 'selected="selected"'; };?>>TV + Internet</option>
<option value="TV + Fone + Internet" <?php if ($linha['comboServicos'] =='TV + Fone + Internet'){ echo 'selected="selected"'; };?>>TV + Fone + Internet</option>

</select>

</td>
<? } else {?>
<td><?php echo $linha['comboServicos'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-planotv" <? if (! strstr($linha['comboServicos'], 'TV')){ echo 'style="display:none"'; }?>>

<td>Plano Tv:</td>

<td>

<? if($editar == '1') {?>



<select name="plano" id="plano">

<option value=""></option>

<option value="INICIAL" <? if($linha['plano'] == 'INICIAL'){ ?> selected="selected" <? }?>>INICIAL</option>
<option value="FÁCIL" <? if($linha['plano'] == 'FÁCIL'){ ?> selected="selected" <? }?>>FÁCIL</option>
<option value="ESSENCIAL" <? if($linha['plano'] == 'ESSENCIAL'){ ?> selected="selected" <? }?>>ESSENCIAL</option>
<option value="ESSENCIAL HBO" <? if($linha['plano'] == 'ESSENCIAL HBO'){ ?> selected="selected" <? }?>>ESSENCIAL HBO</option>
<option value="ESSENCIAL TELECINE LIGHT" <? if($linha['plano'] == 'ESSENCIAL TELECINE LIGHT'){ ?> selected="selected" <? }?>>ESSENCIAL TELECINE LIGHT</option>
<option value="FAMÍLIA" <? if($linha['plano'] == 'FAMÍLIA'){ ?> selected="selected" <? }?>>FAMÍLIA</option>


<option value=""></option>
<option value="FÁCIL HD ABERTOS" <? if($linha['plano'] == 'FÁCIL HD ABERTOS'){ ?> selected="selected" <? }?>>FÁCIL HD ABERTOS</option>
<option value="FÁCIL TELECINE LIGHT HD ABERTOS" <? if($linha['plano'] == 'FÁCIL TELECINE LIGHT HD ABERTOS'){ ?> selected="selected" <? }?>>FÁCIL TELECINE LIGHT HD ABERTOS</option>
<option value="ESSENCIAL HD ABERTOS" <? if($linha['plano'] == 'ESSENCIAL HD ABERTOS'){ ?> selected="selected" <? }?>>ESSENCIAL HD ABERTOS</option>
<option value="ESSENCIAL TELECINE HD ABERTOS" <? if($linha['plano'] == 'ESSENCIAL TELECINE HD ABERTOS'){ ?> selected="selected" <? }?>>ESSENCIAL TELECINE HD ABERTOS</option>
<option value="ESSENCIAL HBO HD ABERTOS" <? if($linha['plano'] == 'ESSENCIAL HBO HD ABERTOS'){ ?> selected="selected" <? }?>>ESSENCIAL HBO HD ABERTOS</option>
<option value=""></option>
<option value="ESSENCIAL HD LIGHT" <? if($linha['plano'] == 'ESSENCIAL HD LIGHT'){ ?> selected="selected" <? }?>>ESSENCIAL HD LIGHT</option>
<option value="ESSENCIAL TELECINE HD LIGHT" <? if($linha['plano'] == 'ESSENCIAL TELECINE HD LIGHT'){ ?> selected="selected" <? }?>>ESSENCIAL TELECINE HD LIGHT</option>
<option value="ESSENCIAL HBO HD LIGHT" <? if($linha['plano'] == 'ESSENCIAL HBO HD LIGHT'){ ?> selected="selected" <? }?>>ESSENCIAL HBO HD LIGHT</option>
<option value="FAMÍLIA HD LIGHT" <? if($linha['plano'] == 'FAMÍLIA HD LIGHT'){ ?> selected="selected" <? }?>>FAMÍLIA HD LIGHT</option>
<option value="FAMÍLIA TELECINE HD LIGHT" <? if($linha['plano'] == 'FAMÍLIA TELECINE HD LIGHT'){ ?> selected="selected" <? }?>>FAMÍLIA TELECINE HD LIGHT</option>
<option value="FAMÍLIA HBO HD LIGHT" <? if($linha['plano'] == 'FAMÍLIA HBO HD LIGHT'){ ?> selected="selected" <? }?>>FAMÍLIA HBO HD LIGHT</option>
<option value=""></option>
<option value="FAMÍLIA HD MAIS" <? if($linha['plano'] == 'FAMÍLIA HD MAIS'){ ?> selected="selected" <? }?>>FAMÍLIA HD MAIS</option>
<option value="FAMÍLIA HBO HD MAIS" <? if($linha['plano'] == 'FAMÍLIA HBO HD MAIS'){ ?> selected="selected" <? }?>>FAMÍLIA HBO HD MAIS</option>
<option value="ESSENCIAL (SEM FIDELIDADE)">ESSENCIAL (SEM FIDELIDADE)</option>
<option value="FAMÍLIA (SEM FIDELIDADE)" <? if($linha['plano'] == 'FAMÍLIA (SEM FIDELIDADE)'){ ?> selected="selected" <? }?>>FAMÍLIA (SEM FIDELIDADE)</option>
<option value=""></option>
<option value="FÁCIL HD ABERTOS DTV" <? if($linha['plano'] == 'FÁCIL HD ABERTOS DTV'){ ?> selected="selected" <? }?>>FÁCIL HD ABERTOS DTV - PE SOMENTE SD</option>
<option value="ESSENCIAL HD ABERTOS DTV" <? if($linha['plano'] == 'ESSENCIAL HD ABERTOS DTV'){ ?> selected="selected" <? }?>>ESSENCIAL HD ABERTOS DTV - PE SOMENTE SD</option>
<option value=""></option>

<option value="ESSENCIAL HD LIGHT DTV" <? if($linha['plano'] == 'ESSENCIAL HD LIGHT DTV'){ ?> selected="selected" <? }?>>ESSENCIAL HD LIGHT DTV</option>
<option value="FAMILIA HD LIGHT DTV" <? if($linha['plano'] == 'FAMILIA HD LIGHT DTV'){ ?> selected="selected" <? }?>>FAMILIA HD LIGHT DTV</option>
<option value="ESSENCIAL TELECINE HD LIGHT DTV" <? if($linha['plano'] == 'ESSENCIAL TELECINE HD LIGHT DTV'){ ?> selected="selected" <? }?>>ESSENCIAL TELECINE HD LIGHT DTV</option>
<option value="ESSENCIAL HBO HD LIGHT DTV" <? if($linha['plano'] == 'ESSENCIAL HBO HD LIGHT DTV'){ ?> selected="selected" <? }?>>ESSENCIAL HBO HD LIGHT DTV</option>
<option value="ESSENCIAL CINEMA HD LIGHT DTV" <? if($linha['plano'] == 'ESSENCIAL CINEMA HD LIGHT DTV'){ ?> selected="selected" <? }?>>ESSENCIAL CINEMA HD LIGHT DTV</option>
<option value="FAMILIA CINEMA HD LIGHT DTV" <? if($linha['plano'] == 'FAMILIA CINEMA HD LIGHT DTV'){ ?> selected="selected" <? }?>>FAMILIA CINEMA HD LIGHT DTV</option>
<option value="FAMÍLIA HD MAIS DTV" <? if($linha['plano'] == 'FAMÍLIA HD MAIS DTV'){ ?> selected="selected" <? }?>>FAMÍLIA HD MAIS DTV</option>

<option value=""></option>
<option value="FAMILIA CINEMA HD MAIS DTV" <? if($linha['plano'] == 'FAMILIA CINEMA HD MAIS DTV'){ ?> selected="selected" <? }?>>FAMILIA CINEMA HD MAIS DTV</option>
<option value="FAMILIA HD MAIS FUT DTV (A La carte PFC)" <? if($linha['plano'] == 'FAMILIA HD MAIS FUT DTV (A La carte PFC)'){ ?> selected="selected" <? }?>>FAMILIA HD MAIS FUT DTV (A La carte PFC)</option>
<option value="FAMILIA CINE HD MAIS FUT DTV (A La carte PFC)" <? if($linha['plano'] == 'FAMILIA CINE HD MAIS FUT DTV (A La carte PFC)'){ ?> selected="selected" <? }?>>FAMILIA CINE HD MAIS FUT DTV (A La carte PFC)</option>



</select>





<? } else { ?>



<?= $linha['plano']; ?>



<input type="hidden" name="plano" value="<?= $linha['plano']; ?>" />



<? } ?>



</td>

</tr>


<tr align="left" id="tr-planofone" <? if (! strstr($linha['comboServicos'], 'Fone')){ echo 'style="display:none"'; }?>>
<td><b>Plano Fone:</b></td>
<? if($editar == '1') {?>
<td>
<select name="planofone" id="planofone" class="item-plano">
<option value="<?php echo $linha['comboFonePlano']; ?>" data-preco-plano="<?php echo str_replace('R$ ', '', $linha['comboFonePlanoPreco']); ?>"><?php echo $linha['comboFonePlano']; ?></option>
</select>
<input type="hidden" name="FonePlanoPreco" value="<?php echo $linha['comboFonePlanoPreco']; ?>">
</td>
<? } else {?>
<td><?php echo $linha['comboFonePlano'];?></td>
<? } ?>

</tr>

<tr align="left" id="tr-planointernet" <? if (! strstr($linha['comboServicos'], 'Internet')){ echo 'style="display:none"'; }?>>
<td><b>Plano Internet:</b></td>
<? if($editar == '1') {?>
<td>
<select name="planointernet" id="planointernet" class="item-plano">
<option value="<?php echo $linha['comboInternetPlano']; ?>" data-preco-plano="<?php echo str_replace('R$ ', '', $linha['comboInternetPlanoPreco']); ?>"><?php echo $linha['comboInternetPlano']; ?></option>
</select>
<input type="hidden" name="InternetPlanoPreco" value="<?php echo $linha['comboFonePlanoPreco']; ?>">
</td>

<? } else {?>
<td><?php echo $linha['comboInternetPlano'];?></td>
<? } ?>

</tr>

<tr align="left" id="tr-totalplanos">
<td><b>Total Planos:</b></td>
<td id="totalplanos">
	<?php echo $linha['comboTotalPlanos']; ?>
</td>
<input type="hidden" value="<?php echo $linha['comboTotalPlanos']; ?>" name="totalplanos">
</tr>

<tr align="left" id="tr-portabilidade" <? if (! strstr($linha['comboServicos'], 'Fone')){ echo 'style="display:none"'; }?>>
<td><b>Portabilidade:</b></td>
<? if($editar == '1') {?>
<td>
<select name="portabilidade" id="portabilidade" class="calculaPrecoRoteador">
<option value=""></option>
<option value="SIM" <?php if ($linha['comboPortabilidade'] =='SIM'){ echo 'selected="selected"'; };?>>Sim</option>
<option value="NAO" <?php if ($linha['comboPortabilidade'] =='NAO'){ echo 'selected="selected"'; };?>>Não</option>
</select>
</td>
<? } else {?>
<td><?php echo $linha['comboPortabilidade'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-numeroportado" <? if ( $linha['comboPortabilidade']=='NAO'){ echo 'style="display:none"'; }?>>
<td><b>Número Portado:</b></td>
<? if($editar == '1') {?>
<td>
<input type="text" name="numeroportado" value="<?php echo $linha['comboNumeroPortado']; ?>" onKeyPress="mascara(this,telefone)" maxlength="15" size="20">
</td>
<? } else {?>
<td><?php echo $linha['comboNumeroPortado'];?></td>
<? } ?>
</tr>

<?php /*
<tr align="left">
<td><b>Pagamento:</b></td>
<td>
<select name="pagamento" id="pagamento" class="calculaPrecoRoteador" onchange="verificapagamento(this.value);">
<option value="BOLETO" <?php if ($linha['pagamento'] =='BOLETO'){ echo 'selected="selected"'; };?>>BOLETO</option>
<option value="DÉBITO" <?php if ($linha['pagamento'] =='DÉBITO'){ echo 'selected="selected"'; };?>>DÉBITO</option>
<option value="CARTÃO DE CRÉDITO" <?php if ($linha['pagamento'] =='CARTÃO DE CRÉDITO'){ echo 'selected="selected"'; };?>>CARTÃO DE CRÉDITO</option>
</select>
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
</td>
</tr>
*/
?>


<tr align="left" id="tr-roteador">
<td><b>Roteador:</b></td>
<? if($editar == '1') {?>
<td>
<select name="roteador" id="roteador" class="calculaPrecoRoteador">

	<option></option>

	<option value="SIM" <?php if ($linha['comboRoteador'] =='SIM'){ echo 'selected="selected"'; };?>>Sim</option>
	<option value="NAO" <?php if ($linha['comboRoteador'] =='NAO'){ echo 'selected="selected"'; };?>>Não</option>

</select>
</td>
<? } else {?>
<td><?php echo $linha['comboRoteador'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-clientetv">
<td><b>Cliente Tv?:</b></td>
<? if($editar == '1') {?>
<td>
<select name="clientetv" id="clientetv" class="calculaPrecoRoteador">

	<option></option>

	<option value="SIM" <?php if ($linha['comboClienteTv'] =='SIM'){ echo 'selected="selected"'; };?>>Sim</option>
	<option value="NAO" <?php if ($linha['comboClienteTv'] =='NAO'){ echo 'selected="selected"'; };?>>Não</option>

</select>
</td>
<? } else {?>
<td><?php echo $linha['comboClienteTv'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-precoroteador" <? if ( $linha['comboRoteador']=='NAO'){ echo 'style="display:none"'; }?>>
<td><b>Preço Roteador:</b></td>
<td id="precoroteador">
	<?php echo $linha['comboRoteadorPreco']; ?>
</td>
<input type="hidden" value="<?php echo $linha['comboRoteadorPreco']; ?>" name="precoroteador">
</tr>


<tr>

<td><b>Forma de Pagamento:</b></td>

<td>


<? if($editar == '1') {?>

<select name="pagamento"  onchange="verificapagamento(this.value, 'fpagamento');">

<option value="BOLETO" <? if($linha['pagamento'] == 'BOLETO'){?>selected="selected"<? } ?>>BOLETO</option>

<option value="DÉBITO" <? if($linha['pagamento'] == 'DÉBITO'){?>selected="selected"<? } ?>>DÉBITO</option>

<option value="CARTÃO DE CRÉDITO" <? if($linha['pagamento'] == 'CARTÃO DE CRÉDITO'){?>selected="selected"<? } ?>>CARTÃO DE CRÉDITO</option>

</select>

<? } else { ?>



<?= $linha['pagamento']; ?>



<input type="hidden" value="<?= $linha['pagamento'];?>" name="pagamento" />

</td>



<? } ?>



</td>

</tr>


<!-- ########## INICIO CARTAO ############# -->

<tr class="idcartaocredito" <? if($linha['pagamento'] != 'CARTÃO DE CRÉDITO'){ ?> style="display: none" <? } ?>>

<td><b>Nome do Titular:</b></td>
<td>

<? if($editar == '1') {?>

<input type="text" name="titularCartao" size="30" value="<?=$linha['titularCartao'];?>" /> <span style="font-size:12px; color:#999; font-style:italic">(Nome impresso no cartão)</span>

<? } else {

if($linha['numCar']){ echo $linha['titularCartao']; } ?>

<input type="hidden" name="titularCartao" size="50" value="<?=$linha['titularCartao'];?>" /> 

<? } ?>

</td>
</tr>



<tr class="idcartaocredito" <? if($linha['pagamento'] != 'CARTÃO DE CRÉDITO'){ ?> style="display: none" <? } ?>>
<td><b>Cartão Crédito:</b></td>
<td>
<? 

if( $linha['status'] == 'APROVADO'){

$numDecoCartao = base64_decode($linha['numCar']);
} else {

if($linha['numCar'] != ''){		
$numDecoCartao = 'XXXX-XXXX-XXXX-'.substr(base64_decode($linha['numCar']),15,4);
} else{ $numDecoCartao = "";}

}

if($editar == '1') {?>

<input type="text" name="numcartao" size="50" onKeyPress="mascara(this,cartaocredito)" onChange="mascara(this,cartaocredito)" maxlength="19" value="<?=$numDecoCartao;?>" /> 

<? } else { 

if($linha['numCar']){ echo 'XXXX-XXXX-XXXX-'.substr(base64_decode($linha['numCar']),15,4); } ?>
<input type="hidden" name="numcartao" size="50" value="<?=$linha['numCar'];?>" /> 

<? } ?>
</td>
</tr>


<tr class="idcartaocredito" <? if($linha['pagamento'] != 'CARTÃO DE CRÉDITO'){ ?> style="display: none" <? } ?>>
<td><b>Cód. Segurança:</b></td>
<td>
<? 
if( $linha['status'] == 'APROVADO'){
$numDecoCodSeg = $linha['codSeg'];
} else {

if($linha['codSeg'] != ''){	

$numDecoCodSeg = 'XX'.substr($linha['codSeg'],2,1);

} else { $numDecoCodSeg = "";}

}

if($editar == '1') {?>

<input type="text" name="numcodseguranca" size="50" onKeyPress="mascara(this,cartaocredito)" onChange="mascara(this,cartaocredito)" maxlength="3" value="<?=$numDecoCodSeg;?>" /> 

<? } else { 

if($linha['numCar']){ echo 'XX'.substr($linha['codSeg'],2,1); } ?>
<input type="hidden" name="numcodseguranca" size="50" value="<?=$linha['codSeg'];?>" /> 
<? } ?>
</td>
</tr>

<tr class="idcartaocredito" <? if($linha['pagamento'] != 'CARTÃO DE CRÉDITO'){ ?> style="display: none" <? } ?>>
<td><b>Validade:</b></td>
<td>

<? 
$ValidadeCartao = explode('/',$linha['carVal']);

if($editar == '1') {?>
<select name="mesval">
<option value=""></option>
<? for($i=1;$i<=12;$i++){ ?>
<option value="<?= sprintf("%02d",$i);?>" <? if($i == $ValidadeCartao[0]){?> selected="selected" <? } ?>><?= sprintf("%02d",$i);?></option>
<? } ?>
</select>

<select name="anoval">
<option value=""></option>
<? for($i=date('Y');$i<=(date('Y')+15);$i++){ ?>
<option value="<?= sprintf("%02d",$i);?>" <? if($i == $ValidadeCartao[1]){?> selected="selected" <? } ?>><?= sprintf("%02d",$i);?></option>
<? } ?>
</select>

<? } else { 

if($linha['numCar']){ echo $linha['carVal']; } ?>

<input type="hidden" name="numcartao" size="50" value="<?=$linha['carVal'];?>" /> 

<? } ?>

</td>
</tr>


<tr class="idcartaocredito" <? if($linha['pagamento'] != 'CARTÃO DE CRÉDITO'){ ?> style="display: none" <? } ?>>

<td><b>Bandeira:</b></td>
<td>

<? if($editar == '1') {?>

<select name="carbandeira">
<option value=""></option>
<option value="Visa" <? if($linha['carBan'] == 'Visa'){?> selected="selected" <? } ?>>Visa</option>
<option value="MasterCard" <? if($linha['carBan'] == 'MasterCard'){?> selected="selected" <? } ?>>MasterCard</option>
</select>

<? } else {

if($linha['numCar']){ echo $linha['carBan']; } ?>

<input type="hidden" name="carbandeira" size="50" value="<?=$linha['carBan'];?>" /> 

<? } ?>

</td>
</tr>


<tr class="idcartaocredito" <? if($linha['pagamento'] != 'CARTÃO DE CRÉDITO'){ ?> style="display: none" <? } ?>>
<td><b>Parcelas:</b></td>
<td>

<? 

if($editar == '1') {?>

<select name="numparcelas">
<option value=""></option>
<option value="8" <? if($linha['numParcelas'] == '8'){?> selected="selected" <? } ?>>8</option>
<option value="11" <? if($linha['numParcelas'] == '11'){?> selected="selected" <? } ?>>11</option>
<option value="20" <? if($linha['numParcelas'] == '20'){?> selected="selected" <? } ?>>20</option>
<option value="25" <? if($linha['numParcelas'] == '25'){?> selected="selected" <? } ?>>25</option>
</select>


<? } else { 

if($linha['numCar']){ echo $linha['numParcelas']; } ?>

<input type="hidden" name="numparcelas" size="50" value="<?=$linha['numParcelas'];?>" /> 

<? } ?>

</td>
</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<!-- ########## FIM CARTAO ############# -->


<tr id="idbanco" <? if($linha['pagamento'] != 'DÉBITO'){?> style="display:none" <? } ?>>

<td><b>Banco:</b></td>

<td>

<? if($editar == '1') {?>


<input type="text" id="banco" name="banco" size="20" value="<?= $linha['banco'];?>" /> <b>AG:</b> <input type="text" name="agencia" id="agencia" size="5" value="<?= $linha['agencia'];?>" /> <b>CC:</b> <input type="text" name="contacorrente" id="contacorrente" size="7" value="<?= $linha['conta_corrente'];?>" />


<? } else {?>


<?= $linha['banco'].' <b>AG:</b> '.$linha['agencia'].' <b>CC:</b> '.$linha['conta_corrente'];?>

<input type="hidden" size="40" name="banco" value="<?= $linha['banco']; ?>" />

<input type="hidden" size="40" name="agencia" value="<?= $linha['agencia']; ?>" />

<input type="hidden" size="40" name="contacorrente" value="<?= $linha['conta_corrente']; ?>" />


<? } ?>

 </td>

</tr>


<?php /*

<tr id="idpagamentoinstalacao" <? if($linha['pagamento'] != 'BOLETO'){?> style="display:none" <? } ?>>

<td><b>Pagamento Instalação:</b></td>

<td>

<? if($editar == '1'){?>



<select name="pagamentoinstalacao"  onchange="verificapagamento(this.value, 'instalacao');">

<option value="DINHEIRO" <? if($linha['pagamento_instalacao'] == 'DINHEIRO'){?> selected <? } ?>>DINHEIRO</option>

<option value="CARTÃO DE CRÉDITO" <? if($linha['pagamento_instalacao'] == 'CARTÃO DE CRÉDITO'){?> selected <? } ?>>CARTÃO DE CRÉDITO</option>

<option value="DEPÓSITO" <? if($linha['pagamento_instalacao'] == 'DEPÓSITO'){?> selected <? } ?>>DEPÓSITO</option>

</select>



<? } else { ?>



<?= $linha['pagamento_instalacao'];?>

<input type="hidden" name="pagamentoinstalacao" value="<?= $linha['pagamento_instalacao']; ?>" />



<? } ?>

</td>

</tr>


<tr id="idbancodep" <? if($linha['pagamento_instalacao'] != 'DEPÓSITO'){?> style="display:none" <? } ?>>

<td><b>Banco:</b></td>



<td>

<? if($editar == '1') {?>



<input type="text" id="banco_deposito" name="banco_deposito" size="20" value="<?= $linha['banco_deposito'];?>" /> <b>AG:</b> <input type="text" name="agencia_deposito" id="agencia_deposito" size="5" value="<?= $linha['agencia_deposito'];?>" /> <b>CC:</b> <input type="text" name="contacorrente_deposito" id="contacorrente_deposito" size="7" value="<?= $linha['contacorrente_deposito'];?>" />



<? } else {?>



<?= $linha['banco_deposito'].' <b>AG:</b> '.$linha['agencia_deposito'].' <b>CC:</b> '.$linha['contacorrente_deposito'];?>

<input type="hidden" size="40" name="banco_deposito" value="<?= $linha['banco_deposito']; ?>" />

<input type="hidden" size="40" name="agencia_deposito" value="<?= $linha['agencia_deposito']; ?>" />

<input type="hidden" size="40" name="contacorrente_deposito" value="<?= $linha['contacorrente_deposito']; ?>" />





<? } ?>

 </td>

</tr>

<!-- ########## INICIO CARTAO INSTALACAO ############# -->

<tr class="idcartaocredito_i" <? if($linha['pagamento_instalacao'] != 'CARTÃO DE CRÉDITO' || $linha['pagamento'] != 'BOLETO'){ ?> style="display:none" <? } ?>>

<td><b>Nome do Titular:</b></td>
<td>

<? if($editar == '1') {?>

<input type="text" name="titularCartao_i" size="30" value="<?=$linha['titularCartao_i'];?>" /> <span style="font-size:12px; color:#999; font-style:italic">(Nome impresso no cartão)</span>

<? } else {

if($linha['numCar_i']){ echo $linha['titularCartao_i']; } ?>

<input type="hidden" name="titularCartao_i" size="50" value="<?=$linha['titularCartao_i'];?>" /> 

<? } ?>

</td>
</tr>

<tr class="idcartaocredito_i" <? if($linha['pagamento_instalacao'] != 'CARTÃO DE CRÉDITO' || $linha['pagamento'] != 'BOLETO'){?> style="display:none" <? } ?>>
<td><b>Cartão Crédito:</b></td>
<td>
<? 

if( $linha['status'] == 'APROVADO'){

$numDecoCartao = base64_decode($linha['numCar_i']);
} else {

if($linha['numCar_i'] != ''){
$numDecoCartao = 'XXXX-XXXX-XXXX-'.substr(base64_decode($linha['numCar_i']),15,4);
} else{ $numDecoCartao = "";}

}

if($editar == '1') {?>

<input type="text" name="numcartao_i" size="50" onKeyPress="mascara(this,cartaocredito)" onChange="mascara(this,cartaocredito)" maxlength="19" value="<?=$numDecoCartao;?>" /> 

<? } else { 

if($linha['numCar_i']){ echo 'XXXX-XXXX-XXXX-'.substr(base64_decode($linha['numCar_i']),15,4); } ?>
<input type="hidden" name="numcartao_i" size="50" value="<?=$linha['numCar_i'];?>" /> 

<? } ?>
</td>
</tr>


<tr class="idcartaocredito_i" <? if($linha['pagamento_instalacao'] != 'CARTÃO DE CRÉDITO' || $linha['pagamento'] != 'BOLETO'){?> style="display:none" <? } ?>>
<td><b>Cód. Segurança:</b></td>
<td>
<? 
if( $linha['status'] == 'APROVADO'){
$numDecoCodSeg = $linha['codSeg_i'];
} else {

if($linha['codSeg_i'] != ''){	

$numDecoCodSeg = 'XX'.substr($linha['codSeg_i'],2,1);

} else { $numDecoCodSeg = "";}

}

if($editar == '1') {?>

<input type="text" name="numcodseguranca_i" size="50" onKeyPress="mascara(this,cartaocredito)" onChange="mascara(this,cartaocredito)" maxlength="3" value="<?=$numDecoCodSeg;?>" /> 

<? } else { 

if($linha['numCar_i']){ echo 'XX'.substr($linha['codSeg_i'],2,1); } ?>
<input type="hidden" name="numcodseguranca_i" size="50" value="<?=$linha['codSeg_i'];?>" /> 
<? } ?>
</td>
</tr>

<tr class="idcartaocredito_i" <? if($linha['pagamento_instalacao'] != 'CARTÃO DE CRÉDITO' || $linha['pagamento'] != 'BOLETO'){?> style="display:none" <? } ?>>
<td><b>Validade:</b></td>
<td>

<? 
$ValidadeCartao = explode('/',$linha['carVal_i']);

if($editar == '1') {?>
<select name="mesval_i">
<option value=""></option>
<? for($i=1;$i<=12;$i++){ ?>
<option value="<?= sprintf("%02d",$i);?>" <? if($i == $ValidadeCartao[0]){?> selected="selected" <? } ?>><?= sprintf("%02d",$i);?></option>
<? } ?>
</select>

<select name="anoval_i">
<option value=""></option>
<? for($i=date('Y');$i<=(date('Y')+15);$i++){ ?>
<option value="<?= sprintf("%02d",$i);?>" <? if($i == $ValidadeCartao[1]){?> selected="selected" <? } ?>><?= sprintf("%02d",$i);?></option>
<? } ?>
</select>

<? } else { 

if($linha['numCar_i']){ echo $linha['carVal_i']; } ?>

<input type="hidden" name="numcartao_i" size="50" value="<?=$linha['carVal_i'];?>" /> 

<? } ?>

</td>
</tr>


<tr class="idcartaocredito_i" <? if($linha['pagamento_instalacao'] != 'CARTÃO DE CRÉDITO' || $linha['pagamento'] != 'BOLETO'){?> style="display:none" <? } ?>>

<td><b>Bandeira:</b></td>
<td>

<? if($editar == '1') {?>

<select name="carbandeira_i">
<option value=""></option>
<option value="Visa" <? if($linha['carBan_i'] == 'Visa'){?> selected="selected" <? } ?>>Visa</option>
<option value="MasterCard" <? if($linha['carBan_i'] == 'MasterCard'){?> selected="selected" <? } ?>>MasterCard</option>
</select>

<? } else {

if($linha['numCar_i']){ echo $linha['carBan_i']; } ?>

<input type="hidden" name="carbandeira_i" size="50" value="<?=$linha['carBan_i'];?>" /> 

<? } ?>

</td>
</tr>


<tr class="idcartaocredito_i" <? if($linha['pagamento_instalacao'] != 'CARTÃO DE CRÉDITO' || $linha['pagamento'] != 'BOLETO'){?> style="display:none" <? } ?>>
<td><b>Parcelas:</b></td>
<td>

<? 

if($editar == '1') {?>

<select name="numparcelas_i">
<option value=""></option>
<option value="8" <? if($linha['numParcelas_i'] == '8'){?> selected="selected" <? } ?>>8</option>
<option value="11" <? if($linha['numParcelas_i'] == '11'){?> selected="selected" <? } ?>>11</option>
<option value="20" <? if($linha['numParcelas_i'] == '20'){?> selected="selected" <? } ?>>20</option>
<option value="25" <? if($linha['numParcelas_i'] == '25'){?> selected="selected" <? } ?>>25</option>
</select>


<? } else { 

if($linha['numCar_i']){ echo $linha['numParcelas_i']; } ?>

<input type="hidden" name="numparcelas_i" size="50" value="<?=$linha['numParcelas_i'];?>" /> 

<? } ?>

</td>
</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<? //} ?>

<!-- ########## FIM CARTAO INSTALACAO ############# -->




<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

*/ ?>

<tr>

<td><b>Status:</b></td>

<td>
<?
if ( 
		( 
			($editar == '1') 
			|| ($_GET['e']=='1')
		) 
		
		// && ($USUARIO['tipo_usuario'] == 'SUPERVISOR' || $USUARIO['tipo_usuario'] == 'MONITOR' || $USUARIO['tipo_usuario'] == 'ADMINISTRADOR') 
	)  {
		
?>

	<select id="status" name="status" onChange="checkstatus(this.value)">

		<?php 
			
			$venda = new Venda( $linha['id'] );
			
			foreach( $venda->Status->getFluxo() as $key=>$value)
			{
				echo '<option value="' . $key . '">' . $value . '</option>';
			}
			

		?>

	</select>	


<? } else { ?>



<?= $linha['status']; ?>



<input type="hidden" name="status" value="<?= $linha['status']; ?>" />



</td>



<? } ?>



</td>

</tr>
<?php  /* ################## Fluxo Antigo manual ##################
<tr>

<td><b>Status:</b></td>

<td>

<? if($_GET['e']== '1' && ($USUARIO['tipo_usuario'] == 'ADMINISTRADOR' || $USUARIO['id']==3227)) { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="PRE-ANALISE" <? if($linha['status'] == 'PRE-ANALISE'){?>selected="selected"<? } ?>>Pré-Análise</option>

<option value="ANÁLISE" <? if($linha['status'] == 'ANÁLISE'){?>selected="selected"<? } ?>>Análise</option>

<option value="GRAVAR" <? if($linha['status'] == 'GRAVAR'){?>selected="selected"<? } ?>>Gravar</option>

<option value="APROVADO" <? if($linha['status'] == 'APROVADO'){?>selected="selected"<? } ?>>Aprovado</option>

<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>

<option value="SEM CONTATO" <? if($linha['status'] == 'SEM CONTATO'){?>selected="selected"<? } ?>>Sem Contato</option>

<option value="RESTRIÇÃO" <? if($linha['status'] == 'RESTRIÇÃO'){?>selected="selected"<? } ?>>Restrição</option>

<option value="INSTALAR" <? if($linha['status'] == 'INSTALAR'){?>selected="selected"<? } ?>>Instalar</option>

<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>

<option value="PENDENTE" <? if($linha['status'] == 'PENDENTE'){?>selected="selected"<? } ?>>Pendente</option>

<option value="CONECTADO" <? if($linha['status'] == 'CONECTADO'){?>selected="selected"<? } ?>>Conectado</option>



</select>

<!-- // EXCEÇÃO PARA SUPER USUARIO DE INTERNET -->

<? } else if($USUARIO['id']==3227 && ($editar == '1' || $editar_instalacao == '1') && ($linha['status'] == 'DEVOLVIDO' || $linha['status'] == 'SEM CONTATO' || $linha['status'] == 'RESTRIÇÃO') ) { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>
<option value="RECUPERADO" <? if($linha['status'] == 'RECUPERADO'){?>selected="selected"<? } ?>>Venda Recuperada</option>
</select>
<script>

	$(window).load(function () {
		$("[name='status']").trigger("change");

	});

</script>
<? } else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'PRE-ANALISE') { ?>


<select name="status" onChange="checkstatus(this.value)">
<option value="PRE-ANALISE" <? if($linha['status'] == 'PRE-ANALISE'){?>selected="selected"<? } ?>>Pré-Análise</option>

<option value="ANÁLISE" <? if($linha['status'] == 'ANÁLISE'){?>selected="selected"<? } ?>>Análise</option>

<option value="GRAVAR" <? if($linha['status'] == 'GRAVAR'){?>selected="selected"<? } ?>>Gravar</option>

<option value="RESTRIÇÃO" <? if($linha['status'] == 'RESTRIÇÃO'){?>selected="selected"<? } ?>>Restrição</option>

</select>


<? } else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'GRAVAR') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="GRAVAR" <? if($linha['status'] == 'GRAVAR'){?>selected="selected"<? } ?>>Gravar</option>

<option value="APROVADO" <? if($linha['status'] == 'APROVADO'){?>selected="selected"<? } ?>>Aprovado</option>

<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>

<option value="SEM CONTATO" <? if($linha['status'] == 'SEM CONTATO'){?>selected="selected"<? } ?>>Sem Contato</option>

</select>

<? } else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'SEM CONTATO') { ?>

<select name="status" onChange="checkstatus(this.value)">

<option value="SEM CONTATO" <? if($linha['status'] == 'SEM CONTATO'){?>selected="selected"<? } ?>>Sem Contato</option>

<option value="GRAVAR" <? if($linha['status'] == 'GRAVAR'){?>selected="selected"<? } ?>>Gravar</option>

<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>

</select>


<? } else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'ANÁLISE') { ?>


<select name="status" onChange="checkstatus(this.value)">

<option value="ANÁLISE" <? if($linha['status'] == 'ANÁLISE'){?>selected="selected"<? } ?>>Análise</option>

<option value="APROVADO" <? if($linha['status'] == 'APROVADO'){?>selected="selected"<? } ?>>Aprovado</option>

<option value="INSTALAR" <? if($linha['status'] == 'INSTALAR'){?>selected="selected"<? } ?>>Instalar</option>

<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>

<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>



</select>


<? } else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'APROVADO') { ?>

<select name="status" onChange="checkstatus(this.value)">

<option value="APROVADO" <? if($linha['status'] == 'APROVADO'){?>selected="selected"<? } ?>>Aprovado</option>

<option value="INSTALAR" <? if($linha['status'] == 'INSTALAR'){?>selected="selected"<? } ?>>Instalar</option>

<option value="ANÁLISE" <? if($linha['status'] == 'ANÁLISE'){?>selected="selected"<? } ?>>Análise</option>

<option value="RESTRIÇÃO" <? if($linha['status'] == 'RESTRIÇÃO'){?>selected="selected"<? } ?>>Restrição</option>

</select>

<? } else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'INSTALAR') { ?>

<select name="status" onChange="checkstatus(this.value)">

<option value="INSTALAR" <? if($linha['status'] == 'INSTALAR'){?>selected="selected"<? } ?>>Instalar</option>

<option value="CONECTADO" <? if($linha['status'] == 'CONECTADO'){?>selected="selected"<? } ?>>Conectado</option>

<option value="PENDENTE" <? if($linha['status'] == 'PENDENTE'){?>selected="selected"<? } ?>>Pendente</option>

<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>

<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>

</select>

<? } else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'PENDENTE') { ?>

<select name="status" onChange="checkstatus(this.value)">

<option value="PENDENTE" <? if($linha['status'] == 'PENDENTE'){?>selected="selected"<? } ?>>Pendente</option>

<option value="INSTALAR" <? if($linha['status'] == 'INSTALAR'){?>selected="selected"<? } ?>>Instalar</option>

<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>

</select>

<? } else if((($editar == '1' || $editar_instalacao == '1') || ($_GET['e'] == '1' &&  $USUARIO['tipo_usuario'] == 'MONITOR')) && $linha['status'] == 'DEVOLVIDO') { ?>

<select name="status" onChange="checkstatus(this.value)">

<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>

<option value="RECUPERADO" <? if($linha['status'] == 'RECUPERADO'){?>selected="selected"<? } ?>>Recuperado</option>

<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>

</select>

<? }else if((($editar == '1' || $editar_instalacao == '1') || ($_GET['e'] == '1' &&  $USUARIO['tipo_usuario'] == 'LOGISTICA')) && $linha['status'] == 'DEVOLVIDO') {
?>
	<select name="status" onChange="checkstatus(this.value)">

		<option value="DEVOLVIDO" <? if($linha['status'] == 'REDIRECIONADO'){?>selected="selected"<? } ?>>Redirecionado</option>

		<option value="RECUPERADO" <? if($linha['status'] == 'PRÉ-ANÁLISE'){?>selected="selected"<? } ?>>Pré-Análise</option>
	</select>

<?}else if((($editar == '1' || $editar_instalacao == '1') || ($_GET['e'] == '1' &&  $USUARIO['tipo_usuario'] == 'LOGISTICA')) && $linha['status'] == 'REDIRECIONADO') { ?>
	<select name="status" onChange="checkstatus(this.value)">
		<option value="RECUPERADO" <? if($linha['status'] == 'PRÉ-ANÁLISE'){?>selected="selected"<? } ?>>Pré-Análise</option>
	</select>
<?}else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'CANCELADO') { ?>

<select name="status" onChange="checkstatus(this.value)">

<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>

<option value="APROVADO" <? if($linha['status'] == 'APROVADO'){?>selected="selected"<? } ?>>Aprovado</option>

</select>

<? } else { ?>



<?= $linha['status']; ?>



<input type="hidden" name="status" value="<?= $linha['status']; ?>" />



</td>



<? } ?>



</td>

</tr>

################## Fim Fluxo Antigo Manual ################## */
?>




<? if($linha['status'] == 'CANCELADO' || $editar_instalacao == '1' || $editar == '1' || ($USUARIO['tipo_usuario'] == 'LOGISTICA' || $USUARIO['tipo_usuario'] == 'MONITOR')){?>

<tr id="mcancel" <? if($linha['status'] != 'CANCELADO'){ ?> style="display:none" <? } ?>>

<td><b>Motivo:</b></td>

<td>

<? if($editar_instalacao == '1' || $editar == '1' || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR')) { ?>

<select name="motivocancelamento" id="motivocancelamento">

<option value=""></option>

<option value="Inviabilidade Técnica" <? if($linha['motivo_cancelamento'] == 'Inviabilidade Técnica'){?>selected="selected"<? } ?>>Inviabilidade Técnica</option>

<option value="Desistência do Cliente" <? if($linha['motivo_cancelamento'] == 'Desistência do Cliente'){?>selected="selected"<? } ?>>Desistência do Cliente</option>

<?php /*
<option value="Falta de Dinheiro" <? if($linha['motivo_cancelamento'] == 'Falta de Dinheiro'){?>selected="selected"<? } ?>>Falta de Dinheiro</option>

<option value="Venda Perdida para a Concorrência" <? if($linha['motivo_cancelamento'] == 'Venda Perdida para a Concorrência'){?>selected="selected"<? } ?>>Venda Perdida para a Concorrência</option>

<option value="Endereço Não Encontrado" <? if($linha['motivo_cancelamento'] == 'Endereço Não Encontrado'){?>selected="selected"<? } ?>>Endereço Não Encontrado</option>

<option value="Área de Risco" <? if($linha['motivo_cancelamento'] == 'Área de Risco'){?>selected="selected"<? } ?>>Área de Risco</option>

<option value="Cancelado no VSALES" <? if($linha['motivo_cancelamento'] == 'Cancelado no VSALES'){?>selected="selected"<? } ?>>Cancelado no VSALES</option>

<option value="Número Inválido" <? if($linha['motivo_cancelamento'] == 'Número Inválido'){?>selected="selected"<? } ?>>Número Inválido</option>

*/ ?>

</select>

<? } else {?>



<?= $linha['motivo_cancelamento']; ?>



<? } ?>

</td>

</tr>

<? } ?>




<?
// motivo analise

 if($linha['status'] == 'ANÁLISE' || $editar_instalacao == '1' || $editar == '1' || ($USUARIO['tipo_usuario'] == 'LOGISTICA' || $USUARIO['tipo_usuario'] == 'MONITOR')){?>

<tr id="manalise" <? if($linha['status'] != 'ANÁLISE'){ ?> style="display:none" <? } ?>>

<td><b>Motivo:</b></td>

<td>

<? if($editar_instalacao == '1' || $editar == '1' || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR')) { ?>

<select name="motivoanalise" id="motivoanalise">

<option value=""></option>

<option value="CEP Nulo" <? if($linha['motivo_analise'] == 'CEP Nulo'){?>selected="selected"<? } ?>>CEP Nulo</option>

<option value="Duplicidade" <? if($linha['motivo_analise'] == 'Duplicidade'){?>selected="selected"<? } ?>>Duplicidade</option>

<option value="Tipo de Conta Corrente Inválida" <? if($linha['motivo_analise'] == 'Tipo de Conta Corrente Inválida'){?>selected="selected"<? } ?>>Tipo de Conta Corrente Inválida</option>

<?php /*
<option value="Quarentena" <? if($linha['motivo_analise'] == 'Quarentena'){?>selected="selected"<? } ?>>Quarentena</option>

<option value="Conta Inválida" <? if($linha['motivo_analise'] == 'Conta Inválida'){?>selected="selected"<? } ?>>Conta Inválida</option>
*/ ?>

<option value="Endereço Não Encontrado" <? if($linha['motivo_analise'] == 'Endereço Não Encontrado'){?>selected="selected"<? } ?>>Endereço Não Encontrado</option>

<option value="Aguardando retorno bancário" <? if($linha['motivo_analise'] == 'Aguardando retorno bancário'){?>selected="selected"<? } ?>>Aguardando retorno bancário</option>


</select>

<? } else {?>



<?= $linha['motivo_analise']; ?>



<? } ?>

</td>

</tr>

<? } ?>




<? 

// obs recuperacao

if($linha['obs_recuperacao'] != '' || $editar_instalacao == '1' || $editar == '1' || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR')){?>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<tr id="obsrecupe" <? if($linha['obs_recuperacao'] == ''){ ?> style="display:none" <? } ?>>

<td><b>Obs. Recuperação:</b></td>

<td>

<? if( (($editar == '1' || $editar_instalacao == '1') || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR')) && $linha['obs_recuperacao'] == '') { ?>

<textarea name="obsrecuperacao" id="obsrecuperacao" rows="3" cols="30"></textarea>

<? } else {?>


<?= $linha['obs_recuperacao']; ?> <br />

<? 

$conVendaRecuperada = $conexao->query("SELECT nome FROM usuarios WHERE id = '".$linha['usuario_recuperacao']."'");
$usuarioRecuperada = mysql_fetch_array($conVendaRecuperada);

$dataRecuperada = substr($linha['data_recuperacao'],8,2).'/'.substr($linha['data_recuperacao'],5,2).'/'.substr($linha['data_recuperacao'],0,4).' às '.substr($linha['data_recuperacao'],11);

?>

<span style="color:#787878; font-size:11px;">
<b>Recuperada por:</b> <?= $usuarioRecuperada['nome'];?>&nbsp;
em <?= $dataRecuperada;?>
</span>



<? } ?>

</td>

</tr>

<? } ?>






</form>

</table>

<br />

<br />



<? if(($USUARIO==3179 && $_GET['e']==1) ||$editar == '1' || $editar_instalacao == '1' || ($_GET['e'] == '1' && ($USUARIO['tipo_usuario'] == 'LOGISTICA' || $USUARIO['tipo_usuario'] == 'MONITOR'))) {?>



<center>

<img src="img/salvar.png" height="25" onClick="javascript:validar();" style="cursor:pointer" />



<img src="img/cancelar.png" height="25" onClick="window.location = '?id=<?= $_GET['id'];?>'" style="cursor:pointer" />

</center>



<? } else {?>

<center>

<? if($USUARIO['editar_dados'] == 1 || $USUARIO['editar_instalacao'] == 1 || ($USUARIO['tipo_usuario'] == 'LOGISTICA' || $USUARIO['tipo_usuario'] == 'MONITOR') ){?>

<img src="img/editar.png" height="25" onClick="window.location = '?id=<?= $_GET['id'];?>&e=1'" style="cursor:pointer" /> 

<? } ?>



<img src="img/imprimir.png" height="25" onClick="javascript:print();" style="cursor:pointer" />

</center>

<? } ?>





</body>

</html>
