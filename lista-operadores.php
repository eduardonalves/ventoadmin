<?

if($_GET['p'] != 'configuracoes'){ ?>

<script>
window.location = "?p=configuracoes&es=3";	
</script>
<?
	
}
?>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" href="css/tables.css" />

<script type="text/javascript">

function editar(id){

document.getElementById('tr'+id).style.display = 'none';
document.getElementById('tredit'+id).style.display = '';
	
	
}


 /*Cria uma funï¿½ï¿½o de nome mascara, onde o primeiro argumento passado ï¿½ um dos
     objetos input O segundo ï¿½ especificando o tipo de mï¿½todo no qual serï¿½ tratado*/
    function mascara(o,f){
        v_obj=o;
        v_fun=f;
        setTimeout("execmascara()",1);
    }
    
    function execmascara(){
        /*Pegue o valor do objeto e atribua o resultado da funï¿½ï¿½o v_fun; cujo o conteï¿½do
        da mesma ï¿½ a funï¿½ï¿½o que foi referida e que serï¿½ utilizada para tratar dos dados*/
        v_obj.value=v_fun(v_obj.value);
    }
    
    function soNumeros(v){
        return v.replace(/\D/g,"");//Exclua tudo que nï¿½o for numeral e retorne o valor
    }
    
    function telefone(v){
        //Remove tudo o que nï¿½o ï¿½ dï¿½gito
        v=v.replace(/\D/g,"");
        //Coloca parï¿½nteses em volta dos dois primeiros dï¿½gitos
        v=v.replace(/^(\d\d)(\d)/g,"($1) $2");
        //Coloca hï¿½fen entre o quarto e o quinto dï¿½gitos
        v=v.replace(/(\d{4})(\d)/,"$1-$2");
        //retorne o resultado
        return v;
    }
	

    function cpf(v){
        //Remove tudo o que nï¿½o ï¿½ dï¿½gito
        v=v.replace(/\D/g,"");
        //Coloca parï¿½nteses em volta dos dois primeiros dï¿½gitos
        v=v.replace(/^(\d{3})(\d)/g,"$1.$2");
        //Coloca hï¿½fen entre o quarto e o quinto dï¿½gitos
        v=v.replace(/(\d{3})(\d)/,"$1.$2");
        //retorne o resultado
		v=v.replace(/(\d{3})(\d)/,"$1-$2");
        return v;
    }
	
	
	    function data(v){

        //Remove tudo o que nï¿½o ï¿½ dï¿½gito

        v=v.replace(/\D/g,"");

        //Coloca parï¿½nteses em volta dos dois primeiros dï¿½gitos

        v=v.replace(/^(\d{2})(\d)/g,"$1/$2");

        //Coloca hï¿½fen entre o quarto e o quinto dï¿½gitos

        v=v.replace(/(\d{2})(\d)/,"$1/$2");

        return v;

    }
</script>


<?

if(isset($_POST['nomeoperador'])){
	
$IDoperador = $_POST['idoperador'];
	
	
$NOMEoperador = $_POST['nomeoperador'];
$IDmonitor = $_POST['nomemonitor'];
$grupo = $_POST['grupo'];
$data_admissao0 = explode('/',$_POST['dataadmissao']);
$data_admissao = $data_admissao0[2].'-'.$data_admissao0[1].'-'.$data_admissao0[0];

$data_efetivacao0 = explode('/',$_POST['dataefetivacao']);
$data_efetivacao = $data_efetivacao0[2].'-'.$data_efetivacao0[1].'-'.$data_efetivacao0[0];
$tipo_contrato = $_POST['tipocontrato'];
$status = $_POST['status'];

if($NOMEoperador != '' && $IDmonitor != '' && $grupo != '' && $status != ''){
	
	$update = $conexao->query("UPDATE operadores SET nome = '".$NOMEoperador."', monitor = '".$IDmonitor."', grupo = '".$grupo."', tipo_contrato = '".$tipo_contrato."', data_admissao = '".$data_admissao."', data_efetivacao = '".$data_efetivacao."', status = '".$status."' WHERE operador_id = '".$IDoperador."'");
	
	
	}}



