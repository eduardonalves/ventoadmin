<? include "conexao.php";
session_start();

// Verificar se est� logado
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

$os = $_POST['os'];
$esn = $_POST['esn'];
$novoNumero = $_POST['novonumero'];

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

// Endere�o Instala��o
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
$tipoLinha = $_POST['tipolinha'];
$tipoAssinatura = $_POST['tipoassinatura'];
$tipoPlano = $_POST['tipoplano'];
$plano = $_POST['plano'];
$Plano = $_POST['valorplano'];
$aparelho = $_POST['aparelho'];
$valorAparelho = $_POST['valoraparelho'];
$pagamento = $_POST['pagamento'];
$data0 = explode('/',$_POST['idata']);
$data = $data0[2].$data0[1].$data0[0];
$plano = $_POST['plano'];
$vencimento = $_POST['vencimento'];


// Agendamento grava��o


if($_POST['agendagravacao']){

$diaGravacao = explode('/',$_POST['agendagravacao']);

$agendGravacao = $diaGravacao[2].'-'.$diaGravacao[1].'-'.$diaGravacao[0].' '.$_POST['agendagravacaohora'].':'.$_POST['agendagravacaominutos'].':00';

} else {
	
$agendGravacao = $linha['agendagravacao'];
	
}

// Dados da Instala��o
$data_marcada0 = explode('/',$_POST['dataentrega']);
$data_entrega = $data_marcada0[2].$data_marcada0[1].$data_marcada0[0];

if($_POST['datainstalacao'] != ''){  $data_finalizada = explode('/',$_POST['datainstalacao']);
									  $data_finalizada = $data_finalizada[2].$data_finalizada[1].$data_finalizada[0];  } else {

if($linha['data_instalacao'] == '' && $_POST['status'] == 'FINALIZADA'){

$data_finalizada = date("Ymd");

} else if($_POST['status'] != 'FINALIZADA'){

$data_finalizada = '';	

}

else{

$data_finalizada = $linha['data_instalacao'];	

}}


// Motivos
$motivo_restricao = $_POST['motivorestricao'];
$motivo_cancelamento = $_POST['motivocancelamento'];
$motivo_devolvido = $_POST['motivodevolvido'];
$pendencia = $_POST['pendencia'];
$dataLiberacao0 = explode('/',$_POST['dataliberacao']);
$dataLiberacao = $dataLiberacao0[2].$dataLiberacao0[1].$dataLiberacao0[0];

// Observa��es

if(strlen($_POST['obsgravacao']) > 3){
$obs1 = $_POST['obsgravacao'];	
	
$insertOBS1 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','1','".$obs1."')");
		
}

if(strlen($_POST['obsentrega']) > 3){
$obs2 = $_POST['obsentrega'];	
	
$insertOBS2 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','2','".$obs2."')");
		
}

if(strlen($_POST['obsfinalizada']) > 3){
$obs3 = $_POST['obsfinalizada'];	
	
$insertOBS3 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','3','".$obs3."')");
		
}





if($_POST['status'] == 'RECUPERADO'){

$obs_recuperacao = $_POST['obsrecuperacao'];

if($obs_recuperacao){
	
$usuario_recuperacao = $USUARIO['id'];	
$data_recuperacao = date('Y-m-d H:i:s');

	
} }

// Cart�o

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


if($_POST['status'] == ''){ $status = $linha['status'];} 


else if($_POST['status'] == 'GRAVAR' && $linha['gravacao'] == "" || ($_POST['status'] == 'RECUPERADO' && $linha['gravacao'] == "" && $linha['os'] == "" && ($linha['cpf'] == "" || $linha['cpf'] == "000.000.000-00") )){  $status = 'GRAVAR'; }


else if($_POST['status'] == 'GRAVAR' && $linha['gravacao'] != "" || ($_POST['status'] == 'RECUPERADO' && $linha['gravacao'] != "" && $linha['os'] != ""  && ($linha['cpf'] != "" || $linha['cpf'] != "000.000.000-00") )){  $status = 'GRAVADO'; }


else if($_POST['status'] == 'RECUPERADO' && $linha['gravacao'] == "" && $linha['os'] == "" && ($linha['cpf'] != "" || $linha['cpf'] != "000.000.000-00") ){  $status = 'PRE-ANALISE'; }

else if($_POST['status'] == 'RECUPERADO' && $linha['gravacao'] != ""){ $status = 'GRAVADO'; }

else if($_POST['status'] == 'GRAVADO' && $linha['gravacao'] != "" && $linha['os'] == ""){  $status = 'PRE-ANALISE'; }

else { $status = $_POST['status']; }


//////////////////////
// Atualizar Dados //
////////////////////


$update = $conexao->query("UPDATE vendas_clarotv SET os = '".$os."', esn = '".$esn."', novoNumero = '".$novoNumero."', nome = '".$nome."', nascimento = '".$nascimento."', cpf = '".$cpf."', rg = '".$rg."', org_exp = '".$org_exp."', profissao = '".$profissao."', sexo = '".$sexo."', estado_civil = '".$estado_civil."', email = '".$email."', telefone = '".$telefone."', tipo_tel1 = '".$tipo_tel1."', telefone2 = '".$telefone2."', tipo_tel2 = '".$tipo_tel2."', telefone3 = '".$telefone3."', tipo_tel3 = '".$tipo_tel3."', endereco = '".$endereco."', numero = '".$numero."', lote = '".$lote."', quadra = '".$quadra."', complemento = '".$complemento."', bairro = '".$bairro."', cidade = '".$cidade."', uf = '".$uf."', cep = '".$cep."', ponto_referencia = '".$ponto_referencia."', operador = '".$operador."', monitor = '".$monitor."', tipoLinha = '".$tipoLinha."', tipoAssinatura = '".$tipoAssinatura."', tipoPlano = '".$tipoPlano."', plano = '".$plano."', valorPlano = '".$valorPlano."', aparelho = '".$aparelho."', valorAparelho = '".$valorAparelho."', pagamento = '".$pagamento."', status = '".$status."', data = '".$data."', vencimento = '".$vencimento."', agendGravacao = '".$agendGravacao."', motivo_restricao = '".$motivo_restricao."',motivo_cancelamento = '".$motivo_cancelamento."', motivo_devolvido = '".$motivo_devolvido."', pendencia = '".$pendencia."', dataLiberacao = '".$dataLiberacao."', obs_recuperacao = '".$obs_recuperacao."', usuario_recuperacao = '".$usuario_recuperacao."', data_recuperacao = '".$data_recuperacao."', data_marcada = '".$data_entrega."', data_instalacao = '".$data_finalizada."', titularCartao = '".$titularCartao."', numCar = '".$numCar."', codSeg = '".$codSeg."', carVal = '".$carVal."', carBan = '".$carBan."', numParcelas = '".$numParcelas."' WHERE id = '".$_GET['id']."' ") or die('Ocorreu um Erro ao inserir os dados!');




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
////// EXCLUIR GRAVA��O ///////////
//////////////////////////////////



if(isset($_POST['excluirgravacao'])){
	
$excluirgravacao = $conexao->query("UPDATE vendas_clarotv SET auditor = '', gravacao = '' WHERE id = '".$_GET['id']."'");

/////////////////
// Insert LOG //
///////////////

$data = date("Y-m-d H:i:s");

$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$_SESSION['usuario']."','Excluiu uma grava��o: [".$linha['gravacao']."] (ID: ".$_GET['id'].") .')");


	?>
	
