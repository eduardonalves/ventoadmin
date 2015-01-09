<?

// Verificar se está logado
if( (!isset($_SESSION['usuario'])) && (!isset($_SESSION['operador'])) ){ ?>
	
<script type="text/javascript">
window.location = 'index.php'
</script>	
	
	
<? } 

if(isset($_POST['nome'])){

	
// Dados do cliente

$pessoa = $_POST['pessoa'];
$nome = $_POST['nome'];
$nome_mae = $_POST['nomemae'];
$nome_pai = $_POST['nomepai'];
$nascimento = $_POST['nascd'].'/'.$_POST['nascm'].'/'.$_POST['nasca'];
if($_POST['icpf']){ $cpf = $_POST['icpf'];} else { $cpf = $_POST['icnpj'];}
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


// Ensereço Instalação

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
$netCelularPlano = $_POST['planocelular'];
$netCelularPlanoPreco = $_POST['planocelularPreco'];

$netPortabilidadeMovel = $_POST['operadoraportadamovel'];
$netNumeroPortadoMovel = $_POST['numeroportadomovel'];

$pontos = $_POST['pontos'];
$pagamento = $_POST['pagamento'];
$data0 = explode('/',$_POST['idata']);
$data = $data0[2].$data0[1].$data0[0];
$vencimento = $_POST['vencimento'];

$valor = str_replace(',','.',$_POST['valor']);

$banco = $_POST['banco'];
$agencia = $_POST['agencia'];
$conta_corrente = $_POST['contacorrente'];
$titularconta = $_POST['titularconta'];
$titularcontacpf = $_POST['titularcontacpf'];
// Verificar venda parceiro/interno

$conTipovenda = $conexao->query("SELECT * FROM usuarios WHERE id = '".$monitor."'");
$rowTipovenda = mysql_fetch_array($conTipovenda);

if($rowTipovenda['acesso_usuario'] == 'INTERNO'){

	if ( strstr(strtolower($rowTipovenda['login']), "internet") )
	{
	
		$tipoVenda = 'INTERNET'; $idTipoVenda = '03';
	
	}else{
		
		$tipoVenda = 'INTERNA'; $idTipoVenda = '01';
	}

	} else {

		

		$tipoVenda = 'EXTERNA'; $idTipoVenda = '02';

	}



// PROTOCOLO
$conNumvenda = $conexao->query("SELECT * FROM vendas_clarotv WHERE data LIKE '%".date('Ymd')."%'");
$rowNumvenda = mysql_num_rows($conNumvenda);

$protocolo = date("ymdHi").$idTipoVenda.str_pad(($rowNumvenda+1),4, "0", STR_PAD_LEFT);



// Dados da Instalação
$data_desejada0 = explode('/',$_POST['datadesejada']);
$data_desejada = $data_desejada0[2].$data_desejada0[1].$data_desejada0[0];

$tipo_instalacao = $_POST['tipoinstalacao'];

if($tipo_instalacao == 'EXTERNA'){ $tecnico = '1';}

$pagamento_instalacao = $_POST['pagamentoinstalacao'];


if($cpf == '' || $cpf == '000.000.000-00' || $cpf == '111.111.111-11' || $cpf == '00.000.000/0000-00'){ 

$status = "GRAVAR"; 
} else { 

$status = "PRE-ANALISE";
}

// EXCESSAO PARA USUARIO DE INTERNET
if  (strstr(strtolower($USUARIO['login']), 'internet')) 

{
	$status = "PRE-ANALISE";
	
}

$inserir = $conexao->query("INSERT INTO vendas_clarotv (protocolo,produto,tipoVenda,pessoa,nome,nome_mae,nome_pai,nascimento,cpf,rg,org_exp,profissao,sexo,estado_civil,email,telefone,tipo_tel1,telefone2,tipo_tel2,telefone3,tipo_tel3,endereco,numero,lote,quadra,complemento,bairro,cidade,uf,cep,ponto_referencia,operador,monitor,pontos,pagamento,data,data_venda,vencimento,valor,banco,agencia,conta_corrente, titular_conta_deposito, cpf_titular_conta_deposito,data_desejada,tipo_instalacao,tecnico_id,pagamento_instalacao,status, netFilial, netTipoContrato, netPerfil, netGrupo, netAgregados, netOrigem, plano, comboFonePlano, comboInternetPlano, comboPortabilidade, comboServicos, netPeriodo, comboNumeroPortado, netOperadoraPortada, netCelularPlano, netCelularPlanoPreco, netPortabilidadeMovel, netNumeroPortadoMovel) VALUES ('".$protocolo."','10','".$tipoVenda."','".$pessoa."','".$nome."','".$nome_mae."','".$nome_pai."','".$nascimento."','".$cpf."','".$rg."','".$org_exp."','".$profissao."','".$sexo."','".$estado_civil."','".$email."','".$telefone."','".$tipo_tel1."','".$telefone2."','".$tipo_tel2."','".$telefone3."','".$tipo_tel3."','".$endereco."','".$numero."','".$lote."','".$quadra."','".$complemento."','".$bairro."','".$cidade."','".$uf."','".$cep."','".$ponto_referencia."','".$operador."','".$monitor."','".$pontos."','".$pagamento."','".$data."','".$data."','".$vencimento."','".$valor."','".$banco."','".$agencia."','".$conta_corrente."','".$titularconta."','".$titularcontacpf."','".$data_desejada."','".$tipo_instalacao."','".$tecnico."','".$pagamento_instalacao."','".$status."','".$netFilial."','".$netTipoContrato."','".$netPerfil."','".$netGrupo."','".$netAgregados."','".$netOrigem."','".$netPlanotv."','".$netPlanofone."','".$netPlanonet."','".$netPortabilidade."','".$netProdutos."','".$netPeriodo."','".$netNumeroPortado."','".$netOperadoraPortada."','".$netCelularPlano."','".$netCelularPlanoPreco."','".$netPortabilidadeMovel."','".$netNumeroPortadoMovel."')") or die('Ocorreu um Erro ao inserir os dados!');

//LOG

$datadehoje = date("Y-m-d H:i:s");
$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$datadehoje."','".$_SESSION['usuario']."','Inseriu um novo dado no sistema (Protocolo: $protocolo).')");