if(isset($_POST['salvar'])){
	
$login = $_POST['login'];
$nome = $_POST['nomeoperador'];
$cpf = $_POST['icpf'];
$grupo = $_POST['grupo'];
$nmonitor = $_POST['nomemonitor'];
$contrato = $_POST['contrato'];
$data_admissao0 = explode('/',$_POST['dataadmissao']);
$data_admissao = $data_admissao0[2].'-'.$data_admissao0[1].'-'.$data_admissao0[0];

$data_efetivacao0 = explode('/',$_POST['dataefetivacao']);
$data_efetivacao = $data_efetivacao0[2].'-'.$data_efetivacao0[1].'-'.$data_efetivacao0[0];

$status = $_POST['status'];

if($login != '' && $nome != '' && $grupo != '' && ($cpf!= '' && $cpf!='000.000.000-00') && ($data_admissao!='' && $data_admissao<=date('Y-m-d')) && $nmonitor != '' && $status != ''){

	$insert = $conexao->query("INSERT INTO operadores (login,nome,cpf,data_admissao,data_efetivacao,grupo,monitor,status) VALUES ('".$login."','".$nome."','".$cpf."','".$data_admissao."','".$data_efetivacao."','".$grupo."','".$nmonitor."','".$status."') ");
	
?>

<script>
window.alert('Operador inserido com sucesso!');
</script>
	
<?	
	
} else { ?>

<script>
window.alert('ERRO: Algum campo não foi preenchido corretamente!');
</script>	
	
<?	
}}


if(isset($_POST['logins'])){
	
	
$logins = explode(',',$_POST['logins']);

if($_POST['grupo'] != ''){ $grupo = ", grupo = '".$_POST['grupo']."'";}


if($_POST['nomemonitor'] != ''){ $monitor = ", monitor = '".$_POST['nomemonitor']."'"; }


if($_POST['tipocontrato'] != ''){ $contrato = ", tipo_contrato = '".$_POST['tipocontrato']."'"; }


if($_POST['status'] != ''){ $status = ", status = '".$_POST['status']."'";}

$n=0;
foreach($logins as $lo){ 
	
	if($lo != ''){
	$insert = $conexao->query("UPDATE operadores SET login = '".$lo."' ".$grupo.$monitor.$contrato.$status." WHERE login = '".$lo."'");
	$n++;
	}
	}	
	
?>

<script type="text/javascript">
alert("<?= $n;?> Operador(es) Modificado(s)!");
window.location = "?p=configuracoes&es=3"
</script>

<?	
	
	}

?>

<br />
<center>

<script type="text/javascript">

function addcheck(l){
		current = document.getElementById('logins').value;
	
	if(current.indexOf(l) != -1){ document.getElementById('logins').value = current.replace(l+",","");} else {
	
	document.getElementById('logins').value = current + l + ',';}
	}

</script>


<!-- INSERIR -->
<form name="novooperador" action="" method="post">
<input type="hidden" name="salvar" />
<? $conLOGIN = $conexao->query("SELECT * FROM operadores ORDER BY ABS(login) DESC");
$ultLOGIN = mysql_fetch_array($conLOGIN);
?>
<input type="hidden" value="<?= ($ultLOGIN['login']+1);?>" name="login" />
<table border="0" width="900px"style="color:#999; font-size:14px;">
<tr>
	<td colspan="2" style="color:#999; font-size:18px;">Inserir Operador</td>
</tr>


<tr bgcolor="#333" style="color:#FFF">
	<td>Nome:</td>
	<td>CPF :</td>
	<td>Produto:</td>
	<td>Monitor:</td>
</tr>

