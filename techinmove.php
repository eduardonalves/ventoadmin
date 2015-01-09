<?



// Verificar se está logado

if(!isset($_SESSION['usuario'])){ ?>

	

<script type="text/javascript">

<!-- window.location = 'index.php' -->

</script>	

	

	

<? } 


if( isset($_GET['me']) && $_GET['me'] != '' ){
		
	$mes  = ($_GET['me'] == 'todos') ? '%' : $_GET['me'];
		
} else {
	
	$mes = date("m");
	
}


if( isset($_GET['an']) && $_GET['an'] != '' ){
		
	$ano  = ($_GET['an'] == 'todos') ? '%' : $_GET['an'];
		
} else {
	
	$ano = date("Y");
	
}


$ordem = $_GET['o'];



if($ordem == ''){ $ordem = 'data_venda DESC';}


///////////////////////////////////////////
//////////////////////////////////////////


if(isset($_POST['chk'])){

	

$set_colunas = $conexao->query("UPDATE usuarios SET colunas_techinmove = '(".$_POST['chk1'].") (".$_POST['chk2'].") (".$_POST['chk3'].") (".$_POST['chk4'].") (".$_POST['chk5'].") (".$_POST['chk6'].") (".$_POST['chk7'].") (".$_POST['chk8'].") (".$_POST['chk9'].") (".$_POST['chk10'].") (".$_POST['chk11'].") (".$_POST['chk12'].") (".$_POST['chk13'].") (".$_POST['chk14'].") (".$_POST['chk15'].") (".$_POST['chk16'].") (".$_POST['chk17'].") (".$_POST['chk18'].") (".$_POST['chk19'].") (".$_POST['chk20'].") (".$_POST['chk21'].") (".$_POST['chk22'].") (".$_POST['chk23'].") (".$_POST['chk24'].") (".$_POST['chk25'].") (".$_POST['chk26'].") (".$_POST['chk27'].") (".$_POST['chk28'].") (".$_POST['chk29'].") (".$_POST['chk30'].") (".$_POST['chk31'].") (".$_POST['chk32'].")' WHERE id = '".$USUARIO['id']."'");

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

	<td width="50%"><input type="checkbox" name="chk1" <? if(strstr($USUARIO['colunas_techinmove'],'(monitor)')){?>checked="checked"<? } ?> value="monitor" /> Monitor</td>

	<td width="50%"><input type="checkbox" name="chk2" <? if(strstr($USUARIO['colunas_techinmove'],'(operador)')){?>checked="checked"<? } ?> value="operador" /> Vendedor</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk3" <? if(strstr($USUARIO['colunas_techinmove'],'(razao_social)')){?>checked="checked"<? } ?> value="razao_social" /> Razão Social</td>

	<td width="50%"><input type="checkbox" name="chk4" <? if(strstr($USUARIO['colunas_techinmove'],'(cnpj)')){?>checked="checked"<? } ?> value="cnpj" /> CNPJ</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk5" <? if(strstr($USUARIO['colunas_techinmove'],'(tipo_venda)')){?>checked="checked"<? } ?> value="tipo_venda" /> Tipo Venda</td>

	<td width="50%"><input type="checkbox" name="chk6" <? if(strstr($USUARIO['colunas_techinmove'],'(produto)')){?>checked="checked"<? } ?> value="produto" /> Produto</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk7" <? if(strstr($USUARIO['colunas_techinmove'],'(valor_produto)')){?>checked="checked"<? } ?> value="valor_produto" /> Valor Produto</td>

	<td width="50%"><input type="checkbox" name="chk8" <? if(strstr($USUARIO['colunas_techinmove'],'(forma_pagamento_produto)')){?>checked="checked"<? } ?> value="forma_pagamento_produto" /> Pagamento Produto</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk9" <? if(strstr($USUARIO['colunas_techinmove'],'(telefone1)')){?>checked="checked"<? } ?> value="telefone1" /> Telefone</td>

	<td width="50%"><input type="checkbox" name="chk10" <? if(strstr($USUARIO['colunas_techinmove'],'(email_principal)')){?>checked="checked"<? } ?> value="email_principal" /> Email</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk11" <? if(strstr($USUARIO['colunas_techinmove'],'(site)')){?>checked="checked"<? } ?> value="site" /> Site</td>

	<td width="50%"><input type="checkbox" name="chk12" <? if(strstr($USUARIO['colunas_techinmove'],'(cep)')){?>checked="checked"<? } ?> value="cep" /> CEP</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk13" <? if(strstr($USUARIO['colunas_techinmove'],'(cidade)')){?>checked="checked"<? } ?> value="cidade" /> Cidade</td>

	<td width="50%"><input type="checkbox" name="chk14" <? if(strstr($USUARIO['colunas_techinmove'],'(data_venda)')){?>checked="checked"<? } ?> value="data_venda" /> Data da Venda</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk15" <? if(strstr($USUARIO['colunas_techinmove'],'(data_finalizada)')){?>checked="checked"<? } ?> value="data_finalizada" /> Data Finalizada</td>

	<td width="50%"><input type="checkbox" name="chk16" <? if(strstr($USUARIO['colunas_techinmove'],'(status)')){?>checked="checked"<? } ?> value="status" /> Status Auditoria</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk17" <? if(strstr($USUARIO['colunas_techinmove'],'(mensalidade)')){?>checked="checked"<? } ?> value="mensalidade" /> Mensalidade</td>

	<td width="50%"><input type="checkbox" name="chk18" <? if(strstr($USUARIO['colunas_techinmove'],'(vencimento)')){?>checked="checked"<? } ?> value="vencimento" /> Vencimento</td>

</tr>

<tr align="left">

	<td width="50%"><input type="checkbox" name="chk19" <? if(strstr($USUARIO['colunas_techinmove'],'(forma_pagamento_mensalidade)')){?>checked="checked"<? } ?> value="forma_pagamento_mensalidade" /> Pagamento Mensalidade</td>

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

<? include "submenu-techinmove.php";?>

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

<td> | Produto: 

<select name="t" onchange="javascript:document.forms.filtro.submit();">

<option value=""></option>

<option value="SITE STANDART" <?php if($_GET['t']=='SITE STANDART') { echo "selected=selected"; } ?>>SITE STANDART</option>
<option value="SITE PERSONALIZADO" <?php if($_GET['t']=='SITE PERSONALIZADO') { echo "selected=selected"; } ?>>SITE PERSONALIZADO</option>

<option value=""></option>

<option value="CATÁLOGO STANDART 50 PRODUTOS" <?php if($_GET['t']=='CATÁLOGO STANDART 50 PRODUTOS') { echo "selected=selected"; } ?>>CATÁLOGO STANDART 50 PRODUTOS</option>
<option value="CATÁLOGO STANDART 100 PRODUTOS" <?php if($_GET['t']=='CATÁLOGO STANDART 100 PRODUTOS') { echo "selected=selected"; } ?>>CATÁLOGO STANDART 100 PRODUTOS</option>
<option value="CATÁLOGO STANDART 250 PRODUTOS" <?php if($_GET['t']=='CATÁLOGO STANDART 250 PRODUTOS') { echo "selected=selected"; } ?>>CATÁLOGO STANDART 250 PRODUTOS</option>
<option value="CATÁLOGO STANDART 500 PRODUTOS" <?php if($_GET['t']=='CATÁLOGO STANDART 500 PRODUTOS') { echo "selected=selected"; } ?>>CATÁLOGO STANDART 500 PRODUTOS</option>

<option value=""></option>

<option value="CATÁLOGO PAGSEGURO 50 PRODUTOS" <?php if($_GET['t']=='CATÁLOGO PAGSEGURO 50 PRODUTOS') { echo "selected=selected"; } ?>>CATÁLOGO PAGSEGURO 50 PRODUTOS</option>
<option value="CATÁLOGO PAGSEGURO 100 PRODUTOS" <?php if($_GET['t']=='CATÁLOGO PAGSEGURO 100 PRODUTOS') { echo "selected=selected"; } ?>>CATÁLOGO PAGSEGURO 100 PRODUTOS</option>
<option value="CATÁLOGO PAGSEGURO 250 PRODUTOS" <?php if($_GET['t']=='CATÁLOGO PAGSEGURO 250 PRODUTOS') { echo "selected=selected"; } ?>>CATÁLOGO PAGSEGURO 250 PRODUTOS</option>
<option value="CATÁLOGO PAGSEGURO 500 PRODUTOS" <?php if($_GET['t']=='CATÁLOGO PAGSEGURO 500 PRODUTOS') { echo "selected=selected"; } ?>>CATÁLOGO PAGSEGURO 500 PRODUTOS</option>

<option value=""></option>

<option value="LOJA VIRTUAL" <?php if($_GET['t']=='LOJA VIRTUAL') { echo "selected=selected"; } ?>>LOJA VIRTUAL</option>

</select>

</td>



<td>

 | Pagamento Produto:

<select name="f" onchange="javascript:document.forms.filtro.submit();">

<option value=""></option>
<!-- 
<option value="BOLETO" <? if($_GET['f'] == 'BOLETO'){?>selected="selected"<? }?>>Boleto</option>

<option value="CARTÃO DE CRÉDITO" <? if($_GET['f'] == 'CARTÃO DE CRÉDITO'){?>selected="selected"<? }?>>Cartão de Crédito</option>

<option value="PRONTA ENTREGA" <? if($_GET['f'] == 'PRONTA ENTREGA'){?>selected="selected"<? }?>>Pronta Entrega</option>
-->
<?php

if(! ($USUARIO["tipo_usuario"]=="MONITOR" && $USUARIO["acesso_usuario"]=="EXTERNO") )
{
	
?>

<option value="BOLETO" <? if($_GET['f'] == 'BOLETO'){?>selected="selected"<? }?>>BOLETO</option>

<option value="CARTÃO DE CRÉDITO" <? if($_GET['f'] == 'CARTÃO DE CRÉDITO'){?>selected="selected"<? }?>>CARTÃO DE CRÉDITO</option>

<option value="DEPÓSITO" <? if($_GET['f'] == 'DEPÓSITO'){?>selected="selected"<? }?>>DEPÓSITO</option>

<option value="GRÁTIS" <? if($_GET['f'] == 'GRÁTIS'){?>selected="selected"<? }?>>GRÁTIS</option>

<option value="PAGSEGURO" <? if($_GET['f'] == 'PAGSEGURO'){?>selected="selected"<? }?>>PAGSEGURO</option>

<?php

}

?>

<option value="DINHEIRO" <? if($_GET['f'] == 'DINHEIRO'){?>selected="selected"<? }?>>DINHEIRO</option>


</select>

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
	$venda->Status->produtoId = 3;
	
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





<td> | Venda de: <input type="text" name="v" id="calendario" onKeyPress="mascara(this,data)" value="<?= $_GET['v'];?>" maxlength="10" style="width:120px;" onchange="javascript:document.forms.filtro.submit();" /></td>



<td>Até: <input type="text" name="i" id="calendario2" onKeyPress="mascara(this,data)" value="<?= $_GET['i'];?>" maxlength="10" style="width:120px;" onchange="javascript:document.forms.filtro.submit();" /></td>



</tr>



</table>

<table width="1000px" bgcolor="#f6f6f6" onmouseover="loadsize(document.getElementById('pagesize').innerHTML);">

<tr align="left" height="40" style="font-size:13px">



<td colspan="3"><div style="width:325px"> | Data Finalizada <br>De: <input type="text" width="100%" class="datepicker" name="di" id="calendario4" onKeyPress="mascara(this,data)" value="<?= $_GET['di'];?>" maxlength="10" style="width:120px;" onchange="javascript:document.forms.filtro.submit();" />



Até: <input type="text" name="di2" id="calendario42" class="datepicker" onKeyPress="mascara(this,data)" value="<?= $_GET['di2'];?>" maxlength="10" style="width:120px;" onchange="javascript:document.forms.filtro.submit();" /></div></td>



<td width="230px" align="left"><span  style="margin-top:-5px;"> | Documentação: </span><input type="radio" name="g" value="1" <? if($_GET['g'] == '1'){?> checked="checked" <? }?> onchange="javascript:document.forms.filtro.submit();" /> Sim <input type="radio" name="g" value="0" <? if($_GET['g'] == '0'){?> checked="checked" <? }?> onchange="javascript:document.forms.filtro.submit();" /> Não</td>

<td width="140px"> | Tipo Venda: <select name="tpv" onchange="javascript:document.forms.filtro.submit();" style="width:110px;">
				   	<option></option>
                    <option <? if($_GET['tpv'] == 'INTERNA'){?>selected="selected"<? } ?>>INTERNA</option>
                    <option <? if($_GET['tpv'] == 'EXTERNA'){?>selected="selected"<? } ?>>EXTERNA</option>
                    </select></td>

<td  width="220px">| Buscar: <input type="text" style="width:140px;" value="<?= $_GET['b']; ?>" name="b" onkeyup="keypressed()" /> &nbsp;</td>


<td valign="middle" colspan="1" align="left"><img src="img/bt_ok.png" style="margin-left:10px; margin-top:0px; margin-right:8px; cursor:pointer; position:relative; padding-top:2px;" onclick="javascript:document.forms.filtro.submit();" valign="bootom" /></td>

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



include "includes/filtro-techinmove.php";

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



<? if(strstr($USUARIO['colunas_techinmove'],'(monitor)')){?>

<td title="Monitor" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'monitor DESC'){ echo 'monitor DESC'; } else { echo 'monitor ASC'; }?>'">Monitor <? if($_GET['o'] == 'monitor DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'monitor ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(operador)')){?>

<td title="Operador" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'operador DESC'){ echo 'operador DESC'; } else { echo 'operador ASC'; }?>'">Operador <? if($_GET['o'] == 'operador DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operador ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(razao_social)')){?>

