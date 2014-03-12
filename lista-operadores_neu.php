<link rel="stylesheet" href="css/tables.css" />

<script type="text/javascript">

function editar(id){

document.getElementById('tr'+id).style.display = 'none';
document.getElementById('tredit'+id).style.display = '';
	
	
}


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
	
</script>


<?

if(isset($_POST['nomeoperador'])){
	
$IDoperador = $_POST['idoperador'];
	
	
$NOMEoperador = $_POST['nomeoperador'];
$IDmonitor = $_POST['nomemonitor'];
$grupo = $_POST['grupo'];
$status = $_POST['status'];

if($NOMEoperador != '' && $IDmonitor != '' && $grupo != '' && $status != ''){
	
	$update = $conexao->query("UPDATE operadores SET nome = '".$NOMEoperador."', monitor = '".$IDmonitor."', grupo = '".$grupo."', status = '".$status."' WHERE operador_id = '".$IDoperador."'");
	
	
	}}



if(isset($_POST['salvar'])){
	
$login = $_POST['login'];
$nome = $_POST['nome'];
$cpf = $_POST['icpf'];
$grupo = $_POST['grupo'];
$nmonitor = $_POST['nomemonitor'];
$status = $_POST['status'];


if($login != '' && $nome != '' && $grupo != '' && $nmonitor != '' && $status != ''){

	$insert = $conexao->query("INSERT INTO operadores (login,nome,cpf,grupo,monitor,status) VALUES ('".$login."','".$nome."','".$cpf."','".$grupo."','".$nmonitor."','".$status."') ");
	
}}

?>

<br />
<center>
<form name="novooperador" action="" method="post">
<? $conLOGIN = $conexao->query("SELECT * FROM operadores ORDER BY ABS(login) DESC");
$ultLOGIN = mysql_fetch_array($conLOGIN);
?>
<input type="hidden" value="<?= ($ultLOGIN['login']+1);?>" name="login" />
<table border="0" width="900px">
<tr>
<td colspan="2" style="color:#999; font-size:18px;">Inserir Operador</td>
</tr>


<tr>
<td>Nome:</td>
<td><input type="text" name="nome" /></td>
</tr>

<tr>
<td>CPF :</td>
<td><input type="text" id="idcpf" name="icpf" onKeyPress="mascara(this,cpf)" maxlength="14" /></td>
</tr>

<tr>
<td>Produto:</td>
<td>
<select name="grupo">
<option value=""></option>
<option value="0004" <? if($OPERADOR['grupooperador'] == '0004'){ ?>selected="selected" <? } ?>>Oi</option>
<option value="0001" <? if($OPERADOR['grupooperador'] == '0001'){ ?>selected="selected" <? } ?>>Claro TV</option>
<option value="0002" <? if($OPERADOR['grupooperador'] == '0002'){ ?>selected="selected" <? } ?>>Claro 3G</option>
<option value="0003" <? if($OPERADOR['grupooperador'] == '0003'){ ?>selected="selected" <? } ?>>Claro FIXO</option>
<option value="0001|0002" <? if($OPERADOR['grupooperador'] == '0001|0002'){ ?>selected="selected" <? } ?>>Claro TV e Claro 3G</option>
<option value="0001|0003" <? if($OPERADOR['grupooperador'] == '0001|0003'){ ?>selected="selected" <? } ?>>Claro TV e Claro FIXO</option>
<option value="0002|0003" <? if($OPERADOR['grupooperador'] == '0002|0003'){ ?>selected="selected" <? } ?>>Claro 3G e Claro Fixo</option>
<option value="0001|0002|0003" <? if($OPERADOR['grupooperador'] == '0001|0002|0003'){ ?>selected="selected" <? } ?>>Claro TV, Claro 3G e Claro Fixo</option>
</select>
</td>
</tr>

<tr>
<td>Monitor:</td>
<td>
<select name="nomemonitor">
<option value=""></option>

<?