<tr bgcolor="#ededed">
	<td><input type="text" id="nome" name="nomeoperador" size="15" /></td>
	<td><input type="text" id="idcpf" name="icpf" onKeyPress="mascara(this,cpf)" maxlength="14" size="15" /></td>
	<td>
		<select name="grupo" id="grupo">
			<option value=""></option>
			<option value="0004" <? if($OPERADOR['grupooperador'] == '0004'){ ?>selected="selected" <? } ?>>Oi</option>
			<option value="0001|0004" <? if($OPERADOR['grupooperador'] == '0001|0004'){ ?>selected="selected" <? } ?>>Claro TV e Oi</option>
			<option value="0003|0004" <? if($OPERADOR['grupooperador'] == '0003|0004'){ ?>selected="selected" <? } ?>>Claro Fixo e Oi</option>
			<option value="0001" <? if($OPERADOR['grupooperador'] == '0001'){ ?>selected="selected" <? } ?>>Claro TV</option>
			<option value="0002" <? if($OPERADOR['grupooperador'] == '0002'){ ?>selected="selected" <? } ?>>Claro 3G</option>
			<option value="0003" <? if($OPERADOR['grupooperador'] == '0003'){ ?>selected="selected" <? } ?>>Claro FIXO</option>
			<option value="0001|0002" <? if($OPERADOR['grupooperador'] == '0001|0002'){ ?>selected="selected" <? } ?>>Claro TV e Claro 3G</option>
			<option value="0001|0003" <? if($OPERADOR['grupooperador'] == '0001|0003'){ ?>selected="selected" <? } ?>>Claro TV e Claro FIXO</option>
			<option value="0002|0003" <? if($OPERADOR['grupooperador'] == '0002|0003'){ ?>selected="selected" <? } ?>>Claro 3G e Claro Fixo</option>
			<option value="0001|0002|0003" <? if($OPERADOR['grupooperador'] == '0001|0002|0003'){ ?>selected="selected" <? } ?>>Claro TV, Claro 3G e Claro Fixo</option>
			<option value="0001|0002|0003|0004" <? if($OPERADOR['grupooperador'] == '0001|0002|0003|0004'){ ?>selected="selected" <? } ?>>Claro TV, Claro 3G, Claro Fixo e Oi</option>
		</select>
	</td>
	<td>
	<select name="nomemonitor">
	<option value=""></option>
	
	<?
	
	if($USUARIO['tipo_usuario'] == 'MONITOR'){ $ifmonitor = "&& id = ".$USUARIO['id']; }
	
	$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE tipo_usuario = 'MONITOR' ".$ifmonitor." && status != 'DESLIGADO' ORDER BY nome");
	while($MONITOR = mysql_fetch_array($conMONITORES)){
	
	?>
	<option value="<?= $MONITOR['id']; ?>" <? if($OPERADOR['idmonitor'] == $MONITOR['id']){ ?>selected="selected" <? } ?>><?= $MONITOR['nome']; ?></option>
	
	<? } ?>
	
	</select>
	</td>
</tr>
<tr>
	<td>Data Admiss&atilde;o:</td>
	<td>Tipo Contrato:</td>
	<td>Status:</td>
	<td>
</tr>
<tr>
	<td>
		<input type="text" name="dataadmissao"  onKeyPress="mascara(this,data)" maxlength="10" value="" placeholder="ex:(dd/mm/aaaa)">
	</td>
	<td>
		<select name="tipocontrato">
			<option value=""></option>
			<option value="TREINAMENTO">TREINAMENTO</option>
			<option value="EFETIVO">EFETIVO</option>
		</select>
	</td>
	<td>
		<select name="status">
		<option value=""></option>
		<option value="ATIVO" <? if($OPERADOR['statusoperador'] == 'ATIVO'){ ?>selected="selected" <? } ?>>ATIVO</option>
		<option value="DESLIGADO" <? if($OPERADOR['statusoperador'] == 'DESLIGADO'){ ?>selected="selected" <? } ?>>DESLIGADO</option>
		</select>
	</td>

	<td><img src="img/icone-salvar.png" width="20" style="cursor:pointer" title="Salvar" onclick="javascript:document.novooperador.submit();" /></td>
</tr>