<td title="Razão Social" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'razao_social DESC'){ echo 'razao_social DESC'; } else { echo 'razao_social ASC'; }?>'">Razão Social <? if($_GET['o'] == 'razao_social DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'razao_social ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(cnpj)')){?>

<td title="CNPJ" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'cnpj DESC'){ echo 'cnpj DESC'; } else { echo 'cnpj ASC'; }?>'">CNPJ <? if($_GET['o'] == 'cnpj DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'cnpj ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(tipo_venda)')){?>

<td title="Tipo de Venda" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'tipo_venda DESC'){ echo 'tipo_venda DESC'; } else { echo 'tipo_venda ASC'; }?>'">Tipo Venda <? if($_GET['o'] == 'tipo_venda DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'tipo_venda ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(produto)')){?>

<td title="Produto" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'produto DESC'){ echo 'produto DESC'; } else { echo 'produto ASC'; }?>'">Produto <? if($_GET['o'] == 'produto DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'produto ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(valor_produto)')){?>

<td title="Valor Produto" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'valor_produto DESC'){ echo 'valor_produto DESC'; } else { echo 'valor_produto ASC'; }?>'">Valor Produto <? if($_GET['o'] == 'valor_produto DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'valor_produto ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(forma_pagamento_produto)')){?>

<td title="Pagamento Produto" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'forma_pagamento_produto DESC'){ echo 'forma_pagamento_produto DESC'; } else { echo 'forma_pagamento_produto ASC'; }?>'">Pagamento Produto <? if($_GET['o'] == 'forma_pagamento_produto DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'forma_pagamento_produto ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(telefone1)')){?>

<td title="Telefone Principal" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'telefone1 DESC'){ echo 'telefone1 DESC'; } else { echo 'telefone1 ASC'; }?>'">Telefone <? if($_GET['o'] == 'telefone1 DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'telefone1 ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(email_principal)')){?>

<td title="Email Principal" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'email_principal DESC'){ echo 'email_principal DESC'; } else { echo 'os ASC'; }?>'">Email <? if($_GET['o'] == 'email_principal DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'email_principal ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(site)')){?>

<td title="Site" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'site DESC'){ echo 'site DESC'; } else { echo 'site ASC'; }?>'">Site <? if($_GET['o'] == 'site DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'site ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(cep)')){?>

<td title="CEP" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'cep DESC'){ echo 'cep DESC'; } else { echo 'cep ASC'; }?>'">CEP <? if($_GET['o'] == 'cep DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'cep ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(cidade)')){?>

<td title="Cidade" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'cidade DESC'){ echo 'cidade DESC'; } else { echo 'cidade ASC'; }?>'">Cidade <? if($_GET['o'] == 'cidade DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'cidade ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(data_venda)')){?>

<td title="Data da Venda" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'data_venda DESC'){ echo 'data_venda DESC'; } else { echo 'data_venda ASC'; }?>'">Data Venda <? if($_GET['o'] == 'data_venda DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'data_venda ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(data_finalizada)')){?>

<td title="Data Finalizada" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'data_finalizada DESC'){ echo 'data_finalizada DESC'; } else { echo 'data_finalizada ASC'; }?>'">Data Finalizada <? if($_GET['o'] == 'data_finalizada DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'data_finalizada ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(status)')){?>

<td title="Status" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'status DESC'){ echo 'status DESC'; } else { echo 'status ASC'; }?>'">Status <? if($_GET['o'] == 'status DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'status ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(mensalidade)')){?>

<td title="Mensalidade" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'mensalidade DESC'){ echo 'mensalidade DESC'; } else { echo 'mensalidade ASC'; }?>'">Mensalidade <? if($_GET['o'] == 'mensalidade DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'mensalidade ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(vencimento)')){?>

<td title="Vencimento" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'vencimento DESC'){ echo 'vencimento DESC'; } else { echo 'vencimento ASC'; }?>'">Vencimento <? if($_GET['o'] == 'vencimento DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'vencimento ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(forma_pagamento_mensalidade)')){?>

<td title="Pagamento Mensalidade" onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'forma_pagamento_mensalidade DESC'){ echo 'forma_pagamento_mensalidade DESC'; } else { echo 'os ASC'; }?>'">Pagamento Mensalidade <? if($_GET['o'] == 'forma_pagamento_mensalidade DESC'){ ?><img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'forma_pagamento_mensalidade ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