?>

<script type="text/javascript">

window.alert("Cadastro efetuado com sucesso!");
window.location = '?p=net';


</script>


<?

}

?>



<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>
<script type="text/javascript" src="js/calendario.js"></script>
<script type="text/javascript" src="js/cep.js"></script>
<script type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.7.3.custom.css" />
<link rel="stylesheet" type="text/css" href="css/geral.css" />
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
	
	
	
	
	
////////////////////////////////////

function verificapagamento(v){
	
	if(v == "DÉBITO"){ 
	
	//document.getElementById('valor').value = '49,90';
	//document.getElementById('valor').disabled = true;
	document.getElementById('idbanco').style.display = '';
	//document.getElementById('inppagamentoinstalacao').style.display = 'none';
	
	 } else { //document.getElementById('valor').disabled = false;  
	          //document.getElementById('idbanco').style.display = 'none'; 	
			  //document.getElementById('inppagamentoinstalacao').style.display = '';   
			  }
	
	}
	
	
function verificapessoa(v){
	
if(v == 'Pessoa Jurídica') {
	
     document.getElementById('nomel').innerHTML = 'Razão Social:';
     document.getElementById('cpfl').style.display = 'none';
	 document.getElementById('idcpf').value = '';
     document.getElementById('cnpjl').style.display = '';
	 
	 document.getElementById('inpnasc').style.display = 'none';
	 document.getElementById('inprg').style.display = 'none';
	 document.getElementById('inpprofissao').style.display = 'none';
	 document.getElementById('inpsexo').style.display = 'none';
	 document.getElementById('inpestadocivil').style.display = 'none';
	 
} else if(v == 'Pessoa Física') {
	
     document.getElementById('nomel').innerHTML = 'Nome:';
     document.getElementById('cpfl').style.display = '';
 	 document.getElementById('idcnpj').value = '';
     document.getElementById('cnpjl').style.display = 'none';

	 document.getElementById('inpnasc').style.display = '';
	 document.getElementById('inprg').style.display = '';
	 document.getElementById('inpprofissao').style.display = '';
	 document.getElementById('inpsexo').style.display = '';
	 document.getElementById('inpestadocivil').style.display = '';
	 
	
	}
	
	
	}
	
	
///////////////////////


function submitform(){

e=0;

/////// -- DADOS PESSOAIS -- ////////
if(!document.getElementById('pessoa1').checked && !document.getElementById('pessoa2').checked){ document.getElementById('epessoa').style.display = ''; e=(e+1)} else { document.getElementById('epessoa').style.display = 'none';}

if(document.getElementById('nome').value == ''){ document.getElementById('enome').style.display = ''; e=(e+1)} else { document.getElementById('enome').style.display = 'none';}	

if(document.getElementById('idcpf').value == '' && document.getElementById('idcnpj').value == ''){ document.getElementById('ecpf').style.display = ''; e=(e+1)} else { document.getElementById('ecpf').style.display = 'none';}

if(document.getElementById('idcpf').value == '' && document.getElementById('idcnpj').value == '' && document.getElementById('pessoa2').checked){ document.getElementById('ecnpj').style.display = ''; e=(e+1)} else { document.getElementById('ecnpj').style.display = 'none';}

if(!document.getElementById('pessoa2').checked){

if(document.getElementById('nascd').value == '' || document.getElementById('nascm').value == '' || document.getElementById('nasca').value == ''){ document.getElementById('enasc').style.display = ''; e=(e+1)} else { document.getElementById('enasc').style.display = 'none';}	

if(document.getElementById('rg').value == '' || document.getElementById('orgexp').value == ''){ document.getElementById('erg').style.display = ''; e=(e+1)} else { document.getElementById('erg').style.display = 'none';}

if(document.getElementById('profissao').value == ''){ document.getElementById('eprofissao').style.display = ''; e=(e+1)} else { document.getElementById('eprofissao').style.display = 'none';}

if(!document.getElementById('sexo1').checked && !document.getElementById('sexo2').checked){ document.getElementById('esexo').style.display = ''; e=(e+1)} else { document.getElementById('esexo').style.display = 'none';}

if(document.getElementById('estadocivil').value == ''){ document.getElementById('eestadocivil').style.display = ''; e=(e+1)} else { document.getElementById('eestadocivil').style.display = 'none';}

if(document.getElementById('estadocivil').value == ''){ document.getElementById('eestadocivil').style.display = ''; e=(e+1)} else { document.getElementById('eestadocivil').style.display = 'none';}


}


if(document.getElementById('email').value == ''){ document.getElementById('eemail').style.display = ''; e=(e+1)} else { document.getElementById('eemail').style.display = 'none';}

if(document.getElementById('tel1').value == ''){ document.getElementById('etelefone').style.display = ''; e=(e+1)} else { document.getElementById('etelefone').style.display = 'none';}

if(document.getElementById('tel2').value == ''){ document.getElementById('etelefone2').style.display = ''; e=(e+1)} else { document.getElementById('etelefone2').style.display = 'none';}



/////// -- ENDEREÇO INSTALAÇÃO -- ////////

if(document.getElementById('endereco').value == '' || document.getElementById('numero').value == ''){ document.getElementById('eendereco').style.display = ''; e=(e+1)} else { document.getElementById('eendereco').style.display = 'none';}
	
if(document.getElementById('bairro').value == ''){ document.getElementById('ebairro').style.display = ''; e=(e+1)} else { document.getElementById('ebairro').style.display = 'none';}

if(document.getElementById('uf').value == ''){ document.getElementById('euf').style.display = ''; e=(e+1)} else { document.getElementById('euf').style.display = 'none';}	

if(document.getElementById('cidade').value == ''){ document.getElementById('ecidade').style.display = ''; e=(e+1)} else { document.getElementById('ecidade').style.display = 'none';}	

//if(document.getElementById('idcep').value == ''){ document.getElementById('ecep').style.display = ''; e=(e+1)} else { document.getElementById('ecep').style.display = 'none';}	


/////// -- DADOS DA VENDA -- ////////


if(document.getElementById('operador').value == ''){ document.getElementById('eoperador').style.display = ''; e=(e+1)} else { document.getElementById('eoperador').style.display = 'none';}	

if(document.getElementById('monitor').value == ''){ document.getElementById('emonitor').style.display = ''; e=(e+1)} else { document.getElementById('emonitor').style.display = 'none';}	

//if(document.getElementById('plano').value == ''){ document.getElementById('eplano').style.display = ''; e=(e+1)} else { document.getElementById('eplano').style.display = 'none';}	

//if(!document.getElementById('ponto1').checked && !document.getElementById('ponto2').checked && !document.getElementById('ponto3').checked){ document.getElementById('epontos').style.display = ''; e=(e+1)} else { document.getElementById('epontos').style.display = 'none';}	

if(document.getElementById('calendario2').value == ''){ document.getElementById('evenda').style.display = ''; e=(e+1)} else { document.getElementById('evenda').style.display = 'none';}
	
	
if(!document.getElementById('venci1').checked && !document.getElementById('venci2').checked && !document.getElementById('venci3').checked && !document.getElementById('venci4').checked){ document.getElementById('evencimento').style.display = ''; e=(e+1)} else { document.getElementById('evencimento').style.display = 'none';}


if( document.getElementById('pagamento').value == 'DÉBITO' && (document.getElementById('titularconta').value == '' || document.getElementById('titularcontacpf').value == '' || document.getElementById('banco').value == '' || document.getElementById('agencia').value == '' || document.getElementById('contacorrente').value == '')){ document.getElementById('ebanco').style.display = ''; e=(e+1)} else { document.getElementById('ebanco').style.display = 'none';}

//if(document.getElementById('calendario').value == ''){ document.getElementById('eagendamento').style.display = ''; e=(e+1)} else { document.getElementById('eagendamento').style.display = 'none';}
/////// -- VERIFICAR SE EXISTEM ERROS -- ////////

if(e!=0){ window.alert('ERRO: Preencha todos os campos indicados, corretamente'); $('body,html').animate({scrollTop: 150}, 800);} else { document.forms.inserir.submit(); }
	
}



