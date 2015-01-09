<?
include_once "lib/class.Usuarios.php";
include_once "lib/class.VentoAdmin.php";
include_once "lib/class.Venda.php";
include_once "lib/class.VendaStatus.php";
include_once "lib/class.ProtectionAgendamento.php";

class DateT2ime {
	
	public function __construct(){
		echo "a";
	}
	
}
include_once "includes/protectionGlobalsVars.php";

// Verificar se está logado

if(!isset($_SESSION['usuario'])){ ?>


<script type="text/javascript">

<!-- window.location = 'index.php' -->

</script>	

	

	

<? } 



$campo = simplexml_load_file("xml/campos.xml");





if($_GET['me'] != "" && $_GET['me'] != "todos"){ $mes = $_GET['me']; } else if($_GET['me'] == "todos"){ $mes = "";} else if($_GET['me'] == ""){$mes = date("m");}



if($_GET['an'] == "todos"){ $ano = "";} else if($_GET['an'] != ""){ $ano = $_GET['an']; } else {$ano = date("Y");}



$ordem = $_GET['o'];



if($ordem == ''){ $ordem = 'data DESC';}



else if($ordem == 'data_marcada ASC'){ $ordem = "(case when reagendamento1 = '' then data_marcada else reagendamento1 end) ASC";}



else if($ordem == 'data_marcada DESC'){ $ordem = "(case when reagendamento1 = '' then data_marcada else reagendamento1 end) DESC";}





if($_GET['v'] != ''){



$v0 = explode('/',$_GET['v']);

$v = $v0[2].$v0[1].$v0[0];



} else {



if($_GET['ve'] == '1' || $_GET['ve'] == ''){	

$v = $ano.$mes;	

}

}





$in0 = explode('/',$_GET['i']);

$in = $in0[2].$in0[1].$in0[0];


$de0 = explode('/',$_GET['de']);

$dataentrega = $de0[2].$de0[1].$de0[0];





///////////////////////////////////////////
//////////////////////////////////////////



if(isset($_POST['chk'])){

	

$set_colunas = $conexao->query("UPDATE usuarios SET colunas_protection = '(".$_POST['chk1'].") (".$_POST['chk2'].") (".$_POST['chk3'].") (".$_POST['chk4'].") (".$_POST['chk5'].") (".$_POST['chk6'].") (".$_POST['chk7'].") (".$_POST['chk8'].") (".$_POST['chk9'].") (".$_POST['chk10'].") (".$_POST['chk11'].") (".$_POST['chk12'].") (".$_POST['chk13'].") (".$_POST['chk14'].") (".$_POST['chk15'].") (".$_POST['chk16'].") (".$_POST['chk17'].") (".$_POST['chk18'].") (".$_POST['chk19'].") (".$_POST['chk20'].") (".$_POST['chk21'].") (".$_POST['chk22'].") (".$_POST['chk23'].") (".$_POST['chk24'].")' WHERE id = '".$USUARIO['id']."'");

?>	



<script type="text/javascript">

window.location = '?p=<?= $_GET['p'];?>'

</script>





<? }?>





<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />



<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>

<script type="text/javascript" src="js/calendario.js"></script>

<script type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.7.3.custom.css" />

<link rel="stylesheet" type="text/css" href="css/tables.css" />

<link rel="stylesheet" type="text/css" href="css/geral.css" />





<script type="text/javascript">

	

	function loadsize(p){

		

	var o = p;	

	$('#pagesize').load('mysql_size.php', 1000, function(p){

	

	var size =  document.getElementById('pagesize').innerHTML;

	

	if(o != ''){

	if(o != size){ document.location.reload(); }

	}

	});

	

	

		}

	



	

</script>







<div id="pagesize" style="display:none"></div>







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

	

    function data(v){

        //Remove tudo o que não é dígito

        v=v.replace(/\D/g,"");

        //Coloca parênteses em volta dos dois primeiros dígitos

        v=v.replace(/^(\d{2})(\d)/g,"$1/$2");

        //Coloca hífen entre o quarto e o quinto dígitos

        v=v.replace(/(\d{2})(\d)/,"$1/$2");

        return v;

    }	

	

	

	

	

function keypressed(){

if(event.keyCode=='13'){document.forms.filtro.submit();}

}	







function mostrarcolunas(){ 



$('#colunas').fadeIn(1); 

$('#blackout').fadeIn(500);	

$('#colunas').animate({left:'50%',opacity:'1'},500);



 }



function escondercolunas(){  $('#colunas').fadeOut(500); $('#blackout').fadeOut(500); $('#colunas').animate({left:'-50%',opacity:'0'},500);

 }





	

</script>





<style type="text/css">



#blackout{position:fixed; top:0px; left:0px; width:100%; height:100%; background-color:#000; z-index:200; opacity: 0.6; display:none; }



#colunas{position:fixed; padding-bottom:20px; width:400px; background-color:#FFF; top:30px; left:-50%; margin: 0 0 0 -200px; z-index:300; display:none; opacity: 0;



-webkit-border-radius: 10px;

border-radius: 10px;



-webkit-box-shadow:  0px 0px 10px 2px #999;

        

box-shadow:  0px 0px 10px 2px #999;

}



.close{position:absolute; right:6px; top:3px; font-size:12px;     background: none repeat scroll 0 0 #B6B6B6;

	border-radius: 15px;

	color: #FFFFFF;

	float: right;

	height: 15px;

	line-height: 15px;

	padding: 3px;

	margin-top:4px;

	text-align: center;

	width: 15px;

	cursor:pointer;}



</style>



<div id="blackout"></div>



<div id="colunas">





<div class="close" onclick="escondercolunas();">X</div>

<table border="0" width="100%">



<tr align="center" height="40px" style="color:#999; font-weight:bold; font-size:14px;">

<td>COLUNAS VISÍVEIS</td>

</tr>

</table>



<center>

<table border="0" width="90%" style="font-size:12px;text-transform:uppercase">

<form name="colunas" method="post">

<input type="hidden" name="chk" />