<script type="text/javascript">

window.alert('Grava��o exclu�da com sucesso!');

window.location = '?e=1&id=<?= $_GET['id'];?>'


</script>    	


<?	
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Detalhes Venda Claro Fixo</title>
<style type="text/css">
body{margin: 0 0 0 0; font-family:Arial, Helvetica, sans-serif;}

#topo{position:relative; background:url(img/topo-bg.png) repeat-x; top:0px; height:120px; width:100%;}
</style>
</head>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>
<script type="text/javascript">

 /*Cria uma fun��o de nome mascara, onde o primeiro argumento passado � um dos
   objetos input O segundo � especificando o tipo de m�todo no qual ser� tratado*/

    function mascara(o,f){


        v_obj=o;


        v_fun=f;















        setTimeout("execmascara()",1);















    }















    















    function execmascara(){















        /*Pegue o valor do objeto e atribua o resultado da fun��o v_fun; cujo o conte�do















        da mesma � a fun��o que foi referida e que ser� utilizada para tratar dos dados*/















        v_obj.value=v_fun(v_obj.value);















    }















    















    function soNumeros(v){















        return v.replace(/\D/g,"");//Exclua tudo que n�o for numeral e retorne o valor















    }















    















    function telefone(v){















        //Remove tudo o que n�o � d�gito















        v=v.replace(/\D/g,"");















        //Coloca par�nteses em volta dos dois primeiros d�gitos



        v=v.replace(/^(\d\d)(\d)/g,"($1) $2");



        //Coloca h�fen entre o quarto e o quinto d�gitos



        v=v.replace(/(\d{4})(\d)/,"$1-$2");















        //retorne o resultado















        return v;















    }















	































    function cpf(v){















        //Remove tudo o que n�o � d�gito















        v=v.replace(/\D/g,"");















        //Coloca par�nteses em volta dos dois primeiros d�gitos















        v=v.replace(/^(\d{3})(\d)/g,"$1.$2");















        //Coloca h�fen entre o quarto e o quinto d�gitos















        v=v.replace(/(\d{3})(\d)/,"$1.$2");















        //retorne o resultado















		v=v.replace(/(\d{3})(\d)/,"$1-$2");















        return v;















    }















	















	















    function cep(v){
		        //Remove tudo o que n�o � d�gito

       v=v.replace(/\D/g,"");

        //Coloca h�fen entre o quarto e o quinto d�gitos

        v=v.replace(/(\d{5})(\d)/,"$1-$2");

        //retorne o resultado

        return v;




    }	


    function num(v){
		        //Remove tudo o que n�o � d�gito

       v=v.replace(/\D/g,"");

        //retorne o resultado

        return v;

    }	














	















    function data(v){















        //Remove tudo o que n�o � d�gito















        v=v.replace(/\D/g,"");















        //Coloca par�nteses em volta dos dois primeiros d�gitos















        v=v.replace(/^(\d{2})(\d)/g,"$1/$2");















        //Coloca h�fen entre o quarto e o quinto d�gitos















        v=v.replace(/(\d{2})(\d)/,"$1/$2");















        return v;















    }	















	















    function cartaocredito(v){















        //Remove tudo o que n�o � d�gito















        v=v.replace(/\D/g,"");















        //Coloca par�nteses em volta dos dois primeiros d�gitos















        v=v.replace(/^(\d{4})(\d)/g,"$1-$2");















        //Coloca h�fen entre o quarto e o quinto d�gitos















        v=v.replace(/(\d{4})(\d)/,"$1-$2");















        v=v.replace(/(\d{4})(\d)/,"$1-$2");































        return v;















    }	















	















	















//////////////////////////////////	















	















	















function verificaassinatura(v){































if(v == "Nova Linha"){ $('#tipoplano').html('<option value=""></option><option value="Pr� Pago">Pr� Pago</option><option value="P�s Pago">P�s Pago</option>'); }















else if(v == "Portabilidade"){ $('#tipoplano').html('<option value=""></option><option value="P�s Pago">P�s Pago</option>'); }















else { $('#tipoplano').html('<option value=""></option>');}































verificatipoplano('');















verificaplano('');















verificaaparelho('');















}































function verificatipoplano(v){































if(v == "Pr� Pago"){ $('#plano').html('<option value=""></option><option value="Pr� 35">Pr� 35</option><option value="Pr� Fixo Ilimitado Local">Pr� Fixo Ilimitado Local</option>'); }































else if(v == "P�s Pago"){ $('#plano').html('<option value=""></option><option value="FAV Local">FAV Local</option><option value="FAV Local com DDD">FAV Local com DDD</option><option value="FAV Local e DDD">FAV Local e DDD</option><option value="FAV Local e DDD com M�vel">FAV Local e DDD com M�vel</option>'); }















else { $('#plano').html('<option value=""></option>');}































verificaplano('');















verificaaparelho('');































}		































function verificaplanos(v){ 































if(v == "Pr� 15"){ document.getElementById('valorplano').value = '15,00'; }















else if(v == "Pr� Fixo Ilimitado Local"){ document.getElementById('valorplano').value = '19,90';}















else if(v == "FAV Local"){ document.getElementById('valorplano').value = '19,90'; }















else if(v == "FAV Local com DDD"){ document.getElementById('valorplano').value = '29,90'; }















else if(v == "FAV Local e DDD"){ document.getElementById('valorplano').value = '39,90'; }















else if(v == "FAV Local e DDD com M�vel"){ document.getElementById('valorplano').value = '49,90'; }















else { document.getElementById('valorplano').value = '';}































$('#aparelho').html('<option value=""></option><option value="Alcatel OT 208">Alcatel OT 208</option><option value="ALCATEL CF100">ALCATEL CF100</option><option value="ALCATEL MF100">ALCATEL MF100</option><option value="Huawei 8551">Huawei 8551</option><option value="Huawei 2555">Huawei 2555</option><option value="Huawei U2800 (Cinza)">Huawei U2800 (Cinza)</option><option value="Huawei U2800 (Branco)">Huawei U2800 (Branco)</option><option value="Huawei C2610">Huawei C2610</option><option value="Chip Claro Fixo">Chip Claro Fixo</option>');





verificaaparelho('');







}