$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE tipo_usuario = 'MONITOR' && status != 'DESLIGADO' ORDER BY nome");
while($MONITOR = mysql_fetch_array($conMONITORES)){

?>
<option value="<?= $MONITOR['id']; ?>" <? if($OPERADOR['idmonitor'] == $MONITOR['id']){ ?>selected="selected" <? } ?>><?= $MONITOR['nome']; ?></option>

<? } ?>

</select>
</td>
</tr>

<tr>
<td>Status:</td>
<td>
<select name="status">
<option value=""></option>
<option value="ATIVO" <? if($OPERADOR['statusoperador'] == 'ATIVO'){ ?>selected="selected" <? } ?>>ATIVO</option>
<option value="DESLIGADO" <? if($OPERADOR['statusoperador'] == 'DESLIGADO'){ ?>selected="selected" <? } ?>>DESLIGADO</option>

</select>
</td>
</tr>
<tr>

<td>Contratação:</td>

<td>

<select name="contrato">

<option value=""></option>


<option value="TREINAMENTO" <? if($OPERADOR['contrato'] == 'TREINAMENTO'){ ?>selected="selected" <? } ?>>TREINAMENTO</option>

<option value="EFETIVO" <? if($OPERADOR['contrato'] == 'EFETIVO'){ ?>selected="selected" <? } ?>>EFETIVO</option>



</select>

</td>

</tr>
<tr>
<td></td>
<td><input type="submit" name="salvar" value="Salvar" /></td>
</tr>

<tr>
<td colspan="2">
<hr />
</td>
</tr>

</table>
</form>
<br>

<table border="0" width="900px">
<tr style="color:#FFF; font-size:14px; font-weight:bold; cursor:pointer;" class="tr1" align="center">
<td>Login</td>
<td>Nome do Operador</td>
<td>Monitor</td>
<td>Produto</td>
<td>Status</td>
<td></td>
</tr>

<?

$class = "tr2";

$conOPERADORES = $conexao->query("SELECT *, operadores.nome AS nomeoperador, 
											operadores.operador_id AS idoperador,
											operadores.login AS loginoperador,
											usuarios.nome AS nomemonitor, 
											usuarios.id AS idmonitor,
											operadores.grupo AS grupooperador,
											operadores.status AS statusoperador
											FROM operadores 
											INNER JOIN usuarios ON operadores.monitor = usuarios.id 
											WHERE operadores.status != 'DESLIGADO' 
											ORDER BY operadores.nome"
											
											);
