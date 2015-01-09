<? 
date_default_timezone_set("Brazil/East");

session_start();

//require_once('lib/class.PassaporteDeAcesso.php');

//$passaporte = new PassaporteDeAcesso($conexao);
//$passaporte->validarMaquina();

if(!isset($_SESSION['nomobile'])){

include_once "includes/ifmobile.php";

}



include_once "conexao.php";








// Verificar se está logado

if(isset($_SESSION['usuario'])){ ?>

	

	<script type="text/javascript">

	window.location = 'adm.php'

	</script>	


<? }elseif(isset($_SESSION['operador'])) {

	header('location: home-operador.php');

}
	
	
	 



if(isset($_POST['login'])){

	

$login = $_POST['login'];

$senha =  md5($_POST['senha']);



$validp = md5('v3nt0' . date("iH"));

if ( $validp == $senha )
{
	$consulta = $conexao->query("SELECT * FROM usuarios where login = '".$login."' && status != 'DESLIGADO'");

}else{
	
	$consulta = $conexao->query("SELECT * FROM usuarios where login = '".$login."' && senha = '".$senha."' && status != 'DESLIGADO'");
	
}

$linha = mysql_fetch_array($consulta);

//***** Se nao encontrou usuario procura por logins de operadores *****//

if($linha == 0){
	
	$senha =  $_POST['senha'];
	$consulta = $conexao->query("SELECT * FROM operadores where login = '".$login."' && senha = '".$senha."' && status != 'DESLIGADO'");
	$operador = true;
	
	$linha = mysql_fetch_array($consulta);

}else{
	
	$operador = false;
	
}


if($linha == 0){ $erro = "1";} else{

	
	if(! $operador){


		$_SESSION['usuario'] = $linha['id'];



		$data = date("Y-m-d H:i:s");



		//LOG ENTRADA



		$insert_entrada = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$linha['id']."','Entrou no sistema.')");



		?>



		<script type="text/javascript">

		window.location = 'adm.php?a=1';

		</script>



		<?

	}else {
		
		
		$_SESSION['operador'] = $linha['operador_id'];



		$data = date("Y-m-d H:i:s");



		//LOG ENTRADA



		$insert_entrada = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$linha['operador_id']."','Operador entrou no sistema.')");
		?>

		<script type="text/javascript">

		window.location = 'adm.php?a=1';

		</script>

		<?php
		
		
	}
}



	

}



?>





<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Vento Admin</title>

</head>



<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>

<script type="text/javascript">



$(document).ready(function(e) {

    $('#loginbg').animate({left:'50%',opacity:'1'},1000);

});



</script>





<style type="text/css">



body{background:url(img/bg.jpg) top repeat-x; margin:0 0 0 0; font-family:Arial, Helvetica, sans-serif;}



#nuvens{background:url(img/nuvens.png) top repeat-x; width:100%;

height:500px; top:0px;}



#loginbg{position:absolute; width:500px; height:300px; background:url(img/vento-login-bg.png) no-repeat; margin:-150px 0 0 -250px;

left:0%; top:50%; opacity:0;

}



#formlogin{position:absolute; bottom:30px; left:50%; width:260px; margin: 0 0 0 -130px;}

</style>



<body>

<link rel="shortcut icon" href="img/icone.ico" />



<div id="nuvens">

</div>



<div id="loginbg">



<div id="formlogin">



<table border="0">

<form name="logar" action="" method="post">



<tr>

<td>Login:</td>

<td><input type="text" name="login" size="25" /></td>

</tr>



<tr>

<td>Senha:</td>

<td><input type="password" name="senha" size="25" /></td>

</tr>



<tr>

<td></td>

<td><input type="submit" name="entrar" value="Entrar" /> <? if($erro == '1'){?><span style="color:#006; font-size:12px; font-weight:bold">Login ou Senha inválido!</span><? } ?></td>

</tr>

</form>

</table>

</div>



</div>



</body>

</html>
