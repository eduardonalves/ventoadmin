<?

include "conexao.php";

session_start();

// Verificar se está logado
if(!isset($_GET['u'])){ ?>
	
<script type="text/javascript">
window.location = 'index.php'
window.close();
</script>	
	
	
<? } 


$conUSUARIO = $conexao->query("SELECT * FROM usuarios WHERE id = '".$_GET['u']."'");
$USUARIO = mysql_fetch_array($conUSUARIO);


ini_set('upload_max_filesize', '100M');  
ini_set('post_max_size', '100M');  
ini_set('max_input_time', 300);  
ini_set('max_execution_time', 600);







if($_GET['id']){
$consulta = $conexao->query("SELECT * FROM vendas_clarotv WHERE id = '".$_GET['id']."'");
$linha = mysql_fetch_array($consulta);
} else { ?>
		
<script type="text/javascript">

window.alert('Número de proposta não encontrado!');
window.close();

</script>

	
<? }




if(isset($_POST['upload'])){

	$auditorpost = $_POST['auditor'];
	$arquivo = $_POST["nome_arquivo"];

		?>

		<script type="text/javascript">

			window.alert(': <?= $_POST["uploaded"]; ?>');
		
		</script>	

		<?

	if($_POST["uploaded"]=="1")
	{ 

		$update = $conexao->query("UPDATE vendas_clarotv SET gravacao = '".$arquivo."', auditor = '".$auditorpost."' WHERE id = '".$_GET['id']."'");

		//LOG

		$datadehoje = date("Y-m-d H:i:s");
		$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$datadehoje."','".$_SESSION['usuario']."','Inseriu uma nova gravação no sistema (ID: ".$_GET['id'].").')");

?>
	
<script type="text/javascript">

window.alert('O arquivo "<?= $gravacao ?>" foi enviado com sucesso!');
window.location = 'http://vem.vento-consulting.com/detalhes-venda-clarocombo.php?id=<?= $_GET['id'];?>';
</script>	

<?
	}
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>UpLoad Gravação</title>
</head>

<body style="font-family:Arial, Helvetica, sans-serif">


<table border="0" width="100%">

<tr valign="bottom" height="40px">
<td style="font-size:18px; color:#999">INSERIR GRAVAÇÃO</td>
</tr>

<tr>
<td><hr size="1" color="#CCCCCC" /></td>
</tr>

</table>

<table border="0">
<form name="gravacoes" action="http://172.16.0.30/vento-adm/upload-gravacao-simples-clarocombo-br.php?id=<?= $_GET['id'];?>" enctype="multipart/form-data" method="post">

<tr>
<td>Proposta:</td> <td><input type="text" disabled="disabled" size="40" name="proposta" value="<?= $linha['proposta'];?>" /></td>
</tr>

<tr>
<td>Contrato:</td> <td><input type="text" disabled="disabled" size="40" name="contrato" value="<?= $linha['contrato'];?>" /></td>
</tr>

<tr>
<td>Cliente:</td> <td><input type="text" disabled="disabled" size="40" name="cliente" value="<?= strtoupper($linha['nome']);?>" /></td>
</tr>

<tr>
<td>Telefone:</td> <td><input type="text" disabled="disabled" size="40" name="telefone" value="<?= $linha['telefone'];?>" /></td>
</tr>

<tr height="50px" valign="bottom">
<td>Gravação:</td> <td><input type="file" name="gravacao[]" size="40" /></td>
</tr>


<tr align="left">
<td>Auditor:</td> 
<td>
<select name="auditor">
<option value=""></option>
<? $conAUDITOR = $conexao->query("SELECT * FROM usuarios WHERE tipo_usuario='AUDITOR' ORDER BY nome ASC");
while($AUDITOR = mysql_fetch_array($conAUDITOR)){
?>
<option value="<?= $AUDITOR['id'];?>"><?= $AUDITOR['nome'];?></option>
<? } ?>
</select>
</td>
</tr>

<tr id="uploadid" height="40px" valign="bottom">
<td></td>
<td><input type="submit" name="upload" value="Enviar" /></td>
</tr>

</form>
</table>

</body>
</html>
