<?

// Verificar se est� logado
if(!isset($_SESSION['usuario'])){ ?>
	
<script type="text/javascript">
window.location = 'index.php'
</script>	
	
	
<? } 

if(isset($_POST['nome'])){
		
// Dados do cliente
$pessoa = $_POST['pessoa'];
$nome = $_POST['nome'];
$nome_mae = $_POST['nomemae'];
$nascimento = $_POST['nascd'].'/'.$_POST['nascm'].'/'.$_POST['nasca'];
if($_POST['icpf']){ $cpf = $_POST['icpf'];} else { $cpf = $_POST['icnpj'];}
$rg = $_POST['rg'];
$org_exp = $_POST['orgexp'];
$data_exp0 = explode('/',$_POST['dataexp']);
$data_exp = $data_exp0[2].$data_exp0[1].$data_exp0[0];
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


// Ensere�o Instala��o
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
$oifixo = $_POST['oifixo'];
$telOifixo = $_POST['telOifixo'];
$pagamento = $_POST['pagamento'];

$banco = $_POST['banco'];
$agencia = $_POST['agencia'];
$conta_corrente = $_POST['contacorrente'];

$plano = $_POST['plano'];

$pacotesAdicionais = $_POST['pacAdi1']." | ".$_POST['pacAdi2']." | ".$_POST['pacAdi3']." | ".$_POST['pacAdi4']." | ".$_POST['pacAdi5']." | ".$_POST['pacAdi6']." | ".$_POST['pacAdi7'];

$pacoteEscolha = $_POST['pacEsc'];
$eventosTemporada = $_POST['evTemp'];
$pontos = $_POST['pontos'];
$data0 = explode('/',$_POST['idata']);
$data = $data0[2].$data0[1].$data0[0];
$vencimento = $_POST['vencimento'];
$valor = $_POST['valor'];


$status = "PR�-AN�LISE";

$obs = $_POST['obs'];


$inserir = $conexao->query("INSERT INTO vendas_clarotv (produto,pessoa,nome,nome_mae,nascimento,cpf,rg,org_exp,data_exp,profissao,sexo,estado_civil,email,telefone,tipo_tel1,telefone2,tipo_tel2,telefone3,tipo_tel3,endereco,numero,lote,quadra,complemento,bairro,cidade,uf,cep,ponto_referencia,operador,monitor,oifixo,telOifixo,pagamento,banco,agencia,conta_corrente,plano,pacotes_e_canais_adicionais,pacoteEscolha,eventosTemporada,pontos,data,data_venda,vencimento,valor,status,obs) VALUES ('".$_POST['produto']."','".$pessoa."','".$nome."','".$nome_mae."','".$nascimento."','".$cpf."','".$rg."','".$org_exp."','".$data_exp."','".$profissao."','".$sexo."','".$estado_civil."','".$email."','".$telefone."','".$tipo_tel1."','".$telefone2."','".$tipo_tel2."','".$telefone3."','".$tipo_tel3."','".$endereco."','".$numero."','".$lote."','".$quadra."','".$complemento."','".$bairro."','".$cidade."','".$uf."','".$cep."','".$ponto_referencia."','".$operador."','".$monitor."','".$oifixo."','".$telOifixo."','".$pagamento."','".$banco."','".$agencia."','".$conta_corrente."','".$plano."','".$pacotesAdicionais."','".$pacoteEscolha."','".$eventosTemporada."','".$pontos."','".$data."','".$data."','".$vencimento."','".$valor."','".$status."','".$obs."')") or die('Ocorreu um Erro ao inserir os dados!');


//LOG

$datadehoje = date("Y-m-d H:i:s");
$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$datadehoje."','".$_SESSION['usuario']."','Inseriu um novo dado no sistema.')");

?>

<script type="text/javascript">

window.alert("Cadastro efetuado com sucesso!");
window.location = '?p=inserir-dados-oi&i=<?= $_POST['redir'];?>';


</script>


<?

}

?>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>
<script type="text/javascript" src="js/calendario.js"></script>
<script type="text/javascript" src="js/cep.js"></script>
<script type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type=text/css href="css/ui-lightness/jquery-ui-1.7.3.custom.css" />
<script type="text/javascript">


//////////////////////////////
/////// ESCOLHER PRODUTO ////
////////////////////////////

