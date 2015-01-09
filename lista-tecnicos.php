<?php
include_once "conexao.php";
include_once "lib/class.Usuarios.php";

$objUsuario = new Usuarios;
$table = ( (isset($_GET['produto'])) && ($_GET['produto']=='net') ) ? 'tecnicosnet' : 'tecnicos';

if ( (! isset($_GET['produto'])) || $_GET['produto']=='') {
	
	if ( in_array('0001', $objUsuario->grupos) ){
		
		$produto = 'clarotv';
	
	}elseif ( in_array('0010', $objUsuario->grupos) ) {
		
		$produto = 'net';
	
	}else{
		
		$produto='';
		
	}
	
}

if ( isset($_POST['action']) && $_POST['action'] == 'add' ){
	
	$consulta = $conexao->query("Select nome from $table where nome='" . $_POST['nome'] . "'");
	
	if ($_POST['nome'] == ''){

	echo "
		<meta charset=\"UTF-8\">
		<script>
		
			alert('O nome do técnico encontra-se em branco.');
			
			document.location = '" . $_SERVER['HTTP_REFERER'] . "';
		
		</script>";
		
		die();
	}

	if (mysql_num_rows($consulta) > 0){

	echo "
		<meta charset=\"UTF-8\">
		<script>
		
			alert('Já existe um técnico cadastrado com este nome.');
			
			document.location = '" . $_SERVER['HTTP_REFERER'] . "';
		
		</script>";
		die();
	}else{
		
		$add = $conexao->query("insert into " . $table . "(nome, status) VALUES ('" . $_POST['nome'] . "', '" . $_POST['status'] . "')");
		header("Location: " . $_SERVER['HTTP_REFERER']);
	}
	
}

?>
<meta charset="UTF-8">
<link rel="stylesheet" href="css/tables.css" />

<script>

$(document).ready(function(){
	
	$("#add-tecnico-form").submit( function(){
		
		if( $("#produto option:selected").val() == '') {
			
			alert('Selecione o produto acima antes de gerenciar os técnicos.');
			
			return false;
		}

	});
	
	$('.bt-desativa-tecnico').click( function(){
		
		var $tecnicoId = $(this).attr('data-tecnico-id');
		var $tecnicoNome = $('.tecnico-' + $tecnicoId + '-nome').html();

		var $confirmado = confirm('Você realmente deseja desligar o técnico ' + $tecnicoNome + '?');
		
		if ($confirmado){

			$.ajax({

				url: "ajax/desativarTecnico.php?produto=net&tecid=" + $tecnicoId,

			}).done(function(result) {

				if( result == '1' ){

					$('.tecnico-' + $tecnicoId).remove();
					alert('Técnico desligado com sucesso.');
					
				}else{

					alert('Erro ao desligar técnico. Tente novamente.');
				
				}

			}).fail(function(result) {
				
				alert('Erro ao desligar técnico. Tente novamente.');
				
			});


		}
		
	});
	
});

</script>

<div id="add-tecnico-form" name="add-tecnico" style="margin-left:auto; margin-right:auto; width:80%; margin-top:30px;">

	<div style="height:40px;">
		
		<form method="GET" name="frmproduto">
			
			<?php 
			
				foreach( $_GET as $get=>$value ){
					
					if($get != 'produto'){

						echo "<input type=\"hidden\" name=\"" . $get . "\" value=\"" . $value . "\">";

					}
				}
			
			?>
			
			<select style="float:right;" id="produto" name="produto" onchange="javascript:frmproduto.submit();">
				
				<option value=""></option>

				<?php if (in_array('0001', $objUsuario->grupos)){ ?>
				<option value="clarotv" <?php if($_GET['produto']=='clarotv'){ ?>selected="selected"<? } ?>>CLARO TV</option>
				<?php } ?>

				<?php if (in_array('0010', $objUsuario->grupos)){ ?>
				<option value="net" <?php if($_GET['produto']=='net'){ ?>selected="selected"<? } ?>>NET</option>
				<?php } ?>

			</select>

			<label style="float:right; margin-top:3px;" for="produto">Produto:</label>
		
		</form>

	</div>
	
	<div style="color:#4D4D4D; font-size:18px; background-color:#E5E5E5; padding:5px">Adicionar Técnico</div>

	<div style="color:#999999; margin-top:10px;">
		
		<form id="add-tecnico-form" name="add-tecnico-form" action="lista-tecnicos.php?produto=<?php echo $_GET['produto']; ?>" method="POST">
		
		<label for="nome">Nome:</label>
		<input type="text" name="nome" id="tecnico-name" size="30">

		<label for="status">Status:</label>
		<select name="status">
			
			<option value="ATIVO">ATIVO</option>
			<option value="DESLIGADO">DESLIGADO</option>
			
		</select>

		
		<br>
		
		<input type="hidden" name="produto" value="net">
		<input type="hidden" name="action" value="add">
		
		<input style="margin-left:54px; margin-top:10px; margin-bottom:20px;padding:0px; width:110px; height:30px" type="submit" name="cadastrar" value="Cadastrar" id="bt-cadastrar">
		</form>
	</div>
	

</div><!-- add-tecnico-form -->

<?php

if (! ($_GET['produto']=='' || (! isset($_GET['produto']))) ){

?>

<div id="edit-tecnico-form" name="edit-tecnico" style="margin-left:auto; margin-right:auto; width:80%; margin-top:30px;">

	<div style="color:#4D4D4D; font-size:14px; background-color:#E5E5E5; padding:5px"><b>Lista de Técnicos - <?php echo strtoupper($_GET['produto']); ?></b></div>
	
	<table style="width:100%; text-align:center; padding:2px; font-size:14px; margin-bottom:30px;">
		<thead>
		<tr style="background-color:#E5E5E5;" class="tr1">
			<th style="padding:5px">Nome</th>
			<th style="padding:5px">Status</th>
			<th></th>
		</tr>
		</thead>
		
		<tbody>
		
		<?php 
		
		$tecnicos = $conexao->query('Select tecnico_id, nome, status from ' . $table . ' order by nome');
		$class = 'tr2';
		
		while( $tecnico = mysql_fetch_assoc($tecnicos) ){

		?>

		<tr class='<?php echo $class; ?> tecnico-<?php echo $tecnico['tecnico_id']; ?>'>
			<td style="padding:2px;" class='tecnico-<?php echo $tecnico['tecnico_id']; ?>-nome'><?php echo $tecnico['nome']; ?></td>
			<td style="padding:2px;"><?php echo $tecnico['status']; ?></td>
			<td style="padding:2px;"><img style="cursor:pointer; width:20px;" data-tecnico-id="<?php echo $tecnico['tecnico_id']; ?>" class="bt-desativa-tecnico" title="Desligar técnico #<?php echo $tecnico['tecnico_id']; ?>" src='img/delete-icon.png'></td>
		
		</tr>


		<?php
			
			$class = ($class == 'tr2') ? 'tr3' : 'tr2';
		}
		
		?>


		</tbody>
	</table>
	
</div>

<?php } //  ?>
