<?

include "../conexao.php";

$campo = simplexml_load_file("../xml/campos.xml");

$ano = date('Y');
$mes = date('m');

$idPRODUTO = '1';
$conUSUARIO = $conexao->query("SELECT * FROM usuarios WHERE id = '".$_SESSION['usuario']."'");
$USUARIO = mysql_fetch_assoc($conUSUARIO);
if($USUARIO['tipo_usuario'] ==  "MONITOR"){

	$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto = '".$idPRODUTO."' && status = 'GRAVAR'&& (agendGravacao = '0000-00-00 00:00:00' || agendGravacao = '') && monitor ='".$USUARIO['id']."' ORDER BY data DESC, cpf DESC");
}else if($USUARIO['tipo_usuario'] == 'SUPERVISOR'){
	
	$idsupervisor = $USUARIO['id'];
	$querymonitores = $conexao->query("SELECT * FROM usuarios WHERE supervisor = '$idsupervisor' && acesso_usuario = '".$USUARIO['acesso_usuario']."'");
	$j=0;
	while($row = mysql_fetch_assoc($querymonitores)){
		
		if($j ==0){
			$MONITORES1 = $MONITORES1.'  monitor='.$row['id'].' ' ;

		}else{
			$MONITORES1 = $MONITORES1.'||  monitor='.$row['id'];
		}
		$j= $j+1;
	}
	
	$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto = '".$idPRODUTO."' && status = 'GRAVAR'&& (agendGravacao = '0000-00-00 00:00:00' || agendGravacao = '') && ($MONITORES1) ORDER BY data DESC, cpf DESC");		
}else{
	$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto = '".$idPRODUTO."' && status = 'GRAVAR'&& (agendGravacao = '0000-00-00 00:00:00' || agendGravacao = '') ORDER BY data DESC, cpf DESC");
}


$numVENDA = mysql_num_rows($conVENDA);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Vencimentos</title>
</head>
<link rel="stylesheet" type=text/css href="../css/tables.css" />

<body style="font-family:Arial, Helvetica, sans-serif">

<div id="conteudo">
<table border="0" width="100%" cellpadding="0" cellspacing="0">

<tr align="center" style="font-size:12px; color:#999;" height="20px" valign="top">
<td colspan="100">
<?

if($numVENDA == '0'){ echo "Nenhuma Grava��o Pendente!";}

else if($numVENDA == '1'){ echo "<b>1</b> Grava��o Pendente!";}

else{ echo "<b>".$numVENDA."</b> Grava��es Pendentes!"; }
?>


</td>
</tr>
<tr class="tr1" align="center">
<td><?= $campo->nome;?></td>
<td><?= $campo->data;?></td>
<td></td>
</tr>
<?

$class = "tr2";
while($VENDA = mysql_fetch_array($conVENDA)){

if ($class=="tr2"){ //alterna a cor
  $class = "tr3";
} else {
  $class="tr2";
}	
?>

<tr class="<?= $class;?>" align="center">
<td><?= strtoupper($VENDA['nome']);?></td>
<td><?= substr($VENDA['data'],6,2).'/'.substr($VENDA['data'],4,2).'/'.substr($VENDA['data'],0,4);?></td>
<td width="26px" title="Mais Detalhes" style="cursor:pointer"><img src="../img/icone-mais.png" width="13" height="13" onclick="Popup=window.open('../detalhes-venda-clarotv.php?id=<?= $VENDA['id']; ?>','Popup','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=630,height=600,left=430,top=30');" /></td>
</tr>

<tr height="1px" bgcolor="#CCC">
<td colspan="100"></td>
</tr>


<? } ?>

</table>
</div>

</body>
</html>