<tr align="left">


	<td width="50%">
		<input type="checkbox" name="chk1" <? if(strstr($USUARIO['colunas_protection'],'(consultor)')){?>checked="checked"<? } ?> value="consultor" /> Consultor
	</td>

	<td width="50%">
		<input type="checkbox" name="chk2" <? if(strstr($USUARIO['colunas_protection'],'(operador)')){?>checked="checked"<? } ?> value="operador" /> Operador
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk3" <? if(strstr($USUARIO['colunas_protection'],'(nome)')){?>checked="checked"<? } ?> value="nome" /> Cliente
	</td>

	<td width="50%">
		<input type="checkbox" name="chk4" <? if(strstr($USUARIO['colunas_protection'],'(tipoplano)')){?>checked="checked"<? } ?> value="tipoplano" /> Tipo Plano
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk5" <? if(strstr($USUARIO['colunas_protection'],'(telefone)')){?>checked="checked"<? } ?> value="telefone" /> Telefone
	</td>

	<td width="50%">
		<input type="checkbox" name="chk6" <? if(strstr($USUARIO['colunas_protection'],'(cpf)')){?>checked="checked"<? } ?> value="cpf" /> CPF
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk7" <? if(strstr($USUARIO['colunas_protection'],'(cidade)')){?>checked="checked"<? } ?> value="cidade" /> Cidade
	</td>

	<td width="50%">
		<input type="checkbox" name="chk8" <? if(strstr($USUARIO['colunas_protection'],'(cep)')){?>checked="checked"<? } ?> value="cep" /> CEP
	</td>


</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk9" <? if(strstr($USUARIO['colunas_protection'],'(data)')){?>checked="checked"<? } ?> value="data" /> Data da Venda
	</td>


	<td width="50%">
		<input type="checkbox" name="chk10" <? if(strstr($USUARIO['colunas_protection'],'(data_finalizada)')){?>checked="checked"<? } ?> value="data_finalizada" /> Data Finalizada
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk11" <? if(strstr($USUARIO['colunas_protection'],'(protectionVeiculo)')){?>checked="checked"<? } ?> value="protectionVeiculo" /> Tipo Veículo
	</td>

	<td width="50%">
		<input type="checkbox" name="chk12" <? if(strstr($USUARIO['colunas_protection'],'(protectionMarca)')){?>checked="checked"<? } ?> value="protectionMarca" /> Marca
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk13" <? if(strstr($USUARIO['colunas_protection'],'(protectionModelo)')){?>checked="checked"<? } ?> value="protectionModelo" /> Modelo
	</td>

	<td width="50%">
		<input type="checkbox" name="chk14" <? if(strstr($USUARIO['colunas_protection'],'(protectionAnoModelo)')){?>checked="checked"<? } ?> value="protectionAnoModelo" /> Ano/Modelo
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk15" <? if(strstr($USUARIO['colunas_protection'],'(protectionValorVeiculo)')){?>checked="checked"<? } ?> value="protectionValorVeiculo" /> Valor
	</td>

	<td width="50%">
		<input type="checkbox" name="chk16" <? if(strstr($USUARIO['colunas_protection'],'(protectionTxAdesao)')){?>checked="checked"<? } ?> value="protectionTxAdesao" /> Taxa Adesão
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk17" <? if(strstr($USUARIO['colunas_protection'],'(protectionMensalidade)')){?>checked="checked"<? } ?> value="protectionMensalidade" /> Mensalidade
	</td>

	<td width="50%">
		<input type="checkbox" name="chk18" <? if(strstr($USUARIO['colunas_protection'],'(protectionRastreador)')){?>checked="checked"<? } ?> value="protectionRastreador" /> Rastreador
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk19" <? if(strstr($USUARIO['colunas_protection'],'(protectionGnv)')){?>checked="checked"<? } ?> value="protectionGnv" /> GNV
	</td>

	<td width="50%">
		<input type="checkbox" name="chk20" <? if(strstr($USUARIO['colunas_protection'],'(pagamento)')){?>checked="checked"<? } ?> value="pagamento" /> Pagamento
	</td>

</tr>

<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk21" <? if(strstr($USUARIO['colunas_protection'],'(vencimento)')){?>checked="checked"<? } ?> value="vencimento" /> Vencimento
	</td>

	<td width="50%">
		<input type="checkbox" name="chk22" <? if(strstr($USUARIO['colunas_protection'],'(status)')){?>checked="checked"<? } ?> value="status" /> Status
	</td>

</tr>


<tr align="left">

	<td width="50%">
		<input type="checkbox" name="chk23" <? if(strstr($USUARIO['colunas_protection'],'(motivo_cancelamento)')){?>checked="checked"<? } ?> value="motivo_cancelamento" /> Motivo Cancelamento
	</td>

	<td width="50%">
		<input type="checkbox" name="chk24" <? if(strstr($USUARIO['colunas_protection'],'(data_visita)')){?>checked="checked"<? } ?> value="data_visita" /> Data Visita
	</td>

</tr>

<tr align="left" height="40px" valign="bottom">

<td><img src="img/salvar.png" onClick="javascript:document.forms.colunas.submit();" width="100" style="cursor:pointer" /></td>

<td></td>

</tr>

</form>

</table>

</center>





</div>







<!-- SUBMENU -->

<? include "submenu-protection.php";?>

<!-- FIM DO SUBMENU -->







<br />

<br />



<center>







<form name="filtro" method="get">

<table border="0" width="1000px" style="font-size:12px; color:#FFF; font-weight:bold" onmouseover="loadsize(document.getElementById('pagesize').innerHTML);">

<tr>

<td></td>

<td bgcolor="#565656" width="380px" align="center">

<select name="ve" onchange="javascript:document.forms.filtro.submit();">

<option value="1" <? if($_GET['ve'] == '1'){ ?> selected="selected" <? } ?>>Vendas</option>

<option value="2" <? if($_GET['ve'] == '2'){ ?> selected="selected" <? } ?>>Finalizada</option>

</select>

&nbsp; &nbsp;

Mês: 

<select name="me" onchange="javascript:document.forms.filtro.submit();">

<option value="todos">Todos</option>

<option value="01" <? if($mes == '01'){ ?> selected="selected" <? } ?>>JANEIRO</option>