///////////////////////////////////
///////// CHECAR PROPOSTA////////
/////////////////////////////////

function checkpropostas(p){
	
	
	$('#loadpropostas').load('check-propostas.php?p='+p);
	
	
	}
	
function checkoperador(m){
	
	
	$('#loadoperadores').load('check-operadores.php?m='+m+'&g=0010');
	
	}
	
function checkcidades(uf){
	
	
	$('#loadcidades').load('check-cidades.php?uf='+uf);
	
	
	}	
	

$(document).ready(function(e) {
	
	checkoperador();
	checkcidades()
	});

</script>

<style type="text/css">

.erro{color:#C00; font-size:12px;}

</style>

<!-- SUBMENU -->
<? include "submenu-net.php";?>
<!-- FIM DO SUBMENU -->

<center>
<table border="0" width="1000px">

<tr valign="bottom" height="40px" align="left">
<td style="font-size:14px; color:#999;">NOVA VENDA</td>
<td align="right"><img src="img/voltar.png" style="cursor:pointer" onclick="window.location = '?p=net'" /></td>
</tr>

<tr>
<td colspan="2"><hr size="1" color="#CCCCCC" /></td>
</tr>

</table>


<center>
	
<form name="inserir" action="" method="post">

<table border="0" width="850px" >

<tr align="left">
<td>Monitor:</td>
<td>
<select type="text" id="monitor" name="monitor" onchange="checkoperador(this.value)">
<option value=""></option>
<? $conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE tipo_usuario = 'MONITOR' && grupo LIKE '%0010%'");
   while($MONITORES = mysql_fetch_array($conMONITORES)){
?>
<option value="<?= $MONITORES['id']?>"><?= $MONITORES['nome']?></option>
<? } ?>
</select> 
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="emonitor" style="display:none">Por favor, selecione o monitor responsável pelo operador que fez a venda!</span>
</td>
</tr>

<tr align="left">
<td>Operador:</td>
<td>
<div id="loadoperadores" style="position:relative"></div>
</td>
</tr>

<tr align="left">
<td>Tipo Contrato:</td>
<td>

<select name="tipocontrato" id="tipocontrato">

<option value=""></option>
<option value="INCLUSÃO">INCLUSÃO</option>
<option value="PME">PME</option>
<option value="VENDA">VENDA</option>

</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="etipocontrato" style="display:none">Por favor, preencha esta campo!</span>

</td>
</tr>

<tr height="30px" valign="bottom" align="left">
<td style="color:#069; font-size:12px">Dados do Cliente</td>
</tr>

<tr align="left">
<td>Tipo:</td>
<td>
<input type="radio" name="pessoa" id="pessoa1" value="Pessoa Física" onchange="verificapessoa(this.value)"> <label for="pessoa1">Pessoa Física</label>
<input type="radio" name="pessoa" id="pessoa2" value="Pessoa Jurídica" onchange="verificapessoa(this.value)" /> <label for="pessoa2">Pessoa Jurídica</label>
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="epessoa" style="display:none">Por favor, selecione o tipo do cliente!</span>
</td>
</tr>

<tr align="left">
<td id="nomel">Nome:</td>
<td><input type="text" id="nome" name="nome" size="40" />
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="enome" style="display:none">Por favor, digite o nome do cliente!</span>
</td>
</tr>

<tr align="left" id="nomemael">

<td>Nome da Mãe:</td>

<td><input type="text" id="nomemae" name="nomemae" size="40" />


<span class="campoobrigatorio" title="Campo Obrigatório">*</span>

<span class="erro" id="enomemae" style="display:none">Por favor, digite o nome da mãe do cliente!</span> 


</td>

</tr>

<tr align="left" id="nomepail">

<td>Nome do Pai:</td>

<td><input type="text" id="nomepai" name="nomepai" size="40" />


<span class="campoobrigatorio" title="Campo Obrigatório">*</span>

<span class="erro" id="enomepai" style="display:none">Por favor, digite o nome do pai do cliente!</span> 


</td>

</tr>


<tr align="left" id="inpnasc">
<td>Nascimento:</td>
<td>

<script type="text/javascript">

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
							
						} else if (fidelidade == 'SEM FIDELIDADE' ){
							
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

		$("#tr-pontos-adicionais").css('display', 'table-row');
		$("#tr-label-pontos-adicionais").css('display', 'table-row');

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
			$("#operadoraportadamovel").val('');
			$("#numeroportadomovel").val('');
			
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
		$("#operadoraportadamovel").val('');
		$("#numeroportadomovel").val('');

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

	$('#perfil, #netProdutos, #portabilidade, #tipocontrato, #pagamento').bind('change', function(){

		atualizaCampos($(this));

	});
	
	$('#planotv-fidelidade').bind('change', function(){

		atualizaCampos($(this));
		
		$('#planotv').trigger('change');
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

		var precoInstalacao = $('option:selected', this).attr('data-valor-instalacao');
		
		if (typeof precoInstalacao === typeof undefined){

			$('#tr-planotv-info').css('display', 'none');

		} else {

			$('#tr-planotv-info').css('display', '');
			$('#planotv-info').text('Taxa de instalação de R$ ' + precoInstalacao);

		}
		
	});
	
	$('#planofone').bind('change', function(){
		
		if( $('#planofone option:selected').is('[data-valor-instalacao]') ) {

			var precoInstalacao = $('#planofone option:selected').attr('data-valor-instalacao');
			
			$('#tr-planofone-info').css('display', '');
			$('#planofone-info').text('Taxa de instalação de R$ ' + precoInstalacao);
			
		} else {
			
			$('#tr-planofone-info').css('display', 'none');
		}
		
	});

	$('#planonet').bind('change', function(){

		if( $('#planonet option:selected').is('[data-valor-adesao]') ) {

			var precoInstalacao = $('#planonet option:selected').attr('data-valor-adesao');
			
			$('#tr-planonet-info').css('display', '');
			$('#planonet-info').text('Taxa de adesão de R$ ' + precoInstalacao);
			
		} else {
			
			$('#tr-planonet-info').css('display', 'none');
		}
		
	});

	$('#netProdutos').bind('change', function(){

		$('.infobox').css('display', 'none');

	});
	
	$(".data-nasc").bind("change", function() {

		vData = new Date();
		
		vDia = $("#nascd").val();
		vMes = $("#nascm").val();
		vAno = $("#nasca").val();
		
		vAnoAtual = vData.getFullYear();
		vMesAtual = vData.getMonth()+1;
		vDiaAtual = vData.getDate();
		vAnoMaximo = vAnoAtual - 18;

		
		if (vDia!='' && vMes!='' && vAno!='')
		{

			if(vAno==vAnoMaximo)
			{

				if(parseInt(vMes)>parseInt(vMesAtual))
				{
					vDia = $("#nascd").val('');
					vMes = $("#nascm").val('');
					
					alert('O cliente precisa ser maior de 18 anos. Verifique se a data de nascimento está correta.');

				}else if (parseInt(vMes)==parseInt(vMesAtual)) {

					if(parseInt(vDia)>parseInt(vDiaAtual))
					{
						vDia = $("#nascd").val('');
						vMes = $("#nascm").val('');
						
						alert('O cliente precisa ser maior de 18 anos. Verifique se a data de nascimento está correta.');
						
					}
				}
			}
		}
	
	});

});