<tr>
	<td colspan="100">
	<hr />
	</td>
</tr>

</table>
</form>
<br>
<!-- FIM INSERIR -->



<!-- PARA SELECIONADOS -->

<form name="checkactions" action="" method="post">
<input type="hidden" name="p" value="<?= $_GET['p'];?>" />
<input type="hidden" name="es" value="<?= $_GET['es'];?>" />
<input type="hidden" id="logins" name="logins" />


<table border="0" width="900px"style="color:#999; font-size:14px;" bgcolor="#f6f6f6">
<tr>
<td colspan="2" style="color:#999; font-size:18px;">Editar Selecionados</td>
</tr>


<tr bgcolor="#333" style="color:#FFF">
<td>Produto:</td>
<td>Monitor:</td>
<td>Tipo Contrato:</td>
<td>Status:</td>
<td>
</tr>

<tr bgcolor="#CCC">
<td>
<select name="grupo" id="grupo">
<option value=""></option>
<option value="0004" <? if($OPERADOR['grupooperador'] == '0004'){ ?>selected="selected" <? } ?>>Oi</option>
<option value="0001|0004" <? if($OPERADOR['grupooperador'] == '0001|0004'){ ?>selected="selected" <? } ?>>Claro TV e Oi</option>
<option value="0003|0004" <? if($OPERADOR['grupooperador'] == '0003|0004'){ ?>selected="selected" <? } ?>>Claro Fixo e Oi</option>
<option value="0001" <? if($OPERADOR['grupooperador'] == '0001'){ ?>selected="selected" <? } ?>>Claro TV</option>
<option value="0002" <? if($OPERADOR['grupooperador'] == '0002'){ ?>selected="selected" <? } ?>>Claro 3G</option>
<option value="0003" <? if($OPERADOR['grupooperador'] == '0003'){ ?>selected="selected" <? } ?>>Claro FIXO</option>
<option value="0001|0002" <? if($OPERADOR['grupooperador'] == '0001|0002'){ ?>selected="selected" <? } ?>>Claro TV e Claro 3G</option>
<option value="0001|0003" <? if($OPERADOR['grupooperador'] == '0001|0003'){ ?>selected="selected" <? } ?>>Claro TV e Claro FIXO</option>
<option value="0002|0003" <? if($OPERADOR['grupooperador'] == '0002|0003'){ ?>selected="selected" <? } ?>>Claro 3G e Claro Fixo</option>
<option value="0001|0002|0003" <? if($OPERADOR['grupooperador'] == '0001|0002|0003'){ ?>selected="selected" <? } ?>>Claro TV, Claro 3G e Claro Fixo</option>
<option value="0001|0002|0003|0004" <? if($OPERADOR['grupooperador'] == '0001|0002|0003|0004'){ ?>selected="selected" <? } ?>>Claro TV, Claro 3G, Claro Fixo e Oi</option>

</select>
</td>
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

<td>
<select name="tipocontrato">
<option value=""></option>
<option value="TREINAMENTO">TREINAMENTO</option>
<option value="EFETIVO">EFETIVO</option>
</select>
</td>
<td>
<select name="status">
<option value=""></option>
<option value="ATIVO" <? if($OPERADOR['statusoperador'] == 'ATIVO'){ ?>selected="selected" <? } ?>>ATIVO</option>
<option value="DESLIGADO" <? if($OPERADOR['statusoperador'] == 'DESLIGADO'){ ?>selected="selected" <? } ?>>DESLIGADO</option>
</select>
</td>

<td>
	<img src="img/icone-salvar.png" width="20" style="cursor:pointer" title="Salvar" onclick="javascript:document.checkactions.submit();" />
</td>
</tr>



<tr height="10px">
<td colspan="100">
</td>
</tr>

</table>
</form>

<!-- FIM PARA SELECIONADOS -->