function verificaaparelho(v){

var tipoassinatura = document.getElementById('tipoassinatura').value;

if(tipoassinatura == 'Portabilidade'){
	
if(v == 'Alcatel OT 208'){document.getElementById('valoraparelho').value = '34,50'; }
else if(v == 'ALCATEL CF100'){document.getElementById('valoraparelho').value = '49,00'; }
else if(v == 'ALCATEL MF100'){document.getElementById('valoraparelho').value = '79,00'; }
else if(v == 'Huawei 8551'){document.getElementById('valoraparelho').value = '79,00'; }
else if(v == 'Huawei 2555'){document.getElementById('valoraparelho').value = '49,00'; }
else if(v == 'Huawei 2555'){document.getElementById('valoraparelho').value = '49,00'; }
else if(v == 'Huawei U2800 (Cinza)'){document.getElementById('valoraparelho').value = '99,00'; }
else if(v == 'Huawei U2800 (Branco)'){document.getElementById('valoraparelho').value = '99,00'; }
else if(v == 'Huawei C2610'){document.getElementById('valoraparelho').value = '34,50'; }
else if(v == 'Chip Claro Fixo'){document.getElementById('valoraparelho').value = '5,00'; }

else{ document.getElementById('valoraparelho').value = ''; }	
	
	
	}



else if(tipoassinatura == 'Nova Linha'){

var plano = document.getElementById('plano').value;
	
if(plano == 'Pr� 15' || plano == 'Pr� Fixo Ilimitado Local'){ 

if(v == 'Alcatel OT 208'){document.getElementById('valoraparelho').value = '69,00'; }
else if(v == 'ALCATEL CF100'){document.getElementById('valoraparelho').value = '79,90'; }
else if(v == 'ALCATEL MF100'){document.getElementById('valoraparelho').value = '149,00'; }
else if(v == 'Huawei 8551'){document.getElementById('valoraparelho').value = '179,00'; }
else if(v == 'Huawei 2555'){document.getElementById('valoraparelho').value = '149,00'; }
else if(v == 'Huawei U2800 (Cinza)'){document.getElementById('valoraparelho').value = '99,00'; }
else if(v == 'Huawei U2800 (Branco)'){document.getElementById('valoraparelho').value = '99,00'; }
else if(v == 'Huawei C2610'){document.getElementById('valoraparelho').value = '69,00'; }
else if(v == 'Chip Claro Fixo'){document.getElementById('valoraparelho').value = '5,00'; }
else{ document.getElementById('valoraparelho').value = ''; }
                                                    }

else if(plano == 'FAV Local'){ 

if(v == 'Alcatel OT 208'){document.getElementById('valoraparelho').value = '49,00'; }
else if(v == 'ALCATEL CF100'){document.getElementById('valoraparelho').value = '79,90'; }
else if(v == 'ALCATEL MF100'){document.getElementById('valoraparelho').value = '79,00'; }
else if(v == 'Huawei 8551'){document.getElementById('valoraparelho').value = '119,00'; }
else if(v == 'Huawei 2555'){document.getElementById('valoraparelho').value = '79,00'; }
else if(v == 'Huawei U2800 (Cinza)'){document.getElementById('valoraparelho').value = '99,00'; }
else if(v == 'Huawei U2800 (Branco)'){document.getElementById('valoraparelho').value = '99,00'; }
else if(v == 'Huawei C2610'){document.getElementById('valoraparelho').value = '49,00'; }
else if(v == 'Chip Claro Fixo'){document.getElementById('valoraparelho').value = '5,00'; }
else{ document.getElementById('valoraparelho').value = ''; }
                                                    }	

else if(plano == 'FAV Local com DDD' || plano == 'FAV Local e DDD' || plano == 'FAV Local e DDD com M�vel'){ 

if(v == 'Alcatel OT 208'){document.getElementById('valoraparelho').value = '49,00'; }
else if(v == 'ALCATEL CF100'){document.getElementById('valoraparelho').value = '79,90'; }
else if(v == 'ALCATEL MF100'){document.getElementById('valoraparelho').value = '79,00'; }
else if(v == 'Huawei 8551'){document.getElementById('valoraparelho').value = '119,00'; }
else if(v == 'Huawei 2555'){document.getElementById('valoraparelho').value = '79,00'; }
else if(v == 'Huawei U2800 (Cinza)'){document.getElementById('valoraparelho').value = '99,00'; }
else if(v == 'Huawei U2800 (Branco)'){document.getElementById('valoraparelho').value = '99,00'; }
else if(v == 'Huawei C2610'){document.getElementById('valoraparelho').value = '49,00'; }
else if(v == 'Chip Claro Fixo'){document.getElementById('valoraparelho').value = '5,00'; }
else{ document.getElementById('valoraparelho').value = ''; }
                                                    }

else{ document.getElementById('valoraparelho').value = ''; }

}

else{ document.getElementById('valoraparelho').value = ''; }

                            }

	


/////////////////////////////









function mostrar(id){ document.getElementById(id).style.display = '' }





function esconder(id){ document.getElementById(id).style.display = 'none' }







function checkstatus(v){


if(v == 'CANCELADO'){ document.getElementById('mcancel').style.display = '';
					  document.getElementById('mrest').style.display = 'none';
					  document.getElementById('mdevo').style.display = 'none';
					  document.getElementById('mpend').style.display = 'none';
					  document.getElementById('obsrecupe').style.display = 'none';
			        } 

else if(v == 'RESTRI��O'){ document.getElementById('mcancel').style.display = 'none';
					  document.getElementById('mrest').style.display = '';
					  document.getElementById('mdevo').style.display = 'none';
					  document.getElementById('mpend').style.display = 'none';
					  document.getElementById('obsrecupe').style.display = 'none';
			             }
						 
else if(v == 'DEVOLVIDO'){ document.getElementById('mcancel').style.display = 'none';
					  document.getElementById('mrest').style.display = 'none';
					  document.getElementById('mdevo').style.display = '';
					  document.getElementById('mpend').style.display = 'none';
					  document.getElementById('obsrecupe').style.display = 'none';
			             }						 

else if(v == 'PENDENTE'){ document.getElementById('mcancel').style.display = 'none';
					 		   document.getElementById('mrest').style.display = 'none';
							   document.getElementById('mdevo').style.display = 'none';
					           document.getElementById('mpend').style.display = '';
							   document.getElementById('obsrecupe').style.display = 'none';
			                 }
							 
else if(v == 'RECUPERADO'){ document.getElementById('mcancel').style.display = 'none';
							document.getElementById('mrest').style.display = 'none';
							document.getElementById('mdevo').style.display = 'none';
							document.getElementById('mpend').style.display = 'none';
							document.getElementById('obsrecupe').style.display = '';  } 							 


else{ document.getElementById('mcancel').style.display = 'none';  
document.getElementById('motivocancelamento').value = "";

document.getElementById('mrest').style.display = 'none'; 	
document.getElementById('motivorestricao').value = "";

document.getElementById('mdevo').style.display = 'none';
document.getElementById('motivodevolvido').value = "";

document.getElementById('mpend').style.display = 'none';
document.getElementById('pendencia').value = "";

document.getElementById('maguardlb').style.display = 'none';
document.getElementById('dataliberacao').value = "";

document.getElementById('obsrecupe').style.display = 'none';
document.getElementById('obsrecuperacao').innerHTML = "";

}

}


function checkpendencia(v){

if(v == 'Cart�o N�o Autorizado'){ document.getElementById('maguardlb').style.display = '';  }

else {

document.getElementById('maguardlb').style.display = 'none';
document.getElementById('dataliberacao').value = "";

}
}