</script>

<select name="nascd" id="nascd" class="data-nasc">
<option value=""></option>
<? $d = 1; while($d <= 31){ $dn = $d++;?>
<option value="<?= sprintf("%02d", $dn); ?>"> <?= sprintf("%02d", $dn); ?></option>
<? } ?>
</select>

<select name="nascm" id="nascm" class="data-nasc">
<option value=""></option>
<? $m = 1; while($m <= 12){ $mn = $m++;?>
<option value="<?= sprintf("%02d", $mn); ?>"> <?= sprintf("%02d", $mn); ?></option>
<? } ?>
</select>

<select name="nasca" id="nasca" class="data-nasc">
<option value=""></option>
<? $a = date('Y'); while($a > 1900){ $an = $a--;?>
<option value="<?= $an; ?>"> <?= $an; ?></option>
<? } ?>
</select>
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="enasc" style="display:none">Por favor, selecione uma data de nascimento válida!</span>
</td>
</tr>


<tr align="left" id="cpfl">
<td>CPF:</td>
<td id="cpfinp"><input type="text" id="idcpf" name="icpf" onKeyPress="mascara(this,cpf)" maxlength="14" size="20" />
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="ecpf" style="display:none">Por favor, digite o CPF do cliente!</span>
</td>
</tr>


<tr align="left" id="cnpjl" style="display:none">
<td>CNPJ:</td>
<td id="cpfinp"><input type="text" id="idcnpj" name="icnpj" onKeyPress="mascara(this,cnpj)" maxlength="18" size="20" />
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="ecnpj" style="display:none">Por favor, digite o CNPJ do cliente!</span>
</td>
</tr>