<option value="02" <? if($mes == '02'){ ?> selected="selected" <? } ?>>FEVEREIRO</option>

<option value="03" <? if($mes == '03'){ ?> selected="selected" <? } ?>>MARÇO</option>

<option value="04" <? if($mes == '04'){ ?> selected="selected" <? } ?>>ABRIL</option>

<option value="05" <? if($mes == '05'){ ?> selected="selected" <? } ?>>MAIO</option>

<option value="06" <? if($mes == '06'){ ?> selected="selected" <? } ?>>JUNHO</option>

<option value="07" <? if($mes == '07'){ ?> selected="selected" <? } ?>>JULHO</option>

<option value="08" <? if($mes == '08'){ ?> selected="selected" <? } ?>>AGOSTO</option>

<option value="09" <? if($mes == '09'){ ?> selected="selected" <? } ?>>SETEMBRO</option>

<option value="10" <? if($mes == '10'){ ?> selected="selected" <? } ?>>OUTUBRO</option>

<option value="11" <? if($mes == '11'){ ?> selected="selected" <? } ?>>NOVEMBRO</option>

<option value="12" <? if($mes == '12'){ ?> selected="selected" <? } ?>>DEZEMBRO</option>

</select>

&nbsp; &nbsp;

Ano: 

<select name="an" onchange="javascript:document.forms.filtro.submit();">
<option value="todos" <? if($ano == 'todos'){ ?> selected="selected" <? } ?>>Todos</option>

<? $a = date('Y'); while($a > '2011'){ $an = $a--; ?>



<option value="<?= $an; ?>" <? if($ano == $an){ ?> selected="selected" <? } ?>><?= $an; ?></option>



<? } ?>

</select>

</td>

</tr>

</table>



<table border="0" width="1000px" bgcolor="#f6f6f6" onmouseover="loadsize(document.getElementById('pagesize').innerHTML);">



<input type="hidden" name="p" value="<?= $_GET['p'];?>" />

<input type="hidden" name="o" value="<?= $_GET['o'];?>" />

<input type="hidden" name="m" value="<?= $_GET['m'];?>" />



<tr style="font-size:13px">

<td>Mostrar: <span style=" cursor:pointer; <? if(!$_GET['t'] && !$_GET['f'] && !$_GET['tpentrega'] && !$_GET['s'] && !$_GET['v'] && !$_GET['i'] && !$_GET['b'] && !$_GET['di'] && $_GET['di2']){?> font-weight:bold;<? } ?>" onclick="window.location = '?p=<?= $_GET['p'];?>'">Todos</span></td>

<td> | Veiculo: 

<select name="t" onchange="javascript:document.forms.filtro.submit();">

<option value=""></option>

<option value="carro" <? if($_GET['t'] == 'carro') { ?> selected <? } ?>>Carro</option>
<option value="moto" <? if($_GET['t'] == 'moto') { ?> selected <? } ?>>Moto</option>

</select>

</td>



<td>

 | Pagamento:

<select name="f" onchange="javascript:document.forms.filtro.submit();">

<option value=""></option>
<option value="CARTÃO DE CRÉDITO" <? if($_GET['f'] == 'CARTÃO DE CRÉDITO'){?>selected="selected"<? }?>>CARTÃO DE CRÉDITO</option>
<option value="DINHEIRO" <? if($_GET['f'] == 'DINHEIRO'){?>selected="selected"<? }?>>DINHEIRO</option>
<option value="PAGSEGURO" <? if($_GET['f'] == 'PAGSEGURO'){?>selected="selected"<? }?>>PAGSEGURO</option>

</select>

</td>

<td>

 | Tipo Plano:

<select name="tplano" onchange="javascript:document.forms.filtro.submit();">

<option value=""></option>
<option value="1" <? if($_GET['tplano'] == '1'){?>selected="selected"<? }?>>Adesão</option>
<option value="2" <? if($_GET['tplano'] == '2'){?>selected="selected"<? }?>>Migração</option>
</td>

<td>

 | Status Auditoria:

<select name="s" onchange="javascript:document.forms.filtro.submit();">

<option value=""></option>

<?php /* <option value="PRE-ANALISE" <? if($_GET['s'] == 'PRE-ANALISE'){?>selected="selected"<? }?>>Pré-Análise</option>

<option value="GRAVAR" <? if($_GET['s'] == 'GRAVAR'){?>selected="selected"<? }?>>Gravar</option>

<option value="GRAVADO" <? if($_GET['s'] == 'GRAVADO'){?>selected="selected"<? }?>>Gravado</option>

<option value="BOLETO GERADO" <? if($_GET['s'] == 'BOLETO GERADO'){?>selected="selected"<? }?>>Boleto Gerado</option>

<option value="ENVIAR GRAVAÇÃO" <? if($_GET['s'] == 'ENVIAR GRAVAÇÃO'){?>selected="selected"<? }?>>Enviar Gravação</option>

<option value="ENTREGAR" <? if($_GET['s'] == 'ENTREGAR'){?>selected="selected"<? }?>>Entregar</option>

<option value="FINALIZADA" <? if($_GET['s'] == 'FINALIZADA'){?>selected="selected"<? }?>>Finalizada</option>

<option value="RESTRIÇÃO" <? if($_GET['s'] == 'RESTRIÇÃO'){?>selected="selected"<? }?>>Restrição</option>

<option value="CANCELADO" <? if($_GET['s'] == 'CANCELADO'){?>selected="selected"<? }?>>Cancelado</option>

<option value="DEVOLVIDO" <? if($_GET['s'] == 'DEVOLVIDO'){?>selected="selected"<? }?>>Devolvido</option>

<option value="PENDENTE" <? if($_GET['s'] == 'PENDENTE'){?>selected="selected"<? }?>>Pendente</option>

<option value="SEM COBERTURA" <? if($_GET['s'] == 'SEM COBERTURA'){?>selected="selected"<? } ?>>Sem Cobertura</option>

<option value="SEM CONTATO" <? if($_GET['s'] == 'SEM CONTATO'){?>selected="selected"<? }?>>Sem Contato</option>

<option value="REDIRECIONADO" <? if($_GET['s'] == 'REDIRECIONADO'){?>selected="selected"<? }?>>Redirecionado</option>
*/ ?>

