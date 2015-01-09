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

$contrato = $_POST['contrato'];


// Dados Pessoais

$nome = $_POST['nome'];
$nome_mae = $_POST['nomemae'];
$nome_pai = $_POST['nomepai'];
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
//$plano = $_POST['plano'];
$pontos = $_POST['pontos'];
$vencimento = $_POST['vencimento'];

$netFilial = $_POST['filial'];
$netTipoContrato = $_POST['tipocontrato'];
$netPerfil = $_POST['perfil'];
$netGrupo = $_POST['grupo'];
$netAgregados = $_POST['agregados'];
$netOrigem = $_POST['origem'];
$netPlanotv = $_POST['planotv'];
$netPlanofone = $_POST['planofone'];
$netPlanonet = $_POST['planonet'];
$netPortabilidade = $_POST['portabilidade'];
$netProdutos = $_POST['netProdutos'];
$netPeriodo = $_POST['periodo-instalacao'];
$netNumeroPortado = $_POST['numeroportado'];
$netOperadoraPortada = $_POST['operadoraportada'];
$netNumeroPortadoMovel = $_POST['numeroportadomovel'];
$netOperadoraPortadaMovel = $_POST['operadoraportadamovel'];
$netTipoServico = $_POST['tiposervico'];

$netCelularPlano = $_POST['planocelular'];
$netCelularPlanoPreco = $_POST['planocelularPreco'];

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

$titularconta = $_POST['titularconta'];
$titularcontacpf = $_POST['titularcontacpf'];

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



$update = $conexao->query("UPDATE vendas_clarotv SET proposta = '".$proposta."', os = '".$os."', contrato = '".$contrato."', nome = '".$nome."', nome_mae = '".$nome_mae."', nome_pai = '".$nome_pai."', nascimento = '".$nascimento."', cpf = '".$cpf."', rg = '".$rg."', org_exp = '".$org_exp."', profissao = '".$profissao."', sexo = '".$sexo."', estado_civil = '".$estado_civil."', email = '".$email."', telefone = '".$telefone."', tipo_tel1 = '".$tipo_tel1."', telefone2 = '".$telefone2."', tipo_tel2 = '".$tipo_tel2."', telefone3 = '".$telefone3."', tipo_tel3 = '".$tipo_tel3."', endereco = '".$endereco."', numero = '".$numero."', lote = '".$lote."', quadra = '".$quadra."', complemento = '".$complemento."', bairro = '".$bairro."', cidade = '".$cidade."', uf = '".$uf."', cep = '".$cep."', ponto_referencia = '".$ponto_referencia."', operador = '".$operador."', monitor = '".$monitor."', status = '".$status."', valor = '".$valor."', pagamento = '".$pagamento."', banco = '".$banco."', agencia = '".$agencia."', conta_corrente = '".$conta_corrente."', titular_conta_deposito = '".$titularconta."', cpf_titular_conta_deposito = '".$titularcontacpf."', banco_deposito = '".$banco_deposito."', agencia_deposito = '".$agencia_deposito."', contacorrente_deposito = '".$contacorrente_deposito."', data = '".$data."', plano = '".$plano."', pontos = '".$pontos."', os2 = '".$os2."', os3 = '".$os3."', vencimento = '".$vencimento."', agendGravacao = '".$agendGravacao."', data_marcada = '".$data_marcada."',numerosReagendPendentes = '".$numerosReagendPendentes."', reagendamentos = '".$numreagendamentos."', motivo_cancelamento = '".$motivo_cancelamento."', motivo_analise = '".$motivo_analise."', obs_recuperacao = '".$obs_recuperacao."', usuario_recuperacao = '".$usuario_recuperacao."', data_recuperacao = '".$data_recuperacao."', data_instalacao = '".$data_instalacao."', qs = '".$qs."', nivel = '".$nivel."', decoder = '".$decoder."', certidao = '".$certidao."', smart = '".$smart."', quality_nota = '".$quality_nota."', decoder2 = '".$decoder2."', certidao2 = '".$certidao2."', smart2 = '".$smart2."', decoder3 = '".$decoder3."', certidao3 = '".$certidao3."', smart3 = '".$smart3."', tipo_instalacao = '".$tipo_instalacao."', pagamento_instalacao = '".$pagamento_instalacao."', tecnico_id = '".$tecnico_id."', titularCartao = '".$titularCartao."', numCar = '".$numCar."', codSeg = '".$codSeg."', carVal = '".$carVal."', carBan = '".$carBan."', numParcelas = '".$numParcelas."', titularCartao_i = '".$titularCartao_i."', numCar_i = '".$numCar_i."', codSeg_i = '".$codSeg_i."', carVal_i = '".$carVal_i."', carBan_i = '".$carBan_i."', numParcelas_i = '".$numParcelas_i."', netFilial = '".$netFilial."', netTipoContrato = '".$netTipoContrato."', netPerfil = '".$netPerfil."', netGrupo = '".$netGrupo."', netAgregados = '".$netAgregados."', netOrigem = '".$netOrigem."', plano = '".$netPlanotv."', comboFonePlano = '".$netPlanofone."', comboInternetPlano = '".$netPlanonet."', comboPortabilidade = '".$netPortabilidade."', comboServicos = '".$netProdutos."', netPeriodo = '".$netPeriodo."', netOperadoraPortada = '".$netOperadoraPortada."', comboNumeroPortado = '".$netNumeroPortado."', netPortabilidadeMovel = '".$netOperadoraPortadaMovel."', netNumeroPortadoMovel = '".$netNumeroPortadoMovel."', netCelularPlano = '".$netCelularPlano."', netCelularPlanoPreco = '".$netCelularPlanoPreco."', netTipoServico = '".$netTipoServico."' WHERE id = '".$_GET['id']."' ") or die('Ocorreu um Erro ao inserir os dados!');





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

<title>Detalhes Venda Net</title>



<style type="text/css">



body{margin: 0 0 0 0; font-family:Arial, Helvetica, sans-serif;}



#topo{position:relative; background:url(img/topo-bg.png) repeat-x; top:0px; height:120px; width:100%;}



</style>



</head>



<!-- <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>-->
 
 <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>

<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>

<script type="text/javascript">

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

	

    function cnpj(v){
        //Remove tudo o que não é dígito
        v=v.replace(/\D/g,"");
        //Coloca parênteses em volta dos dois primeiros dígitos
        v=v.replace(/^(\d{2})(\d)/g,"$1.$2");
        //Coloca hífen entre o quarto e o quinto dígitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2");
        //retorne o resultado
		v=v.replace(/(\d{3})(\d)/,"$1/$2");
        //retorne o resultado
		v=v.replace(/(\d{4})(\d)/,"$1-$2");
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

function validarCNPJ(str){

    str = str.replace('.','');
    str = str.replace('.','');
    str = str.replace('.','');
    str = str.replace('-','');
    str = str.replace('/','');
    cnpj = str;
    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    digitos_iguais = 1;
    if (cnpj.length < 14 && cnpj.length < 15)
        return false;
    for (i = 0; i < cnpj.length - 1; i++)
        if (cnpj.charAt(i) != cnpj.charAt(i + 1))
    {
        digitos_iguais = 0;
        break;
    }
    if (!digitos_iguais)
    {
        tamanho = cnpj.length - 2
        numeros = cnpj.substring(0,tamanho);
        digitos = cnpj.substring(tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--)
        {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
            return false;
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0,tamanho);
        soma = 0;
        pos = tamanho - 7;
        for (i = tamanho; i >= 1; i--)
        {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2)
                pos = 9;
        }
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
            return false;
        return true;
    }
    else
        return false;
}

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

	validacao = cpf.length > 14 ? validarCNPJ(cpf) : validacpf(cpf);
	if(!validacao)
	{
	alert("CPF/CNPJ Inválido");

	$('input[name="icpf"]').focus();

	erro = erro+1;

	window.location.reload();

	}
}
///// Se APROVADO /////

if(status == 'APROVADO'){

// Verificar se existe gravação
if(erro == 0){

	/*
	if(gravacao == ''){

		alert("Status não permitido sem gravação!");

		erro = erro+1;

		window.location.reload();

	}
	*/
}

}


//////// Se INSTALAR	/////////