<tr align="left" id="inprg">
<td>RG:</td>
<td id="rginp"><input type="text" id="rg" name="rg" size="20" maxlength="12" /><span class="campoobrigatorio" title="Campo Obrigatório">*</span>
Org. Exp: <input type="text" title="Orgão Expedidor" id="orgexp" name="orgexp" size="20" />
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
Data Exp: <input type="text" title="Data Expedição" id="dataexp" name="dataexp" onKeyPress="mascara(this,data)" maxlength="10" size="20" />
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="erg" style="display:none">Por favor, digite o RG do cliente!</span>
</td>
</tr>


<tr align="left" id="inpprofissao">
<td class="t1">Profissão:</td>
<td><input type="text" name="profissao" id="profissao" size="50" /> 
<span class="campoobrigatorio" title="Campo Obrigatório">*</span> 
<span class="erro" id="eprofissao" style="display:none">Por favor, preencha a profissão do cliente!</span></td>
</tr>

<tr align="left" id="inpsexo">
<td class="t1">Sexo:</td>
<td><input type="radio" name="sexo" id="sexo1" value="Masculino" /> Masculino <input type="radio" name="sexo" id="sexo2" value="Feminino" /> Feminino
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="esexo" style="display:none">Por favor, selecione o sexo do cliente!</span>
</td>
</tr>

<tr align="left" id="inpestadocivil">
<td class="t1">Estado Civil:</td>
<td>
<select name="estadocivil" id="estadocivil" >
<option value=""></option>
<option value="Solteiro">Solteiro</option>
<option value="Casado">Casado</option>
<option value="Desquitado">Desquitado</option>
<option value="Separado">Separado</option>
<option value="Divorciado">Divorciado</option> 
<option value="Viúvo">Viúvo</option> 
</select>
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eestadocivil" style="display:none">Por favor, selecione o Estado Civil do cliente!</span>
</td>
</tr>


<tr align="left">
<td>Email:</td>
<td><input type="text" id="email" name="email"  size="30" />
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eemail" style="display:none">Por favor, digite o Email do cliente!</span>
</td>
</tr>

<tr align="left">
<td>Telefone 1:</td>
<td><input type="text"  id="tel1" name="itelefone" onKeyPress="mascara(this,telefone)" maxlength="15" size="20" /> 
<select name="tipotel1">
<option value="Residencial">Residencial</option> 
<option value="Celular">Celular</option>
<option value="Comercial">Comercial</option>
</select> 
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="etelefone" style="display:none">Por favor, digite o telefone 1 do cliente!</span>
</td>
</tr>

<tr align="left">
<td>Telefone 2:</td>
<td><input type="text" name="itelefone2" id="tel2" onKeyPress="mascara(this,telefone)" maxlength="15" size="20" /> 
<select name="tipotel2">
<option value="Residencial">Residencial</option> 
<option value="Celular" selected="selected">Celular</option>
<option value="Comercial">Comercial</option>
</select>
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="etelefone2" style="display:none">Por favor, digite o telefone 2 do cliente!</span>
</td>
</tr>

<tr align="left">
<td>Telefone 3:</td>
<td><input type="text" name="itelefone3" onKeyPress="mascara(this,telefone)" maxlength="15" size="20" /> 
<select name="tipotel3">
<option value="Residencial">Residencial</option> 
<option value="Celular">Celular</option>
<option value="Comercial" selected="selected">Comercial</option>
</select>
</td>
</tr>

<tr height="30px" valign="bottom" align="left">
<td style="color:#069; font-size:12px">Endereço de Instalação</td>
</tr>

<tr align="left">
<td>CEP:</td>
<td><input type="text" id="idcep" name="icep" size="30" onkeyup="return getEndereco()" onchange="return getEndereco()" onKeyPress="mascara(this,cep)" maxlength="9" > <span class="erro" id="ecep" style="display:none">Por favor, digite o CEP da instalação!</span></td>
</tr>

<tr align="left">
<td>Endereço:</td>
<td><input type="text" id="endereco" name="endereco" size="40" > <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
 Nº: <input type="text" name="numero" id="numero" size="5" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
 Lote: <input type="text" name="lote" id="lote" size="5" /> 
 Quadra: <input type="text" name="quadra" id="quadra" size="5" /> <br /> 
 <span class="erro" id="eendereco" style="display:none">Por favor, digite pelo menos o logradouro e o número do endereço de instalação!</span>
 </td>
</tr>

<tr align="left">
<td>Complemento:</td>
<td><input type="text" id="complemento" name="complemento" size="30" ></td>
</tr>

<tr align="left">
<td>Bairro:</td>
<td><input type="text" id="bairro" name="bairro" size="30" > 
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="ebairro" style="display:none">Por favor, digite o bairro da instalação!</span></td>
</tr>


<tr align="left">
<td>Estado:</td>
<td>
<select name="uf" id="uf" onchange="checkcidades(this.value)">
<option value=""></option>
<? $conESTADO = $conexao->query("SELECT DISTINCT(uf),nome FROM tb_estados");
   while($ESTADO = mysql_fetch_array($conESTADO)){
?>

<option value="<?= $ESTADO['uf'];?>"><?= $ESTADO['nome'];?></option>

<? } ?>
</select> 
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="euf" style="display:none">Por favor, selecione o estado da instalação!</span>
</td>
</tr>

<tr align="left">
<td>Cidade:</td>
<td>
<input type="text" id="cidade" name="cidade" size="30" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>

<span class="erro" id="ecidade" style="display:none">Por favor, selecione a cidade da instalação!</span></td>
</tr>

<tr align="left">
<td>Ponto de Referência:</td>
<td><textarea name="pontoref" rows="3" cols="30"></textarea>
</td>
</tr>

<tr height="30px" valign="bottom" align="left">
<td style="color:#069; font-size:12px">Dados da Venda</td>
</tr>