<?php 

	$venda = new Venda();
	$venda->Status->produtoId = 7;
	
	$statusAuditoria = $venda->Status->getAllStatus();
	
	foreach($statusAuditoria as $key=>$status)
	{
	?>
		<option value="<?php echo $key; ?>" <? if($_GET['s'] == "$key"){?>selected="selected"<? }?>><?php echo $status; ?></option>
   <?php 
	}
?>

</select>

</td>





<td> | Venda de: <input type="text" name="v" id="calendario" onKeyPress="mascara(this,data)" value="<?= $_GET['v'];?>" maxlength="10" size="8" onchange="javascript:document.forms.filtro.submit();" /></td>



<td>Até: <input type="text" name="i" id="calendario2" onKeyPress="mascara(this,data)" value="<?= $_GET['i'];?>" maxlength="10" size="8" onchange="javascript:document.forms.filtro.submit();" /></td>



</tr>



</table>

<table width="1000px" bgcolor="#f6f6f6" onmouseover="loadsize(document.getElementById('pagesize').innerHTML);">

<tr align="left" height="40" style="font-size:13px">



<td align="left" width="180px">
<!-- <input type="text" name="de" id="calendario3" onKeyPress="mascara(this,data)" value="<?= $_GET['de'];?>" maxlength="10" size="8" onchange="javascript:document.forms.filtro.submit();" /> -->
<div style="width:300px;"> | Data Visita: <br>De: <input type="text" class="datepicker" name="dv" id="calendario41" onKeyPress="mascara(this,data)" value="<?= $_GET['dv'];?>" maxlength="10" size="6" onchange="javascript:document.forms.filtro.submit();" />



Até: <input type="text" name="dv2" id="calendario421" class="datepicker" onKeyPress="mascara(this,data)" value="<?= $_GET['dv2'];?>" maxlength="10" size="6" onchange="javascript:document.forms.filtro.submit();" /></div>
</td>


<td colspan="1"><div style="width:300px;"> | Data Finalizada: <br>De: <input type="text" class="datepicker" name="di" id="calendario4" onKeyPress="mascara(this,data)" value="<?= $_GET['di'];?>" maxlength="10" size="6" onchange="javascript:document.forms.filtro.submit();" />



Até: <input type="text" name="di2" id="calendario42" class="datepicker" onKeyPress="mascara(this,data)" value="<?= $_GET['di2'];?>" maxlength="10" size="6" onchange="javascript:document.forms.filtro.submit();" /></div>
</td>



<!-- <td width="280px" align="left"><span  style="margin-top:-5px;"> | Gravação: </span><input type="radio" name="g" value="1" <? if($_GET['g'] == '1'){?> checked="checked" <? }?> onchange="javascript:document.forms.filtro.submit();" /> Sim <input type="radio" name="g" value="0" <? if($_GET['g'] == '0'){?> checked="checked" <? }?> onchange="javascript:document.forms.filtro.submit();" /> Não</td>


<td style="width:300px;"> | Tipo Venda: <select name="tpv" onchange="javascript:document.forms.filtro.submit();" style="width:100px;">
				   	<option></option>
                    <option <? if($_GET['tpv'] == 'INTERNA'){?>selected="selected"<? } ?>>INTERNA</option>
                    <option <? if($_GET['tpv'] == 'EXTERNA'){?>selected="selected"<? } ?>>EXTERNA</option>
                    </select></td>


<td> | Tipo Entrega: <select name="tpentrega" onchange="javascript:document.forms.filtro.submit();">
				   	<option></option>
				   	
				   	<option <? if($_GET['tpentrega'] == 'EMBRATEL'){?>selected="selected"<? } ?> value="EMBRATEL">EMBRATEL</option>
					<option <? if($_GET['tpentrega'] == 'MOTOBOY INTERNO'){?>selected="selected"<? } ?> value="MOTOBOY INTERNO">MOTOBOY INTERNO</option>
					<option <? if($_GET['tpentrega'] == 'MOTOBOY EXTERNO'){?>selected="selected"<? } ?> value="MOTOBOY EXTERNO">MOTOBOY EXTERNO</option>
					<option <? if($_GET['tpentrega'] == 'PRONTA ENTREGA'){?>selected="selected"<? } ?> value="PRONTA ENTREGA">PRONTA ENTREGA</option>
                    
                    </select></td>
-->
<!-- </tr>
<tr align="left" height="40" style="font-size:13px">
-->

<td><div style="width:170px;"> | Buscar: <input type="text" size="11" value="<?= $_GET['b']; ?>" name="b" onkeyup="keypressed()" /> &nbsp;</div></td>

<td valign="middle" width="100%" colspan="1" align="left"><img src="img/bt_ok.png" style="margin-left:0px; margin-top:10px; cursor:pointer; position:relative; padding-top:2px;" onclick="javascript:document.forms.filtro.submit();" valign="bootom" /></td>

</tr>






</table>

</form>





<br />

<?

$pg = $_GET['pg'];

if($_GET['m'] == ''){

$numreg = 30;

} else {

$numreg = $_GET['m'];	

}

    if (!isset($_GET['pg']) or ($_GET['pg']==0)) {

        $pg = 1;

    }

	else

	{

	$pg = $_GET['pg'];

	}

    $inicial = ($pg-1) * $numreg;



include "includes/filtro-protection.php";

?>



<table border="0" width="1000px" onmouseover="loadsize(document.getElementById('pagesize').innerHTML);">

<tr align="left">

<td>

<span style="color:#999; font-size:14px;">

<b><?= $quantreg; ?></b> <? if($quantreg == 1){?>Venda encontrada<? } else {?> Vendas encontradas <? } ?>

</span>

</td>



<td width="30" align="center">



<img src="img/gear.png" width="20" style="cursor:pointer" onclick="mostrarcolunas();" title="Selecionar Colunas Visíveis"  />

</td>

<td width="100px" align="right">

<form name="mostrar" method="get" action="">



