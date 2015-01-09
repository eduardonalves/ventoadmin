<?php 
session_start();

include_once "conexao.php";

$conUSUARIO = $conexao->query("SELECT * FROM operadores WHERE operador_id = '".$_SESSION['operador']."'");
	
$USUARIO = mysql_fetch_assoc($conUSUARIO);

$_SESSION['operador_inserir'] = 1;

$pagina = $_GET['p'];

$nomeMonitor = ucwords(strtolower(mysql_result($conexao->query("Select nome from usuarios where id='" . $USUARIO['monitor']  . "'"),0,0)))
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" height="100%">

<head>



<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<title>Vento Admin</title>

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/geral.css" />
<script>
	
	$(document).ready ( function() {
		
		if( $('.submenu').length > 0 ){
			$('.submenu').remove();
		}
		
		if( $("[src='img/voltar.png']").length > 0 ){
			
			$("[src='img/voltar.png']").attr('onclick','');
			
		}
	
		$("[src='img/voltar.png']").click(function(){
		
			window.location = 'home-operador.php';
			
		});
	

		$("#monitor").html("<option value=\"<?php echo $USUARIO['monitor'];?>\"><?php echo $nomeMonitor;?></option>");
		$("#operador").html("<option value=\"<?php echo $USUARIO['operador_id'];?>\"><?php echo $USUARIO['nome'];?></option>");

		$(document).bind('click', "#monitor, #operador", function(){
			
			$("#monitor").html("<option value=\"<?php echo $USUARIO['monitor'];?>\"><?php echo $nomeMonitor;?></option>");
			$("#operador").html("<option value=\"<?php echo $USUARIO['operador_id'];?>\"><?php echo $USUARIO['nome'];?></option>");

		});
		
		$(window).load( function(){
			
			setTimeout( function() {
						$("#operador").html("<option value=\"<?php echo $USUARIO['operador_id'];?>\"><?php echo $USUARIO['nome'];?></option>");
					}, 300);
		});
		
		
	});
	
	

function sldown(id){

	

	$(id).stop().animate({height:'80px',opacity:'1'}, 500);

	

	

	}



function slup(id){

	

	$(id).stop().animate({height:'0px',opacity:'0'}, 500);

	

	}

</script>
<style type="text/css">



body{background:url(img/bg.jpg) top repeat-x; margin:0 0 0 0; font-family:Arial, Helvetica, sans-serif;}



#nuvens{position:absolute; background:url(img/nuvens.png) top repeat-x; width:100%;

height:500px; top:0px;}



#loginbg{position:absolute; width:500px; height:300px; background:url(img/vento-login-bg.png) no-repeat; margin:-150px 0 0 -250px;

left:50%; top:50%; opacity:1; z-index:1000;

}



#formlogin{position:absolute; bottom:50px; left:50%; width:260px; margin: 0 0 0 -130px; z-index:1000;}



</style>

</head>

<?php flush(); ?>

<body height="100%" onLoad="slup('#opcoes');loadpage();">



<div id="nuvens"></div>
<div id="pagina" <? if($_GET['a'] == 1){?> style="display:none;" <? } ?>>



<div id="topobg">



<div id="topo">



<div id="logo">

<img src="img/LOGO-VENTO-p.png" border="0" style="cursor:pointer" onClick="window.location = 'adm'" />

</div>



<div id="usuario" onClick="sldown('#opcoes')" onMouseOut="slup('#opcoes')">

<table border="0">

<tr>

<td width="45px" align="left"><? if($USUARIO['foto'] != ''){ ?> <img src="img/fotos/<?= $USUARIO['foto'];?>.jpg" /> <? } else { ?><img src="img/U-<? if($USUARIO['sexo'] == 'F'){ echo 'F';} else { echo 'M';}?>.jpg" /> <? } ?></td>

<td style="font-size:14px;"><?= $USUARIO['nome']; ?></td>

<td width="18px" align="center"><img src="img/seta1.png" title="Opções" /></td>

</tr>

</table>



<div id="opcoes" onMouseOver="sldown('#opcoes')" >



<table border="0" width="100%" style="font-size:12px">
<tr height="5px">

<td></td>

</tr>



<tr>

<td><hr size="1" color="#CCCCCC" /></td>

</tr>

<!-- 

<tr align="center" class="opcoes">

<td onClick="window.location = '?p=configuracoes'">CONFIGURAÇÕES</td>

</tr>



<tr>

<td><hr size="1" color="#CCCCCC" /></td>

</tr>

-->


<tr align="center" class="opcoes">

<td onClick="window.location = 'sair'">SAIR</td>

</tr>

<tr>

<td><hr size="1" color="#CCCCCC" /></td>

</tr>




</table>





</div>





</div>

</div>

</div>


<div id="menu">

<table border="0" align="center" height="45px" cellpadding="0" cellspacing="0" style="cursor:pointer;">



<tr align="center">



<td class="<? if($pagina == '' || $pagina == 'home'){?>menuselected<? } else{ ?>menu<? } ?>" onClick="window.location = 'home-operador.php'">&nbsp; &nbsp; HOME &nbsp; &nbsp;</td>



<?


$conGRUPO = explode('|',$USUARIO['grupo']);



for($i=0;$i<count($conGRUPO);$i++){

	

$conMENU = $conexao->query("SELECT * FROM menu WHERE grupo = '".$conGRUPO[$i]."' ORDER BY menu.ordem");

$MENU = mysql_fetch_array($conMENU);


?>

<td class="<? if(strstr($pagina,$MENU['link'])){?>menuselected<? } else { ?>menu<? } ?>" onClick="window.location = '?p=inserir-dados-<?= $MENU['link'] ?>'">&nbsp; &nbsp; <?= strtoupper($MENU['menu']); ?> &nbsp; &nbsp;</td>



<? } ?>



<td></td>

</tr>



</table>

</div>

<div id="conteudo">

<?php
if($_GET['p'] != ''){

	include $_GET['p'] . ".php";
}else{
?>


	<div id="content-area" style="padding-top:130px; margin-left:auto; margin-right:auto; width:1000px;">
		
		<div style="float:left; margin-left:50px;">
			<span style="float:left;"><img src="img/callcenter.png" style="width:100px;"></span>
			<span style="float:left; margin-top:20px; margin-left:50px; color:#666666"><h2>Área do Operador</h2></span>
		</div>
		
		<div style="float:right; margin-right:130px; padding-left:20px; border-left:1px solid #CCCCCC; font-size:14px;">
		<b>Nome: </b><?php echo ucwords(strtolower($USUARIO['nome'])); ?>
		<br><br>
		<b>Login: </b><?php echo $USUARIO['login']; ?>
		<br><br>
		<b>Tipo Contrato: </b><?php echo ucwords(strtolower($USUARIO['tipo_contrato'])); ?>
		<br><br>
		<br>
		<?php
		
		?>
		<b>Monitor: </b><?php echo $nomeMonitor; ?>
		</div>
		

	</div>

<?php } ?>
</div><!-- conteudo -->

<div id="rodape">

<table align="center" height="34px"><tr valign="middle"><td class="rodape">

Vento Consulting &copy; 2013 - versão 2.0

</td></tr></table>

</div>

</div>



</body>

</html>


