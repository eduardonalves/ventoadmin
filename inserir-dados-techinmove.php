<?

// Verificar se está logado

if(!isset($_SESSION['usuario'])){ ?>

<script type="text/javascript">

window.location = 'index.php'

</script>	

<? } ?>

<?php

extract($_POST, EXTR_PREFIX_ALL, "data"); 

if ( ( isset($data_action) ) && ( ($data_action)== 'add') ){
	
	// **** Adicionar nova venda ****
	
	$queryFields = "(";
	$queryValues = "VALUES (";
	
	$campos = $conexao->query("SELECT COLUMN_NAME, DATA_TYPE FROM information_schema.columns WHERE TABLE_SCHEMA = 'techin_ventoadmin' AND TABLE_NAME = 'vendas_techinmove'");

	while ( $campo = mysql_fetch_assoc($campos) ){
		
		$varName = "data_" . $campo['COLUMN_NAME'];
		
		if( isset($$varName) ){

			$queryFields .= $campo['COLUMN_NAME'] . ", ";
			
			if($campo['DATA_TYPE']== 'decimal') {
			
				$$varName = preg_replace("/[^0-9,]/", "", $$varName);
				
				$$varName = str_replace(".", "", $$varName);
				$$varName = str_replace(",", ".", $$varName);

			}

			if($campo['DATA_TYPE']== 'date'){
			
				$newVal = "STR_TO_DATE('" . $$varName . "', '%d/%m/%Y')";
				$$varName = $newVal;
				
				$queryValues .= $$varName . ", ";
			
			}else{
			
				$queryValues .= "'" . $$varName . "', ";
			}
			
		}
		
	}

	$queryFields .= "criado) ";
	$queryValues .= "'" . date("Y-m-d H:i:s") . "')";

	$insertQuery = "Insert into vendas_techinmove " . $queryFields . $queryValues;

	$conexao->query($insertQuery);
	
	echo '<script type="text/javascript">
	window.alert("Cadastro efetuado com sucesso!");

	window.location = \'?p=techinmove\';

	</script>';

}

?>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>

<script type="text/javascript" src="js/calendario.js"></script>

<script type="text/javascript" src="js/cep.js"></script>

<script type="text/javascript" src="js/techinmove.js"></script>

<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.7.3.custom.css" />

<link rel="stylesheet" type="text/css" href="css/geral.css" />


<script type="text/javascript">

	$(document).ready( function() {
		
		function checkoperador(m){

			$('#loadoperadores').load('check-operadores.php?m='+m+'&g=0008');

		}
		
		
		$(document).on('change', "#monitor", function(){

			var monitor = $('option:selected', this).val();
			var nomeMonitor = $('option:selected', this).text().toLowerCase();
			
			var acesso_monitor = $('option:selected', this).attr('data-acesso_usuario');
			var tipo_venda = acesso_monitor;

			checkoperador(monitor);
			
			if(acesso_monitor == 'INTERNO'){
				
				tipo_venda = 'INTERNA';
			
			} else if ( acesso_monitor == 'EXTERNO' ){
				
				tipo_venda = 'EXTERNA';
			
			} else if ( nomeMonitor.search('internet') ){
				
				tipo_venda = 'INTERNET';
				
			}
			
			$('#tipo_venda').val(acesso_monitor);
			
		});
		
		/****************************************************/

	});


</script>

<!-- SUBMENU -->

<? include "submenu-techinmove.php";?>

<!-- FIM DO SUBMENU -->

