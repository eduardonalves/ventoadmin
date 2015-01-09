<?
include_once "lib/class.MetasNet.php";

$metasNet = new metasNet($conexao);

if($USUARIO['tipo_usuario'] == 'ADMINISTRADOR'){



if($_GET['m'] != ""){ $mes = $_GET['m']; } else {$mes = date("m");}
if($_GET['an'] != ""){ $ano = $_GET['an']; } else {$ano = date("Y");}

switch ($mes) {
        case "01":    $m = Janeiro;     break;
        case "02":    $m = Fevereiro;   break;
        case "03":    $m = Março;       break;
        case "04":    $m = Abril;       break;
        case "05":    $m = Maio;        break;
        case "06":    $m = Junho;       break;
        case "07":    $m = Julho;       break;
        case "08":    $m = Agosto;      break;
        case "09":    $m = Setembro;    break;
        case "10":    $m = Outubro;     break;
        case "11":    $m = Novembro;    break;
        case "12":    $m = Dezembro;    break; 
 }
	
/////////////////////////////////////////

$produto = $_GET['pro'];



if(isset($_POST['salvar'])){

	if ( isset($_POST['metand']) ){
		
		$myMetaNd = $_POST['metand'];
		
		$metasNet->inserirMetaND($ano.$mes, $myMetaNd);
		
	}

	if ( isset($_POST['metaempresa']) ){
		
		$myMetaEmpresa = $_POST['metaempresa'];
		
		$metasNet->inserirMetaEmpresa($ano.$mes, $myMetaEmpresa);
		
	}

	if ( isset($_POST['metacelular']) ){
		
		$myMetaCelular = $_POST['metacelular'];
		
		$metasNet->inserirBonusCelular($ano.$mes, $myMetaCelular);
		
	}

		
		$myMetaCombinado = $_POST['combinado'];
		$metasNet->inserirMetaPersonalizada('combinada', $ano.$mes, $myMetaCombinado);
		

		$myMetaEspecial = $_POST['especial1'];
		$metasNet->inserirMetaPersonalizada('especial1', $ano.$mes, $myMetaEspecial);
		
		
		$myMetaEspecial = $_POST['especial2'];
		$metasNet->inserirMetaPersonalizada('especial2', $ano.$mes, $myMetaEspecial);
		
		
		$myMetaEspecial = $_POST['especial3'];
		$metasNet->inserirMetaPersonalizada('especial3', $ano.$mes, $myMetaEspecial);
		

?>
<script type="text/javascript">

alert('Metas salvas com sucesso!');
window.location = '?p=<?= $_GET['p'];?>&pro=<?= $produto;?>&m=<?= $mes;?>&an=<?= $ano;?>&es=<?= $_GET['es'];?>';

</script>



<?
}


/////////////////////////////////////////


?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<style type="text/css">

input[type="submit"]{ padding:7px; border:1px solid #CCC; color:#777;
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

input[type="submit"]:hover{ border:1px solid #AAA; color:#434343; cursor:pointer;}

input[type="submit"]:active{ background:#ededed;}


blockquote select, blockquote input{
	
	background-color:#FFF;
	border:#CCC 1px solid;
	border-radius:0.3em;	
}

</style>


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
    	
	

///////////////////////////////////////////
///////////////////////////////////////////


$(document).ready(function(e) {

	$(".fields").html("\
						\
						<option value=\"\"></option>\
						<option value=\"netTipoContrato\">Tipo Contrato</option>\
						<option value=\"netPerfil\">Perfil</option>\
						<option value=\"comboServicos\">Produto</option>\
						<option value=\"netGrupo\">Grupo</option>\
					");


	$(".sinais").html("\
						\
						<option value=\"\"></option>\
						<option value=\"=\">Igual a</option>\
						<option value=\"tem\">tem</option>\
					");

	$(".valores").html("<option value=\"\"></option>");
	
	
	$(document).on('change','.fields',function(){
	
		$parentClass = $(this).parent().attr('class');
		$campo = $('option:selected', this).val();
		
		if ($campo == 'netTipoContrato'){

			$("." + $parentClass + " .valores").html("\
													<option value=\"\"></option>\
													<option value=\"VENDA\">VENDA</option>\
													<option value=\"PME\">PME</option>\
													<option value=\"INCLUSÃO\">INCLUSÃO</option>\
													\
													");
			
		} else if ($campo == 'netPerfil') {

			$("." + $parentClass + " .valores").html("\
													<option value=\"\"></option>\
													<option value=\"COMBO\">COMBO</option>\
													<option value=\"COMBO MULTI\">COMBO MULTI</option>\
													<option value=\"DOUBLO\">DOUBLO</option>\
													<option value=\"SINGLE\">SINGLE</option>\
													<option value=\"COLETIVO\">COLETIVO</option>\
													\
													");
			
		} else if ($campo == 'comboServicos') {

			$("." + $parentClass + " .valores").html("\
													<option value=\"\"></option>\
													<option value=\"NET FONE\">NET FONE</option>\
													<option value=\"NET TV\">NET TV</option>\
													<option value=\"VIRTUA\">VIRTUA</option>\
													<option value=\"CELULAR\">CELULAR</option>\
													\
													");
			
		} else if ($campo == 'netGrupo') {

			$("." + $parentClass + " .valores").html("\
													<option value=\"\"></option>\
													<option value=\"GP1\">GP1</option>\
													<option value=\"GP2\">GP2</option>\
													<option value=\"GP3\">GP3</option>\
													\
													");			
		}
		
		if ( $(this).val() == 'comboServicos'){

			$("." + $parentClass + " .sinais").html("\
													<option value=\"\"></option>\
													<option value=\"=\">Igual a</option>\
													<option value=\"tem\">tem</option>\
													\
													");
			
		}else{
			
			$("." + $parentClass + " .sinais").html("\
													<option value=\"\"></option>\
													<option value=\"=\">Igual a</option>\
													\
													");
			
		}
		
	});
	
	
	$(document).on('click','.remove-field',function(){
		
		var	$campo = $(this).attr('data-campo');
		var $del = confirm("Você realmente deseja remover o campo \"" + $campo + "\"?");
		
		if ($del == true){

			$(this).parent().remove();
		}

	});
	
	
	$(document).on('click', '.add-field', function(){
		
		var $myParent = $(this).parent();
		var $box =  $(this).attr('data-boxid');
		var $campo = $(this).attr('data-meta');

		var $elementCampo = "\
						<div class=\"field-item\">\
						<label style=\"font-size:12px\">Campo:</label>\
						\
						<select name=\"" + $campo + "[" + $(".fields option:selected", $myParent).val() + "]\"> \
							<option value=\"" + $(".fields option:selected", $myParent).val() + "\">\
								" + $(".fields option:selected", $myParent).text() + "\
							</option>\
						</select>\
						\
						<select name=\"" + $campo + "[" + $(".fields option:selected", $myParent).val() + "][sinal]\"> \
							<option value=\"" + $(".sinais option:selected", $myParent).val() + "\">\
								" + $(".sinais option:selected", $myParent).text() + "\
							</option>\
						</select>\
						\
						<select name=\"" + $campo + "[" + $(".fields option:selected", $myParent).val() + "][valor]\"> \
							<option value=\"" + $(".valores option:selected", $myParent).val() + "\">\
								" + $(".valores option:selected", $myParent).text() + "\
							</option>\
						</select>\
						\
						<input name=\"" + $campo + "[" + $(".fields option:selected", $myParent).val() + "][quantidade]\" type=\"text\" placeholder=\"Quant.\" size=\"7\" value=\"" + $(".quantidade", $myParent).val() + "\">\
						\
	<img src=\"img/delete-icon.png\" style=\"width:13px;margin-left:10px; cursor:pointer;\" data-campo=\""+$(".fields option:selected", $myParent).text()+"\" class=\"remove-field\" title=\"Remover Campo\" data-meta=\"combinado\" data-boxid=\"campos-combinado\">\
	<br><br>\
	</div>";
	
	$("#" + $box + " blockquote .sem-registro").remove();
	$($elementCampo).appendTo($("#" + $box + " blockquote"));
//	.append($elementCampo);
			//alert( $(element).val() + " : " + $('option:selected', element).text()  );
			//alert(element.nodeName);
//			alert($elementCampo);

		
	});
	
});

</script>



<center>

<table border="0" width="90%" height="500px">
<tr valign="top">
<td>

<table border="0" width="1000px">

<tr valign="bottom" height="40px" align="left">
<td style="font-size:14px; color:#999;" colspan="2">DEFINIR METAS PARA O MÊS DE <b><?= strtoupper($m).' DE '.$ano;?></b></td>

</tr>

<tr>
<td colspan="2"><hr size="1" color="#CCCCCC" /></td>
</tr>


<tr style="font-size:13px" height="40px" valign="middle" align="left" bgcolor="#f6f6f6">
<td  align="center" width="100px">Produto:</td>
<td>
<form name="selectproduto" action="" method="get">
<input type="hidden" name="p" value="<?= $_GET['p'];?>" />
<input type="hidden" name="es" value="<?= $_GET['es'];?>" />

<select name="pro" onchange="javascript:document.forms.selectproduto.submit();">
<option value=""></option>
<?php 

	$curUserGroups = explode('|', $USUARIO['grupo']);

	foreach( $curUserGroups as $group ){
		
		$grupoName = mysql_result($conexao->query('Select menu from menu where grupo=\'' . $group . '\''), 0 ,'menu');
?>
		<option value="<?php echo $group; ?>" <? if($produto == $group) { ?> selected="selected" <? } ?>><?php echo $grupoName; ?></option>

	<?php 
	}
	?>


</select>
</form>
</td>
</tr>

</table>

<table border="0" width="1000px">
<form name="filtro" method="get">
<input type="hidden" name="p" value="<?= $_GET['p'];?>" />
<input type="hidden" name="es" value="<?= $_GET['es'];?>" />

<tr style="font-size:13px" height="40px" valign="middle" align="left" bgcolor="#f6f6f6">
<td>
&nbsp; &nbsp; &nbsp;

Mês: 
<select name="m">
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

| Ano: 
<select name="an">
<? $a = date('Y'); while($a > '2011'){ $an = $a--; ?>

<option value="<?= $an; ?>" <? if($ano == $an){ ?> selected="selected" <? } ?>><?= $an; ?></option>

<? } ?>
</select>
<input type="hidden" name="pro" value="<?= $_GET['pro'];?>" />

&nbsp;
<img src="img/bt_ok.png" style="position:absolute; margin-top:3px; cursor:pointer" onclick="javascript:document.forms.filtro.submit();" />
</td>
</tr>
</form>

<tr>
<td colspan="2"><hr size="1" color="#CCCCCC" /></td>
</tr>
</table>


<form name="meta" method="post" action="">
<table border="0" width="470px" <? if($produto == ''){?> style="display:none" <? } ?>>



<?php
$metaND = $metasNet->getMetaND($ano.$mes);
$metaND = ($metaND) ? $metaND['meta'] : "";
?>
<tr>
<td width="150px">Meta ND:</td>
<td><input type="text"  name="metand" value="<?php echo $metaND; ?>" onkeyup="mascara(this,soNumeros)" onchange="mascara(this,soNumeros)" maxlength="5" size="7" /></td>
</tr>

<?php
$metaEmpresa = $metasNet->getMetaEmpresa($ano.$mes);
$metaEmpresa = ($metaEmpresa) ? $metaEmpresa['meta'] : "";
?>

<tr>
<td width="150px">Net Empresa:</td>
<td><input type="text" name="metaempresa" value="<?php echo $metaEmpresa; ?>" onkeyup="mascara(this,soNumeros)" onchange="mascara(this,soNumeros)" maxlength="5"  size="7" /></td>
</tr>

<?php
$metaCelular = $metasNet->getBonusCelular($ano.$mes);
$metaCelular = ($metaCelular) ? $metaCelular['meta'] : "";
?>

<tr>
<td width="150px">Bônus Celular:</td>
<td><input type="text" name="metacelular" value="<?php echo $metaCelular; ?>" onkeyup="mascara(this,soNumeros)" onchange="mascara(this,soNumeros)" maxlength="5"  size="7" /></td>
</tr>

<tr height="30px">
<td colspan="2"></td>
</tr>

</table>

<div style="width:100%; padding-bottom:20px;">

<hr style="width:100%" />
<label><h4>Meta Combinada:</h4></label>

<blockquote>
	<div class="combinado-add">
	<span style="font-size:12px">Adicionar Campo:</span>
	<select class="fields">

		<option value=""></option>

	</select>


	<select class="sinais">

		<option value=""></option>
		<option value="=">Igual a</option>
		<option value=">="</option>Maior igual a</option>
		<option value="<=">Menor igual a</option>
		<option value="!=">Diferente de</option>

	</select>

	<select class="valores">

		<option value=""></option>
		<option value="NET FONE">net Fone</option>
		<option value="VIRTUA"</option>Virtua</option>
	</select>

	<input class="quantidade" onkeyup="mascara(this,soNumeros)" type="text" placeholder="Quant." size="7">

	<img src="img/add.png" style="margin-left:10px; cursor:pointer;" class="add-field" title="Adicionar Campo" data-meta="combinado" data-boxid="campos-combinado">
    </div>
	
    <br><br>
	
    <div id="campos-combinado">
		<br>
		<span>Campos da meta Combinada:</span>
		<blockquote>
		<br>

		<?php

		$camposCombinada = $metasNet->getCamposFromMeta($ano.$mes, 'combinada');
		if(!$camposCombinada){
			echo "<span class=\"sem-registro\" style=\"color:red; font-size:12px;\">Não há registros neste período.</span>";	
		}

		foreach ($camposCombinada as $campo=>$data){
		?>
		<div class="field-item">
		<label style="font-size:12px">Campo:</label>
		
		<select name="combinado[<?php echo $campo;?>]">

			<option value="<?php echo $campo;?>"><?php echo $campo;?></option>

		</select>


		<select name="combinado[<?php echo $campo;?>][sinal]">

			<option value="<?php echo $data->sinal;?>"><?php echo $data->sinal;?></option>

		</select>

		<select name="combinado[<?php echo $campo;?>][valor]">

			<option value="<?php echo $data->valor;?>"><?php echo $data->valor;?></option>

		</select>
		
	<input name="combinado[<?php echo $campo;?>][quantidade]" type="text" placeholder="Quant." size="7" value="<?php echo $data->quantidade;?>">
	
	<img src="img/delete-icon.png" style="width:13px;margin-left:10px; cursor:pointer;" data-campo="<?php echo $campo;?>" class="remove-field" title="Remover Campo">
	<br><br>
    </div>

		<?php
		}
		?>
		</blockquote>
	</div>
	
</blockquote>

<hr style="width:100%" />
<label><h4>Especial 1:</h4></label>

<blockquote>
	<div class="especial1-add">
	<span style="font-size:12px">Adicionar Campo:</span>
	<select class="fields">

		<option value=""></option>
		<option value="netTipoContrato">Tipo Contrato</option>
		<option value="netPerfil">Perfil</option>
		<option value="comboServicos">Produto</option>
	</select>


	<select class="sinais">

		<option value=""></option>
		<option value="=">Igual a</option>
		<option value=">="</option>Maior igual a</option>
		<option value="<=">Menor igual a</option>
		<option value="!=">Diferente de</option>
	</select>

	<select class="valores">

		<option value=""></option>
		<option value="NET FONE">net Fone</option>
		<option value="VIRTUA"</option>Virtua</option>
	</select>

	<input class="quantidade" onkeyup="mascara(this,soNumeros)" type="text" placeholder="Quant." size="7">

	<img src="img/add.png" style="margin-left:10px; cursor:pointer;" class="add-field" title="Adicionar Campo" data-meta="especial1" data-boxid="campos-especial1">
    </div>
	
    <br><br>
	
    <div id="campos-especial1">
		<br>
		<span>Campos da meta Especial 1:</span>
		<blockquote>
		<br>

		<?php

		$camposCombinada = $metasNet->getCamposFromMeta($ano.$mes, 'especial1');
		if(!$camposCombinada){
			echo "<span class=\"sem-registro\" style=\"color:red; font-size:12px;\">Não há registros neste período.</span>";	
		}
		foreach ($camposCombinada as $campo=>$data){
		?>
		<div class="field-item">
		<label style="font-size:12px">Campo:</label>
		
		<select name="especial1[<?php echo $campo;?>]">

			<option value="<?php echo $campo;?>"><?php echo $campo;?></option>

		</select>


		<select name="especial1[<?php echo $campo;?>][sinal]">

			<option value="<?php echo $data->sinal;?>"><?php echo $data->sinal;?></option>

		</select>

		<select name="especial1[<?php echo $campo;?>][valor]">

			<option value="<?php echo $data->valor;?>"><?php echo $data->valor;?></option>

		</select>
		
	<input name="especial1[<?php echo $campo;?>][quantidade]" type="text" placeholder="Quant." size="7" value="<?php echo $data->quantidade;?>">
	
	<img src="img/delete-icon.png" style="width:13px;margin-left:10px; cursor:pointer;" data-campo="<?php echo $campo;?>" class="remove-field" title="Remover Campo">
	<br><br>
    </div>

		<?php
		}
		?>
		</blockquote>
	</div>
	
</blockquote>

<hr style="width:100%" />
<label><h4>Especial 2:</h4></label>

<blockquote>
	<div class="especial2-add">
	<span style="font-size:12px">Adicionar Campo:</span>
	<select class="fields">

		
	</select>


	<select class="sinais">

		<option value=""></option>
		<option value="=">Igual a</option>
		<option value=">="</option>Maior igual a</option>
		<option value="<=">Menor igual a</option>
		<option value="!=">Diferente de</option>
	</select>

	<select class="valores">

		<option value=""></option>
		<option value="NET FONE">net Fone</option>
		<option value="VIRTUA"</option>Virtua</option>
	</select>

	<input class="quantidade" onkeyup="mascara(this,soNumeros)" type="text" placeholder="Quant." size="7">

	<img src="img/add.png" style="margin-left:10px; cursor:pointer;" class="add-field" title="Adicionar Campo" data-meta="especial2" data-boxid="campos-especial2">
    </div>
	
    <br><br>
	
    <div id="campos-especial2">
		<br>
		<span>Campos da meta Especial 2:</span>
		<blockquote>
		<br>

		<?php

		$camposCombinada = $metasNet->getCamposFromMeta($ano.$mes, 'especial2');
		if(!$camposCombinada){
			echo "<span class=\"sem-registro\" style=\"color:red; font-size:12px;\">Não há registros neste período.</span>";	
		}

		foreach ($camposCombinada as $campo=>$data){
		?>
		<div class="field-item">
		<label style="font-size:12px">Campo:</label>
		
		<select name="especial2[<?php echo $campo;?>]">

			<option value="<?php echo $campo;?>"><?php echo $campo;?></option>

		</select>


		<select name="especial2[<?php echo $campo;?>][sinal]">

			<option value="<?php echo $data->sinal;?>"><?php echo $data->sinal;?></option>

		</select>

		<select name="especial2[<?php echo $campo;?>][valor]">

			<option value="<?php echo $data->valor;?>"><?php echo $data->valor;?></option>

		</select>
		
	<input name="especial2[<?php echo $campo;?>][quantidade]" type="text" placeholder="Quant." size="7" value="<?php echo $data->quantidade;?>">
	
	<img src="img/delete-icon.png" style="width:13px;margin-left:10px; cursor:pointer;" data-campo="<?php echo $campo;?>" class="remove-field" title="Remover Campo">
	<br><br>
    </div>

		<?php
		}
		?>
		</blockquote>
	</div>
	
</blockquote>
<hr style="width:100%" />
<label><h4>Especial 3:</h4></label>

<blockquote>
	<div class="especial3-add">
	<span style="font-size:12px">Adicionar Campo:</span>
	<select class="fields">

		<option value=""></option>
		<option value="netTipoContrato">Tipo Contrato</option>
		<option value="netPerfil">Perfil</option>
		<option value="comboServicos">Produto</option>
	</select>


	<select class="sinais">

		<option value=""></option>
		<option value="=">Igual a</option>
		<option value=">="</option>Maior igual a</option>
		<option value="<=">Menor igual a</option>
		<option value="!=">Diferente de</option>
	</select>

	<select class="valores">

		<option value=""></option>
		<option value="NET FONE">net Fone</option>
		<option value="VIRTUA"</option>Virtua</option>
	</select>

	<input class="quantidade" onkeyup="mascara(this,soNumeros)" type="text" placeholder="Quant." size="7">

	<img src="img/add.png" style="margin-left:10px; cursor:pointer;" class="add-field" title="Adicionar Campo" data-meta="especial3" data-boxid="campos-especial3">
    </div>
	
    <br><br>
	
    <div id="campos-especial3">
		<br>
		<span>Campos da meta Especial 3:</span>
		<blockquote>
		<br>

		<?php

		$camposCombinada = $metasNet->getCamposFromMeta($ano.$mes, 'especial3');
		if(!$camposCombinada){
			echo "<span class=\"sem-registro\" style=\"color:red; font-size:12px;\">Não há registros neste período.</span>";	
		}

		foreach ($camposCombinada as $campo=>$data){
		?>
		<div class="field-item">
		<label style="font-size:12px">Campo:</label>
		
		<select name="especial3[<?php echo $campo;?>]">

			<option value="<?php echo $campo;?>"><?php echo $campo;?></option>

		</select>


		<select name="especial3[<?php echo $campo;?>][sinal]">

			<option value="<?php echo $data->sinal;?>"><?php echo $data->sinal;?></option>

		</select>

		<select name="especial3[<?php echo $campo;?>][valor]">

			<option value="<?php echo $data->valor;?>"><?php echo $data->valor;?></option>

		</select>
		
	<input name="especial3[<?php echo $campo;?>][quantidade]" type="text" placeholder="Quant." size="7" value="<?php echo $data->quantidade;?>">
	
	<img src="img/delete-icon.png" style="width:13px;margin-left:10px; cursor:pointer;" data-campo="<?php echo $campo;?>" class="remove-field" title="Remover Campo">
	<br><br>
    </div>

		<?php
		}
		?>
		</blockquote>
	</div>
	
</blockquote>
</div>

<input type="submit" name="salvar" value="Salvar" />

<input type="hidden" name="p" value="<?= $_GET['p'];?>" />
<input type="hidden" name="pro" value="<?= $_GET['pro'];?>" />
<input type="hidden" name="es" value="<?= $_GET['es'];?>" />


</form>

</td></tr></table>

</center>

<br />
<br />

<? } ?>