while($OPERADOR = mysql_fetch_array($conOPERADORES)){


if($class == "tr2"){ $class = "tr3";} else { $class = "tr2";}

?>


<tr class="<?= $class;?>" align="center" id="tr<?= $OPERADOR['idoperador'];?>">
<td><?= $OPERADOR['loginoperador'];?></td>
<td><?= $OPERADOR['nomeoperador'];?></td>
<td><?= $OPERADOR['nomemonitor'];?></td>
<td>
<? if($OPERADOR['grupooperador'] == '0004'){$produto = 'Oi';}
else if($OPERADOR['grupooperador'] == '0001'){$produto = 'Claro TV';}
else if($OPERADOR['grupooperador'] == '0002'){$produto = 'Claro 3G';}
else if($OPERADOR['grupooperador'] == '0003'){$produto = 'Claro FIXO';}
else if($OPERADOR['grupooperador'] == '0001|0002'){$produto = 'Claro TV e Claro 3G';}
else if($OPERADOR['grupooperador'] == '0001|0003'){$produto = 'Claro TV e Claro FIXO';}
else if($OPERADOR['grupooperador'] == '0002|0003'){$produto = 'Claro 3G e Claro Fixo';}
else if($OPERADOR['grupooperador'] == '0001|0002|0003'){$produto = 'Claro TV, Claro 3G e Claro Fixo';}
echo $produto;
?>


</td>
<td><?= $OPERADOR['statusoperador'];?></td>
<td><img src="img/icone-editar.png" onclick="editar(<?= $OPERADOR['idoperador'];?>)" style="cursor:pointer" /></td>
</tr>


<form action="" method="post" name="form<?= $OPERADOR['idoperador'];?>">
<tr class="<?= $class;?>" align="center" id="tredit<?= $OPERADOR['idoperador'];?>" style="display:none;">
<td>
<input type="hidden" name="idoperador" value="<?= $OPERADOR['idoperador'];?>" />
<input type="text" name="nomeoperador" value="<?= $OPERADOR['nomeoperador'];?>" /></td>
<td>
<select name="nomemonitor">
<?

$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE tipo_usuario = 'MONITOR' && status != 'DESLIGADO' ORDER BY nome");
while($MONITOR = mysql_fetch_array($conMONITORES)){

?>
<option value="<?= $MONITOR['id']; ?>" <? if($OPERADOR['idmonitor'] == $MONITOR['id']){ ?>selected="selected" <? } ?>><?= $MONITOR['nome']; ?></option>

<? } ?>

</select>
</td>
<td>
<?   if($OPERADOR['grupooperador'] == '0004'){$produto = 'Oi';}
else if($OPERADOR['grupooperador'] == '0001'){$produto = 'Claro TV';}
else if($OPERADOR['grupooperador'] == '0002'){$produto = 'Claro 3G';}
else if($OPERADOR['grupooperador'] == '0003'){$produto = 'Claro FIXO';}
else if($OPERADOR['grupooperador'] == '0001|0002'){$produto = 'Claro TV e Claro 3G';}
else if($OPERADOR['grupooperador'] == '0001|0003'){$produto = 'Claro TV e Claro FIXO';}
else if($OPERADOR['grupooperador'] == '0002|0003'){$produto = 'Claro 3G e Claro Fixo';}
else if($OPERADOR['grupooperador'] == '0001|0002|0003'){$produto = 'Claro TV, Claro 3G e Claro Fixo';}
?>

<select name="grupo">
<option value="0004" <? if($OPERADOR['grupooperador'] == '0004'){ ?>selected="selected" <? } ?>>Oi</option>
<option value="0001" <? if($OPERADOR['grupooperador'] == '0001'){ ?>selected="selected" <? } ?>>Claro TV</option>
<option value="0002" <? if($OPERADOR['grupooperador'] == '0002'){ ?>selected="selected" <? } ?>>Claro 3G</option>
<option value="0003" <? if($OPERADOR['grupooperador'] == '0003'){ ?>selected="selected" <? } ?>>Claro FIXO</option>
<option value="0001|0002" <? if($OPERADOR['grupooperador'] == '0001|0002'){ ?>selected="selected" <? } ?>>Claro TV e Claro 3G</option>
<option value="0001|0003" <? if($OPERADOR['grupooperador'] == '0001|0003'){ ?>selected="selected" <? } ?>>Claro TV e Claro FIXO</option>
<option value="0002|0003" <? if($OPERADOR['grupooperador'] == '0002|0003'){ ?>selected="selected" <? } ?>>Claro 3G e Claro Fixo</option>
<option value="0001|0002|0003" <? if($OPERADOR['grupooperador'] == '0001|0002|0003'){ ?>selected="selected" <? } ?>>Claro TV, Claro 3G e Claro Fixo</option>
</select>



</td>
<td>

<select name="status">

<option value="ATIVO" <? if($OPERADOR['statusoperador'] == 'ATIVO'){ ?>selected="selected" <? } ?>>ATIVO</option>
<option value="TREINAMENTO" <? if($OPERADOR['statusoperador'] == 'TREINAMENTO'){ ?>selected="selected" <? } ?>>TREINAMENTO</option>
<option value="DESLIGADO" <? if($OPERADOR['statusoperador'] == 'DESLIGADO'){ ?>selected="selected" <? } ?>>DESLIGADO</option>

</select>
</td>
<td><img src="img/icone-salvar.png" width="20" style="cursor:pointer" onclick="javascript:document.form<?= $OPERADOR['idoperador'];?>.submit();" /></td>
</tr>
</form>

<?
}
?>
</table>
</center>

<br />
<br />