<tr align="left">
<td>Filial:</td>
<td>

<select name="filial" id="filial">

<option value=""></option>
<option value="NOVA IGUAÇU">NOVA IGUAÇU</option>
<option value="RIO DAS OSTRAS">RIO DAS OSTRAS</option>

</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="efilial" style="display:none">Por favor, preencha esta campo!</span>

</td>
</tr>

<tr align="left">
<td>Perfil</td>
<td>

<select name="perfil" id="perfil">

<option value=""></option>
<option value="COMBO">COMBO</option>
<option value="COMBO MULTI">COMBO MULTI</option>
<option value="DOUBLO">DOUBLO</option>
<option value="SINGLE">SINGLE</option>
<option value="COLETIVO">COLETIVO</option>

</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eperfil" style="display:none">Por favor, selecione o perfil!</span>

</td>
</tr>

<tr align="left" id="tr-produtos">
<td>Produtos</td>
<td>

<select name="netProdutos" id="netProdutos">

<option value=""></option>
<option value="NET FONE">NET FONE</option>
<option value="NET TV">NET TV</option>
<option value="NET FONE + NET TV">NET FONE + TV</option>
<option value="NET FONE + VIRTUA">NET FONE + VIRTUA</option>
<option value="NET TV + VIRTUA">NET TV + VIRTUA</option>


</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eperfil" style="display:none">Por favor, selecione o perfil!</span>

</td>
</tr>

<input type="hidden" value="" name="grupo" id="grupo">

<tr id="tr-planotv-fidelidade" style="display:none;">
<td>Fidelidade</td>
<td>
<select name="planotv-fidelidade" id="planotv-fidelidade">
	
	<option value=""></option>
	<option value="SEM FIDELIDADE">SEM FIDELIDADE</option>
	<option value="12 MESES">12 MESES</option>

</select>
</td>
</tr>

<tr align="left" id="tr-planotv">
<td>Plano Tv:</td>
<td>

<select name="planotv" id="planotv">

<option value=""></option>

<!--  PLANOS COLETIVOS -->

<option value="NET Top HD Cinema Futebol" data-grupo="GP3">NET Top HD Cinema Futebol</option>
<option value="NET Top HD Telecine Futebol" data-grupo="GP3">NET Top HD Telecine Futebol</option>
<option value="NET Top HD HBO Futebol" data-grupo="GP3">NET Top HD HBO Futebol</option>
<option value="NET Top HD Cinema Futebol" data-grupo="GP3">NET Top HD Cinema Futebol</option>
<option value="NET Top HD Futebol" data-grupo="GP3">NET Top HD Futebol</option>
<option value="NET Top HD Telecine" data-grupo="GP3">NET Top HD Telecine</option>
<option value="NET Top HD HBO" data-grupo="GP3">NET Top HD HBO</option>
<option value="NET Top HD HBO 4" data-grupo="GP3">NET Top HD HBO 4</option>
<option value="NET Top HD" data-grupo="GP3">NET Top HD</option>
<option value="NET Mais HD Cinema Futebol" data-grupo="GP2">NET Mais HD Cinema Futebol</option>
<option value="NET Mais HD Telecine Futebol" data-grupo="GP2">NET Mais HD Telecine Futebol</option>
<option value="NET Mais HD HBO Futebol" data-grupo="GP2">NET Mais HD HBO Futebol</option>
<option value="NET Mais HD Cinema" data-grupo="GP2">NET Mais HD Cinema</option>
<option value="NET Mais HD Futebol" data-grupo="GP2">NET Mais HD Futebol</option>
<option value="NET Mais HD Telecine" data-grupo="GP2">NET Mais HD Telecine</option>
<option value="NET Mais HD HBO" data-grupo="GP2">NET Mais HD HBO</option>
<option value="NET Mais HD HBO 4" data-grupo="GP2">NET Mais HD HBO 4</option>
<option value="NET Mais HD" data-grupo="GP2">NET Mais HD</option>
<option value="NET Essencial HD Cinema Futebol" data-grupo="GP2">NET Essencial HD Cinema Futebol</option>
<option value="NET Essencial HD Telecine Futebol" data-grupo="GP2">NET Essencial HD Telecine Futebol</option>
<option value="NET Essencial HD HBO Futebol" data-grupo="GP2">NET Essencial HD HBO Futebol</option>
<option value="NET Essencial HD Cinema" data-grupo="GP2">NET Essencial HD Cinema</option>
<option value="NET Essencial HD Futebol" data-grupo="GP2">NET Essencial HD Futebol</option>
<option value="NET Essencial HD Telecine" data-grupo="GP2">NET Essencial HD Telecine</option>
<option value="NET Essencial HD HBO" data-grupo="GP2">NET Essencial HD HBO</option>
<option value="NET Essencial HD HBO 4" data-grupo="GP2">NET Essencial HD HBO 4</option>
<option value="NET Essencial HD" data-grupo="GP2">NET Essencial HD</option>

<!-- ** fim PLANOS COLETIVOS -->