<input type="hidden" name="g" value="<?= $_GET['g'];?>" />

<input type="hidden" name="p" value="<?= $_GET['p'];?>" />

<input type="hidden" name="o" value="<?= $_GET['o'];?>" />

<input type="hidden" name="b" value="<?= $_GET['b'];?>" />

<input type="hidden" name="i" value="<?= $_GET['i'];?>" />

<input type="hidden" name="v" value="<?= $_GET['v'];?>" />

<input type="hidden" name="s" value="<?= $_GET['s'];?>" />

<input type="hidden" name="t" value="<?= $_GET['t'];?>" />

<input type="hidden" name="f" value="<?= $_GET['f'];?>" />

<input type="hidden" name="di" value="<?= $_GET['di'];?>" />

<input type="hidden" name="tpentrega" value="<?= $_GET['tpentrega'];?>" />

<input type="hidden" name="di" value="<?= $_GET['di2'];?>" />

<input type="hidden" name="de" value="<?= $_GET['de'];?>" />

<input type="hidden" name="me" value="<?= $_GET['me'];?>" />

<input type="hidden" name="an" value="<?= $_GET['an'];?>" />

<input type="hidden" name="ve" value="<?= $_GET['ve'];?>" />

<input type="hidden" name="tpv" value="<?= $_GET['tpv'];?>" />


<span style="font-size:13px">Mostrar: </span>







<select name="m" onchange="javascript:document.forms.mostrar.submit();">

<option value="15" <? if($_GET['m'] == '15'){?>selected="selected"<? }?>>15</option>

<option value="30" <? if($_GET['m'] == '30' || $_GET['m'] == ''){?>selected="selected"<? }?>>30</option>

<option value="40" <? if($_GET['m'] == '40'){?>selected="selected"<? }?>>40</option>

<option value="60" <? if($_GET['m'] == '60'){?>selected="selected"<? }?>>60</option>

</select>



</form>





</td>

</tr>

</table>





<hr size="1" color="#CCC" width="1000px" />



<table border="0" width="1000px" onmouseover="loadsize(document.getElementById('pagesize').innerHTML);">

<tr bgcolor="#565656" style="color:#FFF; font-size:14px; font-weight:bold; cursor:pointer;" align="center" class="tr1">


<? if(strstr($USUARIO['colunas_protection'],'(consultor)')){?>

<td title="Nome do Consultor" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'monitor DESC'){ echo 'monitor DESC'; } else { echo 'monitor ASC'; }?>'">Consultor <? if($_GET['o'] == 'monitor DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'monitor ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>



<? if(strstr($USUARIO['colunas_protection'],'(operador)')){?>

<td title="Nome do Operador" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'operador DESC'){ echo 'operador DESC'; } else { echo 'operador ASC'; }?>'">Operador <? if($_GET['o'] == 'operador DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operador ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>



<? if(strstr($USUARIO['colunas_protection'],'(nome)')){?>

<td title="Nome do Cliente" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'nome DESC'){ echo 'nome DESC'; } else { echo 'nome ASC'; }?>'">Cliente <? if($_GET['o'] == 'nome DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'nome ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>


<? if(strstr($USUARIO['colunas_protection'],'(tipoplano)')){?>

<td title="Tipo Plano" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&de=<?= $_GET['de']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'tipoplano DESC'){ echo 'tipoplano DESC'; } else { echo 'tipoplano ASC'; }?>'">Tipo Plano <? if($_GET['o'] == 'tipoplano DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'tipoplano ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(telefone)')){?>

<td title="Telefone do Cliente" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'telefone DESC'){ echo 'telefone DESC'; } else { echo 'telefone ASC'; }?>'">Telefone <? if($_GET['o'] == 'telefone DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'telefone ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(cpf)')){?>

<td title="CPF do Cliente" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'cpf DESC'){ echo 'cpf DESC'; } else { echo 'cpf ASC'; }?>'">CPF/CNPJ <? if($_GET['o'] == 'cpf DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'cpf ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(cidade)')){?>

<td title="Cidade do Cliente" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'cidade DESC'){ echo 'cidade DESC'; } else { echo 'cidade ASC'; }?>'">Cidade <? if($_GET['o'] == 'cidade DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'cidade ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(cep)')){?>

<td title="CEP" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'cep DESC'){ echo 'cep DESC'; } else { echo 'cep ASC'; }?>'">CEP <? if($_GET['o'] == 'cep DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'cep ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(data)')){?>

<td title="Data da Venda" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'data ASC' || $_GET['o'] == ''){ echo 'data ASC'; } else { echo 'data DESC'; }?>'">Data Venda <? if($_GET['o'] == 'data DESC' || $_GET['o'] == ''){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'data ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(data_visita)')){?>

<td title="Data da Visita" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionDataVisita ASC'){ echo 'protectionDataVisita ASC'; } else { echo 'protectionDataVisita DESC'; }?>'">&nbsp;&nbsp;&nbsp;&nbsp;Data&nbsp;Visita&nbsp;&nbsp;&nbsp;&nbsp;<? if($_GET['o'] == 'protectionDataVisita DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionDataVisita ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(data_finalizada)')){?>