<div class="site-default-work-area">
	
	<div class="label-lightgray">NOVA VENDA</div>
	<div class="bt-voltar"><img src="img/voltar.png" style="cursor:pointer" onclick="window.location = '?p=techinmove'" /></div>
	
	<hr size="1" color="#CCCCCC" style="clear:both;" />
	
	<form class="formulario-inserir" name="inserir" action="" method="post">
		
		<input id="action" type="hidden" name="action" value="add">
		<input id="tipo_venda" type="hidden" name="tipo_venda" value="">
		<input id="status" type="hidden" name="status" value="status-padrao">
		<input id="data_venda" type="hidden" name="data_venda" value="<?php echo date('d/m/Y'); ?>">
		
		<fieldset>
		
			<label for="monitor">Monitor: </label>
			<select class="campo-obrigatorio" type="text" id="monitor" name="monitor" onchange="checkoperador(this.value)">

				<option value=""></option>


				<?
					if($USUARIO["tipo_usuario"]=="MONITOR")
					{
					
						$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE tipo_usuario = 'MONITOR' && grupo LIKE '%0008%' && status='ATIVO' && id=" . $USUARIO["id"] . " order by nome");
					
					}else{
					
						$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE (tipo_usuario = 'MONITOR' || tipo_usuario = 'MONITORBO') && grupo LIKE '%0008%' && status='ATIVO' order by nome");
					}

				   while($MONITORES = mysql_fetch_array($conMONITORES)){

				?>

				<option value="<?= $MONITORES['id']?>" data-acesso_usuario="<?= $MONITORES['acesso_usuario']?>"><?= $MONITORES['nome']?></option>

				<? } ?>

			</select> 

			<label for="operador">Operador: </label>
				
				<div id="loadoperadores">

					<select  class="campo-obrigatorio" type="text" id="operador" name="operador">
						<option></option>
					</select>

				</div>
			
			<br>
			
			<div class="label-azul">Dados do Cliente</div>

			<label for="nome">Razão Social: </label>

				<input class="campo-obrigatorio" type="text" value="" id="razao_social" name="razao_social" size="30">

			<label for="cpf">CNPJ: </label>

				<input class="campo-obrigatorio mask" type="text" id="cnpj" name="cnpj" placeholder="99.999.999/9999-99" maxlength="18" size="20" />
			
			<br><br>
			
			<label for="email">Email Principal: </label>

				<input class="campo-obrigatorio" placeholder="email-cliente@dominio.com" type="text" id="email_principal" name="email_principal"  size="30" />

			<label for="email">Email Alternativo: </label>

				<input type="text" id="email_alternativo" name="email_alternativo"  placeholder="email-cliente@dominio.com"  size="30" />
			
			<br><br>

			<label for="email">Site: </label>

				<input type="text" id="site" name="site"  placeholder="www.site-do-cliente.com.br"  size="30" />
			
			<br><br>
			
			<label for="telefone">Telefone: </label>
				
				<input class="campo-obrigatorio mask" data-masktype="telefone" type="text" id="telefone1" name="telefone1" placeholder="(xx) X-XXXX-XXXX" maxlength="16" size="20" /> 

				<select name="tipo_telefone1">

					<option value="Residencial">Residencial</option> 
					<option value="Celular">Celular</option>
					<option value="Comercial">Comercial</option>

				</select> 

			<label for="telefone2">Telefone 2: </label>
				
				<input class="mask" data-masktype="telefone" type="text"  id="telefone2" name="telefone2" placeholder="(xx) X-XXXX-XXXX" maxlength="16" size="20" /> 

				<select name="tipo_telefone2">

					<option value="Celular">Celular</option>
					<option value="Residencial">Residencial</option> 
					<option value="Comercial">Comercial</option>

				</select> 

			<label for="telefone3">Telefone 3: </label>
				
				<input class="mask" data-masktype="telefone" type="text"  id="telefone3" name="telefone3" placeholder="(xx) X-XXXX-XXXX" maxlength="16" size="20" /> 

				<select name="tipo_telefone3">

					<option value="Comercial">Comercial</option>
					<option value="Residencial">Residencial</option> 
					<option value="Celular">Celular</option>

				</select> 

			<br><br>

			<label for="email">Pessoa de Contato: </label>

				<input type="text" id="pessoa_contato" name="pessoa_contato" size="30" />

			<label for="email">Pessoa Responsável: </label>

				<input type="text" id="pessoa_responsavel" name="pessoa_responsavel"  size="30" />
			
			<br>
			
			<div class="label-azul">Endereço do Cliente</div>
			
			<label for="cep">CEP:</label>
			
				<input class="campo-obrigatorio mask" type="text" id="cep" onkeyup="return getEndereco()" onchange="return getEndereco()" name="cep" size="30" placeholder="XXXXX-XXX" maxlength="9" >

			<label for="endereco">Endereço: </label>
				
				<input class="campo-obrigatorio" type="text" id="endereco" name="endereco" size="40">
				<div style="display:inline-block; float:left; margin-left:10px; margin-top:8px;"> Nº: </div>
				<input class="campo-obrigatorio" type="text" name="numero" id="numero" size="5" maxlength="10" onKeyPress="mascara(this,soNumeros);">
			
			<label for="complemento">Complemento:</label>

				<input type="text" id="complemento" name="complemento" size="40">
				
			<label for="uf">Estado: </label>

				<select class="campo-obrigatorio" name="estado" id="estado" onchange="checkcidades(this.value,'')">

					<option value=""></option>

					<? $conESTADO = $conexao->query("SELECT DISTINCT(uf),nome FROM tb_estados");

					   while($ESTADO = mysql_fetch_array($conESTADO)){

					?>
					<option value="<?= $ESTADO['uf'];?>"><?= $ESTADO['nome'];?></option>
					<? } ?>

				</select>
			
			<label for="cidade">Cidade: </label>

				<input class="campo-obrigatorio" type="text" id="cidade" name="cidade" size="30" />
			
			<label for="pontoref">Ponto de Referência:</label>
			
				<textarea id="referencia" name="referencia" rows="3" cols="30"></textarea>
			
			<br>
			
			<div class="label-azul">Dados da Venda</div>
			
			<label for="plano">Produto: </label>
				
				<select class="campo-obrigatorio" id="produto" name="produto">

					<option value=""></option>

					<option value="SITE STANDART">SITE STANDART</option>
					<option value="SITE PERSONALIZADO">SITE PERSONALIZADO</option>
					<option value=""></option>

					<option value="CATÁLOGO STANDART 50 PRODUTOS">CATÁLOGO STANDART 50 PRODUTOS</option>
					<option value="CATÁLOGO STANDART 100 PRODUTOS">CATÁLOGO STANDART 100 PRODUTOS</option>
					<option value="CATÁLOGO STANDART 250 PRODUTOS">CATÁLOGO STANDART 250 PRODUTOS</option>
					<option value="CATÁLOGO STANDART 500 PRODUTOS">CATÁLOGO STANDART 500 PRODUTOS</option>

					<option value=""></option>

					<option value="CATÁLOGO PAGSEGURO 50 PRODUTOS">CATÁLOGO PAGSEGURO 50 PRODUTOS</option>
					<option value="CATÁLOGO PAGSEGURO 100 PRODUTOS">CATÁLOGO PAGSEGURO 100 PRODUTOS</option>
					<option value="CATÁLOGO PAGSEGURO 250 PRODUTOS">CATÁLOGO PAGSEGURO 250 PRODUTOS</option>
					<option value="CATÁLOGO PAGSEGURO 500 PRODUTOS">CATÁLOGO PAGSEGURO 500 PRODUTOS</option>

					<option value=""></option>

					<option value="LOJA VIRTUAL">LOJA VIRTUAL</option>

				</select>
		
			<label for="plano">Valor: </label>
				
				<input class="mask" data-masktype="moeda" class="campo-obrigatorio" id="valor_produto" name="valor_produto" type="text" style="width:120px;">

			<div style="display:inline-block; float:left; margin-top:8px; margin-left:10px; margin-right:5px;">Forma Pagamento: </div>
				
				<select class="campo-obrigatorio" id="forma_pagamento_produto" name="forma_pagamento_produto">
				
					<option>Boleto</option>
					<option>Cartão de Crédito</option>
					<option>Cheque</option>
					<option>Dinheiro</option>
				
				</select>
			
			<br><br>
			
			<label for="mensalidade">Mensalidade: </label>
				
				<input class="campo-obrigatorio mask" data-masktype="moeda" type="text" id="mensalidade" name="mensalidade" style="width:120px;">

			<div style="display:inline-block; float:left; margin-top:8px; margin-left:10px; margin-right:5px;">Vencimento: </div>
				
				<select class="campo-obrigatorio" id="vencimento" name="vencimento">

					<option>5</option>
					<option>10</option>
					<option>15</option>
					<option>20</option>

				</select>

			<div style="display:inline-block; float:left; margin-top:8px; margin-left:10px; margin-right:5px;">Forma Pagamento: </div>
				
				<select class="campo-obrigatorio" id="forma_pagamento_mensalidade" name="forma_pagamento_mensalidade">
				
					<option>Boleto</option>
					<option>Cartão de Crédito</option>
					<option>Cheque</option>
					<option>Dinheiro</option>
				
				</select>
			
			
			<label></label>

				<img class="bt-submit-form" data-formulario="inserir" style="display:inline-block; float:left; margin-top:30px; cursor:pointer;" src="img/salvar.png" onclick="submitform();" />
				<span class="campoobrigatorio" style="display:inline-block; margin-top:37px;">(*) Campos Obrigatórios!</span>

		</fieldset>

	</form>
	

	
</div>