<!-- LISTA -->
<table border="0" width="900px">

	<input type="hidden" name="o" value="<?= $_GET['o'];?>" />

	<tr style="color:#FFF; font-size:14px; font-weight:bold; cursor:pointer;" class="tr1" align="center">
		<td></td>
		
		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'ABS(operadores.login) ASC'){ echo 'ABS(operadores.login) ASC'; } 
		else { echo 'ABS(operadores.login) DESC'; }?>'">Login<? if($_GET['o'] == 'ABS(operadores.login) DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'ABS(operadores.login) ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'operadores.data_admissao ASC'){ echo 'operadores.data_admissao ASC'; } 
		else { echo 'operadores.data_admissao DESC'; }?>'">Data Admissão<? if($_GET['o'] == 'operadores.data_admissao DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operadores.data_admissao ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'operadores.data_efetivacao ASC'){ echo 'operadores.data_efetivacao ASC'; } 
		else { echo 'operadores.data_efetivacao DESC'; }?>'">Data Efetivação<? if($_GET['o'] == 'operadores.data_efetivacao DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operadores.data_efetivacao ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>
		
		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'operadores.nome ASC'){ echo 'operadores.nome ASC'; } 
		else { echo 'operadores.nome DESC'; }?>'">Nome do Operador<? if($_GET['o'] == 'operadores.nome DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operadores.nome ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'operadores.cpf ASC'){ echo 'operadores.cpf ASC'; } 
		else { echo 'operadores.cpf DESC'; }?>'">CPF<? if($_GET['o'] == 'operadores.cpf DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operadores.cpf ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>

		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'usuarios.nome ASC'){ echo 'usuarios.nome ASC'; } 
		else { echo 'usuarios.nome DESC'; }?>'">Monitor<? if($_GET['o'] == 'usuarios.nome DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'usuarios.nome ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>
		
		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'operadores.grupo ASC'){ echo 'operadores.grupo ASC'; } 
		else { echo 'operadores.grupo DESC'; }?>'">Produto<? if($_GET['o'] == 'operadores.grupo DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operadores.grupo ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>
		
		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'operadores.tipo_contrato ASC'){ echo 'operadores.tipo_contrato ASC'; } 
		else { echo 'operadores.tipo_contrato DESC'; }?>'">Tipo Contrato<? if($_GET['o'] == 'operadores.tipo_contrato DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operadores.tipo_contrato ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>	
		
		<td title="Login" onclick="window.location = '?p=configuracoes&m=<?= $_GET['m'];?>&an=<?= $_GET['an'];?>&es=<?= $_GET['es'];?>
		&o=<? if($_GET['o'] != 'operadores.status ASC'){ echo 'operadores.status ASC'; } 
		else { echo 'operadores.status DESC'; }?>'">Status<? if($_GET['o'] == 'operadores.status DESC'){ ?>
		<img src="img/seta-d.png" /> <? } else if($_GET['o'] == 'operadores.status ASC'){ ?> <img src="img/seta-u.png" /> <? } ?></td>
		
		<td></td>
	</tr>


<?

$class = "tr2";

$ordem = $_GET['o'];

if($ordem == ''){ $ordem = ' operadores.nome ASC';}

if($USUARIO['tipo_usuario'] == 'MONITOR'){

	$QUERY = "AND usuarios.id = '".$USUARIO['id']."'
			  ORDER BY ".$ordem;
}else{
	$QUERY = "ORDER BY ".$ordem;
}

$conOPERADORES = $conexao->query("SELECT *, operadores.login AS loginoperador,
											DATE_FORMAT(operadores.data_admissao, '%d/%m/%Y') AS dataadmissao,
											DATE_FORMAT(operadores.data_efetivacao, '%d/%m/%Y') AS dataefetivacao,
											operadores.nome AS nomeoperador, 
											operadores.cpf AS cpfoperador, 
  											operadores.operador_id AS idoperador,
											usuarios.nome AS nomemonitor, 
											usuarios.id AS idmonitor,
											operadores.grupo AS grupooperador,
											operadores.tipo_contrato AS contratooperador,
											operadores.status AS statusoperador
											FROM operadores 
											INNER JOIN usuarios ON operadores.monitor = usuarios.id 
											WHERE operadores.status != 'DESLIGADO'".$QUERY								
											);