<td title="Data da Autorização" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'data_instalacao DESC'){ echo 'data_instalacao DESC'; } else { echo 'data_instalacao ASC'; }?>'">Data Finalizada <? if($_GET['o'] == 'data_instalacao DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'data_instalacao ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionVeiculo)')){?>

<td title="Tipo de Veículo" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionVeiculo DESC'){ echo 'protectionVeiculo DESC'; } else { echo 'protectionVeiculo ASC'; }?>'">Veículo <? if($_GET['o'] == 'protectionVeiculo DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionVeiculo ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionMarca)')){?>

<td title="Marca do Veículo" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionMarca DESC'){ echo 'protectionMarca DESC'; } else { echo 'protectionMarca ASC'; }?>'">Marca <? if($_GET['o'] == 'protectionMarca DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionMarca ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionModelo)')){?>

<td title="Modelo do Veículo" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionModelo DESC'){ echo 'protectionModelo DESC'; } else { echo 'protectionModelo ASC'; }?>'">Modelo <? if($_GET['o'] == 'protectionModelo DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionModelo ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionAnoModelo)')){?>

<td title="Ano do Veículo" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionAnoModelo DESC'){ echo 'protectionAnoModelo DESC'; } else { echo 'protectionAnoModelo ASC'; }?>'">Ano/Modelo <? if($_GET['o'] == 'protectionAnoModelo DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionAnoModelo ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionValorVeiculo)')){?>

<td title="Valor do Veículo" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionValorVeiculo DESC'){ echo 'protectionValorVeiculo DESC'; } else { echo 'protectionValorVeiculo ASC'; }?>'">Valor do Veículo <? if($_GET['o'] == 'protectionValorVeiculo DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionValorVeiculo ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionTxAdesao)')){?>

<td title="Taxa Adesão" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionTxAdesao DESC'){ echo 'protectionTxAdesao DESC'; } else { echo 'protectionTxAdesao ASC'; }?>'">Taxa de Adesão <? if($_GET['o'] == 'protectionTxAdesao DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionTxAdesao ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionMensalidade)')){?>

<td title="Mensalidade" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionMensalidade DESC'){ echo 'protectionMensalidade DESC'; } else { echo 'protectionMensalidade ASC'; }?>'">Mensalidade <? if($_GET['o'] == 'protectionMensalidade DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionMensalidade ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionRastreador)')){?>

<td title="Rastreador" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionRastreador DESC'){ echo 'protectionRastreador DESC'; } else { echo 'protectionRastreador ASC'; }?>'">Rastreador <? if($_GET['o'] == 'protectionRastreador DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionRastreador ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionGnv)')){?>

<td title="GNV" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'protectionGnv DESC'){ echo 'protectionGnv DESC'; } else { echo 'protectionRastreador ASC'; }?>'">GNV <? if($_GET['o'] == 'protectionGnv DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'protectionGnv ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(pagamento)')){?>

<td title="Forma de Pagamento" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'pagamento DESC'){ echo 'pagamento DESC'; } else { echo 'pagamento ASC'; }?>'">Pagamento <? if($_GET['o'] == 'pagamento DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'pagamento ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(vencimento)')){?>

<td title="Dia do Vencimento da Fatura" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'ABS(vencimento) DESC'){ echo 'ABS(vencimento) DESC'; } else { echo 'ABS(vencimento) ASC'; }?>'">Vencimento <? if($_GET['o'] == 'ABS(vencimento) DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'ABS(vencimento) ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(status)')){?>

<td onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'status DESC'){ echo 'status DESC'; } else { echo 'status ASC'; }?>'">Status Auditoria <? if($_GET['o'] == 'status DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'status ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(motivo_cancelamento)')){?>

<td title="Motivo Cancelamento" onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'motivo_cancelamento DESC'){ echo 'motivo_cancelamento DESC'; } else { echo 'motivo_cancelamento ASC'; }?>'">Motivo Cancelamento <? if($_GET['o'] == 'motivo_cancelamento DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'motivo_cancelamento ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<td></td>

<td onclick="window.location = '?p=protection&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'gravacao DESC'){ echo 'gravacao DESC'; } else { echo 'gravacao ASC'; }?>'"></td>



<? if($USUARIO['editar_dados'] == 1 || $USUARIO['editar_instalacao'] == 1){?>

<td></td>

<? } ?>



<td></td>



</tr>



<?



$class = "tr2";

while($VENDA = mysql_fetch_assoc($conVENDA)){

	

$conMONITOR = $conexao->query("SELECT * FROM usuarios WHERE id = '".$VENDA['monitor']."'");	

$MONITOR = mysql_fetch_assoc($conMONITOR);

	

$conOPERADOR = $conexao->query("SELECT * FROM operadores WHERE operador_id = '".$VENDA['operador']."'");	

$OPERADOR = mysql_fetch_assoc($conOPERADOR);



if ($class=="tr2"){ //alterna a cor

  $class = "tr3";

} else {

  $class="tr2";

}	

?>



<tr class="<?= $class;?>" align="center">




<? if(strstr($USUARIO['colunas_protection'],'(consultor)')){?>

<td title="Nome do Monitor" <? if(strstr($_GET['o'],'monitor')){ ?>class="tdselected" <? } ?>><?= $MONITOR['nome'];?></td>

<? } ?>



<? if(strstr($USUARIO['colunas_protection'],'(operador)')){?>

<td title="Nome do Operador" <? if(strstr($_GET['o'],'operador')){ ?>class="tdselected" <? } ?>><?= $OPERADOR['nome'];?></td>

<? } ?>



<? if(strstr($USUARIO['colunas_protection'],'(nome)')){?>

<td title="Nome do Cliente" <? if(strstr($_GET['o'],'nome')){ ?>class="tdselected" <? } ?>><?= ucwords(strtolower($VENDA['nome']));?></td>

<? } ?> 

<? if(strstr($USUARIO['colunas_protection'],'(tipoplano)')){?>

<td title="Tipo Plano" <? if(strstr($_GET['o'],'tipoplano')){ ?>class="tdselected" <? } ?>><?= $PLANOS[ $VENDA['tipoPlano'] ];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(telefone)')){?>

<td title="Telefone do Cliente" <? if(strstr($_GET['o'],'telefone')){ ?>class="tdselected" <? } ?>><?= strtoupper($VENDA['telefone']);?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(cpf)')){?>

<td title="CPF/CNPJ do Cliente" <? if(strstr($_GET['o'],'cpf')){ ?>class="tdselected" <? } ?>><?= strtoupper($VENDA['cpf']);?></td>

<? } ?>


<? if(strstr($USUARIO['colunas_protection'],'(cidade)')){?>

<td title="Cidade do Cliente" <? if(strstr($_GET['o'],'cidade')){ ?>class="tdselected" <? } ?>><?= ucwords(strtolower($VENDA['cidade']));?></td>

<? } ?>



<? if(strstr($USUARIO['colunas_protection'],'(cep)')){?>

<td title="CEP" <? if(strstr($_GET['o'],'cep')){ ?>class="tdselected" <? } ?>><?= ucwords(strtolower($VENDA['cep']));?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(data)')){?>

<td title="Data da Venda" <? if($_GET['o']=='data ASC' || $_GET['o']=='data DESC' || $_GET['o'] == ''){ ?>class="tdselected"  <? } ?>><?= substr($VENDA['data'],6,2)."/".substr($VENDA['data'],4,2)."/".substr($VENDA['data'],0,4);?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(data_visita)')){?>
<?php

$venda = new venda($VENDA['id']);
$vendaAg = protectionAgendamento::getAgendamentos($venda, $conexao);

$reagendImg = ( $vendaAg !== false && count($vendaAg > 1) ) ? "<img width=\"16\" align=\"absmiddle\" title=\"Visita Reagendada\" src=\"img/time_machine_shaped.png\" />" : "";

?>
<td title="Data da Visita" <? if(strstr($_GET['o'],'protectionDataVisita')){ ?>class="tdselected"  <? } ?>><?= substr($VENDA['protectionDataVisita'],8,2)."/".substr($VENDA['protectionDataVisita'],5,2)."/".substr($VENDA['protectionDataVisita'],0,4)."&nbsp;".substr($VENDA['protectionDataVisita'],11,5) . "&nbsp;" . $reagendImg;?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(data_finalizada)')){?>

<td title="Data Finalizada" <? if(strstr($_GET['o'],'data_instalacao')){ ?>class="tdselected" <? } ?>>

<?= substr($VENDA['data_instalacao'],6,2)."/".substr($VENDA['data_instalacao'],4,2)."/".substr($VENDA['data_instalacao'],0,4);?>

</td>

<? } ?>


<? if(strstr($USUARIO['colunas_protection'],'(protectionVeiculo)')){?>

<td title="Tipo de Veículo" <? if(strstr($_GET['o'],'protectionVeiculo')){ ?>class="tdselected" <? } ?>><?= strtoupper($VENDA['protectionVeiculo']);?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionMarca)')){?>

<?php

	//$conexao2 = new Connection("localhost","root","vento","extrair");
	$sql = ("Select nome from fipe_marca where id='" . $VENDA['protectionMarca'] . "'");
	
	$sqlMarca = $conexao->query($sql);
	
	$marca = mysql_result($sqlMarca,0,'nome');

?>

<td title="Marca" <? if(strstr($_GET['o'],'protectionMarca')){ ?>class="tdselected" <? } ?>><?= strtoupper($marca);?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionModelo)')){?>