if(status == 'INSTALAR'){


// Verificar se o CPF é válido

validacao = cpf.length > 14 ? validarCNPJ(cpf) : validacpf(cpf);
if(!validacao)

{
alert("CPF/CNPJ Inválido");

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

	/*
	if(gravacao == '')

	{

	alert("Status não permitido sem gravação!");

	erro = erro+1;


	}
	*/
}


}

// Se CONECTADO

if(status == 'CONECTADO'){


validacao = cpf.length > 14 ? validarCNPJ(cpf) : validacpf(cpf);
if(!validacao)

{
alert("CPF/CNPJ Inválido");

$('input[name="icpf"]').focus();

erro = erro+1;

window.location.reload();

}


if(erro == 0){

	/*
	if(gravacao == '')

	{



	alert("Status não permitido sem gravação!");

	erro = erro+1;



	}
	*/
}



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

function atualizaPlanosTv(){
	
	var perfil = $('#perfil option:selected').val();
	var planosTv  = '<option value=""></option>';
	
	if( perfil == 'COLETIVO' ){

			planosTv += '<option value="NET Top HD Cinema Futebol" data-grupo="GP3">NET Top HD Cinema Futebol</option>\
						<option value="NET Top HD Telecine Futebol" data-grupo="GP3">NET Top HD Telecine Futebol</option>\
						<option value="NET Top HD HBO Futebol" data-grupo="GP3">NET Top HD HBO Futebol</option>\
						<option value="NET Top HD Cinema Futebol" data-grupo="GP3">NET Top HD Cinema Futebol</option>\
						<option value="NET Top HD Futebol" data-grupo="GP3">NET Top HD Futebol</option>\
						<option value="NET Top HD Telecine" data-grupo="GP3">NET Top HD Telecine</option>\
						<option value="NET Top HD HBO" data-grupo="GP3">NET Top HD HBO</option>\
						<option value="NET Top HD HBO 4" data-grupo="GP3">NET Top HD HBO 4</option>\
						<option value="NET Top HD" data-grupo="GP3">NET Top HD</option>\
						<option value="NET Mais HD Cinema Futebol" data-grupo="GP2">NET Mais HD Cinema Futebol</option>\
						<option value="NET Mais HD Telecine Futebol" data-grupo="GP2">NET Mais HD Telecine Futebol</option>\
						<option value="NET Mais HD HBO Futebol" data-grupo="GP2">NET Mais HD HBO Futebol</option>\
						<option value="NET Mais HD Cinema" data-grupo="GP2">NET Mais HD Cinema</option>\
						<option value="NET Mais HD Futebol" data-grupo="GP2">NET Mais HD Futebol</option>\
						<option value="NET Mais HD Telecine" data-grupo="GP2">NET Mais HD Telecine</option>\
						<option value="NET Mais HD HBO" data-grupo="GP2">NET Mais HD HBO</option>\
						<option value="NET Mais HD HBO 4" data-grupo="GP2">NET Mais HD HBO 4</option>\
						<option value="NET Mais HD" data-grupo="GP2">NET Mais HD</option>\
						<option value="NET Essencial HD Cinema Futebol" data-grupo="GP2">NET Essencial HD Cinema Futebol</option>\
						<option value="NET Essencial HD Telecine Futebol" data-grupo="GP2">NET Essencial HD Telecine Futebol</option>\
						<option value="NET Essencial HD HBO Futebol" data-grupo="GP2">NET Essencial HD HBO Futebol</option>\
						<option value="NET Essencial HD Cinema" data-grupo="GP2">NET Essencial HD Cinema</option>\
						<option value="NET Essencial HD Futebol" data-grupo="GP2">NET Essencial HD Futebol</option>\
						<option value="NET Essencial HD Telecine" data-grupo="GP2">NET Essencial HD Telecine</option>\
						<option value="NET Essencial HD HBO" data-grupo="GP2">NET Essencial HD HBO</option>\
						<option value="NET Essencial HD HBO 4" data-grupo="GP2">NET Essencial HD HBO 4</option>\
						<option value="NET Essencial HD" data-grupo="GP2">NET Essencial HD</option>';
			
	} else {

		planosTv += '<option value="NET Top HD Max Cinema Fut" data-grupo="GP3">NET Top HD Max Cinema Fut</option>\
				<option value="NET Top HD Max HBO Futebol" data-grupo="GP3">NET Top HD Max HBO Futebol</option>\
				<option value="NET Top HD Max Cinema" data-grupo="GP3">NET Top HD Max Cinema</option>\
				<option value="NET Top HD Max Futebol" data-grupo="GP3">NET Top HD Max Futebol</option>\
				<option value="NET Top HD Max Telecine" data-grupo="GP3">NET Top HD Max Telecine</option>\
				<option value="NET Top HD Max HBO" data-grupo="GP3">NET Top HD Max HBO</option>\
				<option value="NET Top HD Max" data-grupo="GP3">NET Top HD Max</option>\
				<option value="NET Top HD Cinema Futebol" data-grupo="GP3">NET Top HD Cinema Futebol</option>\
				<option value="NET Top HD Telecine Futebol" data-grupo="GP3">NET Top HD Telecine Futebol</option>\
				<option value="NET Top HD HBO Futebol" data-grupo="GP3">NET Top HD HBO Futebol</option>\
				<option value="NET Top HD Cinema" data-grupo="GP3">NET Top HD Cinema</option>\
				<option value="NET Top HD Futebol" data-grupo="GP3">NET Top HD Futebol</option>\
				<option value="NET Top HD Telecine" data-grupo="GP3">NET Top HD Telecine</option>\
				<option value="NET Top HD HBO" data-grupo="GP3">NET Top HD HBO</option>\
				<option value="NET Top HD" data-grupo="GP3">NET Top HD</option>\
				<option value="NET Mais HD Cinema Futebol" data-grupo="GP2">NET Mais HD Cinema Futebol</option>\
				<option value="NET Mais HD Telecine Futebol" data-grupo="GP2">NET Mais HD Telecine Futebol</option>\
				<option value="NET Mais HD HBO Futebol" data-grupo="GP2">NET Mais HD HBO Futebol</option>\
				<option value="NET Mais HD Cinema" data-grupo="GP2">NET Mais HD Cinema</option>\
				<option value="NET Mais HD Futebol" data-grupo="GP2">NET Mais HD Futebol</option>\
				<option value="NET Mais HD Telecine" data-grupo="GP2">NET Mais HD Telecine</option>\
				<option value="NET Mais HD HBO" data-grupo="GP2">NET Mais HD HBO</option>\
				<option value="NET Mais HD" data-grupo="GP2">NET Mais HD</option>\
				<option value="NET Essencial HD Cinema Futebol" data-grupo="GP2">NET Essencial HD Cinema Futebol</option>\
				<option value="NET Essencial HD Telecine Futebol" data-grupo="GP2">NET Essencial HD Telecine Futebol</option>\
				<option value="NET Essencial HD HBO Futebol" data-grupo="GP2">NET Essencial HD HBO Futebol</option>\
				<option value="NET Essencial HD Futebol" data-grupo="GP2">NET Essencial HD Futebol</option>\
				<option value="NET Essencial HD Cinema" data-grupo="GP2">NET Essencial HD Cinema</option>\
				<option value="NET Essencial HD Telecine" data-grupo="GP2">NET Essencial HD Telecine</option>\
				<option value="NET Essencial HD HBO" data-grupo="GP2">NET Essencial HD HBO</option>\
				<option value="NET Essencial HD" data-grupo="GP2">NET Essencial HD</option>\
				<option value="NET Fácil HD Telecine Light" data-grupo="GP1">NET Fácil HD Telecine Light</option>\
				<option value="NET Fácil HD HBO Light" data-grupo="GP1">NET Fácil HD HBO Light</option>\
				<option value="NET Fácil HD" data-grupo="GP1">NET Fácil HD</option>\
				<option value="NET Fácil Telecine Light" data-grupo="GP1">NET Fácil Telecine Light</option>\
				<option value="NET Fácil HBO Light" data-grupo="GP1">NET Fácil HBO Light</option>\
				<option value="NET Fácil" data-grupo="GP1">NET Fácil</option>';
		
	}
	
	var persistPlanoTv = $('#planotv option:selected').val();
			
	$('#planotv').html(planosTv);
	$('#planotv').val(persistPlanoTv);

}

function atualizaPlanosVirtua(){
	
	var perfil = $('#perfil option:selected').val();
	var persistPlanoVirtua = $('#planonet option:selected').val();

	var planosVirtua = '<option value=""></option>';

	if (perfil=='COLETIVO'){

		planosVirtua += '<option value="10 MB">10 MB</option>\
						<option value="30 MB">30 MB</option>\
						<option value="60 MB">60 MB</option>\
						<option value="100 MB">100 MB</option>';

	} else {

		planosVirtua += '<option value="10 MB">10 MB</option>\
						<option value="30 MB">30 MB</option>\
						<option value="60 MB">60 MB</option>\
						<option value="120 MB">120 MB</option>';
	
	}
	
	$('#planonet').html(planosVirtua);
	$('#planonet').val(persistPlanoVirtua);
	
}

function atualizaPlanosFone(){
	
	var perfil = $('#perfil option:selected').val();
	var tipoContrato = $('#tipocontrato option:selected').val();
	var portabilidade = $('#portabilidade option:selected').val();
	var persistPlanoFone = $('#planofone option:selected').val();

	var optsPlanosFone = '<option value=""></option>';	

	if (tipoContrato == 'PME') {
		
		
		optsPlanosFone += '<option value="ECONÔMICO 2 LINHAS" data-valor-plano="63,56">ECONÔMICO 2 LINHAS</option>';
		
		if (perfil != 'SINGLE'){
			
			optsPlanosFone += '<option value="ECONÔMICO 4 LINHAS" data-valor-plano="130,00">ECONÔMICO 4 LINHAS</option>\
						<option value="ECONÔMICO 8 LINHAS" data-valor-plano="250,00">ECONÔMICO 8 LINHAS</option>';
		}

		if ( portabilidade == 'SIM' ){
			
			optsPlanosFone += '<option value="FALE FIXO ILIMITADO 2 LINHAS" data-valor-plano="90,00">FALE FIXO ILIMITADO 2 LINHAS</option>';

			if (perfil != 'SINGLE'){
				
				optsPlanosFone += '<option value="FALE FIXO ILIMITADO 4 LINHAS" data-valor-plano="200,00">FALE FIXO ILIMITADO 4 LINHAS</option>';
				optsPlanosFone += '<option value="FALE FIXO ILIMITADO 8 LINHAS" data-valor-plano="410,00">FALE FIXO ILIMITADO 8 LINHAS</option>';
			
			}
		
		} else {

			optsPlanosFone += '<option value="FALE FIXO ILIMITADO 2 LINHAS" data-valor-plano="120,00">FALE FIXO ILIMITADO 2 LINHAS</option>';

			if (perfil != 'SINGLE'){
				
				optsPlanosFone += '<option value="FALE FIXO ILIMITADO 4 LINHAS" data-valor-plano="260,00">FALE FIXO ILIMITADO 4 LINHAS</option>';
			
			}			
		}
		
	} else {

		if ( perfil == 'COMBO MULTI' ){
			

			optsPlanosFone += '<option value="MULTI CLARO LOCAL" data-valor-plano="29,90">MULTI CLARO LOCAL</option>\
							<option value="MULTI CLARO BRASIL 21" data-valor-plano="49,90">MULTI CLARO BRASIL 21</option>\
							<option value="MULTI CLARO MUNDO 21" data-valor-plano="69,90">MULTI CLARO MUNDO 21</option>';

		} else {
			
			var portabilidade = $('#portabilidade option:selected').val();
									
			if ( portabilidade == 'SIM' ){
						
				optsPlanosFone += '<option value="FALE DO SEU JEITO">FALE DO SEU JEITO</option>';
			}

			optsPlanosFone += '<option value="FALE ILIMITADO">FALE ILIMITADO</option>\
										<option value="FALE ESSENCIAL">FALE ESSENCIAL</option>\
										<option value="FALE SIMPLES">FALE SIMPLES</option>';
		}
	}
	
	$('#planofone').html(optsPlanosFone).val(persistPlanoFone);	

}

function atualizaTaxasAdesao(){
	
	var perfil = $('#perfil option:selected').val();
	var produtos = $("#netProdutos option:selected").val();

	var tipoContrato = $('#tipocontrato option:selected').val();

	var strFone = 'FONE';
	var strNet = 'VIRTUA';
	var strTV = 'TV';
	
	if( perfil == 'SINGLE' ){
		

		if( produtos.search(strFone) > 0 ){
			
			$("#planofone option").each( function() {
				
				if( $(this).val() != '' ) {
					
					if (tipoContrato == 'PME'){
						
						$(this).attr('data-valor-instalacao', '600,00');
					
					}else{
						
						$(this).attr('data-valor-instalacao', '300,00');
					}
				}
				
			});
			
		} else if ( produtos.search(strNet) > 0 ) {

			var fidelidade = $('#planotv-fidelidade option:selected').val();

			$("#planonet option").each( function() {
				
				if( $(this).val() != '' ) {
					
					if ( tipoContrato == 'PME' ){
						
						if (fidelidade == '12 MESES') {
							
							$(this).attr('data-valor-adesao', '150,00');
							
						} else if (fidelidade == 'SEM FIDELIDADE'){
							
							$(this).attr('data-valor-adesao', '250,00');

						}
						
					
					} else {

						if (fidelidade == '12 MESES') {
							
							$(this).attr('data-valor-adesao', '00,00 (Grátis)');
							
						} else if (fidelidade == 'SEM FIDELIDADE' ){
							
							$(this).attr('data-valor-adesao', '249,00');

						}
					}
				}
			});
			
		} else if ( produtos.search(strTV) > 0 ) {

			var fidelidade = $('#planotv-fidelidade option:selected').val();
			
			$("#planotv option").each( function() {
				
				if( $(this).val() != '' ) {
					
					if ( tipoContrato == 'PME' ){
						
						if (fidelidade == '12 MESES') {
							
							$(this).attr('data-valor-instalacao', '150,00');
							
						} else if (fidelidade == 'SEM FIDELIDADE' ){
							
							$(this).attr('data-valor-instalacao', '250,00');

						}
						
					
					} else {

						if (fidelidade == '12 MESES') {
							
							$(this).attr('data-valor-instalacao', '00,00 (Grátis)');
							
						} else if (fidelidade == 'SEM FIDELIDADE' ){
							
							$(this).attr('data-valor-instalacao', '249,00');

						}
					}
				}
				
			});
			
		}


	} else if ( perfil == 'DOUBLO' ){

		if ( produtos.search(strNet) > 0 ) {
			
			$("#planonet option").each( function() {
				
				if( $(this).val() != '' ) {
					
					if ( tipoContrato == 'PME' ){

						$(this).attr('data-valor-adesao', '150,00');

					}
				}
				
			});
			
		}
	}
	
}

function atualizaCampos(me) {
	
	var perfil = $('#perfil option:selected').val();
	var tipocontrato = $('#tipocontrato option:selected').val();
	var pagamento = $('#pagamento option:selected').val();

	if( pagamento == 'BOLETO' ) {
		
		if( tipocontrato == 'PME' ) {
			
			$('#infoPagamento').text('Acréscimo de R$ 5,00 na mensalidade em BOLETO.');

			$("#pessoa1").css('display', '');
			$("#pessoa1+label").css('display', '');
			
			$("#pessoa2").css('display', '');
			$("#pessoa2+label").css('display', '');
			
			
		
		} else {

			$("#pessoa1").css('display', '');
			$("#pessoa1+label").css('display', '');
			
			$("#pessoa2").css('display', 'none');
			$("#pessoa2+label").css('display', 'none');
			
			$("#pessoa1").attr('checked', 'checked');
			$("#pessoa1").trigger('change');
			
			if( perfil == 'SINGLE' || perfil == 'DOUBLO' ) {
				
				$('#infoPagamento').text('Acréscimo de R$ 4,00 na mensalidade em BOLETO.');
				
			} else if ( perfil == 'COMBO' || perfil == 'COMBO MULTI' ) {
				
				$('#infoPagamento').text('Acréscimo de R$ 10,00 na mensalidade em BOLETO.');
				
			} else {
				
				$('#infoPagamento').text('');
			}
			
		}
		
	} else {
		
		$('#infoPagamento').text('');
		
	}
	
	if ( tipocontrato == 'PME' ) {
		
		$("#perfil option[value='COMBO MULTI']").remove();
		$("#perfil option[value='COLETIVO']").remove();

	} else {

		if ( $("#perfil option[value='COMBO MULTI']").length <= 0 ) {
			
			$('<option value="COMBO MULTI">COMBO MULTI</option>').insertAfter("#perfil option[value='COMBO']");
			$('<option value="COLETIVO">COLETIVO</option>').insertAfter("#perfil option[value='SINGLE']");
		}
		
	}

	/*var planosFone = '<option value=""></option>\
					<option value="FALE DO SEU JEITO">FALE DO SEU JEITO</option>\
					<option value="FALE ILIMITADO">FALE ILIMITADO</option>\
					<option value="FALE ESSENCIAL">FALE ESSENCIAL</option>';*/
	
	if( perfil == 'COMBO'){

		$('#netProdutos').html('<option value="NET FONE + NET TV + VIRTUA">NET FONE + TV + VIRTUA</option>');

		$("#tr-planotv").css('display', 'table-row');
		$("#tr-planofone").css('display', 'table-row');
		$("#tr-planonet").css('display', 'table-row');
		$("#tr-portabilidade").css('display', 'table-row');
		$("#tr-operadoraportada").css('display', 'table-row');
		$("#tr-numeroportado").css('display', 'table-row');
		$("#tr-operadoraportadamovel").css('display', 'table-row');
		$("#tr-numeroportadomovel").css('display', 'table-row');

	} else if ( perfil=='DOUBLO' || perfil == 'SINGLE' || perfil == 'COLETIVO' || perfil == 'COMBO MULTI'){
		$('#tr-produtos').css('display', 'table-row');
		
		var	optProdutos = '<option value=""></option>';
		var persistProdutos = $('#netProdutos option:selected').val();

		if( perfil == 'DOUBLO' ){
			
			if (tipocontrato == 'PME' ){
				
				$('#tr-planotv-fidelidade').css('display', 'table-row');
			
			} else {
				
				$('#tr-planotv-fidelidade').css('display', 'none');
			}
			
			optProdutos += '<option value="NET FONE + NET TV">NET FONE + TV</option>\
						<option value="NET FONE + VIRTUA">NET FONE + VIRTUA</option>\
						<option value="NET TV + VIRTUA">NET TV + VIRTUA</option>';

		} else if( perfil == 'SINGLE' ){

			var prod =  $('#netProdutos option:selected').val();

			if (tipocontrato == 'PME' ){
				
				$('#tr-planotv-fidelidade').css('display', 'table-row');
			
			} else {
				
				$('#tr-planotv-fidelidade').css('display', 'none');
			}

			
			if (prod.search('TV') > 0) {

				var persistFidelidade = $('#planotv-fidelidade').val();
				
				$('#tr-planotv-fidelidade').css('display', 'table-row');
				
				$('#planotv-fidelidade').html('<option value=""></option>\
												<option value="SEM FIDELIDADE">SEM FIDELIDADE</option>\
												<option value="12 MESES">12 MESES</option>');
				
				$('#planotv-fidelidade').val(persistFidelidade);
			}
			
			optProdutos += '<option value="NET FONE">NET FONE</option>\
							<option value="NET TV">NET TV</option>\
							<option value="NET VIRTUA">NET VIRTUA</option>';
		
		} else if( perfil == 'COLETIVO' ){

			var persistFidelidade = $('#planotv-fidelidade').val();
			var prod =  $('#netProdutos option:selected').val();
			
			if (prod.search('TV') > 0) {

				$('#tr-planotv-fidelidade').css('display', 'table-row');
				
				$('#planotv-fidelidade').html('<option value="12 MESES">12 MESES</option>');
				$('#planotv-fidelidade').val(persistFidelidade);
			}
			
			optProdutos = '<option value="NET TV + VIRTUA">NET TV + VIRTUA</option>';

		} else if (perfil == 'COMBO MULTI'){

			optProdutos += '<option value="NET FONE + CELULAR + NET TV + VIRTUA">NET FONE + CELULAR + TV + VIRTUA</option>\
						<option value="NET FONE + CELULAR + VIRTUA">NET FONE + CELULAR + VIRTUA</option>\
						<option value="NET FONE + CELULAR + NET TV">NET FONE + CELULAR + TV</option>';
		}

		$('#netProdutos').html(optProdutos);
		$('#netProdutos').val(persistProdutos);
		
		produtos = $('#netProdutos option:selected').val();

		var strFone = 'FONE';
		var strNet = 'VIRTUA';
		var strTV = 'TV';
		var strCelular = 'CELULAR';

		if( produtos.search(strFone) > 0 ){
			
			$("#tr-planofone").css('display', 'table-row');
			$("#tr-portabilidade").css('display', 'table-row');
			$("#tr-operadoraportada").css('display', 'table-row');
			$("#tr-numeroportado").css('display', 'table-row');
			$("#tr-operadoraportadamovel").css('display', 'table-row');
			$("#tr-numeroportadomovel").css('display', 'table-row');


			
		} else {
			
			$("#tr-planofone").css('display', 'none');
			$('#planofone').val('');

			$("#tr-portabilidade").css('display', 'none');
			$('#portabilidade').val('');
			$("#operadoraportada").val('');
			$("#numeroportado").val('');
			$("#tr-operadoraportadamovel").val('');
			$("#tr-numeroportadomovel").val('');

			
		}

		if( produtos.search(strCelular) > 0 ){
			
			$("#tr-planocelular").css('display', 'table-row');
		} else {
			
			$("#tr-planocelular").css('display', 'none');	
			$('#planocelular').val('');
		}

		if( produtos.search(strNet) > 0 ){
			
			$("#tr-planonet").css('display', 'table-row');
		} else {
			
			$("#tr-planonet").css('display', 'none');	
			$('#planonet').val('');
		}

		if( produtos.search(strTV) > 0 ){
			
			$("#tr-planotv").css('display', 'table-row');
			$("#tr-pontos-adicionais").css('display', 'table-row');
			$("#tr-label-pontos-adicionais").css('display', 'table-row');
			$("#tr-agregados").css('display', 'table-row');
		} else {
			
			$("#tr-planotv").css('display', 'none');
			$('#planotv').val('');

			$("#tr-pontos-adicionais").css('display', 'none');
			$("#tr-label-pontos-adicionais").css('display', 'none');
			
			$("#tr-agregados").css('display', 'none');
			$('#agregados').val('');
		}

	
	} else {

		

		$("#tr-planotv").css('display', 'none');
		$("#tr-planofone").css('display', 'none');
		$("#tr-planonet").css('display', 'none');
		
		
	}
	
	/*var persistPlanoFone = $('#planofone option:selected').val();
	var optsPlanosFone = '<option value=""></option>';	

	if ( perfil == 'COMBO MULTI' ){
		

		optsPlanosFone += '<option value="MULTI CLARO LOCAL" data-valor-plano="29,90">MULTI CLARO LOCAL</option>\
						<option value="MULTI CLARO BRASIL 21" data-valor-plano="49,90">MULTI CLARO BRASIL 21</option>\
						<option value="MULTI CLARO MUNDO 21" data-valor-plano="69,90">MULTI CLARO MUNDO 21</option>';

	} else {
		
		var portabilidade = $('#portabilidade option:selected').val();
								
		if ( portabilidade == 'SIM' ){
					
			optsPlanosFone += '<option value="FALE DO SEU JEITO">FALE DO SEU JEITO</option>';
		}

		optsPlanosFone += '<option value="FALE ILIMITADO">FALE ILIMITADO</option>\
									<option value="FALE ESSENCIAL">FALE ESSENCIAL</option>';
	}
			
	$('#planofone').html(optsPlanosFone).val(persistPlanoFone);*/

	
	var portabilidade = $('#portabilidade option:selected').val();
								
	if ( portabilidade == 'SIM' ){

		$("#tr-operadoraportada").css('display', 'table-row');
		$("#tr-numeroportado").css('display', 'table-row');
		$("#tr-operadoraportadamovel").css('display', 'table-row');
		$("#tr-numeroportadomovel").css('display', 'table-row');


	}else{

		$("#tr-operadoraportada").css('display', 'none');
		$("#tr-numeroportado").css('display', 'none');
		$("#tr-operadoraportadamovel").css('display', 'none');
		$("#tr-numeroportadomovel").css('display', 'none');

		$("#operadoraportada").val('');
		$("#numeroportado").val('');
		$("#tr-operadoraportadamovel").val('');
		$("#tr-numeroportadomovel").val('');


	}
	
	atualizaPlanosTv();
	atualizaPlanosVirtua();
	atualizaPlanosFone();
	
	atualizaTaxasAdesao();
	
	if( perfil != 'SINGLE' ){
		 
		 $(".infobox").css('display', 'none');
	}
}


$(document).ready( function() {

	atualizaCampos($(this));

	$('#perfil, #netProdutos, #portabilidade, #tipocontrato, #pagamento').bind('change', function(){

		atualizaCampos($(this));

	});
	
	$('#planotv').bind('change', function(){
		
		var planoGrupo = $('option:selected', this).attr('data-grupo');

		if ( $('#planotv option:selected').attr('data-grupo') == 'GP1' ){
			
			$('.label-pontos-adicionais').html('Pontos adiconais por R$60,00.');
			
		} else if ( $('#planotv option:selected').attr('data-grupo') == 'GP2' || $('#planotv option:selected').attr('data-grupo') == 'GP3' ){
			
			$('.label-pontos-adicionais').html('1 ponto adicional grátis. Demais pontos R$24,90 por 12 meses após R$29,90.');
			
		} else {
			
			$('.label-pontos-adicionais').html('');
		}
		
		if (typeof planoGrupo === typeof undefined){

			$('#grupo').val('');

		} else {
			
			$('#grupo').val(planoGrupo);
		}

		
	});
});
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

<td><b>Nome da Mãe:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="nomemae" size="40" value="<?= $linha['nome_mae']; ?>" />

<? } else { ?>



<?= ucwords($linha['nome_mae']); ?>

<input type="hidden" name="nomemae" size="40" value="<?= $linha['nome_mae']; ?>" />



</td>



<? } ?>