while($OPERADOR = mysql_fetch_array($conOPERADORES)){


if($class == "tr2"){ $class = "tr3";} else { $class = "tr2";}

?>


<tr class="<?= $class;?>" align="center" id="tr<?= $OPERADOR['idoperador'];?>">
<td><input type="checkbox" name="checkop" onclick="addcheck(this.value)" value="<?= $OPERADOR['loginoperador'];?>" /></td>
<td><?= $OPERADOR['loginoperador'];?></td>
<td><?= $OPERADOR['dataadmissao'];?></td>
<td><?= $OPERADOR['dataefetivacao'];?></td>
<td><?= $OPERADOR['nomeoperador'];?></td>
<td><?= $OPERADOR['cpfoperador'];?></td>

<td><?= $OPERADOR['nomemonitor'];?></td>
<td>
<? if($OPERADOR['grupooperador'] == '0004'){$produto = 'Oi';}
else if($OPERADOR['grupooperador'] == '0001|0004'){$produto = 'Claro TV e Oi';}
else if($OPERADOR['grupooperador'] == '0003|0004'){$produto = 'Claro Fixo e Oi';}
else if($OPERADOR['grupooperador'] == '0001'){$produto = 'Claro TV';}
else if($OPERADOR['grupooperador'] == '0002'){$produto = 'Claro 3G';}
else if($OPERADOR['grupooperador'] == '0003'){$produto = 'Claro FIXO';}
else if($OPERADOR['grupooperador'] == '0001|0002'){$produto = 'Claro TV e Claro 3G';}
else if($OPERADOR['grupooperador'] == '0001|0003'){$produto = 'Claro TV e Claro FIXO';}
else if($OPERADOR['grupooperador'] == '0002|0003'){$produto = 'Claro 3G e Claro Fixo';}
else if($OPERADOR['grupooperador'] == '0001|0002|0003'){$produto = 'Claro TV, Claro 3G e Claro Fixo';}
else if($OPERADOR['grupooperador'] == '0001|0002|0003|0004'){$produto = 'Claro TV, Claro 3G, Claro Fixo e Oi';}

echo $produto;
?>


</td>
<td><?= $OPERADOR['contratooperador'];?></td>
<td><?= $OPERADOR['statusoperador'];?></td>

<td><img src="img/icone-editar.png" onclick="editar(<?= $OPERADOR['idoperador'];?>)" style="cursor:pointer" /></td>
</tr>


<form action="" method="post" name="form<?= $OPERADOR['idoperador'];?>">
<tr class="<?= $class;?>" align="center" id="tredit<?= $OPERADOR['idoperador'];?>" style="display:none;">
<td></td>
<td><?= $OPERADOR['loginoperador'];?></td>

<td><input style="font-size: 11px;" type="text" name="dataadmissao" size="10" value="<?= $OPERADOR['dataadmissao'];?>" /></td>

<td><input style="font-size: 11px;" type="text" name="dataefetivacao" size="10" value="<?= $OPERADOR['dataefetivacao'];?>" /></td>

<td>
<input type="hidden" name="idoperador" value="<?= $OPERADOR['idoperador'];?>" />
<input style="font-size: 11px;" type="text" name="nomeoperador" value="<?= $OPERADOR['nomeoperador'];?>" /></td>
<td><?= $OPERADOR['cpfoperador'];?></td>

<td>
<select style="font-size: 11px; name="nomemonitor">
<?

$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE tipo_usuario = 'MONITOR' && status != 'DESLIGADO' ORDER BY nome");
while($MONITOR = mysql_fetch_array($conMONITORES)){

?>
<option style="font-size: 11px; value="<?= $MONITOR['id']; ?>" <? if($OPERADOR['idmonitor'] == $MONITOR['id']){ ?>selected="selected" <? } ?>><?= $MONITOR['nome']; ?></option>

<? } ?>

</select>
</td>
<td>
<?   if($OPERADOR['grupooperador'] == '0004'){$produto = 'Oi';}
else if($OPERADOR['grupooperador'] == '0001|0004'){$produto = 'Claro TV e Oi';}
else if($OPERADOR['grupooperador'] == '0003|0004'){$produto = 'Claro Fixo e Oi';}
else if($OPERADOR['grupooperador'] == '0001'){$produto = 'Claro TV';}
else if($OPERADOR['grupooperador'] == '0002'){$produto = 'Claro 3G';}
else if($OPERADOR['grupooperador'] == '0003'){$produto = 'Claro FIXO';}
else if($OPERADOR['grupooperador'] == '0001|0002'){$produto = 'Claro TV e Claro 3G';}
else if($OPERADOR['grupooperador'] == '0001|0003'){$produto = 'Claro TV e Claro FIXO';}
else if($OPERADOR['grupooperador'] == '0002|0003'){$produto = 'Claro 3G e Claro Fixo';}
else if($OPERADOR['grupooperador'] == '0001|0002|0003'){$produto = 'Claro TV, Claro 3G e Claro Fixo';}
else if($OPERADOR['grupooperador'] == '0001|0002|0003|0004'){$produto = 'Claro TV, Claro 3G, Claro Fixo e Oi';}

?>

<select style="font-size: 11px;" name="grupo">
<option value="0004" <? if($OPERADOR['grupooperador'] == '0004'){ ?>selected="selected" <? } ?>>Oi</option>
<option value="0001|0004" <? if($OPERADOR['grupooperador'] == '0001|0004'){ ?>selected="selected" <? } ?>>Claro TV e Oi</option>
<option value="0003|0004" <? if($OPERADOR['grupooperador'] == '0003|0004'){ ?>selected="selected" <? } ?>>Claro Fixo e Oi</option>
<option value="0001" <? if($OPERADOR['grupooperador'] == '0001'){ ?>selected="selected" <? } ?>>Claro TV</option>
<option value="0002" <? if($OPERADOR['grupooperador'] == '0002'){ ?>selected="selected" <? } ?>>Claro 3G</option>
<option value="0003" <? if($OPERADOR['grupooperador'] == '0003'){ ?>selected="selected" <? } ?>>Claro FIXO</option>
<option value="0001|0002" <? if($OPERADOR['grupooperador'] == '0001|0002'){ ?>selected="selected" <? } ?>>Claro TV e Claro 3G</option>
<option value="0001|0003" <? if($OPERADOR['grupooperador'] == '0001|0003'){ ?>selected="selected" <? } ?>>Claro TV e Claro FIXO</option>
<option value="0002|0003" <? if($OPERADOR['grupooperador'] == '0002|0003'){ ?>selected="selected" <? } ?>>Claro 3G e Claro Fixo</option>
<option value="0001|0002|0003" <? if($OPERADOR['grupooperador'] == '0001|0002|0003'){ ?>selected="selected" <? } ?>>Claro TV, Claro 3G e Claro Fixo</option>
<option value="0001|0002|0003|0004" <? if($OPERADOR['grupooperador'] == '0001|0002|0003|0004'){ ?>selected="selected" <? } ?>>Claro TV, Claro 3G, Claro Fixo e Oi</option>

</select>

</td>

<td>
	<select style="font-size: 11px;" name="tipocontrato">
		<option value="EFETIVO" <? if($OPERADOR['tipo_contrato'] == 'EFETIVO'){ ?>selected="selected" <? } ?>>EFETIVO</option>
		<option value="TREINAMENTO" <? if($OPERADOR['tipo_contrato'] == 'TREINAMENTO'){ ?>selected="selected" <? } ?>>TREINAMENTO</option>
	</select>
</td>


<td>

<select style="font-size: 11px;"name="status">

<option value="ATIVO" <? if($OPERADOR['statusoperador'] == 'ATIVO'){ ?>selected="selected" <? } ?>>ATIVO</option>
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