<? } ?>

<?php $conOBS = $conexao->query("SELECT DATE_FORMAT(observacoes.data, '%d/%m/%Y às %H:%i:%s') AS data,
										  observacoes.observacao AS obs, 
										  usuarios.nome AS usuario
				   				   FROM observacoes 
				                   INNER JOIN usuarios ON usuarios.id = observacoes.id_usuario 
				                   WHERE observacoes.id_venda = '".$VENDA['id']."'
								   ORDER BY observacoes.id DESC
										  
										  ");
   $OBS = mysql_fetch_array($conOBS);
?>

<? if($OBS['obs']){ ?>
<td></td>
<? } ?>

<td onclick="window.location = '?p=techinmove&m=<?= $_GET['m'];?>&t=<?= $_GET['t'];?>&f=<?= $_GET['f'];?>&s=<?= $_GET['s'];?>&v=<?= $_GET['v'];?>&i=<?= $_GET['i'];?>&b=<?= $_GET['b'];?>&tpv=<?= $_GET['tpv']; ?>&pg=<?php echo ($pg - 1); ?>&di=<?= $_GET['di']; ?>&di2=<?= $_GET['di2']; ?>&tpentrega=<?= $_GET['tpentrega']; ?>&de=<?= $_GET['de']; ?>&me=<?= $_GET['me']; ?>&an=<?= $_GET['an']; ?>&ve=<?= $_GET['ve']; ?>&g=<?= $_GET['g']; ?>&o=<? if($_GET['o'] != 'gravacao DESC'){ echo 'gravacao DESC'; } else { echo 'gravacao ASC'; }?>'"></td>



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



<? if(strstr($USUARIO['colunas_techinmove'],'(monitor)')){?>

<td title="Monitor" <? if(strstr($_GET['o'],'monitor')){ ?> class="tdselected" <? } ?>><?= ucwords(strtolower($MONITOR['nome']));?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(operador)')){?>

<td title="Operador" <? if(strstr($_GET['o'],'operador')){ ?> class="tdselected" <? } ?>><?= ucwords(strtolower($OPERADOR['nome']));?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(razao_social)')){?>

<td title="Razão Social" <? if(strstr($_GET['o'],'razao_social')){ ?> class="tdselected" <? } ?>><?= $VENDA['razao_social'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(cnpj)')){?>

<td title="CNPJ" <? if(strstr($_GET['o'],'cnpj')){ ?> class="tdselected" <? } ?>><?= $VENDA['cnpj'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(tipo_venda)')){?>

<td title="Tipo Venda" <? if(strstr($_GET['o'],'tipo_venda')){ ?> class="tdselected" <? } ?>><?= $VENDA['tipo_venda'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(produto)')){?>

<td title="Produto" <? if(strstr($_GET['o'],'produto')){ ?> class="tdselected" <? } ?>><?= $VENDA['produto'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(valor_produto)')){?>

<td title="Valor Produto" <? if(strstr($_GET['o'],'valor_produto')){ ?> class="tdselected" <? } ?>><?= 'R$ ' . number_format($VENDA['valor_produto'],2,',','.');?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(forma_pagamento_produto)')){?>

<td title="Pagamento Produto" <? if(strstr($_GET['o'],'forma_pagamento_produto')){ ?> class="tdselected" <? } ?>><?= $VENDA['forma_pagamento_produto'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(telefone1)')){?>

<td title="Telefone" <? if(strstr($_GET['o'],'telefone1')){ ?> class="tdselected" <? } ?>><?= $VENDA['telefone1'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(email_principal)')){?>

<td title="Email" <? if(strstr($_GET['o'],'email_principal')){ ?> class="tdselected" <? } ?>><?= $VENDA['email_principal'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(site)')){?>

<td title="Site" <? if(strstr($_GET['o'],'site')){ ?> class="tdselected" <? } ?>><?= $VENDA['site'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(cep)')){?>

<td title="CEP" <? if(strstr($_GET['o'],'cep')){ ?> class="tdselected" <? } ?>><?= $VENDA['cep'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(cidade)')){?>

<td title="Cidade" <? if(strstr($_GET['o'],'cidade')){ ?> class="tdselected" <? } ?>><?= $VENDA['cidade'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(data_venda)')){?>

<td title="Data Venda" <? if(strstr($_GET['o'],'data_venda')){ ?> class="tdselected" <? } ?>><?= date("d/m/Y", strtotime($VENDA['data_venda']));?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(data_finalizada)')){?>

<td title="Data Finalizada" <? if(strstr($_GET['o'],'data_finalizada')){ ?> class="tdselected" <? } ?>><?= ($VENDA['data_finalizada'] != '' && $VENDA['data_finalizada'] != '0000-00-00') ? date("d/m/Y", strtotime($VENDA['data_finalizada'])) : '-';?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(status)')){?>

<td title="Status" <? if(strstr($_GET['o'],'status')){ ?> class="tdselected" <? } ?>><?= $VENDA['status'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(mensalidade)')){?>

<td title="Mensalidade" <? if(strstr($_GET['o'],'mensalidade')){ ?> class="tdselected" <? } ?>><?= 'R$ ' . number_format($VENDA['mensalidade'],2,',','.');?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(vencimento)')){?>

<td title="Vencimento" <? if(strstr($_GET['o'],'vencimento')){ ?> class="tdselected" <? } ?>><?= $VENDA['vencimento'];?></td>

<? } ?>

<? if(strstr($USUARIO['colunas_techinmove'],'(forma_pagamento_mensalidade)')){?>

<td title="Pagamento Mensalidade" <? if(strstr($_GET['o'],'forma_pagamento_mensalidade')){ ?> class="tdselected" <? } ?>><?= $VENDA['forma_pagamento_mensalidade'];?></td>

<? } ?>

<? if($OBS['obs']){?>
	
	<td width="26px" style="cursor:default" title=" <?= str_replace('"',"'",$OBS['obs']).' 
	('.$OBS['usuario'].' em '.$OBS['data'].')';?> ">
		
		<img src="img/coment.png" width="16" height="16" />
	
	</td>
	
<? } ?>

<td width="26px" style="cursor:pointer">

<? if($USUARIO['inserir_gravacao'] == 1 && $VENDA['documentos'] == ''){?>

<img src="img/icone-anexar.png" title="Anexar Documentos" width="13" height="13" onclick="Popup=window.open('detalhes-venda-techinmove.php?e=1&id=<?= $VENDA['id']; ?>#documentos','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=630,height=600,left=430,top=30');" />

<? } ?>

<? if($VENDA['documentos'] != ''){?>

<img src="img/icone-ver-documentos.png" title="Visualizar Documentos" width="16" height="16" onclick="Popup=window.open('detalhes-venda-techinmove.php?id=<?= $VENDA['id']; ?>#documentos','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=630,height=600,left=430,top=30');" />

<? } ?>

</td>





<? if($USUARIO['editar_dados'] == 1 || $USUARIO['editar_instalacao'] == 1  || $USUARIO['id']==3179){?>

<td width="26px" title="Editar Dados" style="cursor:pointer"><img src="img/icone-editar.png" width="13" height="13" onclick="Popup=window.open('detalhes-venda-techinmove.php?e=1&id=<?= $VENDA['id']; ?>','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=630,height=600,left=430,top=30');" /></td>

<? } ?>



<td width="26px" title="Mais Detalhes" style="cursor:pointer"><img src="img/icone-mais.png" width="13" height="13" onclick="Popup=window.open('detalhes-venda-techinmove.php?id=<?= $VENDA['id']; ?>','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=630,height=600,left=430,top=30');" /></td>



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

