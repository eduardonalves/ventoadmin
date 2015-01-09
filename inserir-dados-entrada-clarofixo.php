	<style>
	.erro{color:#C00; font-size:12px; display:none;}
	
	label {
		display:inline-block;
		font-size:15px;
		color: #666666;
		width:150px;
	} 
	
	input {
		
		border: 1px solid #CCC;
		border-radius:0.2em;
	}
	
	#table-esns{
		
		border:1px solid #CCC;
		border-radius:0.3em;
		position:relative;
	}

	#table-esns-head{
		
		border:1px solid #CCC;
		border-radius:0.3em;
		position:relative;
		text-align:center;
	}

	#table-esns tr{
		
		height:40px;
		text-align:center;
		color: #666666;
		font-size:14px;
	}

	#table-esns-head td{
		
		height:40px;
		text-align:center;
		color: #666666;
		width:18%;
	}

	#table-esns-head .button{
		
		height:40px;
		text-align:center;
		width:5%;
	}

	#table-esns td{
		
		height:40px;
		text-align:center;
		color: #666666;
		width:18%;
	}

	#table-esns .button{
		
		height:40px;
		text-align:center;
		width:5%;
	}
	
	#table-esns tr:nth-child(even){
		
		background-color:#F6F6F6;

	}

	
	#table-esns-head tr:first-child{

		background: #ffffff;
		font-family:arial;
		color:#3E3D39;
		font-weight:bolder;

		background: -moz-linear-gradient(top, #ffffff 0%, #e5e5e5 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5));
		background: -webkit-linear-gradient(top, #ffffff 0%,#e5e5e5 100%);
		background: -o-linear-gradient(top, #ffffff 0%,#e5e5e5 100%);
		background: -ms-linear-gradient(top, #ffffff 0%,#e5e5e5 100%);
		background: linear-gradient(to bottom, #ffffff 0%,#e5e5e5 100%);
		filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#e5e5e5',GradientType=0 );

	}
	</style>

	<script type="text/javascript">

		$(window).load( function() {
			
			var totalEsns = 0;

			function atualizaContagemEsns(){
				
				$(".qt_esns").html(totalEsns);
				$("input.qt_esns").val(totalEsns);

				if (totalEsns>0){
					
					$("[name='entrada-nota-fiscal']").attr("disabled", true);
					$("[name='entrada-aparelho']").attr("disabled", true);
					$("[name='entrada-origem']").attr("disabled", true);

				} else {

					$("[name='entrada-nota-fiscal']").attr("disabled", false);
					$("[name='entrada-aparelho']").attr("disabled", false);
					$("[name='entrada-origem']").attr("disabled", false);
					
				}

			}

			function validarForm(action){
				var e = 0
				
				var nota_fiscal = $("[name='entrada-nota-fiscal']").val();
				var estoquista = $("[name='entrada-estoquista'] option:selected").text();
				var origem = $("[name='entrada-origem'] option:selected").text();
				var aparelho = $("[name='entrada-aparelho'] option:selected").text();
				var esn = $.trim($("[name='entrada-esn']").val());
				
				if(nota_fiscal=='') { $("#eentrada-nota-fiscal").css('display','inline-block'); $("[name='entrada-nota-fiscal']").focus(); e++; }
				if(estoquista=='') { $("#eentrada-estoquista").css('display','inline-block'); $("[name='entrada-estoquista'] option:selected").focus(); e++; }
				if(origem=='') { $("#eentrada-origem").css('display','inline-block'); $("[name='entrada-origem'] option:selected").focus(); e++; }
				if(aparelho=='') { $("#eentrada-aparelho").css('display','inline-block'); $("[name='entrada-aparelho'] option:selected").focus(); e++; }

				if(action=='add'){

					if(esn=='') { $("#eentrada-esn").css('display','inline-block'); $("[name='entrada-esn']").focus(); e++; }

				} else if (action='save'){
					
					if(totalEsns<1) {
						
						alert('Não há esns inseridas nesta entrada.');
						return false;
					}
				}
				
				if (e == 0 ){
					
					return true;

				}else{

					return false;
				}
			}

			$("#btSalvar").bind( 'click', function(event) {
				
				if(!validarForm('save')) { alert('Preencha todos os campos antes de adicionar uma ESN.'); keyFromAlert=1; return false;  }

				$("[name='entrada-nota-fiscal']").attr("disabled", false);
				$("[name='entrada-aparelho']").attr("disabled", false);
				$("[name='entrada-origem']").attr("disabled", false);

				$("#submitForm").submit();
				
			});

			$(document).on( 'click', '.btRemove', function(event) {
				
				var esn = $(this).attr('data-esn');
				
				if ( confirm("Tem certeza que deseja remover a esn " + esn + " desta lista?") ){
					
					totalEsns--;
					atualizaContagemEsns();
					
					$("tr[data-esn='"+esn+"']").remove();
					
				}
				
				
				
			});

			$("[name='entrada-esn']").bind( 'keyup', function(event) {
				
					$(this).val($(this).val().toUpperCase());

			});
			
			$("[name='entrada-esn']").bind( 'keypress', function(event) {
				
				if (event.keyCode==13){
					
					$("[name='entrada-add-esn']").trigger('click');
					event.keyCode = 0;
					return false;
				}
				
				$("[name='entrada-esn']").focus();
				
			});
			
			$("[name='entrada-add-esn']").bind ( 'click', function() {
				
				$(".erro").css("display", "none");


				
				if(totalEsns>=900) { alert('Erro ao adicionar ESN. Limite máximo de ESNs por entrada é de 900.'); return false;  }
				if(!validarForm('add')) { alert('Preencha todos os campos antes de adicionar uma ESN.'); return false;  }

				var esn = $.trim($("[name='entrada-esn']").val());
				var origem = $("[name='entrada-origem'] option:selected").text();
				
				$("[name='entrada-esn']").val('');
				
				if( $("[data-esn='"+ esn + "']" ).length > 0 ) { alert('A Esn '+esn+' já foi adicionada a esta entrada.'); return false;  }				
				
				$("#loader-esn-check").css("display", "block");
				$("[name='entrada-add-esn']").css("display", "none");
				$("[name='entrada-esn']").attr("disabled", true);
				
				$.ajax({ 
					type: "GET", 
					url: "ajax/verificaEsnExiste-entrada.php", 
					data: "esn="+esn+"&origem="+origem, 
					success: function(data){ 

							data = $.trim(data);
							
							if( data == 'DEV_FAIL' ) {

								alert('Impossível a devolução. A esn '+esn+' não foi encontrada com parceiro.');
								
								$("#loader-esn-check").css("display", "none");
								$("[name='entrada-add-esn']").css("display", "inline-block");
								$("[name='entrada-esn']").attr("disabled", false);
								
								return false;
								
							
							} else if( $.isNumeric(data) && data != 0){
								
								alert('A esn '+esn+' já encontra-se no estoque. Impossível adicionar a esta entrada.');
								
								$("#loader-esn-check").css("display", "none");
								$("[name='entrada-add-esn']").css("display", "inline-block");
								$("[name='entrada-esn']").attr("disabled", false);
								
								return false;
							
							} else {
								
								addEsn(esn);
								
								$("#loader-esn-check").css("display", "none");
								$("[name='entrada-add-esn']").css("display", "inline-block");
								$("[name='entrada-esn']").attr("disabled", false);
								
								$("[name='entrada-esn']").focus();
							
							}
							
						},
					error: function(XMLHttpRequest, textStatus, errorThrown){ 
						alert('Erro! Não foi possível checar a esn, tente novamente.'); 
						
						$("#loader-esn-check").css("display", "none");
						$("[name='entrada-add-esn']").css("display", "inline-block");
						$("[name='entrada-esn']").attr("disabled", false);
						
						return false;
						}
					});
			});
			
			function addEsn(esn){

				var nota_fiscal = $("[name='entrada-nota-fiscal']").val();
				var estoquista = $("[name='entrada-estoquista'] option:selected").text();
				var origem = $("[name='entrada-origem'] option:selected").text();
				var aparelho = $("[name='entrada-aparelho'] option:selected").text();

				$("#table-esns").append('\
				\
				<tr class="esn-entrada" data-esn="'+esn+'">\
					<input type="hidden" name="entrada-esns[]" value="'+esn+'" />\
					<td>'+nota_fiscal+'</td>\
					<td>'+estoquista+'</td>\
					<td>'+origem+'</td>\
					<td>'+aparelho+'</td>\
					<td>'+esn+'</td>\
					<td class="button"><img class="btRemove" src="img/delete-icon.png" data-esn="'+esn+'" style="width:25px; cursor:pointer;" title="Remover Esn da Entrada" /> </td>\
				</tr>');
				
				$("[name='entrada-esn']").val('');
				
				$("#box-table-esns1").scrollTop($("#box-table-esns1").scrollTop()+50);
				
				totalEsns++;

				atualizaContagemEsns();
				$("[name='entrada-esn']").focus();
			}
			
		});
	
	</script>
<?php
		function inserirEntrada(){

			global $conexao;
			global $data;
			global $notaFiscal;
			global $estoquista;
			global $origem;
			global $aparelho;
			global $quantidade;
			global $esnsTemp;
			global $esns;

			$query = "INSERT INTO entradas(data, nf, id_estoquista, origem) VALUES ('". $data ."','".$notaFiscal."','".$estoquista."','".$origem."')";
			$conexao->query($query);
			$idEntrada = mysql_insert_id($conexao->connection);

			$query2 = "INSERT INTO itensEntrada(id_entrada, id_aparelho, qtde) VALUES ('".$idEntrada."','".$aparelho."','".count($esns)."')";
			$conexao->query($query2);
			$idItensEntrada = mysql_insert_id($conexao->connection);

			foreach($esns as $esn){

				if (strtolower($origem) == "parceiro"){
					
					$sqlUp = "UPDATE ESNsSaida SET status='Devolvido' WHERE esn='" . $esn . "' && (status='Em Estoque' || status='Vendido')";
					$conexao->query($sqlUp);

					$sqlUp2 = "UPDATE ESNsEntradas SET status='Devolvido' WHERE esn='" . $esn . "' && status='Com Parceiro'";
					$conexao->query($sqlUp2);
					
				}
				
				$query3 = "INSERT INTO ESNsEntradas(id_entrada, esn, status) VALUES ('".$idItensEntrada."','".$esn."','Em Estoque')";
				$conexao->query($query3);
				//echo "Entrada de $esn: OK<br>";
				

			}
			
			?>
			
			<script type="text/javascript">
			
				alert("Entrada inserida com sucesso.");
				window.location="?p=index-estoque-clarofixo&es=inserir-dados-entrada-clarofixo";
			
			</script>
			
		<?php

			
		}
		
		function limpaArray($val){
			
			return trim($val);
			
		}

if ( isset($_POST['action']) && $_POST['action']=='save' ){

    //Conexão com Banco

		$data = date("Y-m-d H:i:s");
		$notaFiscal = $_POST['entrada-nota-fiscal'];
		$estoquista = $_POST['entrada-estoquista'];
		$origem = $_POST['entrada-origem'];
		$aparelho = $_POST['entrada-aparelho'];
		$quantidade = $_POST['quatidade-esn'];
		$esnsTemp = array_map("limpaArray", $_POST['entrada-esns']);
		$esns = array_unique($esnsTemp);

		$erros = array();

		if ($notaFiscal=="") { array_push($erros, array("campo"=>"Nota Fiscal", "erro"=>"Número de Nota Fiscal inválido")); }
		if ($estoquista=="") { array_push($erros, array("campo"=>"Estoquista", "erro"=>"Selecione o Estoquista")); }
		if ($origem=="") { array_push($erros, array("campo"=>"Origem", "erro"=>"Informe a origem do aparelho")); }
		if ($aparelho=="") { array_push($erros, array("campo"=>"Aparelho", "erro"=>"Informe o modelo do aparelho")); }
		if ( ($quantidade!=count($esns)) || ($quantidade=="" || $esnsTemp=="")) { array_push($erros, array("campo"=>"Quantidade de Aparelhos", "erro"=>"A quantidade de aparelhos não confere. Cheque se há números ESN repetidos.")); }

		if (strtolower($origem) == "parceiro"){
			
			foreach($esns as $esn){
				
				$qry = "Select count(esn.esn) as count,esn.id_esnssaida, itens.* from ESNsSaida esn
				INNER JOIN itenssaida itens ON (itens.id_itenssaida=esn.id_saida)
				WHERE esn='$esn' && (status='Vendido' OR status='Em Estoque')";
				
				$cont_qry = $conexao->query($qry);
				
				if(mysql_result($cont_qry,0,'count') <= 0){
					
					array_push($erros, array("campo"=>"Esn".mysql_result($cont_qry,0,'count'), "erro"=>"A esn ". $esn ." não consta com saída para nenhum parceiro."));
				}

			}


		}

		if(count($erros)>0){
			
			$erroScript = "Erro ao cadastrar entrada:\\n\\n";
			
			foreach($erros as $erro){
				
				$erroScript .= $erro['campo'] . ": " . $erro['erro'] . "\\n";

			}
			
			echo "
				
				<script type=\"text/javascript\">
					
					var errors = '" . $erroScript . "';
					
					alert(errors);
					history.back();
					
				</script>
				";
			
		} else {
			
			inserirEntrada();
			
		}


} else {
	
	?>

	<!-- SUBMENU -->
	<? include "submenu-clarofixo.php";?>
	<!-- FIM DO SUBMENU -->
	<? include ("menu-lateral-estoque-clarofixo.php") ; ?>

	<div style="margin:30px; margin-top:0px;">
		
		<span style="font-size:14px; color:#999;">Estoque Claro Fixo</span>
		<hr size="1" color="#CCCCCC" />
		
			
		<div style="color:#069; font-size:12px; width:158px; margin-bottom:20px;">Nova Entrada</div>

		<form id="submitForm" name="submitForm" method="post">

			<input type="hidden" name="action" value="save" />

		<div id="form-box" style="margin:50px; margin-left:100px;">			
		
			<div style="margin-bottom:10px">
				<label for="entrada-nota-fiscal">Nota Fiscal: </label> <input type="text" name="entrada-nota-fiscal" size="7" />
				
				<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
				<span class="erro" id="eentrada-nota-fiscal" style="">Por favor, digite o número da nota fiscal!</span>
			
			</div>
			
			<div style="margin-bottom:10px;">
				
				<label for="entrada-estoquista">Estoquista: </label>
			
				<select name="entrada-estoquista">
					
					<?
					echo"<option value=".$USUARIO['id'].">".$USUARIO['nome']."</option>"; 
					?>
				
				</select>

				<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
				<span class="erro" id="eentrada-estoquista" style="">Por favor, selecione um estoquista!</span>
			
			</div>

			<div style="margin-bottom:10px">
				
				<label for="entrada-origem">Origem: </label>
			
				<select name="entrada-origem">
					
					<option value=""></option>
					<option value="Claro">Claro</option>
					<option value="Parceiro">Parceiro</option>
				
				</select>

				<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
				<span class="erro" id="eentrada-origem" style="">Por favor, selecione a origem!</span>

			</div>
			
			<hr size="1" color="#CCCCCC" style="margin-top:30px; margin-bottom:30px;" />
			

			<div style="margin-bottom:10px">
				
				<label for="entrada-aparelho">Modelo do Aparelho: </label>
			
				<select name="entrada-aparelho">

					<option value=""></option>
				<?
					$sql = "SELECT id_aparelho, marca, modelo FROM aparelhos "; 
					$aparelho = mysql_query($sql); 
					
					
					while ($array= mysql_fetch_array($aparelho)) {
						echo"<option value=".$array['id_aparelho'].">".$array['marca']." - ".$array['modelo']."</option>";
						
					}
				?>
				
				</select>

				<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
				<span class="erro" id="eentrada-aparelho" style="">Por favor, selecione o modelo do Aparelho!</span>
			
			</div>

			<div style="margin-bottom:10px">
				
				<label for="entrada-esn">ESN: </label>
				<input type="text" name="entrada-esn" />

				<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
				<span class="erro" id="eentrada-esn" style="">Esn inválida!</span>

				<img name="entrada-add-esn" src="img/add.png" style="margin-left:10px; cursor:pointer;" title="Adicionar ESN" />
				
				<div id="loader-esn-check" style="margin-left:153px; margin-top:10px; display:none;">
					
					<div style="float:left"><img src="img/loader.gif" style="display:inline-block;" /></div>
					<div style="float:left; margin-left:5px;"><span style="font-size:15px; color:#666666; "> Aguarde, o sistema está checando a ESN.</span></div>

				</div>
			
			</div>			
		
		</div> <!--  form-box -->
		
		<div id="box-table-esns" style="margin:50px; margin-bottom:0px; margin-left:100px;">
		
			<table id="table-esns-head" style="width:100%; height:40px;">
				<tr>
					<td>Nota Fiscal: </td>
					<td>Estoquista: </td>
					<td>Origem: </td>
					<td>Aparelho: </td>
					<td>ESN: </td>
					<td class="button"></td>

				</tr>
			</table>
		</div>
		<div id="box-table-esns1" style="margin:50px; margin-left:100px; margin-top:1px; max-height:170px; overflow:auto;">

			<table id="table-esns" style="width:100%">

			</table>
		
		</div>
		
		<input type="hidden" class="qt_esns" name="quatidade-esn" value="" />
		
		</form>
		
		<div style="margin-left:100px; margin-top:-30px; float:right; margin-right:50px;"><span class="qt_esns">0</span> Esns adicionadas.</div>
		<img id="btSalvar" style="position:relative; cursor:pointer; margin-left:100px; margin-top:10px;" src="img/salvar.png" title="Salvar Entrada" />

		
		
	</div>
<?php
	
}

?>