<option value="NET Top HD Max Cinema Fut" data-grupo="GP3">NET Top HD Max Cinema Fut</option>
<option value="NET Top HD Max HBO Futebol" data-grupo="GP3">NET Top HD Max HBO Futebol</option>
<option value="NET Top HD Max Cinema" data-grupo="GP3">NET Top HD Max Cinema</option>
<option value="NET Top HD Max Futebol" data-grupo="GP3">NET Top HD Max Futebol</option>
<option value="NET Top HD Max Telecine" data-grupo="GP3">NET Top HD Max Telecine</option>
<option value="NET Top HD Max HBO" data-grupo="GP3">NET Top HD Max HBO</option>
<option value="NET Top HD Max" data-grupo="GP3">NET Top HD Max</option>
<option value="NET Top HD Cinema Futebol" data-grupo="GP3">NET Top HD Cinema Futebol</option>
<option value="NET Top HD Telecine Futebol" data-grupo="GP3">NET Top HD Telecine Futebol</option>
<option value="NET Top HD HBO Futebol" data-grupo="GP3">NET Top HD HBO Futebol</option>
<option value="NET Top HD Cinema" data-grupo="GP3">NET Top HD Cinema</option>
<option value="NET Top HD Futebol" data-grupo="GP3">NET Top HD Futebol</option>
<option value="NET Top HD Telecine" data-grupo="GP3">NET Top HD Telecine</option>
<option value="NET Top HD HBO" data-grupo="GP3">NET Top HD HBO</option>
<option value="NET Top HD" data-grupo="GP3">NET Top HD</option>
<option value="NET Mais HD Cinema Futebol" data-grupo="GP2">NET Mais HD Cinema Futebol</option>
<option value="NET Mais HD Telecine Futebol" data-grupo="GP2">NET Mais HD Telecine Futebol</option>
<option value="NET Mais HD HBO Futebol" data-grupo="GP2">NET Mais HD HBO Futebol</option>
<option value="NET Mais HD Cinema" data-grupo="GP2">NET Mais HD Cinema</option>
<option value="NET Mais HD Futebol" data-grupo="GP2">NET Mais HD Futebol</option>
<option value="NET Mais HD Telecine" data-grupo="GP2">NET Mais HD Telecine</option>
<option value="NET Mais HD HBO" data-grupo="GP2">NET Mais HD HBO</option>
<option value="NET Mais HD" data-grupo="GP2">NET Mais HD</option>
<option value="NET Essencial HD Cinema Futebol" data-grupo="GP2">NET Essencial HD Cinema Futebol</option>
<option value="NET Essencial HD Telecine Futebol" data-grupo="GP2">NET Essencial HD Telecine Futebol</option>
<option value="NET Essencial HD HBO Futebol" data-grupo="GP2">NET Essencial HD HBO Futebol</option>
<option value="NET Essencial HD Futebol" data-grupo="GP2">NET Essencial HD Futebol</option>
<option value="NET Essencial HD Cinema" data-grupo="GP2">NET Essencial HD Cinema</option>
<option value="NET Essencial HD Telecine" data-grupo="GP2">NET Essencial HD Telecine</option>
<option value="NET Essencial HD HBO" data-grupo="GP2">NET Essencial HD HBO</option>
<option value="NET Essencial HD" data-grupo="GP2">NET Essencial HD</option>
<option value="NET Fácil HD Telecine Light" data-grupo="GP1">NET Fácil HD Telecine Light</option>
<option value="NET Fácil HD HBO Light" data-grupo="GP1">NET Fácil HD HBO Light</option>
<option value="NET Fácil HD" data-grupo="GP1">NET Fácil HD</option>
<option value="NET Fácil Telecine Light" data-grupo="GP1">NET Fácil Telecine Light</option>
<option value="NET Fácil HBO Light" data-grupo="GP1">NET Fácil HBO Light</option>
<option value="NET Fácil" data-grupo="GP1">NET Fácil</option>

</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eplanotv" style="display:none">Por favor, selecione o plano de TV!</span>

</td>
</tr>

<tr align="left" style="display:none;" id="tr-label-pontos-adicionais">
<td></td>
<td class="label-pontos-adicionais"></td>
</tr>

<tr align="left" style="display:none;" id="tr-pontos-adicionais">
<td>Pontos Adicionais:</td>
<td>
<input type="radio" id="ponto1" name="pontos" value="0" /> 0 &nbsp;
<input type="radio" id="ponto2" name="pontos" value="1" /> 1 &nbsp;
<input type="radio" id="ponto3" name="pontos" value="2" /> 2 &nbsp;
<input type="radio" id="ponto3" name="pontos" value="3" /> 3 &nbsp;
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="epontos" style="display:none">Por favor, selecione o número de pontos adicionais!</span>

</td>
</tr>

<tr id="tr-planotv-info" class="infobox" style="display:none;">
<td>&nbsp;</td>
<td id="planotv-info"></td>
</tr>

<tr align="left" id="tr-portabilidade">
<td>Portabilidade:</td>
<td>
<select name="portabilidade" id="portabilidade">
<option value=""></option>
<option value="SIM">Sim</option>
<option value="NAO">Não</option>
</select>
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eportabilidade" style="display:none">Por favor, selecione a portabilidade!</span>
</td>
</tr>

<tr align="left" id="tr-operadoraportada" style="display:none">
<td>Operadora:</td>
<td>
	<select name="operadoraportada" id="operadoraportada">

		<option value=""></option>
		<option value="CLARO">CLARO</option>
		<option value="VIVO">VIVO</option>
		<option value="TIM">TIM</option>
		<option value="OI">OI</option>

	</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eoperadoraportada" style="display:none">Por favor,informe a antiga operadora!</span>
</td>
</tr>

<tr align="left" id="tr-numeroportado" style="display:none">
<td>Número Portado:</td>
<td>
<input type="text" name="numeroportado" value="" onKeyPress="mascara(this,telefone)" maxlength="15" size="20">
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="enumeroportado" style="display:none">Por favor,informe o número portado!</span>
</td>
</tr>

<tr align="left" id="tr-operadoraportadamovel" style="display:none">
<td>Operadora Móvel:</td>
<td>
	<select name="operadoraportadamovel" id="operadoraportadamovel">

		<option value=""></option>
		<option value="CLARO">CLARO</option>
		<option value="VIVO">VIVO</option>
		<option value="TIM">TIM</option>
		<option value="OI">OI</option>

	</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eoperadoraportadamovel" style="display:none">Por favor,informe a antiga operadora móvel!</span>
</td>
</tr>