function escolherproduto(p){
    
if(p == '4'){ produto = 'Oi TV'; include = 'includes/oi/inserir-oi-tv.php';}
else if(p == '5'){ produto = 'Oi Fixo'}
else if(p == '6'){ produto = 'Oi Velox'; include = 'includes/oi/inserir-oi-velox.php';}    
    
document.getElementById('escolherproduto').innerHTML = produto;
    
$('#logo-produto').animate({left:'10%'},1000);
$('#logo-produto img').animate({width:'60px'},1000);

$('#escolherproduto').animate({paddingTop:'10px',paddingBottom:'10px'},1000, function(){
    
	$('#tabelaproduto').load(include);    
    $('#table').fadeIn(1000);
    
    }); 
   
}


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
	
	    function cnpj(v){
        //Remove tudo o que n�o � d�gito
        v=v.replace(/\D/g,"");
        //Coloca par�nteses em volta dos dois primeiros d�gitos
        v=v.replace(/^(\d{2})(\d)/g,"$1.$2");
        //Coloca h�fen entre o quarto e o quinto d�gitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2");
        //retorne o resultado
		v=v.replace(/(\d{3})(\d)/,"$1/$2");
        //retorne o resultado
		v=v.replace(/(\d{4})(\d)/,"$1-$2");
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
	
    function data(v){
        //Remove tudo o que n�o � d�gito
        v=v.replace(/\D/g,"");
        //Coloca par�nteses em volta dos dois primeiros d�gitos
        v=v.replace(/^(\d{2})(\d)/g,"$1/$2");
        //Coloca h�fen entre o quarto e o quinto d�gitos
        v=v.replace(/(\d{2})(\d)/,"$1/$2");
        return v;
    }	





function verificapessoa(v){
	
if(v == 'Pessoa Jur�dica') {
	
     document.getElementById('nomel').innerHTML = 'Raz�o Social:';
     document.getElementById('nomemael').style.display = 'none';
     document.getElementById('cpfl').style.display = 'none';
	 document.getElementById('idcpf').value = '';
     document.getElementById('cnpjl').style.display = '';
	 
	 document.getElementById('inpnasc').style.display = 'none';
	 document.getElementById('inprg').style.display = 'none';
	 document.getElementById('inpprofissao').style.display = 'none';
	 document.getElementById('inpsexo').style.display = 'none';
	 document.getElementById('inpestadocivil').style.display = 'none';
	 
} else if(v == 'Pessoa F�sica') {
	
     document.getElementById('nomel').innerHTML = 'Nome:';
     document.getElementById('nomemael').style.display = '';	 
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


function submitform(pro){
	
	
e=0;

/////// -- DADOS PESSOAIS -- ////////
if(!document.getElementById('pessoa1').checked && !document.getElementById('pessoa2').checked){ document.getElementById('epessoa').style.display = ''; e=(e+1)} else { document.getElementById('epessoa').style.display = 'none';}

if(document.getElementById('nome').value == ''){ document.getElementById('enome').style.display = ''; e=(e+1)} else { document.getElementById('enome').style.display = 'none';}	

	
//if(document.getElementById('idcpf').value == '' && document.getElementById('idcnpj').value == ''){ document.getElementById('ecpf').style.display = ''; e=(e+1)} else { document.getElementById('ecpf').style.display = 'none';}

//if(document.getElementById('idcpf').value == '' && document.getElementById('idcnpj').value == '' && document.getElementById('pessoa2').checked){ document.getElementById('ecnpj').style.display = ''; e=(e+1)} else { document.getElementById('ecnpj').style.display = 'none';}


if(!document.getElementById('pessoa2').checked){
	
if(document.getElementById('nomemae').value == ''){ document.getElementById('enomemae').style.display = ''; e=(e+1)} else { document.getElementById('enomemae').style.display = 'none';}
	
if(document.getElementById('nascd').value == '' || document.getElementById('nascm').value == '' || document.getElementById('nasca').value == ''){ document.getElementById('enasc').style.display = ''; e=(e+1)} else { document.getElementById('enasc').style.display = 'none';}	

//if(document.getElementById('rg').value == '' || document.getElementById('orgexp').value == ''){ document.getElementById('erg').style.display = ''; e=(e+1)} else { document.getElementById('erg').style.display = 'none';}

if(document.getElementById('profissao').value == ''){ document.getElementById('eprofissao').style.display = ''; e=(e+1)} else { document.getElementById('eprofissao').style.display = 'none';}

if(!document.getElementById('sexo1').checked && !document.getElementById('sexo2').checked){ document.getElementById('esexo').style.display = ''; e=(e+1)} else { document.getElementById('esexo').style.display = 'none';}

if(document.getElementById('estadocivil').value == ''){ document.getElementById('eestadocivil').style.display = ''; e=(e+1)} else { document.getElementById('eestadocivil').style.display = 'none';}

if(document.getElementById('estadocivil').value == ''){ document.getElementById('eestadocivil').style.display = ''; e=(e+1)} else { document.getElementById('eestadocivil').style.display = 'none';}


}


if(document.getElementById('email').value == ''){ document.getElementById('eemail').style.display = ''; e=(e+1)} else { document.getElementById('eemail').style.display = 'none';}

if(document.getElementById('tel1').value == ''){ document.getElementById('etelefone').style.display = ''; e=(e+1)} else { document.getElementById('etelefone').style.display = 'none';}



/////// -- ENDERE�O CLIENTE -- ////////

if(document.getElementById('endereco').value == '' || document.getElementById('numero').value == ''){ document.getElementById('eendereco').style.display = ''; e=(e+1)} else { document.getElementById('eendereco').style.display = 'none';}		
	
if(document.getElementById('bairro').value == ''){ document.getElementById('ebairro').style.display = ''; e=(e+1)} else { document.getElementById('ebairro').style.display = 'none';}

if(document.getElementById('uf').value == ''){ document.getElementById('euf').style.display = ''; e=(e+1)} else { document.getElementById('euf').style.display = 'none';}	

if(document.getElementById('cidade').value == ''){ document.getElementById('ecidade').style.display = ''; e=(e+1)} else { document.getElementById('ecidade').style.display = 'none';}	

//if(document.getElementById('idcep').value == ''){ document.getElementById('ecep').style.display = ''; e=(e+1)} else { document.getElementById('ecep').style.display = 'none';}	


/////// -- DADOS DA VENDA -- ////////


if(document.getElementById('operador').value == ''){ document.getElementById('eoperador').style.display = ''; e=(e+1)} else { document.getElementById('eoperador').style.display = 'none';}	

if(document.getElementById('monitor').value == ''){ document.getElementById('emonitor').style.display = ''; e=(e+1)} else { document.getElementById('emonitor').style.display = 'none';}	

if(document.getElementById('plano').value == ''){ document.getElementById('eplano').style.display = ''; e=(e+1)} else { document.getElementById('eplano').style.display = 'none';}	

if(document.getElementById('calendario2').value == ''){ document.getElementById('evenda').style.display = ''; e=(e+1)} else { document.getElementById('evenda').style.display = 'none';}

/*	
if( document.getElementById('pagamento').value == 'D�BITO' && (document.getElementById('idbanco').value == '' || document.getElementById('agencia').value == '' || document.getElementById('contacorrente').value == '')){ document.getElementById('ebanco').style.display = ''; e=(e+1)} else { document.getElementById('ebanco').style.display = 'none';}
	
if(!document.getElementById('venci1').checked && !document.getElementById('venci2').checked && !document.getElementById('venci3').checked && !document.getElementById('venci4').checked ){ document.getElementById('evencimento').style.display = ''; e=(e+1)} else { document.getElementById('evencimento').style.display = 'none';}
	*/


/////// -- VERIFICAR SE EXISTEM ERROS -- ////////

if(e != '0')
 {  
	window.alert('ERRO: Preencha todos os campos indicados, corretamente'); 
    $('body,html').animate({scrollTop: 150}, 800);
		  
 } else { 
 	
	document.getElementById('redir').value = pro;
	document.forms.inserirtv.submit(); 
		
		}
	
}


///////////////////////////////////
///////// CHECAR PROPOSTA////////
/////////////////////////////////

function checkcpf(c){
	
	
	$('#loadcpf').load('check-cpf-oi.php?c='+c);
	
	
	}
	
function checkoperador(m){
	
	
	$('.loadoperadores').load('check-operadores.php?m='+m+'&g=0004');
	
	
	}
	
function checkcidades(uf,cidade){
	
	
	$('#loadcidades').load('check-cidades.php?uf='+uf+'&c='+cidade);
	
	
	
	}	
	

$(document).ready(function(e) {
	
	checkoperador();
	checkcidades();
	escolherproduto('<?= $_GET['i'];?>');
	
	});
	
$(document).ready(function(e) {
    

  $('#oifixo').change(function() {

    val = this.value;

        if(val == 'SIM'){
        
           $('#TRnum').fadeIn(800);

        }

        else{
        
           $('#TRnum').fadeOut(800);

        }
 
    }); 
  
 }); 	


</script>




<style type="text/css">

.erro{color:#C00; font-size:12px;}

#escolherproduto{ position:relative; width:1000px; padding-top:27px; padding-bottom:25px; font-size:18px; color:#000; font-weight:bold; cursor:default; background: #00dee1; /* Old browsers */
/* IE9 SVG, needs conditional override of 'filter' to 'none' */
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPHJhZGlhbEdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgY3g9IjUwJSIgY3k9IjUwJSIgcj0iNzUlIj4KICAgIDxzdG9wIG9mZnNldD0iNyUiIHN0b3AtY29sb3I9IiMwMGRlZTEiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSI2NyUiIHN0b3AtY29sb3I9IiMwMGFmYjMiIHN0b3Atb3BhY2l0eT0iMSIvPgogICAgPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjMDA2YzcxIiBzdG9wLW9wYWNpdHk9IjEiLz4KICA8L3JhZGlhbEdyYWRpZW50PgogIDxyZWN0IHg9Ii01MCIgeT0iLTUwIiB3aWR0aD0iMTAxIiBoZWlnaHQ9IjEwMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-radial-gradient(center, ellipse cover,  #00dee1 7%, #00afb3 67%, #006c71 100%); /* FF3.6+ */
background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(7%,#00dee1), color-stop(67%,#00afb3), color-stop(100%,#006c71)); /* Chrome,Safari4+ */
background: -webkit-radial-gradient(center, ellipse cover,  #00dee1 7%,#00afb3 67%,#006c71 100%); /* Chrome10+,Safari5.1+ */
background: -o-radial-gradient(center, ellipse cover,  #00dee1 7%,#00afb3 67%,#006c71 100%); /* Opera 12+ */
background: -ms-radial-gradient(center, ellipse cover,  #00dee1 7%,#00afb3 67%,#006c71 100%); /* IE10+ */
background: radial-gradient(ellipse at center,  #00dee1 7%,#00afb3 67%,#006c71 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00dee1', endColorstr='#006c71',GradientType=1 ); /* IE6-8 fallback on horizontal gradient */

-moz-user-select: none; 
        -khtml-user-select: none; 
        -webkit-user-select: none; 
        -o-user-select: none; 
}


#escolherproduto select{width:200px; height:27px; font-size:14px; color:#ACACAC; -webkit-border-radius: 7px; border-radius: 7px; }

#logo-produto{ position:absolute; top:95px; width:117px; margin: 0 0 0 350px; left:50%;}

.button{ padding:7px; border:1px solid #CCC; color:#777;
 background: #ededed; /* Old browsers */
/* IE9 SVG, needs conditional override of 'filter' to 'none' */
background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIwJSIgeTI9IjEwMCUiPgogICAgPHN0b3Agb2Zmc2V0PSI4JSIgc3RvcC1jb2xvcj0iI2ZmZmZmZiIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjUzJSIgc3RvcC1jb2xvcj0iI2ZjZmNmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgICA8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlZGVkZWQiIHN0b3Atb3BhY2l0eT0iMSIvPgogIDwvbGluZWFyR3JhZGllbnQ+CiAgPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNncmFkLXVjZ2ctZ2VuZXJhdGVkKSIgLz4KPC9zdmc+);
background: -moz-linear-gradient(top,  #ffffff 8%, #fcfcfc 53%, #ededed 100%); /* FF3.6+ */
background: -webkit-gradient(linear, left top, left bottom, color-stop(8%,#ffffff), color-stop(53%,#fcfcfc), color-stop(100%,#ededed)); /* Chrome,Safari4+ */
background: -webkit-linear-gradient(top,  #ffffff 8%,#fcfcfc 53%,#ededed 100%); /* Chrome10+,Safari5.1+ */
background: -o-linear-gradient(top,  #ffffff 8%,#fcfcfc 53%,#ededed 100%); /* Opera 11.10+ */
background: -ms-linear-gradient(top,  #ffffff 8%,#fcfcfc 53%,#ededed 100%); /* IE10+ */
background: linear-gradient(to bottom,  #ffffff 8%,#fcfcfc 53%,#ededed 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 ); /* IE6-8 */
}

.button:hover{ border:1px solid #AAA; color:#434343; cursor:pointer;}

.button:active{ background:#ededed;}

#tabelaproduto{position:relative; display:table;}
</style>

<!-- SUBMENU -->
<? include "submenu-oi.php";?>
<!-- FIM DO SUBMENU -->

<center>

<table border="0" width="1000px">

<tr valign="bottom" height="40px" align="left">
<td style="font-size:14px; color:#999;">NOVA VENDA</td>
</tr>

<tr>
<td><hr size="1" color="#CCCCCC" /></td>
</tr>

</table>

<div id="escolherproduto">
Escolha um produto:
<select name="produto" onchange="escolherproduto(this.value)">
<option value=""></option>
<option value="4">Oi TV</option>
<option value="5">Oi Fixo</option>
<option value="6">Oi Velox</option>
</select>
</div>

<div id="logo-produto">
<img src="img/logo-oi.png" />
</div>

<br />
<br />

<center>

<form name="inserirtv" action="" method="post"> 



<table border="0" width="850px" id="table" style="display:none">

<tr align="left">
<td>Monitor:</td>
<td>
<select type="text" id="monitor" name="monitor" onchange="checkoperador(this.value)">
<option value=""></option>
<? $conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE tipo_usuario = 'MONITOR' && grupo LIKE '%0004%'");
   while($MONITORES = mysql_fetch_array($conMONITORES)){
?>
<option value="<?= $MONITORES['id']?>"><?= $MONITORES['nome']?></option>
<? } ?>
</select> 
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="emonitor" style="display:none">Por favor, selecione o monitor respons�vel pelo operador que fez a venda!</span>
</td>
</tr>

<tr align="left">
<td>Operador:</td>
<td>
<div class="loadoperadores" style="position:relative"></div>
</td>
</tr>

<tr height="30px" valign="bottom" align="left">
<td style="color:#069; font-size:12px">Dados do Cliente</td>
</tr>

<tr align="left">
<td>Tipo:</td>
<td>
<input type="radio" name="pessoa" id="pessoa1" value="Pessoa F�sica" onchange="verificapessoa(this.value)" /> Pessoa F�sica
<input type="radio" name="pessoa" id="pessoa2" value="Pessoa Jur�dica" onchange="verificapessoa(this.value)" /> Pessoa Jur�dica
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="epessoa" style="display:none">Por favor, selecione o tipo do cliente!</span>
</td>
</tr>

<tr align="left">
<td id="nomel">Nome:</td>
<td><input type="text" id="nome" name="nome" size="40" />
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="enome" style="display:none">Por favor, digite o nome do cliente!</span>
</td>
</tr>

<tr align="left" id="inpnasc">
<td>Nascimento:</td>
<td>

<select name="nascd" id="nascd">
<option value=""></option>
<? $d = 1; while($d <= 31){ $dn = $d++;?>
<option value="<?= sprintf("%02d", $dn); ?>"> <?= sprintf("%02d", $dn); ?></option>
<? } ?>
</select>

<select name="nascm" id="nascm">
<option value=""></option>
<? $m = 1; while($m <= 12){ $mn = $m++;?>
<option value="<?= sprintf("%02d", $mn); ?>"> <?= sprintf("%02d", $mn); ?></option>
<? } ?>
</select>

<select name="nasca" id="nasca">
<option value=""></option>
<? $a = (date('Y')-18); while($a > 1900){ $an = $a--;?>
<option value="<?= $an; ?>"> <?= $an; ?></option>
<? } ?>
</select>
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="enasc" style="display:none">Por favor, selecione uma data de nascimento v�lida!</span>
</td>
</tr>


<tr align="left" id="cpfl">
<td>CPF:</td>
<td id="cpfinp"><input type="text" id="idcpf" name="icpf" onKeyPress="mascara(this,cpf)" maxlength="14" size="20" />
<span class="erro" id="ecpf" style="display:none">Por favor, digite o CPF do cliente!</span>
</td>
</tr>


<tr align="left" id="cnpjl" style="display:none">
<td>CNPJ:</td>
<td id="cpfinp"><input type="text" id="idcnpj" name="icnpj" onKeyPress="mascara(this,cnpj)" maxlength="18" size="20" />
<span class="erro" id="ecnpj" style="display:none">Por favor, digite o CNPJ do cliente!</span>
</td>
</tr>


<tr align="left" id="inprg">
<td>RG:</td>
<td id="rginp"><input type="text" id="rg" name="rg" size="20" /> Org. Exp: <input type="text" title="Org�o Expedidor" id="orgexp" name="orgexp" size="20" />
<span class="erro" id="erg" style="display:none">Por favor, digite o RG do cliente!</span>
</td>
</tr>


<tr align="left">
<td>Nome da M�e:</td>
<td><input type="text" id="nomemae" name="nomemae" size="40" />
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="enomemae" style="display:none">Por favor, digite o nome da m�e do cliente!</span>
</td>
</tr>

<tr align="left" id="inpprofissao">
<td class="t1">Profiss�o:</td>
<td><input type="text" name="profissao" id="profissao" size="50" /> 
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span> 
<span class="erro" id="eprofissao" style="display:none">Por favor, preencha a profiss�o do cliente!</span></td>
</tr>

<tr align="left" id="inpsexo">
<td class="t1">Sexo:</td>
<td><input type="radio" name="sexo" id="sexo1" value="Masculino" /> Masculino <input type="radio" name="sexo" id="sexo2" value="Feminino" /> Feminino
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
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
<option value="Vi�vo">Vi�vo</option> 
</select>
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="eestadocivil" style="display:none">Por favor, selecione o Estado Civil do cliente!</span>
</td>
</tr>


<tr align="left">
<td>Email:</td>
<td><input type="text" id="email" name="email"  size="30" />
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
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
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="etelefone" style="display:none">Por favor, digite pelo menos um telefone do cliente!</span>
</td>
</tr>

<tr align="left">
<td>Telefone 2:</td>
<td><input type="text" name="itelefone2" onKeyPress="mascara(this,telefone)" maxlength="15" size="20" /> 
<select name="tipotel2">
<option value="Residencial">Residencial</option> 
<option value="Celular" selected="selected">Celular</option>
<option value="Comercial">Comercial</option>
</select>
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
<td style="color:#069; font-size:12px">Endere�o de Instala��o</td>
</tr>

<tr align="left">
<td>CEP:</td>
<td><input type="text" id="idcep" name="icep" size="30" onkeyup="return getEndereco()" onchange="return getEndereco()" onKeyPress="mascara(this,cep)" maxlength="9" > <span class="erro" id="ecep" style="display:none">Por favor, digite o CEP da instala��o!</span></td>
</tr>

<tr align="left">
<td>Endere�o:</td>
<td><input type="text" id="endereco" name="endereco" size="40" > <span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
 N�: <input type="text" name="numero" id="numero" size="5" /> <span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
 Lote: <input type="text" name="lote" id="lote" size="5" /> 
 Quadra: <input type="text" name="quadra" id="quadra" size="5" /> <br /> 
 <span class="erro" id="eendereco" style="display:none">Por favor, digite pelo menos o logradouro e o n�mero do endere�o de instala��o!</span>
 </td>
</tr>

<tr align="left">
<td>Complemento:</td>
<td><input type="text" id="complemento" name="complemento" size="30" ></td>
</tr>

<tr align="left">
<td>Bairro:</td>
<td><input type="text" id="bairro" name="bairro" size="30" > 
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="ebairro" style="display:none">Por favor, digite o bairro da instala��o!</span></td>
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
<span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>
<span class="erro" id="euf" style="display:none">Por favor, selecione o estado da instala��o!</span>
</td>
</tr>

<tr align="left">
<td>Cidade:</td>
<td>
<input type="text" id="cidade" name="cidade" size="30" /> <span class="campoobrigatorio" title="Campo Obrigat�rio">*</span>

<span class="erro" id="ecidade" style="display:none">Por favor, selecione a cidade da instala��o!</span></td>
</tr>

<tr align="left">
<td>Ponto de Refer�ncia:</td>
<td><textarea name="pontoref" rows="3" cols="30"></textarea>
</td>
</tr>

<tr height="30px" valign="bottom" align="left">
<td style="color:#069; font-size:12px">Dados da Venda</td>
</tr>



<tr><td colspan="2">
<div id="tabelaproduto"></div>
</td></tr>



</table>
</form>

</center>
</center>

<br />
<br />