<?php

	//$conexao2 = new Connection("localhost","root","vento","extrair");
	$sql = ("Select nome from fipe_modelo where id='" . $VENDA['protectionModelo'] . "'");
	
	$sqlModelo = $conexao->query($sql);
	
	$modelo = mysql_result($sqlModelo,0,'nome');

?>

<td title="Modelo" <? if(strstr($_GET['o'],'protectionModelo')){ ?>class="tdselected" <? } ?>><?= strtoupper($modelo);?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionAnoModelo)')){?>

<?php

	//$conexao2 = new Connection("localhost","root","vento","extrair");
	$sql = ("Select nome from fipe_ano_modelo where id='" . $VENDA['protectionAnoModelo'] . "'");
	
	$sqlAnoModelo = $conexao->query($sql);
	
	$anoModelo = mysql_result($sqlAnoModelo,0,'nome');

?>

<td title="Ano e Modelo" <? if(strstr($_GET['o'],'protectionAnoModelo')){ ?>class="tdselected" <? } ?>><?= strtoupper($anoModelo);?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionValorVeiculo)')){?>

<?php 

	$valor = (float) substr($VENDA['protectionValorVeiculo'],0, -2) . "." . substr($VENDA['protectionValorVeiculo'], -2);

?>
<td title="Valor do Veículo" <? if(strstr($_GET['o'],'protectionValorVeiculo')){ ?>class="tdselected" <? } ?>><?= "R$ " . number_format($valor,2,",",".");?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionTxAdesao)')){?>

<?php 

	$txAdesao = (float) substr($VENDA['protectionTxAdesao'],0, -2) . "." . substr($VENDA['protectionTxAdesao'], -2);

?>

<td title="Taxa de Adesão" <? if(strstr($_GET['o'],'protectionTxAdesao')){ ?>class="tdselected" <? } ?>><?= "R$ " . number_format($txAdesao,2,",",".");?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionMensalidade)')){?>

<?php 

	$mensalidade = (float) substr($VENDA['protectionMensalidade'],0, -2) . "." . substr($VENDA['protectionMensalidade'], -2);

?>

<td title="Mensalidade" <? if(strstr($_GET['o'],'protectionMensalidade')){ ?>class="tdselected" <? } ?>><?= "R$ " . number_format($mensalidade,2,",",".");?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionRastreador)')){?>

<?php

$rastreador = (strtoupper($VENDA['protectionRastreador']) == 'RASTREADOR') ? 'SIM' : 'NÃO';

?>
<td title="Rastreador" <? if(strstr($_GET['o'],'protectionRastreador')){ ?>class="tdselected" <? } ?>><?= $rastreador;?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(protectionGnv)')){?>

<?php

$gnv = (strtoupper($VENDA['protectionGnv']) == 'GNV') ? 'SIM' : 'NÃO';

?>

<td title="GNV" <? if(strstr($_GET['o'],'protectionGnv')){ ?>class="tdselected" <? } ?>><?= $gnv;?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(pagamento)')){?>

<td title="Pagamento" <? if(strstr($_GET['o'],'pagamento')){ ?>class="tdselected" <? } ?>><?= strtoupper($VENDA['pagamento']);?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(vencimento)')){?>

<td title="Dia de Vencimento das Faturas" <? if(strstr($_GET['o'],'vencimento')){ ?>class="tdselected" <? } ?>><?= $VENDA['vencimento'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(status)')){?>

<td title="Status" <? if(strstr($_GET['o'],'status')){ ?>class="tdselected" <? } ?>><?= strtoupper($VENDA['status']);?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_protection'],'(motivo_cancelamento)')){?>

<td title="Motivo Cancelamento" <? if(strstr($_GET['o'],'motivo_cancelamento')){ ?>class="tdselected" <? } ?>><?= strtoupper($VENDA['motivo_cancelamento']);?></td>

<? } ?>