function verificaplano(v){

if(v == "10GB"){ document.getElementById('valor').value = '159,92'; }

else if(v == "5GB"){ document.getElementById('valor').value = '95,92'; }















else if(v == "3GB"){ document.getElementById('valor').value = '71,92'; }















else if(v == "2GB"){ document.getElementById('valor').value = '63,92'; }















else { document.getElementById('valor').value = '';}





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







/////////////// VALIDA��O ////////////////	







/////////////////////////////////////////































function validar(){
	
	

cpf = $('input[name="icpf"]').val();
gravacao = '<?= $linha['gravacao'];?>';
tecnico = $('select[name="tecnico"]').val();
datainstalacao = $('input[name="datainstalacao"]').val();
os = $('input[name="os"]').val();
ostam = os.length;
//////////	

status = $('select[name="status"]').val();
erro = 0;


// :: verifica os :: //
if(ostam > 0 && ostam < 8){
	

alert("OS Inv�lida");


$('input[name="os"]').focus();


erro = erro+1;

stop();
	
	
	
}



// Se GRAVADO	

if(status == 'GRAVADO' || status == 'PENDENTE'){


if(cpf == '' || cpf == '000.000.000-00' || cpf == '111.111.111-11')



{



alert("CPF Inv�lido");


$('input[name="icpf"]').focus();


erro = erro+1;

stop();

}	



if(erro == 0)		

if(gravacao == '')

{

alert("Status n�o permitido sem grava��o!");
erro = erro+1;

}}




// Se FINALIZADA	











if(status == 'FINALIZADA'){















if(cpf == '' || cpf == '000.000.000-00' || cpf == '111.111.111-11')















{















alert("CPF Inv�lido");















$('input[name="icpf"]').focus();















erro = erro+1;















}	















if(erro == 0){		















if(gravacao == '')















{















alert("Status n�o permitido sem grava��o!");















erro = erro+1;















}}











}























// Se Nada estiver errado:















if(erro == 0){






document.forms.editar.submit();


			}































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


//

function validaos(val,id){
	
	
tam = val.length;


if(tam < 8){
	
 $(id).stop().animate({backgroundColor: '#ffcece', border:"1px solid #ABABAB", padding:'1px', color:'#9a0000'},2000);	
	
	} else if(tam < 1 || tam >= 8) {
		
 $(id).stop().animate({backgroundColor: '#a2ff4f', color:'#428c00'},800, function(){
 $(id).animate({backgroundColor: '#ffffff', color:'#000000'},1200);
	 
	 });	
		
		
	}
	
	
	}

//

function excluir(){if(confirm("Tem certeza que deseja excluir esta grava��o?")){
	
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







<td><b>OS:</b></td>







<td>







<? if($editar == '1' || $editar_instalacao == '1') {?>







<input type="text" name="os" id="os" size="40" onKeyPress="mascara(this,num);validaos(this.value,os);" onKeyUp="validaos(this.value,os);" onChange="mascara(this,num);validaos(this.value,os);" maxlength="8" value="<?= $linha['os']; ?>" />







<? } else { ?>















<?= $linha['os']; ?>







<input type="hidden" name="os" size="40" value="<?= $linha['os']; ?>" />















</td>















<? } ?>







</tr>























<tr>







<td><b>ESN:</b></td>







<td>







<? if($editar == '1' || $editar_instalacao == '1') {?>







<span id="loadcontratos" style="font-size:12px;"></span>







<input type="text" name="esn" size="40" maxlength="10" value="<?= $linha['esn']; ?>" onKeyUp="checkcontratos(this.value)" onChange="checkcontratos(this.value)" />







<? } else { ?>















<?= $linha['esn']; ?>







<input type="hidden" name="esn" size="40" value="<?= $linha['esn']; ?>" />















</td>















<? } ?>







</tr>















<tr>







<td><b>Novo N�mero:</b></td>







<td>







<? if($editar == '1' || $editar_instalacao == '1') {?>







<span id="loadcontratos" style="font-size:12px;"></span>







<input type="text" name="novonumero" size="40" maxlength="14" onKeyPress="mascara(this,telefone)" onChange="mascara(this,telefone)" value="<?= $linha['novoNumero']; ?>" />







<? } else { ?>















<?= $linha['novoNumero']; ?>







<input type="hidden" name="novonumero" size="40" value="<?= $linha['novoNumero']; ?>" />















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







<td><b>Nome da M�e:</b></td>







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







<input type="text" name="rg" size="40" value="<?= $linha['rg']; ?>" />







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







<td><b>Data Exp.:</b></td>







<td>















<? if($editar == '1') {?>







<input type="text" name="dataexp" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<? if($linha['data_exp'] != ''){ echo substr($linha['data_exp'],6,2)."/".substr($linha['data_exp'],4,2)."/".substr($linha['data_exp'],0,4); } ?>" />







<? } else { ?>















<? if($linha['data_exp'] != ''){ echo substr($linha['data_exp'],6,2)."/".substr($linha['data_exp'],4,2)."/".substr($linha['data_exp'],0,4);} ?>















<input type="hidden" name="dataexp" value="<? if($linha['data_exp'] != ''){ echo substr($linha['data_exp'],6,2)."/".substr($linha['data_exp'],4,2)."/".substr($linha['data_exp'],0,4); } ?>" />















<? } ?>







</td>







</tr>















<tr>







<td><b>Profiss�o:</b></td>







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







<option value="Vi�vo" <? if($linha['estado_civil'] == 'Vi�vo'){?> selected="selected" <? } ?>>Vi�vo</option> 







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







<td><b>Endere�o:</b></td>







<td>















<? if($editar == '1') {?>







<input type="text" size="27" name="endereco" value="<?= $linha['endereco']; ?>" /> N�: <input type="text" size="5" name="numero" value="<?= $linha['numero']; ?>" /> <br /> Lote: <input type="text" size="5" name="lote" value="<?= $linha['lote']; ?>" /> Quadra: <input type="text" size="5" name="quadra" value="<?= $linha['quadra']; ?>" />







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















$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE grupo LIKE '%0003%' && tipo_usuario = 'MONITOR' ORDER BY nome ASC");







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







$conOPERADORES1 = $conexao->query("SELECT * FROM operadores WHERE operador_id = '".$linha['operador']."'");







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















$conOPERADORES = $conexao->query("SELECT * FROM operadores WHERE grupo LIKE '%0003%' && status != 'DESLIGADO' ORDER BY nome ASC");







while($OPERADORES = mysql_fetch_array($conOPERADORES)){















?>















<option value="<?= $OPERADORES['operador_id'];?>" <? if($linha['operador'] == $OPERADORES['operador_id']){?> selected="selected" <? } ?>>







<?= $OPERADORES['nome'];?>







</option>















<? } ?>















</select>







<? } else { ?>















<?= $OPERADORES1['nome']; ?>







<input type="hidden" name="operador" value="<?= $linha['operador']; ?>" />















<? } ?>















</td>







</tr>















<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>







<tr>

<td><b>Tipo Linha:</b></td>

<td>

<? if($editar == '1') {?>

<select name="tipolinha" id="tipolinha">

<option value=""></option>

<option value="Residencial" <? if($linha['tipoLinha'] == 'Residencial'){?>selected="selected"<? } ?>>Residencial</option>

<option value="Comercial" <? if($linha['tipoLinha'] == 'Comercial'){?>selected="selected"<? } ?>>Comercial</option>

</select>



<? } else { ?>



<?= $linha['tipoLinha']; ?>



<input type="hidden" name="tipolinha" value="<?= $linha['tipoLinha']; ?>" />



<? } ?>

</td>

</tr>







<tr>

<td><b>Tipo Assinatura:</b></td>

<td>



<? if($editar == '1') {?>

<select name="tipoassinatura" id="tipoassinatura" onChange="verificaassinatura(this.value);">

<option value=""></option>

<option value="Nova Linha" <? if($linha['tipoAssinatura'] == 'Nova Linha'){?>selected="selected"<? } ?>>Nova Linha</option>

<option value="Portabilidade" <? if($linha['tipoAssinatura'] == 'Portabilidade'){?>selected="selected"<? } ?>>Portabilidade</option>

</select>



<? } else { ?>



<?= $linha['tipoAssinatura']; ?>



<input type="hidden" name="tipoassinatura" value="<?= $linha['tipoAssinatura']; ?>" />


<? } ?>

</td>

</tr>





<tr>

<td><b>Tipo Plano:</b></td>

<td>

<? if($editar == '1') {?>

<select name="tipoplano" id="tipoplano" onChange="verificatipoplano(this.value);">

<option value="<?= $linha['tipoPlano']; ?>"><?= $linha['tipoPlano']; ?></option>

</select>

<? } else { ?>

<?= $linha['tipoPlano']; ?>

<input type="hidden" name="tipoplano" value="<?= $linha['tipoPlano']; ?>" />

<? } ?>

</td>

</tr>





<tr align="left">

<td><b>Plano:</b></td>

<td>

<? if($editar == '1') {?>

<select name="plano" id="plano" onChange="verificaplanos(this.value);">

<option value="<?= $linha['plano']; ?>"><?= $linha['plano']; ?></option>

</select>

<? } else { ?>

<?= $linha['plano']; ?>

<input type="hidden" name="plano" value="<?= $linha['plano']; ?>" />

<? } ?>

</td>

</tr>



<tr align="left">

<td><b>Valor Plano:</b></td>

<td> <? if($editar == '1') {?><span style="font-size:12px; color:#999; font-style:italic">R$</span> <input type="text" id="valorplano" name="valorplano" readonly size="8" maxlength="10"  value="<?= $linha['valorPlano']; ?>" />



<? } else { ?>

<?= $linha['valorPlano']; ?>

<input type="hidden" name="valorplano" value="<?= $linha['valorPlano']; ?>" />

<? } ?>

</td>

</tr>





<tr align="left">

<td><b>Aparelho:</b></td>

<td>

<? if($editar == '1') {?>

<select name="aparelho" id="aparelho" onChange="verificaaparelho(this.value);">

<option value="<?= $linha['aparelho']; ?>"><?= $linha['aparelho']; ?></option>

</select>

<? } else { ?>

<?= $linha['aparelho']; ?>

<input type="hidden" name="aparelho" value="<?= $linha['aparelho']; ?>" />

<? } ?>

</td>

</tr>





<tr align="left">

<td><b>Valor Aparelho:</b></td>

<td> <? if($editar == '1') {?> <span style="font-size:12px; color:#999; font-style:italic">R$</span> <input type="text" id="valoraparelho" name="valoraparelho" readonly size="8" maxlength="10" value="<?= $linha['valorAparelho']; ?>" />

<? } else { ?>

<?= $linha['valorAparelho']; ?>

<input type="hidden" name="valorAparelho" value="<?= $linha['valorAparelho']; ?>" />

<? } ?>

</td>

</tr>



<tr align="left">

<td><b>Pagamento:</b></td>

<td>

<? if($editar == '1') {?>

<select name="pagamento" id="pagamento" onChange="verificapagamento(this.value);">

<option value="BOLETO" <? if($linha['pagamento'] == 'BOLETO'){?>selected="selected"<? } ?>>BOLETO</option>

<option value="CART�O DE CR�DITO" <? if($linha['pagamento'] == 'CART�O DE CR�DITO'){?>selected="selected"<? } ?>>CART�O DE CR�DITO</option>

<option value="PRONTA ENTREGA" <? if($linha['pagamento'] == 'PRONTA ENTREGA'){?>selected="selected"<? } ?>>PRONTA ENTREGA</option>

</select>

<? } else { ?>

<?= $linha['pagamento']; ?>

<input type="hidden" name="pagamento" value="<?= $linha['pagamento']; ?>" />

<? } ?>

</td>

</tr>









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















<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<? if($linha['pagamento'] == 'CART�O DE CR�DITO'){ ?>


<tr>

<td><b>Nome do Titular:</b></td>
<td>

<? if($editar == '1') {?>

<input type="text" name="titularCartao" size="30" value="<?=$linha['titularCartao'];?>" /> <span style="font-size:12px; color:#999; font-style:italic">(Nome impresso no cart�o)</span>

<? } else {

if($linha['numCar']){ echo $linha['titularCartao']; } ?>

<input type="hidden" name="titularCartao" size="50" value="<?=$linha['titularCartao'];?>" /> 

<? } ?>

</td>
</tr>



<tr>
<td><b>Cart�o Cr�dito:</b></td>
<td>
<? 

if( $linha['status'] == 'GRAVADO'){

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


<tr>
<td><b>C�d. Seguran�a:</b></td>
<td>
<? 
if( $linha['status'] == 'GRAVADO'){
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

<tr>
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


<tr>

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


<tr>
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

<? } ?>





<?

$conGravacaoRetirada = $conexao->query("SELECT *, 
												usuarios.nome AS nome,
												DATE_FORMAT(log_sistema.data, '%d/%m/%Y �s %H:%i:%s') AS dataevento
												FROM log_sistema 
												INNER JOIN usuarios
												ON usuarios.id = log_sistema.usuario
												WHERE  
												log_sistema.evento LIKE '%Excluiu uma grava��o%' && 
												log_sistema.evento LIKE '%(ID: ".$_GET['id'].")%' 
												ORDER BY log_sistema.id ASC
										");
										
while($GravacaoRetirada = mysql_fetch_array($conGravacaoRetirada)){										

$gravacaoRE = explode('[',$GravacaoRetirada['evento']);
$gravacaoRE = explode(']',$gravacaoRE[1]);
$gravacaoRE = $gravacaoRE[0];

?>

<tr>
<td><b>Grava��o retirada:</b></td>
<td>
<img src="img/play-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Ouvir Grava��o" onClick="javascript:window.location = 'http://172.16.0.30/audio/clarofixo/orig/<?= $gravacaoRE;?>'" /> <span style="font-size:13px;">Ouvir Grava��o </span>
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







<td><b>Grava��o:</b></td>







<td>







<? if($linha['gravacao'] == '' && $USUARIO['inserir_gravacao'] == '1'){?>



<img src="img/record.png" width="20" align="absmiddle" style="cursor:pointer" title="Inserir Grava��o" onClick="window.location = 'http://172.16.0.30/vento-adm/upload-gravacao-simples-clarofixo.php?id=<?= $linha['id'];?>&u=<?= $USUARIO['id'];?>'" /> <span style="font-size:13px;">Inserir Grava��o </span>



<? } else if($linha['gravacao'] != '') {?>



<img src="img/play-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Ouvir Grava��o" onClick="javascript:window.location = 'http://172.16.0.30/audio/clarofixo/orig/<?= $linha['gravacao'];?>'" /> <span style="font-size:13px;">Ouvir Grava��o </span>
&nbsp; &nbsp; &nbsp;


<? if($editar == 1){?>
<img src="img/delete-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Excluir Grava��o" onClick="javascript:excluir();" /> <span style="font-size:13px;">Excluir Grava��o </span>
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

<? 
$tipoOBS = '1';
include "includes/observacoes.php";
?>


<? if($linha['obs_gravacao']){?>
<tr><td colspan="2"><hr size="1" style="border-bottom: 1px dashed #EDEDED;" color="#FFF" /></td></tr>		

<tr>
<td><b>Obs.:</b></td>
<td>

<?= $linha['obs_gravacao'];?>
</td>
</tr>

<? } ?>


<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<? include "includes/agendamento-gravacao.php";?>



<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>















<tr>







<td><b>Data Entrega:</b></td>







<td>















<? if($editar == '1' || $editar_instalacao == '1') {?>







<input type="text" name="dataentrega" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<? if($linha['data_marcada'] != ''){ echo substr($linha['data_marcada'],6,2)."/".substr($linha['data_marcada'],4,2)."/".substr($linha['data_marcada'],0,4); } ?>" />







<? } else { ?>















<? if($linha['data_marcada'] != ''){ echo substr($linha['data_marcada'],6,2)."/".substr($linha['data_marcada'],4,2)."/".substr($linha['data_marcada'],0,4);} ?>















<input type="hidden" name="dataentrega" value="<? if($linha['data_marcada'] != ''){ echo substr($linha['data_marcada'],6,2)."/".substr($linha['data_marcada'],4,2)."/".substr($linha['data_marcada'],0,4); } ?>" />















<? } ?>







</td>







</tr>

<? 
$tipoOBS = '2';
include "includes/observacoes.php";
?>


<? if($linha['obs1']){ ?>
<tr><td colspan="2"><hr size="1" style="border-bottom: 1px dashed #EDEDED;" color="#FFF" /></td></tr>		

<tr>
<td><b>Obs.:</b></td>
<td>
<?= $linha['obs1']; ?>
</td>
</tr>
<? } ?>




<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<tr>
<td><b>Data Finalizada:</b></td>
<td>

<? if($editar == '1' && $USUARIO['tipo_usuario'] == 'ADMINISTRADOR'){ ?>

<input type="text" name="datainstalacao" placeholder="ex:(dd/mm/aaaa)" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<? if($linha['data_instalacao'] != ''){ echo substr($linha['data_instalacao'],6,2)."/".substr($linha['data_instalacao'],4,2)."/".substr($linha['data_instalacao'],0,4); } ?>" />

<? } else {?>

<? echo substr($linha['data_instalacao'],6,2)."/".substr($linha['data_instalacao'],4,2)."/".substr($linha['data_instalacao'],0,4); ?>
<input type="hidden" name="datainstalacao" value="<? if($linha['data_instalacao'] != ''){ echo substr($linha['data_instalacao'],6,2)."/".substr($linha['data_instalacao'],4,2)."/".substr($linha['data_instalacao'],0,4); } ?>" />

<? } ?>


</td>
</tr>


<? 
$tipoOBS = '3';
include "includes/observacoes.php";
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



<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<tr>
<td><b>Status:</b></td>
<td>
<? if($editar == '1' && ($USUARIO['tipo_usuario'] == 'ADMINISTRADOR' || ($USUARIO['id'] == '2' || $USUARIO['id'] == '3140'))){?>  


<select name="status" onChange="checkstatus(this.value)">
<option value="AUTORIZADA" <? if($linha['status'] == 'AUTORIZADA'){?>selected="selected"<? } ?>>Autorizada</option>
<option value="ATIVADO" <? if($linha['status'] == 'ATIVADO'){?>selected="selected"<? } ?>>Ativado</option>
<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>
<option value="PRE-ANALISE" <? if($linha['status'] == 'PRE-ANALISE'){?>selected="selected"<? } ?>>Pr�-An�lise</option>
<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>
<option value="RECUPERADO" <? if($linha['status'] == 'RECUPERADO'){?>selected="selected"<? } ?>>Venda Recuperada</option>
<option value="PENDENTE" <? if($linha['status'] == 'PENDENTE'){?>selected="selected"<? } ?>>Pendente</option>
<option value="FINALIZADA" <? if($linha['status'] == 'FINALIZADA'){?>selected="selected"<? } ?>>Finalizada</option>
<option value="GRAVAR" <? if($linha['status'] == 'GRAVAR'){?>selected="selected"<? } ?>>Gravar</option>
<option value="REDIRECIONADO" <? if($linha['status'] == 'REDIRECIONADO'){?>selected="selected"<? } ?>>Redirecionado</option>
<option value="RESTRI��O" <? if($linha['status'] == 'RESTRI��O'){?>selected="selected"<? } ?>>Restri��o</option>
<option value="SEM COBERTURA" <? if($linha['status'] == 'SEM COBERTURA'){?>selected="selected"<? } ?>>Sem Cobertura</option>
<option value="GRAVADO" <? if($linha['status'] == 'GRAVADO'){?>selected="selected"<? } ?>>Gravado</option>
<option value="SEM CONTATO" <? if($linha['status'] == 'SEM CONTATO'){?>selected="selected"<? } ?>>Sem Contato</option>
<option value="BOLETO GERADO" <? if($linha['status'] == 'BOLETO GERADO'){?>selected="selected"<? } ?>>Boleto Gerado</option>
<option value="ENVIAR GRAVA��O" <? if($linha['status'] == 'ENVIAR GRAVA��O'){?>selected="selected"<? } ?>>Enviar Grava��o</option>

</select>

<? } else {?>

<? if(($editar == '1') && $linha['status'] == 'PRE-ANALISE') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="PRE-ANALISE" <? if($linha['status'] == 'PRE-ANALISE'){?>selected="selected"<? } ?>>Pr�-An�lise</option>
<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>
<option value="GRAVAR" <? if($linha['status'] == 'GRAVAR'){?>selected="selected"<? } ?>>Gravar</option>
<option value="REDIRECIONADO" <? if($linha['status'] == 'REDIRECIONADO'){?>selected="selected"<? } ?>>Redirecionado</option>
<option value="RESTRI��O" <? if($linha['status'] == 'RESTRI��O'){?>selected="selected"<? } ?>>Restri��o</option>
<option value="SEM COBERTURA" <? if($linha['status'] == 'SEM COBERTURA'){?>selected="selected"<? } ?>>Sem Cobertura</option>
</select>

<? } else if(($editar == '1') && $linha['status'] == 'GRAVAR') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="GRAVAR" <? if($linha['status'] == 'GRAVAR'){?>selected="selected"<? } ?>>Gravar</option>
<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>
<option value="GRAVADO" <? if($linha['status'] == 'GRAVADO'){?>selected="selected"<? } ?>>Gravado</option>
<option value="PENDENTE" <? if($linha['status'] == 'PENDENTE'){?>selected="selected"<? } ?>>Pendente</option>
<option value="SEM CONTATO" <? if($linha['status'] == 'SEM CONTATO'){?>selected="selected"<? } ?>>Sem Contato</option>
</select>

<? } else if(($_GET['e'] == '1') && $linha['status'] == 'DEVOLVIDO' && ($USUARIO['tipo_usuario'] == 'MONITOR' || $USUARIO['tipo_usuario'] == 'ADMINISTRADOR')) { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>
<option value="RECUPERADO" <? if($linha['status'] == 'RECUPERADO'){?>selected="selected"<? } ?>>Venda Recuperada</option>
<option value="PENDENTE" <? if($linha['status'] == 'PENDENTE'){?>selected="selected"<? } ?>>Pendente</option>
<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>
</select>

<? } else if(($_GET['e'] == '1') && $linha['status'] == 'PENDENTE') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="PENDENTE" <? if($linha['status'] == 'PENDENTE'){?>selected="selected"<? } ?>>Pendente</option>
<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>
<option value="GRAVADO" <? if($linha['status'] == 'GRAVADO'){?>selected="selected"<? } ?>>Gravado</option>
<option value="FINALIZADA" <? if($linha['status'] == 'FINALIZADA'){?>selected="selected"<? } ?>>Finalizada</option>

</select>

<? } else if(($_GET['e'] == '1') && $linha['status'] == 'REDIRECIONADO' && ($USUARIO['tipo_usuario'] == 'MONITOR' || $USUARIO['tipo_usuario'] == 'ADMINISTRADOR')) { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="REDIRECIONADO" <? if($linha['status'] == 'REDIRECIONADO'){?>selected="selected"<? } ?>>Redirecionado</option>
<option value="RECUPERADO" <? if($linha['status'] == 'RECUPERADO'){?>selected="selected"<? } ?>>Venda Recuperada</option>
<option value="CANCELADO" <? if($linha['status'] == 'CANCELADO'){?>selected="selected"<? } ?>>Cancelado</option>
</select>

<? } else if(($editar == '1') && $linha['status'] == 'GRAVADO') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="GRAVADO" <? if($linha['status'] == 'GRAVADO'){?>selected="selected"<? } ?>>Gravado</option>
<option value="REDIRECIONADO" <? if($linha['status'] == 'REDIRECIONADO'){?>selected="selected"<? } ?>>Redirecionado</option>
<option value="RESTRI��O" <? if($linha['status'] == 'RESTRI��O'){?>selected="selected"<? } ?>>Restri��o</option>
<option value="BOLETO GERADO" <? if($linha['status'] == 'BOLETO GERADO'){?>selected="selected"<? } ?>>Boleto Gerado</option>
<option value="SEM COBERTURA" <? if($linha['status'] == 'SEM COBERTURA'){?>selected="selected"<? } ?>>Sem Cobertura</option>
<option value="PENDENTE" <? if($linha['status'] == 'PENDENTE'){?>selected="selected"<? } ?>>Pendente</option>
<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>
</select>

<? } else if(($editar == '1') && $linha['status'] == 'SEM COBERTURA') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="SEM COBERTURA" <? if($linha['status'] == 'SEM COBERTURA'){?>selected="selected"<? } ?>>Sem Cobertura</option>
<option value="COM COBERTURA" <? if($linha['status'] == 'COM COBERTURA'){?>selected="selected"<? } ?>>Com Cobertura</option>
</select>

<? } else if(($editar == '1') && $linha['status'] == 'BOLETO GERADO') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="BOLETO GERADO" <? if($linha['status'] == 'BOLETO GERADO'){?>selected="selected"<? } ?>>Boleto Gerado</option>
<option value="ENVIAR GRAVA��O" <? if($linha['status'] == 'ENVIAR GRAVA��O'){?>selected="selected"<? } ?>>Enviar Grava��o</option>
</select>

<? } else if(($editar == '1' || $editar_instalacao == '1') && $linha['status'] == 'ENVIAR GRAVA��O') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="ENVIAR GRAVA��O" <? if($linha['status'] == 'ENVIAR GRAVA��O'){?>selected="selected"<? } ?>>Enviar Grava��o</option>GRAVA��O
<option value="FINALIZADA" <? if($linha['status'] == 'FINALIZADA'){?>selected="selected"<? } ?>>Finalizada</option>
</select>

<? } else if(($editar == '1') && $linha['status'] == 'RESTRI��O') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="RESTRI��O" <? if($linha['status'] == 'RESTRI��O'){?>selected="selected"<? } ?>>Restri��o</option>
<option value="AUTORIZADA" <? if($linha['status'] == 'AUTORIZADA'){?>selected="selected"<? } ?>>Autorizada</option>
</select>

<? } else if(($editar == '1') && $linha['status'] == 'AUTORIZADA') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="AUTORIZADA" <? if($linha['status'] == 'AUTORIZADA'){?>selected="selected"<? } ?>>Autorizada</option>
<option value="ATIVADO" <? if($linha['status'] == 'ATIVADO'){?>selected="selected"<? } ?>>Ativado</option>
</select>

<? } else if(($editar == '1') && $linha['status'] == 'SEM CONTATO') { ?>

<select name="status" onChange="checkstatus(this.value)">
<option value="SEM CONTATO" <? if($linha['status'] == 'SEM CONTATO'){?>selected="selected"<? } ?>>Sem Contato</option>
<option value="GRAVAR" <? if($linha['status'] == 'GRAVAR'){?>selected="selected"<? } ?>>Gravar</option>
<option value="DEVOLVIDO" <? if($linha['status'] == 'DEVOLVIDO'){?>selected="selected"<? } ?>>Devolvido</option>
<option value="GRAVADO" <? if($linha['status'] == 'GRAVADO'){?>selected="selected"<? } ?>>Gravado</option>
</select>

<? } else { ?>

<?= $linha['status']; ?>
<input type="hidden" name="status" value="<?= $linha['status']; ?>" />

</td>

<? }} ?>
</td>
</tr>



<? if($linha['status'] == 'CANCELADO' || $_GET['e'] == '1'){?>
<!-- MOTIVO CANCELAMENTO -->

<tr id="mcancel" <? if($linha['status'] != 'CANCELADO'){ ?> style="display:none" <? } ?>>
<td><b>Motivo:</b></td>
<td>

<? if($_GET['e'] == '1' && ($USUARIO['tipo_usuario'] == 'MONITOR' || $USUARIO['tipo_usuario'] == 'ADMINISTRADOR')) { ?>

<select name="motivocancelamento" id="motivocancelamento">

<option value=""></option>

<option value="Inviabilidade T�cnica" <? if($linha['motivo_cancelamento'] == 'Inviabilidade T�cnica'){?>selected="selected"<? } ?>>Inviabilidade T�cnica</option>

<option value="Falta de Dinheiro" <? if($linha['motivo_cancelamento'] == 'Falta de Dinheiro'){?>selected="selected"<? } ?>>Falta de Dinheiro</option>

<option value="Venda Perdida para a Concorr�ncia" <? if($linha['motivo_cancelamento'] == 'Venda Perdida para a Concorr�ncia'){?>selected="selected"<? } ?>>Venda Perdida para a Concorr�ncia</option>

<option value="Desist�ncia do Cliente" <? if($linha['motivo_cancelamento'] == 'Desist�ncia do Cliente'){?>selected="selected"<? } ?>>Desist�ncia do Cliente</option>

<option value="Endere�o N�o Encontrado" <? if($linha['motivo_cancelamento'] == 'Endere�o N�o Encontrado'){?>selected="selected"<? } ?>>Endere�o N�o Encontrado</option>

<option value="�rea de Risco" <? if($linha['motivo_cancelamento'] == '�rea de Risco'){?>selected="selected"<? } ?>>�rea de Risco</option>

<option value="Cancelado no VSALES" <? if($linha['motivo_cancelamento'] == 'Cancelado no VSALES'){?>selected="selected"<? } ?>>Cancelado no VSALES

</option>
<option value="N�mero Inv�lido" <? if($linha['motivo_cancelamento'] == 'N�mero Inv�lido'){?>selected="selected"<? } ?>>N�mero Inv�lido</option>

</select>

<? } else {?>

<?= $linha['motivo_cancelamento']; ?>

<? } ?>
</td>
</tr>
<? } ?>



<? if($linha['status'] == 'RESTRI��O' || $_GET['e'] == '1'){?>
<!-- MOTIVO RESTRI��O -->

<tr id="mrest" <? if($linha['status'] != 'RESTRI��O'){ ?> style="display:none" <? } ?>>

<td><b>Motivo:</b></td>
<td>
<? if($editar == '1') { ?>
<select name="motivorestricao" id="motivorestricao">
<option value=""></option>
<option value="Politicas Embratel" <? if($linha['motivo_restricao'] == 'Politicas Embratel'){?>selected="selected"<? } ?>>Politicas Embratel</option>
<option value="Cart�o Inv�lido" <? if($linha['motivo_restricao'] == 'Cart�o Inv�lido'){?>selected="selected"<? } ?>>Cart�o Inv�lido</option>
<option value="Cart�o N�o Autorizou" <? if($linha['motivo_restricao'] == 'Cart�o N�o Autorizou'){?>selected="selected"<? } ?>>Cart�o N�o Autorizou</option>
<option value="Limite de Linhas" <? if($linha['motivo_restricao'] == 'Limite de Linhas'){?>selected="selected"<? } ?>>Limite de Linhas</option>


</select>

<? } else {?>

<?= $linha['motivo_restricao']; ?>

<? } ?>

</td>
</tr>

<? } ?>


<? if($linha['status'] == 'DEVOLVIDO' || $_GET['e'] == '1'){?>
<!-- MOTIVO DEVOLVIDO -->

<tr id="mdevo" <? if($linha['status'] != 'DEVOLVIDO'){ ?> style="display:none" <? } ?>>

<td><b>Motivo:</b></td>
<td>
<? if($editar == '1') { ?>
<select name="motivodevolvido" id="motivodevolvido">
<option value=""></option>
<option value="Cart�o N�o Autorizado" <? if($linha['motivo_devolvido'] == 'Cart�o N�o Autorizado'){?>selected="selected"<? } ?>>Cart�o N�o Autorizado</option>
<option value="Cart�o Inv�lido" <? if($linha['motivo_devolvido'] == 'Cart�o Inv�lido'){?>selected="selected"<? } ?>>Cart�o Inv�lido</option>
<option value="Diverg�ncia de Informa��o" <? if($linha['motivo_devolvido'] == 'Diverg�ncia de Informa��o'){?>selected="selected"<? } ?>>Diverg�ncia de Informa��o</option>

</select>

<? } else {?>

<input type="hidden" name="motivodevolvido" value="<?= $linha['motivo_devolvido']; ?>" />
<?= $linha['motivo_devolvido']; ?>

<? } ?>

</td>
</tr>

<? } ?>



<? if($linha['status'] == 'PENDENTE' || $_GET['e'] == '1'){?>
<!-- PENDENCIA -->

<tr id="mpend" <? if($linha['status'] != 'PENDENTE'){ ?> style="display:none" <? } ?>>

<td><b>Pendencia:</b></td>
<td>
<? if($editar == '1') { ?>
<select name="pendencia" id="pendencia" onChange="checkpendencia(this.value)">
<option value=""></option>
<option value="Cart�o Pendente" <? if($linha['pendencia'] == 'Cart�o Pendente'){?>selected="selected"<? } ?>>Cart�o Pendente</option>
<option value="Cart�o Inv�lido" <? if($linha['pendencia'] == 'Cart�o Inv�lido'){?>selected="selected"<? } ?>>Cart�o Inv�lido</option>
<option value="Cart�o N�o Autorizado" <? if($linha['pendencia'] == 'Cart�o N�o Autorizado'){?>selected="selected"<? } ?>>Cart�o N�o Autorizado</option>
<option value="Limite de Linhas" <? if($linha['pendencia'] == 'Limite de Linhas'){?>selected="selected"<? } ?>>Limite de Linhas</option>


</select>

<? } else {?>

<input type="hidden" name="pendencia" value="<?= $linha['pendencia']; ?>" />
<?= $linha['pendencia']; ?>

<? } ?>

</td>
</tr>

<? } ?>



<? if($linha['pendencia'] == 'Cart�o N�o Autorizado' || $_GET['e'] == '1'){?>
<!-- DATA LIBERA��O -->

<tr id="maguardlb" <? if($linha['pendencia'] != 'Cart�o N�o Autorizado'){ ?> style="display:none" <? } ?>>

<td><b>Data Libera��o:</b></td>
<td>
<? if($editar == '1') { ?>
<input type="text" name="dataliberacao" id="dataliberacao" placeholder="ex:(dd/mm/aaaa)" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<? if($linha['dataLiberacao']){ echo substr($linha['dataLiberacao'],6,2)."/".substr($linha['dataLiberacao'],4,2)."/".substr($linha['dataLiberacao'],0,4);} ?>" />

<? } else {?>

<input type="hidden" name="dataliberacao" value="<?= substr($linha['dataLiberacao'],6,2)."/".substr($linha['dataLiberacao'],4,2)."/".substr($linha['dataLiberacao'],0,4); ?>" />
<?= substr($linha['dataLiberacao'],6,2)."/".substr($linha['dataLiberacao'],4,2)."/".substr($linha['dataLiberacao'],0,4); ?>

<? } ?>

</td>
</tr>

<? } ?>



<? if($linha['obs_recuperacao'] != '' || $_GET['e'] == '1'){?>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<tr id="obsrecupe" <? if($linha['obs_recuperacao'] == ''){ ?> style="display:none" <? } ?>>

<td><b>Obs. Recupera��o:</b></td>

<td>

<? if(($_GET['e'] == '1') && $linha['obs_recuperacao'] == '') { ?>

<textarea name="obsrecuperacao" id="obsrecuperacao" rows="3" cols="30"></textarea>

<? } else {?>


<?= $linha['obs_recuperacao']; ?> <br />

<? 

$conVendaRecuperada = $conexao->query("SELECT nome FROM usuarios WHERE id = '".$linha['usuario_recuperacao']."'");
$usuarioRecuperada = mysql_fetch_array($conVendaRecuperada);

$dataRecuperada = substr($linha['data_recuperacao'],8,2).'/'.substr($linha['data_recuperacao'],5,2).'/'.substr($linha['data_recuperacao'],0,4).' �s '.substr($linha['data_recuperacao'],11);

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

<? if($editar == '1' || $editar_instalacao == '1' || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'LOGISTICA') || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR' && $linha['status'] == 'DEVOLVIDO')) {?>

<center>

<img src="img/salvar.png" height="25" onClick="javascript:validar();" style="cursor:pointer" />

<img src="img/cancelar.png" height="25" onClick="window.location = '?id=<?= $_GET['id'];?>'" style="cursor:pointer" />

</center>

<? } else {?>

<center>

<? if($USUARIO['editar_dados'] == 1 || $USUARIO['editar_instalacao'] == 1 || ($USUARIO['tipo_usuario'] == 'LOGISTICA') || ($USUARIO['tipo_usuario'] == 'MONITOR' && $linha['status'] == 'DEVOLVIDO') ){?>


<img src="img/editar.png" height="25" onClick="window.location = '?id=<?= $_GET['id'];?>&e=1'" style="cursor:pointer" /> 

<? } ?>

<img src="img/imprimir.png" height="25" onClick="javascript:print();" style="cursor:pointer" />

</center>

<? } ?>


</body>

</html>