<tr align="left" id="tr-numeroportadomovel" style="display:none">
<td>Nº Portado Movel:</td>
<td>
<input type="text" name="numeroportadomovel" value="" onKeyPress="mascara(this,telefone)" maxlength="15" size="20">
<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="enumeroportadomovel" style="display:none">Por favor,informe o número portado móvel!</span>
</td>
</tr>

<tr align="left" id="tr-planofone">
<td>Plano Fone:</td>
<td>

<select name="planofone" id="planofone">

<option value=""></option>
<option value="FALE DO SEU JEITO">FALE DO SEU JEITO</option>
<option value="FALE ILIMITADO">FALE ILIMITADO</option>
<option value="FALE ESSENCIAL">FALE ESSENCIAL</option>
<option value="FALE SIMPLES">FALE SIMPLES</option>

</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eplanofone" style="display:none">Por favor, selecione o plano de Telefone!</span>

</td>
</tr>

<tr id="tr-planofone-info" class="infobox" style="display:none;">
<td>&nbsp;</td>
<td id="planofone-info"></td>
</tr>

<tr align="left" id="tr-planocelular">
<td>Plano Celular:</td>
<td>

<select name="planocelular" id="planocelular">

<option value=""></option>
<option value="MULTI 60" data-valor-plano="108,90">MULTI 60</option>
<option value="MULTI 100" data-valor-plano="126,90">MULTI 100</option>
<option value="MULTI 200" data-valor-plano="209,90">MULTI 200</option>
<option value="MULTI 600" data-valor-plano="342,90">MULTI 600</option>
<option value="MULTI 1200" data-valor-plano="525,90">MULTI 1200</option>

</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eplanocelular" style="display:none">Por favor, selecione o plano de Celular!</span>

</td>
</tr>

<tr align="left" id="tr-planonet">
<td>Plano Virtua:</td>
<td>

<select name="planonet" id="planonet">

<option value=""></option>
<option value="10 MB">10 MB</option>
<option value="30 MB">30 MB</option>
<option value="60 MB">60 MB</option>
<option value="120 MB">120 MB</option>

</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="eplanonet" style="display:none">Por favor, selecione o plano de Internet!</span>

</td>
</tr>

<tr id="tr-planonet-info" class="infobox" style="display:none;">
<td>&nbsp;</td>
<td id="planonet-info"></td>
</tr>

<tr align="left" id="tr-agregados">
<td>Pact. Agregados:</td>
<td>

<select name="agregados" id="agregados">

<option value=""></option>
<option value="PREMIER FUTEBOL CLUBE">PREMIER FUTEBOL CLUBE</option>
<option value="1 CANAL ADULTO">1 CANAL ADULTO</option>
<option value="1 CANAL ADULTO FOR MAN">1 CANAL ADULTO FOR MAN</option>
<option value="2 CANAIS ADULTOS">2 CANAIS ADULTOS</option>
<option value="5 CANAIS ADULTOS">5 CANAIS ADULTOS</option>
<option value="6 CANAIS ADULTOS">6 CANAIS ADULTOS</option>
<option value="COMBATE">COMBATE</option>
<option value="NOTÍCIAS">NOTÍCIAS</option>
<option value="ESPORTES">ESPORTES</option>

</select>

<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<span class="erro" id="efilial" style="display:none">Por favor, preencha esta campo!</span>

</td>
</tr>

<tr align="left">
<td>Data Venda:</td>
<td><input type="text" id="calendario2" name="idata" onKeyPress="mascara(this,data)" maxlength="10" value="<?= date("d/m/Y");?>" size="20" /> <span style="font-size:12px; color:#999; font-style:italic">(dd/mm/aaaa)</span> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
 <br /> 
<span class="erro" id="evenda" style="display:none">Por favor, selecione a data da venda!</span>
</td>
</tr>
<tr align="left">
<td>Pagamento:</td>
<td>
<select name="pagamento" id="pagamento" onchange="verificapagamento(this.value);">
<option value="BOLETO">BOLETO</option>
<option value="DÉBITO">DÉBITO</option>
<!-- <option value="CARTÃO DE CRÉDITO">CARTÃO DE CRÉDITO</option> -->
</select>
<span class="campoobrigatorio" title="Campo Obrigatório">*</span> 
<span id="infoPagamento"></span>
</td>
</tr>

<tr id="idbanco" style="display:none">
<td>Dados da Conta:</td>
<td>
	Titular: <input type="text" id="titularconta" name="titularconta" size="20" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	CPF: <input type="text" id="titularcontacpf" name="titularcontacpf" onkeypress="mascara(this,cpf)" maxlength="14" size="20" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	<br />
	Banco: <input type="text" id="banco" name="banco" size="20" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	AG: <input type="text" name="agencia" id="agencia" size="5" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	CC: <input type="text" name="contacorrente" id="contacorrente" size="7" /> <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
<br />
<span class="erro" id="ebanco" style="display:none">Por favor, preencha todos os dados da conta do cliente!</span>
 </td>
</tr>


<tr align="left">
<td>Vencimento:</td>
<td>
<input type="radio" id="venci1" name="vencimento" value="5" /> 5
<input type="radio" id="venci2" name="vencimento" value="8" /> 8
<input type="radio" id="venci3" name="vencimento" value="10" /> 10 
<input type="radio" id="venci4" name="vencimento" value="15" /> 15
<input type="radio" id="venci4" name="vencimento" value="20" /> 20 <span class="campoobrigatorio" title="Campo Obrigatório">*</span>
 <span class="erro" id="evencimento" style="display:none">Por favor, selecione uma data de vencimento da fatura!</span>
</td>
</tr>

<tr height="50px" valign="bottom" align="left">
<td></td>
<td><img src="img/salvar.png" style="cursor:pointer" align="absmiddle" onclick="submitform();" /> 
<span class="campoobrigatorio">(*) Campos Obrigatórios!</span>
</td>
</tr>

</table>

</form>
	
</center>	
</center>

<br />
<br />