<?php
include_once "lib/class.Accents.php";
//include_once "lib/class.planilhaQualidade.php";
include_once "lib/class.Qualidade.php";
$planilhas = new Qualidade($conexao);
$saidaTexto = new Accents( Accents::UTF_8, Accents::UTF_8 );
?>


<? $conOBS = $conexao->query("SELECT DATE_FORMAT(observacoes.data, '%d/%m/%Y às %H:%i:%s') AS data,
										  observacoes.observacao AS obs, 
										  usuarios.nome AS usuario
				   				   FROM observacoes 
				                   INNER JOIN usuarios ON usuarios.id = observacoes.id_usuario 
				                   WHERE observacoes.id_venda = '".$VENDA['id']."'
								   ORDER BY observacoes.id DESC
										  
										  ");
   $OBS = mysql_fetch_array($conOBS);
?>
<td width="26px" style="cursor:default" title=" <?= str_replace('"',"'",$OBS['obs']).' 
('.$OBS['usuario'].' em '.$OBS['data'].')';?> ">
<? if($OBS['obs']){?>
<img src="img/coment.png" width="16" height="16" />
<? } ?>
</td>


<td width="26px">

<? if($USUARIO['inserir_gravacao'] == 1 && $VENDA['status'] == 'INSERIR DOCUMENTOS' && $VENDA['gravacao'] == ''){?>

<img src="img/icone-anexar.png" title="Inserir Documentos" width="13" height="13" />

<? } ?>



<? if($VENDA['gravacao'] != ''){?>



<img src="img/icone-documentos.png" title="Documentos Inseridos" width="13" height="13"  />



<? } ?>

</td>





<? if($USUARIO['editar_dados'] == 1 || $USUARIO['editar_instalacao'] == 1  || $USUARIO['id']==3179){?>

<td width="26px" title="Editar Dados" style="cursor:pointer"><img src="img/icone-editar.png" width="13" height="13" onclick="Popup=window.open('detalhes-venda-protection.php?e=1&id=<?= $VENDA['id']; ?>','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=630,height=600,left=430,top=30');" /></td>

<? } ?>



<td width="26px" title="Mais Detalhes" style="cursor:pointer"><img src="img/icone-mais.png" width="13" height="13" onclick="Popup=window.open('detalhes-venda-protection.php?id=<?= $VENDA['id']; ?>','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=630,height=600,left=430,top=30');" /></td>



</tr>







<? } ?>



</table>



<hr size="1" color="#CCC" width="1000px" />





<table border="0" width="1000px">

<tr valign="middle" height="20px">

<td></td>

<?php if($pg != '1'){ ?>

<td width="70px" align="center" bgcolor="#ededed" onMouseOver="this.style.background = '#f6f6f6'" onMouseOut="this.style.background = '#ededed'" style="cursor:pointer; font-size:13px" onClick="window.location = ('?p=<?= $_GET['p']; ?>&m=<?= $_GET['m'];?>&o=<?= $_GET['o']; ?>&t=<?= $_GET['t']; ?>&f=<?= $_GET['f']; ?>&s=<?= $_GET['s']; ?>&v=<?= $_GET['v']; ?>&i=<?= $_GET['i']; ?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>')">



&laquo; Anterior</td><? } else{ ?>



<td width="70px" align="center" bgcolor="#fbfbfb" style="cursor:default; font-size:13px; color:#cdcdcd">&laquo; Anterior</td> 



<? } ?>



<? 



$numpaginas = ceil($quantreg / $numreg);



$i = 1; while($i <= $numpaginas && $i<=45){

 $numpag = $i++;	



if($numpag == $pg){ ?>

	

<td width="15px" align="center" bgcolor="#0096ff" style="cursor:pointer; color:#FFF; font-size:13px; font-weight:bold" onClick="window.location = ('?p=<?= $_GET['p']; ?>&m=<?= $_GET['m'];?>&o=<?= $_GET['o']; ?>&t=<?= $_GET['t']; ?>&f=<?= $_GET['f']; ?>&s=<?= $_GET['s']; ?>&v=<?= $_GET['v']; ?>&i=<?= $_GET['i']; ?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo $numpag; ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>')"><? echo $numpag; ?></td>	

    

	<? }else{ ?>

 

<td width="15px" align="center" bgcolor="#ededed" onMouseOver="this.style.background = '#f6f6f6'" onMouseOut="this.style.background = '#ededed'" style="font-size:13px; cursor:pointer" onClick="window.location = ('?p=<?= $_GET['p']; ?>&m=<?= $_GET['m'];?>&o=<?= $_GET['o']; ?>&t=<?= $_GET['t']; ?>&f=<?= $_GET['f']; ?>&s=<?= $_GET['s']; ?>&v=<?= $_GET['v']; ?>&i=<?= $_GET['i']; ?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo $numpag; ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>')"><? echo $numpag; ?></td>





<? }} ?>



<?php if(($inicial + $numreg) < $quantreg ){ ?>

<td width="70px" align="center" bgcolor="#ededed" onMouseOver="this.style.background = '#f6f6f6'" onMouseOut="this.style.background = '#ededed'" style="cursor:pointer; font-size:13px" onClick="window.location = ('?p=<?= $_GET['p']; ?>&m=<?= $_GET['m'];?>&o=<?= $_GET['o']; ?>&t=<?= $_GET['t']; ?>&f=<?= $_GET['f']; ?>&s=<?= $_GET['s']; ?>&v=<?= $_GET['v']; ?>&i=<?= $_GET['i']; ?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg + 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>')">

Próximo &raquo;</td><? } else {?>



<td width="70px" align="center" bgcolor="#fbfbfb" style="cursor:default; font-size:13px; color:#cdcdcd">Próximo &raquo;</td> 



<? } ?>

<td width="10px"></td>

</tr>



</table>



</center>

<br />

<br />