</td>

</tr>

<tr>

<td><b>Nome do Pai:</b></td>

<td>

<? if($editar == '1') {?>

<input type="text" name="nomepai" size="40" value="<?= $linha['nome_pai']; ?>" />

<? } else { ?>



<?= ucwords($linha['nome_pai']); ?>

<input type="hidden" name="nomepai" size="40" value="<?= $linha['nome_pai']; ?>" />


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

<input type="text" name="icpf" size="40" onKeyPress="mascara(this,<?php echo ($linha['pessoa'] == 'Pessoa Jurídica') ? "cnpj" : "cpf"; ?>)" maxlength="<?php echo ($linha['pessoa'] == 'Pessoa Jurídica') ? "18" : "14"; ?>" value="<?= $linha['cpf']; ?>" />

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



$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE grupo LIKE '%0010%' && tipo_usuario = 'MONITOR' ORDER BY nome ASC");

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



$conOPERADORES = $conexao->query("SELECT * FROM operadores WHERE grupo LIKE '%0010%' && status != 'DESLIGADO' ORDER BY nome ASC");

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

<tr id="tr-periodo">

<td><b>Período Instalação:</b></td>
<? if($editar == '1') {?>
<td>


<select name="periodo-instalacao" id="periodo-instalacao">

	<option value="MANHÃ" <? if($linha['netPeriodo'] == 'MANHÃ'){?>selected="selected"<? } ?>>Manhã</option>
    <option value="TARDE" <? if($linha['netPeriodo'] == 'TARDE'){?>selected="selected"<? } ?>>Tarde</option>
</select>


</td>
<? } else { ?>
<td>
<?php echo $linha['netPeriodo']; ?>
</td>
<? } ?>
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
<img src="img/play-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Ouvir Gravação" onClick="javascript:window.location = 'http://172.16.0.30/audio/net/orig/<?= $gravacaoRE;?>'" /> <span style="font-size:13px;">Ouvir Gravação </span>
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



<img src="img/record.png" width="20" align="absmiddle" style="cursor:pointer" title="Inserir Gravação" onClick="window.location = 'upload-gravacao-simples-net.php?id=<?= $linha['id'];?>&u=<?= $USUARIO['id'];?>'" /> <span style="font-size:13px;">Inserir Gravação </span>



<? } else if($linha['gravacao'] != '') {?>



<img src="img/play-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Ouvir Gravação" onClick="javascript:window.location = 'http://172.16.0.30/audio/net/orig/<?= $linha['gravacao'];?>'" /> <span style="font-size:13px;">Ouvir Gravação </span>
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
include "includes/observacoes-net.php";
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

<!--

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

-->

<tr>

<td><b>Tipo de Serviço:</b></td>

<td>



<? if($editar == '1') {?>



<select name="tiposervico">

<option value=""></option>

<option value="Adesão" <? if($linha['netTipoServico'] == 'Adesão'){?>selected="selected"<? } ?>>Adesão</option>
<option value="VT" <? if($linha['netTipoServico'] == 'VT'){?>selected="selected"<? } ?>>VT</option>
<option value="Revisita" <? if($linha['netTipoServico'] == 'Revisita'){?>selected="selected"<? } ?>>Revisita</option>
<option value="Garantia" <? if($linha['netTipoServico'] == 'Garantia'){?>selected="selected"<? } ?>>Garantia</option>
<option value="Mudança de Tecnologia" <? if($linha['netTipoServico'] == 'Mudança de Tecnologia'){?>selected="selected"<? } ?>>Mudança de Tecnologia</option>
<option value="Mudança de Endereço" <? if($linha['netTipoServico'] == 'Mudança de Endereço'){?>selected="selected"<? } ?>>Mudança de Endereço</option>
<option value="Desconexão" <? if($linha['netTipoServico'] == 'Desconexão'){?>selected="selected"<? } ?>>Desconexão</option>


</select>

<? } else { ?>



<?= $linha['netTipoServico']; ?>

<input type="hidden" name="tiposervico" value="<?= $linha['netTipoServico'];?>" />



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


<tr>

<td><b>Técnico:</b></td>

<td>

<? if($editar_instalacao == '1') { ?>



<select name="tecnico">   

<option value=""></option>    

<?    

$conTEC = $conexao->query("SELECT * FROM tecnicosnet WHERE status='ATIVO' ORDER BY nome ASC");

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

<?php
/*
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
include "includes/observacoes-net.php";
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
<td><b>Filial:</b></td>
<? if($editar == '1') {?>
<td>

<select name="filial" id="filial">

<option value=""></option>
<option value="NOVA IGUAÇU" <? if($linha['netFilial'] == 'NOVA IGUAÇU') { ?> selected="selected" <? } ?>>NOVA IGUAÇU</option>
<option value="RIO DAS OSTRAS" <? if($linha['netFilial'] == 'RIO DAS OSTRAS') { ?> selected="selected" <? } ?>>RIO DAS OSTRAS</option>

</select>

</td>
<? } else {?>
<td><?php echo $linha['netFilial'];?></td>
<? } ?>
</tr>

<tr align="left">
<td><b>Tipo Contrato:</b></td>
<? if($editar == '1') {?>
<td>

<select name="tipocontrato" id="tipocontrato">

<option value=""></option>
<option value="INCLUSÃO" <? if($linha['netTipoContrato'] == 'INCLUSÃO') { ?> selected="selected" <? } ?>>INCLUSÃO</option>
<option value="PME" <? if($linha['netTipoContrato'] == 'PME') { ?> selected="selected" <? } ?>>PME</option>
<option value="VENDA" <? if($linha['netTipoContrato'] == 'VENDA') { ?> selected="selected" <? } ?>>VENDA</option>
<!-- 
<option value="COLETIVO" <? if($linha['netTipoContrato'] == 'COLETIVO') { ?> selected="selected" <? } ?>>COLETIVO</option>
-->
</select>

</td>
<? } else {?>
<td><?php echo $linha['netTipoContrato'];?></td>
<? } ?>
</tr>

<tr align="left">
<td><b>Perfil:</b></td>
<? if($editar == '1') {?>
<td>

<select name="perfil" id="perfil">

<option value=""></option>
<option value="COMBO" <? if($linha['netPerfil'] == 'COMBO') { ?> selected="selected" <? } ?>>COMBO</option>
<option value="COMBO MULTI" <? if($linha['netPerfil'] == 'COMBO MULTI') { ?> selected="selected" <? } ?>>COMBO MULTI</option>
<option value="DOUBLO" <? if($linha['netPerfil'] == 'DOUBLO') { ?> selected="selected" <? } ?>>DOUBLO</option>
<option value="SINGLE" <? if($linha['netPerfil'] == 'SINGLE') { ?> selected="selected" <? } ?>>SINGLE</option>
<option value="COLETIVO" <? if($linha['netPerfil'] == 'COLETIVO') { ?> selected="selected" <? } ?>>COLETIVO</option>
</select>

</td>
<? } else {?>
<td>
	<select name="perfil" id="perfil" style="display:none;">
		<option value="<?php echo $linha['netPerfil'];?>"><?php echo $linha['netPerfil'];?></option>
	</select>
	<?php echo $linha['netPerfil'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-produtos">
<td><b>Produtos</b></td>
<? if($editar == '1') {?>
<td>

<select name="netProdutos" id="netProdutos">

<option value=""></option>
<option value="NET FONE" <? if($linha['comboServicos'] == 'NET FONE') { ?> selected="selected" <? } ?>>NET FONE</option>
<option value="NET TV" <? if($linha['comboServicos'] == 'NET TV') { ?> selected="selected" <? } ?>>NET TV</option>
<option value="NET VIRTUA" <? if($linha['comboServicos'] == 'NET VIRTUA') { ?> selected="selected" <? } ?>>NET VIRTUA</option>
<option value="NET FONE + NET TV" <? if($linha['comboServicos'] == 'NET FONE + NET TV') { ?> selected="selected" <? } ?>>NET FONE + TV</option>
<option value="NET FONE + VIRTUA" <? if($linha['comboServicos'] == 'NET FONE + VIRTUA') { ?> selected="selected" <? } ?>>NET FONE + VIRTUA</option>
<option value="NET TV + VIRTUA" <? if($linha['comboServicos'] == 'NET TV + VIRTUA') { ?> selected="selected" <? } ?>>NET TV + VIRTUA</option>
<option value="NET FONE + NET TV + VIRTUA" <? if($linha['comboServicos'] == 'NET FONE + NET TV + VIRTUA') { ?> selected="selected" <? } ?>>NET FONE + TV + VIRTUA</option>
<option value="NET FONE + CELULAR + NET TV + VIRTUA" <? if($linha['comboServicos'] == 'NET FONE + CELULAR + NET TV + VIRTUA') { ?> selected="selected" <? } ?>>NET FONE + CELULAR + TV + VIRTUA</option>
<option value="NET FONE + CELULAR + VIRTUA" <? if($linha['comboServicos'] == 'NET FONE + CELULAR + VIRTUA') { ?> selected="selected" <? } ?>>NET FONE + CELULAR + VIRTUA</option>
<option value="NET FONE + CELULAR + NET TV" <? if($linha['comboServicos'] == 'NET FONE + CELULAR + NET TV') { ?> selected="selected" <? } ?>>NET FONE + CELULAR + TV</option>

</select>

</td>
<? } else {?>
<td><?php echo $linha['comboServicos'];?></td>
<? } ?>
</tr>


<tr align="left" id="tr-portabilidade" <?php if ( ! strstr($linha['comboServicos'], 'FONE') ){ ?> style="display:none;" <?php } ?>>
<td><b>Portabilidade:</b></td>
<? if($editar == '1') {?>
<td>

<select name="portabilidade" id="portabilidade">

<option value=""></option>

<option value="SIM" <? if($linha['comboPortabilidade'] == 'SIM') { ?> selected="selected" <? } ?>>Sim</option>
<option value="NAO" <? if($linha['comboPortabilidade'] == 'NAO') { ?> selected="selected" <? } ?>>Não</option>

</select>

</td>
<? } else {?>
<td>
	<select style="display:none; background-color:#FFF;" name="portabilidade" id="portabilidade">
	<option value="<?php echo $linha['comboPortabilidade']; ?>" selected="selected"><?php echo $linha['comboPortabilidade']; ?></option>
	</select>

	<?php echo $linha['comboPortabilidade']; ?></td>
<? } ?>
</tr>

<tr align="left" id="tr-operadoraportada" style="display:none">
<td><b>Operadora:</b></td>
<? if($editar == '1') {?>
<td>
	<select name="operadoraportada" id="operadoraportada">

		<option value=""></option>
		<option value="CLARO" <? if($linha['netOperadoraPortada'] == 'CLARO') { ?> selected="selected" <? } ?>>CLARO</option>
		<option value="VIVO" <? if($linha['netOperadoraPortada'] == 'VIVO') { ?> selected="selected" <? } ?>>VIVO</option>
		<option value="TIM" <? if($linha['netOperadoraPortada'] == 'TIM') { ?> selected="selected" <? } ?>>TIM</option>
		<option value="OI" <? if($linha['netOperadoraPortada'] == 'OI') { ?> selected="selected" <? } ?>>OI</option>

	</select>

</td>
<? } else {?>
<td><?php echo $linha['netOperadoraPortada'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-numeroportado" style="display:none">
<td><b>Número Portado:</b></td>
<? if($editar == '1') {?>
<td>
<input type="text" name="numeroportado" value="<?php echo $linha['comboNumeroPortado'];?>" onKeyPress="mascara(this,telefone)" maxlength="15" size="20">
</td>
<? } else {?>
<td><?php echo $linha['comboNumeroPortado'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-operadoraportadamovel" style="display:none">
<td><b>Operadora:</b></td>
<? if($editar == '1') {?>
<td>
	<select name="operadoraportadamovel" id="operadoraportadamovel">

		<option value=""></option>
		<option value="CLARO" <? if($linha['netPortabilidadeMovel'] == 'CLARO') { ?> selected="selected" <? } ?>>CLARO</option>
		<option value="VIVO" <? if($linha['netPortabilidadeMovel'] == 'VIVO') { ?> selected="selected" <? } ?>>VIVO</option>
		<option value="TIM" <? if($linha['netPortabilidadeMovel'] == 'TIM') { ?> selected="selected" <? } ?>>TIM</option>
		<option value="OI" <? if($linha['netPortabilidadeMovel'] == 'OI') { ?> selected="selected" <? } ?>>OI</option>

	</select>

</td>
<? } else {?>
<td><?php echo $linha['netPortabilidadeMovel'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-numeroportadomovel" style="display:none">
<td><b>Número Portado:</b></td>
<? if($editar == '1') {?>
<td>
<input type="text" name="numeroportadomovel" value="<?php echo $linha['netNumeroPortadoMovel'];?>" onKeyPress="mascara(this,telefone)" maxlength="15" size="20">
</td>
<? } else {?>
<td><?php echo $linha['netNumeroPortadoMovel'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-planotv" <?php if ( ! strstr($linha['comboServicos'], 'TV') ){ ?> style="display:none;" <?php } ?>>
<td><b>Plano tv:</b></td>
<? if($editar == '1') {?>
<td>

<select name="planotv" id="planotv">

<option value=""></option>
<option value="NET Top HD Max Cinema Fut" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Max Cinema Fut') { ?> selected="selected" <? } ?>>NET TOP</option>
<option value="NET Top HD Max HBO Futebol" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Max HBO Futebol') { ?> selected="selected" <? } ?>>NET Top HD Max HBO Futebol</option>
<option value="NET Top HD Max Cinema" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Max Cinema') { ?> selected="selected" <? } ?>>NET Top HD Max Cinema</option>
<option value="NET Top HD Max Futebol" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Max Futebol') { ?> selected="selected" <? } ?>>NET Top HD Max Futebol</option>
<option value="NET Top HD Max Telecine" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Max Telecine') { ?> selected="selected" <? } ?>>NET Top HD Max Telecine</option>
<option value="NET Top HD Max HBO" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Max HBO') { ?> selected="selected" <? } ?>>NET Top HD Max HBO</option>
<option value="NET Top HD Max" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Max') { ?> selected="selected" <? } ?>>NET Top HD Max</option>
<option value="NET Top HD Cinema Futebol" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Cinema Futebol') { ?> selected="selected" <? } ?>>NET Top HD Cinema Futebol</option>
<option value="NET Top HD Telecine Futebol" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Telecine Futebol') { ?> selected="selected" <? } ?>>NET Top HD Telecine Futebol</option>
<option value="NET Top HD HBO Futebol" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD HBO Futebol') { ?> selected="selected" <? } ?>>NET Top HD HBO Futebol</option>
<option value="NET Top HD Cinema" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Cinema') { ?> selected="selected" <? } ?>>NET Top HD Cinema</option>
<option value="NET Top HD Futebol" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Futebol') { ?> selected="selected" <? } ?>>NET Top HD Futebol</option>
<option value="NET Top HD Telecine" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD Telecine') { ?> selected="selected" <? } ?>>NET Top HD Telecine</option>
<option value="NET Top HD HBO" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD HBO') { ?> selected="selected" <? } ?>>NET Top HD HBO</option>
<option value="NET Top HD" data-grupo="GP3" <? if($linha['plano'] == 'NET Top HD') { ?> selected="selected" <? } ?>>NET Top HD</option>
<option value="NET Mais HD Cinema Futebol" data-grupo="GP2" <? if($linha['plano'] == 'NET Mais HD Cinema Futebol') { ?> selected="selected" <? } ?>>NET Mais HD Cinema Futebol</option>
<option value="NET Mais HD Telecine Futebol" data-grupo="GP2" <? if($linha['plano'] == 'NET Mais HD Telecine Futebol') { ?> selected="selected" <? } ?>>NET Mais HD Telecine Futebol</option>
<option value="NET Mais HD HBO Futebol" data-grupo="GP2" <? if($linha['plano'] == 'NET Mais HD HBO Futebol') { ?> selected="selected" <? } ?>>NET Mais HD HBO Futebol</option>
<option value="NET Mais HD Cinema" data-grupo="GP2" <? if($linha['plano'] == 'NET Mais HD Cinema') { ?> selected="selected" <? } ?>>NET Mais HD Cinema</option>
<option value="NET Mais HD Futebol" data-grupo="GP2" <? if($linha['plano'] == 'NET Mais HD Futebol') { ?> selected="selected" <? } ?>>NET Mais HD Futebol</option>
<option value="NET Mais HD Telecine" data-grupo="GP2" <? if($linha['plano'] == 'NET Mais HD Telecine') { ?> selected="selected" <? } ?>>NET Mais HD Telecine</option>
<option value="NET Mais HD HBO" data-grupo="GP2" <? if($linha['plano'] == 'NET Mais HD HBO') { ?> selected="selected" <? } ?>>NET Mais HD HBO</option>
<option value="NET Mais HD" data-grupo="GP2" <? if($linha['plano'] == 'NET Mais HD') { ?> selected="selected" <? } ?>>NET Mais HD</option>
<option value="NET Essencial HD Cinema Futebol" data-grupo="GP2" <? if($linha['plano'] == 'NET Essencial HD Cinema Futebol') { ?> selected="selected" <? } ?>>NET Essencial HD Cinema Futebol</option>
<option value="NET Essencial HD Telecine Futebol" data-grupo="GP2" <? if($linha['plano'] == 'NET Essencial HD Telecine Futebol') { ?> selected="selected" <? } ?>>NET Essencial HD Telecine Futebol</option>
<option value="NET Essencial HD HBO Futebol" data-grupo="GP2" <? if($linha['plano'] == 'NET Essencial HD HBO Futebol') { ?> selected="selected" <? } ?>>NET Essencial HD HBO Futebol</option>
<option value="NET Essencial HD Futebol" data-grupo="GP2" <? if($linha['plano'] == 'NET Essencial HD Futebol') { ?> selected="selected" <? } ?>>NET Essencial HD Futebol</option>
<option value="NET Essencial HD Cinema" data-grupo="GP2" <? if($linha['plano'] == 'NET Essencial HD Cinema') { ?> selected="selected" <? } ?>>NET Essencial HD Cinema</option>
<option value="NET Essencial HD Telecine" data-grupo="GP2" <? if($linha['plano'] == 'NET Essencial HD Telecine') { ?> selected="selected" <? } ?>>NET Essencial HD Telecine</option>
<option value="NET Essencial HD HBO" data-grupo="GP2" <? if($linha['plano'] == 'NET Essencial HD HBO') { ?> selected="selected" <? } ?>>NET Essencial HD HBO</option>
<option value="NET Essencial HD" data-grupo="GP2" <? if($linha['plano'] == 'NET Essencial HD') { ?> selected="selected" <? } ?>>NET Essencial HD</option>
<option value="NET Fácil HD Telecine Light" data-grupo="GP1" <? if($linha['plano'] == 'NET Fácil HD Telecine Light') { ?> selected="selected" <? } ?>>NET Fácil HD Telecine Light</option>
<option value="NET Fácil HD HBO Light" data-grupo="GP1" <? if($linha['plano'] == 'NET Fácil HD HBO Light') { ?> selected="selected" <? } ?>>NET Fácil HD HBO Light</option>
<option value="NET Fácil HD" data-grupo="GP1" <? if($linha['plano'] == 'NET Fácil HD') { ?> selected="selected" <? } ?>>NET Fácil HD</option>
<option value="NET Fácil Telecine Light" data-grupo="GP1" <? if($linha['plano'] == 'NET Fácil Telecine Light') { ?> selected="selected" <? } ?>>NET Fácil Telecine Light</option>
<option value="NET Fácil HBO Light" data-grupo="GP1" <? if($linha['plano'] == 'NET Fácil HBO Light') { ?> selected="selected" <? } ?>>NET Fácil HBO Light</option>
<option value="NET Fácil" data-grupo="GP1" <? if($linha['plano'] == 'NET Fácil') { ?> selected="selected" <? } ?>>NET Fácil</option>

</select>

</td>
<? } else {?>
<td><?php echo $linha['plano'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-grupo" <?php if( ! strstr($linha['comboServicos'], 'TV')) { echo "style=\"display:none;\""; } ?>>
<td><b>Grupo:</b></td>
<? if($editar == '1') {?>
<td>
<input type="text" name="grupo" id="grupo" value="<?=$linha['netGrupo']?>" readonly="readonly" />
</td>
<? } else {?>
<td><?php echo $linha['netGrupo'];?></td>
<? } ?>
</tr>

<tr align="left" style="display:none;" id="tr-label-pontos-adicionais">
<td></td>
<td class="label-pontos-adicionais"></td>
</tr>

<tr style="tr-pontos-adicionais">

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


<tr id="tr-planotv-fidelidade" style="display:none;">
<td><b>Fidelidade</b></td>
<? if($editar == '1') {?>
<td>
<select name="planotv-fidelidade" id="planotv-fidelidade">
	
	<option value=""></option>
	<option value="SEM FIDELIDADE">SEM FIDELIDADE</option>
	<option value="12 MESES">12 MESES</option>

</select>
</td>
<? } else {?>
<td><?php echo $linha['netFidelidade'];?></td>
<? } ?>
</tr>


<tr align="left" id="tr-planofone" <?php if ( ! strstr($linha['comboServicos'], 'FONE') ){ ?> style="display:none;" <?php } ?>>
<td><b>Plano Fone:</b></td>
<? if($editar == '1') {?>
<td>

<select name="planofone" id="planofone">

<option value=""></option>

<option value="<?=$linha['comboFonePlano']?>" selected="selected"><?=$linha['comboFonePlano']?></option>
</select>

</td>
<? } else {?>
<td><?php echo $linha['comboFonePlano'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-planocelular" <?php if ( ! strstr($linha['comboServicos'], 'CELULAR') ){ ?> style="display:none;" <?php } ?>>
<td><b>Plano Celular:</b></td>
<? if($editar == '1') {?>
<td>

<select name="planocelular" id="planocelular">

<option value=""></option>

<option value="MULTI 60" data-valor-plano="108,90" <? if($linha['netCelularPlano'] == 'MULTI 60') { ?> selected="selected" <? } ?>>MULTI 60</option>
<option value="MULTI 100" data-valor-plano="126,90" <? if($linha['netCelularPlano'] == 'MULTI 100') { ?> selected="selected" <? } ?>>MULTI 100</option>
<option value="MULTI 200" data-valor-plano="209,90" <? if($linha['netCelularPlano'] == 'MULTI 200') { ?> selected="selected" <? } ?>>MULTI 200</option>
<option value="MULTI 600" data-valor-plano="342,90" <? if($linha['netCelularPlano'] == 'MULTI 600') { ?> selected="selected" <? } ?>>MULTI 600</option>
<option value="MULTI 1200" data-valor-plano="525,90" <? if($linha['netCelularPlano'] == 'MULTI 1200') { ?> selected="selected" <? } ?>>MULTI 1200</option>

</select>

</td>
<? } else {?>
<td><?php echo $linha['netCelularPlano'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-planonet" <?php if ( ! strstr($linha['comboServicos'], 'VIRTUA') ){ ?> style="display:none;" <?php } ?>>
<td><b>Plano Virtua:</b></td>
<? if($editar == '1') {?>
<td>

<select name="planonet" id="planonet">

<option value=""></option>
<option value="10 MB" <? if($linha['comboInternetPlano'] == '10 MB') { ?> selected="selected" <? } ?>>10 MB</option>
<option value="30 MB" <? if($linha['comboInternetPlano'] == '30 MB') { ?> selected="selected" <? } ?>>30 MB</option>
<option value="60 MB" <? if($linha['comboInternetPlano'] == '60 MB') { ?> selected="selected" <? } ?>>60 MB</option>
<option value="120 MB" <? if($linha['comboInternetPlano'] == '120 MB') { ?> selected="selected" <? } ?>>120 MB</option>

</select>

</td>
<? } else {?>
<td><?php echo $linha['comboInternetPlano'];?></td>
<? } ?>
</tr>

<tr align="left" id="tr-agregados" <?php if ( ! strstr($linha['comboServicos'], 'TV') ){ ?> style="display:none;" <?php } ?>>
<td><b>Agregados:</b></td>
<? if($editar == '1') {?>
<td>

<select name="agregados" id="agregados">

<option value=""></option>
<option value="PREMIER FUTEBOL CLUBE" <? if($linha['netAgregados'] == 'PREMIER FUTEBOL CLUBE') { ?> selected="selected" <? } ?>>PREMIER FUTEBOL CLUBE</option>
<option value="1 CANAL ADULTO" <? if($linha['netAgregados'] == '1 CANAL ADULTO') { ?> selected="selected" <? } ?>>1 CANAL ADULTO</option>
<option value="1 CANAL ADULTO FOR MAN" <? if($linha['netAgregados'] == '1 CANAL ADULTO FOR MAN') { ?> selected="selected" <? } ?>>1 CANAL ADULTO FOR MAN</option>
<option value="2 CANAIS ADULTOS" <? if($linha['netAgregados'] == '2 CANAIS ADULTOS') { ?> selected="selected" <? } ?>>2 CANAIS ADULTOS</option>
<option value="5 CANAIS ADULTOS" <? if($linha['netAgregados'] == '5 CANAIS ADULTOS') { ?> selected="selected" <? } ?>>5 CANAIS ADULTOS</option>
<option value="6 CANAIS ADULTOS" <? if($linha['netAgregados'] == '6 CANAIS ADULTOS') { ?> selected="selected" <? } ?>>6 CANAIS ADULTOS</option>
<option value="COMBATE" <? if($linha['netAgregados'] == 'COMBATE') { ?> selected="selected" <? } ?>>COMBATE</option>
<option value="NOTÍCIAS" <? if($linha['netAgregados'] == 'NOTÍCIAS') { ?> selected="selected" <? } ?>>NOTÍCIAS</option>
<option value="ESPORTES" <? if($linha['netAgregados'] == 'ESPORTES') { ?> selected="selected" <? } ?>>ESPORTES</option>

</select>

</td>
<? } else {?>
<td><?php echo $linha['netAgregados'];?></td>
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

<tr>

<td><b>Forma de Pagamento:</b></td>

<td>


<? if($editar == '1') {?>

<select id="pagamento" name="pagamento"  onchange="verificapagamento(this.value, 'fpagamento');">

<option value="BOLETO" <? if($linha['pagamento'] == 'BOLETO'){?>selected="selected"<? } ?>>BOLETO</option>

<option value="DÉBITO" <? if($linha['pagamento'] == 'DÉBITO'){?>selected="selected"<? } ?>>DÉBITO</option>

<!-- <option value="CARTÃO DE CRÉDITO" <? if($linha['pagamento'] == 'CARTÃO DE CRÉDITO'){?>selected="selected"<? } ?>>CARTÃO DE CRÉDITO</option> -->

</select>
<span id="infoPagamento"></span>
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

<td><b>Dados da Conta:</b></td>

<td>

<? if($editar == '1') {?>

	Titular: <input type="text" id="titularconta" name="titularconta" size="20" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	CPF: <input type="text" id="titularcontacpf" name="titularcontacpf" onkeypress="mascara(this,cpf)" maxlength="14" size="20" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	<br />


Banco: <input type="text" id="banco" name="banco" size="20" value="<?= $linha['banco'];?>" /> <b>AG:</b> <input type="text" name="agencia" id="agencia" size="5" value="<?= $linha['agencia'];?>" /> <b>CC:</b> <input type="text" name="contacorrente" id="contacorrente" size="7" value="<?= $linha['conta_corrente'];?>" />

<? } else {?>

<?php

echo "<br><b>Titular:</b> " . $linha['titular_conta_deposito'];
echo "<br><b>CPF Titular:</b> " . $linha['cpf_titular_conta_deposito'] . "<br>";

?>

<?= '<b>Banco:</b> ' .  $linha['banco'].' <b>AG:</b> '.$linha['agencia'].' <b>CC:</b> '.$linha['conta_corrente'];?>

<input type="hidden" size="40" name="titularconta" value="<?= $linha['titular_conta_deposito']; ?>" />

<input type="hidden" size="40" name="titularcontacpf" value="<?= $linha['cpf_titular_conta_deposito']; ?>" />

<input type="hidden" size="40" name="banco" value="<?= $linha['banco']; ?>" />

<input type="hidden" size="40" name="agencia" value="<?= $linha['agencia']; ?>" />

<input type="hidden" size="40" name="contacorrente" value="<?= $linha['conta_corrente']; ?>" />

<? } ?>

 </td>

</tr>

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

<option value="CPF Reprovado" <? if($linha['motivo_cancelamento'] == 'CPF Reprovado'){?>selected="selected"<? } ?>>CPF Reprovado</option>
<option value="Endereço Inadimplente" <? if($linha['motivo_cancelamento'] == 'Endereço Inadimplente'){?>selected="selected"<? } ?>>Endereço Inadimplente</option>
<option value="Opção Cliente" <? if($linha['motivo_cancelamento'] == 'Opção Cliente'){?>selected="selected"<? } ?>>Opção Cliente</option>
<option value="Rua sem Cabeamento" <? if($linha['motivo_cancelamento'] == 'Rua sem Cabeamento'){?>selected="selected"<? } ?>>Rua sem Cabeamento</option>
<option value="Sem TAP" <? if($linha['motivo_cancelamento'] == 'Sem TAP'){?>selected="selected"<? } ?>>Sem TAP</option>
<option value="Tubulação Obstruída" <? if($linha['motivo_cancelamento'] == 'Tubulação Obstruída'){?>selected="selected"<? } ?>>Tubulação Obstruída</option>
<option value="CPF Suspenso" <? if($linha['motivo_cancelamento'] == 'CPF Suspenso'){?>selected="selected"<? } ?>>CPF Suspenso</option>
<option value="Prédio sem MDU" <? if($linha['motivo_cancelamento'] == 'Prédio sem MDU'){?>selected="selected"<? } ?>>Prédio sem MDU</option>
<option value="Fora do Padrão de Instalação" <? if($linha['motivo_cancelamento'] == 'Fora do Padrão de Instalação'){?>selected="selected"<? } ?>>Fora do Padrão de Instalação</option>
<option value="Mais de 70 M de Cabo" <? if($linha['motivo_cancelamento'] == 'Mais de 70 M de Cabo'){?>selected="selected"<? } ?>>Mais de 70 M de Cabo</option>
<option value="Rua ou Node não Liberado para Venda" <? if($linha['motivo_cancelamento'] == 'Rua ou Node não Liberado para Venda'){?>selected="selected"<? } ?>>Rua ou Node não Liberado para Venda</option>
<option value="Ausência de Sinal" <? if($linha['motivo_cancelamento'] == 'Ausência de Sinal'){?>selected="selected"<? } ?>>Ausência de Sinal</option>

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

<option value="Endereço em Análise" <? if($linha['motivo_analise'] == 'Endereço em Análise'){?>selected="selected"<? } ?>>Endereço em Análise</option>
<option value="Vistoria" <? if($linha['motivo_analise'] == 'Vistoria'){?>selected="selected"<? } ?>>Vistoria</option>
<option value="Na Infraestrutura" <? if($linha['motivo_analise'] == 'Na Infraestrutura'){?>selected="selected"<? } ?>>Na Infraestrutura</option>

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
