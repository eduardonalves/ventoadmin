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
					
					$("[name='saida-parceiro']").attr("disabled", true);
					$("[name='saida-aparelho']").attr("disabled", true);

				} else {

					$("[name='saida-parceiro']").attr("disabled", false);
					$("[name='saida-aparelho']").attr("disabled", false);
					
				}
			}

			function validarForm(action){
				var e = 0
				
				var estoquista = $("[name='saida-estoquista'] option:selected").text();
				var parceiro = $("[name='saida-parceiro'] option:selected").text();
				var aparelho = $("[name='saida-aparelho'] option:selected").text();
				var esn = $.trim($("[name='saida-esn']").val());
				
				if(estoquista=='') { $("#esaida-estoquista").css('display','inline-block'); $("[name='saida-estoquista'] option:selected").focus(); e++; }
				if(parceiro=='') { $("#esaida-parceiro").css('display','inline-block'); $("[name='saida-parceiro'] option:selected").focus(); e++; }
				if(aparelho=='') { $("#esaida-aparelho").css('display','inline-block'); $("[name='saida-aparelho'] option:selected").focus(); e++; }

				if(action=='add'){

					if(esn=='') { $("#esaida-esn").css('display','inline-block'); $("[name='saida-esn']").focus(); e++; }

				} else if (action='save'){
					
					if(totalEsns<1) {
						
						alert('Não há esns inseridas nesta saida.');
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
				
				if(!validarForm('save')) { alert('Preencha todos os campos antes de adicionar uma ESN.'); return false;  }
				
				$("[name='saida-parceiro']").attr("disabled", false);
				$("[name='saida-aparelho']").attr("disabled", false);
				
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

			$("[name='saida-esn']").bind( 'keyup', function(event) {
				
				$(this).val($(this).val().toUpperCase());

			});

			$("[name='saida-esn']").bind( 'keypress', function(event) {

				if (event.keyCode==13){

					$("[name='saida-add-esn']").trigger('click');
					event.keyCode = 0;
					return false;
				}
				
				$(this).focus();
				
			});
			
			$("[name='saida-add-esn']").bind ( 'click', function() {

				$(".erro").css("display", "none");

				if(totalEsns>=900) { alert('Erro ao adicionar ESN. Limite máximo de ESNs por saida é de 900.'); return false;  }
				if(!validarForm('add')) { alert('Preencha todos os campos antes de adicionar uma ESN.'); return false;  }

				var esn = $.trim($("[name='saida-esn']").val());
				var aparelho = $("[name='saida-aparelho']").val();
				
				$("[name='saida-esn']").val('');
				
				if( $("[data-esn='"+ esn + "']" ).length > 0 ) { alert('A Esn '+esn+' já foi adicionada a esta saida.'); return false;  }				
				
				$("#loader-esn-check").css("display", "block");
				$("[name='saida-add-esn']").css("display", "none");
				$("[name='saida-esn']").attr("disabled", true);

				$.ajax({ 
					type: "GET", 
					url: "ajax/verificaEsnExiste-saida.php", 
					data: "esn="+esn+"&aparelho="+aparelho, 
					success: function(data){ 

							data = $.trim(data);

							if( $.isNumeric(data) && data > 0 ) {

								addEsn(esn);
								
								$("#loader-esn-check").css("display", "none");
								$("[name='saida-add-esn']").css("display", "inline-block");
								$("[name='saida-esn']").attr("disabled", false);
								$("[name='saida-esn']").focus();
								
								return false;
							
							} else {

								alert(data);
								
								$("#loader-esn-check").css("display", "none");
								$("[name='saida-add-esn']").css("display", "inline-block");
								$("[name='saida-esn']").attr("disabled", false);
								$("[name='saida-esn']").focus();
							
							}
							
						},
					error: function(XMLHttpRequest, textStatus, errorThrown){ 

						alert('Erro! Não foi possível checar a esn, tente novamente.');

						$("#loader-esn-check").css("display", "none");
						$("[name='saida-add-esn']").css("display", "inline-block");
						$("[name='saida-esn']").attr("disabled", false);
						
						return false;
						}
					});

				$("[name='saida-esn']").focus();

			});
			
			function addEsn(esn){

				var estoquista = $("[name='saida-estoquista'] option:selected").text();
				var parceiro = $("[name='saida-parceiro'] option:selected").text();
				var aparelho = $("[name='saida-aparelho'] option:selected").text();

				$("#table-esns").append('\
				\
				<tr class="esn-saida" data-esn="'+esn+'">\
					<input type="hidden" name="saida-esns[]" value="'+esn+'" />\
					<td>'+estoquista+'</td>\
					<td>'+parceiro+'</td>\
					<td>'+aparelho+'</td>\
					<td>'+esn+'</td>\
					<td class="button"><img class="btRemove" src="img/delete-icon.png" data-esn="'+esn+'" style="width:25px; cursor:pointer;" title="Remover Esn da Saída" /> </td>\
				</tr>');
				
				$("[name='saida-esn']").val('');
				
				$("#box-table-esns1").scrollTop($("#box-table-esns1").scrollTop()+50);
				
				totalEsns++;

				atualizaContagemEsns();
				$("[name='saida-esn']").focus();
			}
			
		});
	
	</script>
<?php
		function inserirSaida(){

			global $conexao;
			global $data;
			global $estoquista;
			global $parceiro;
			global $aparelho;
			global $quantidade;
			global $esnsTemp;
			global $esns;

			$sql="INSERT INTO saidas (id_estoquista, id_parceiro, data) VALUES ('$estoquista','".$parceiro."', '".$data."')";
            $query = $conexao->query($sql);	

			$idSaida = mysql_insert_id($conexao->connection);

            $sql3="INSERT INTO itenssaida (id_saida, id_aparelho, qtde) VALUES ('".$idSaida."', '".$aparelho."', '".$quantidade."')" or die (mysql_error());
            $query3 = $conexao->query($sql3);
			
			$idItensSaida = mysql_insert_id($conexao->connection);

			foreach($esns as $esn){

				$sql2="INSERT INTO ESNsSaida (id_saida,esn, status ) VALUES ('".$idItensSaida."','".$esn."','Em Estoque')";
				$query2 = $conexao->query($sql2);
				
				$sql_up="UPDATE ESNsEntradas SET status = 'Com Parceiro' WHERE esn = '$esn' && status='Em Estoque'";
				$conexao->query($sql_up);

				

			}
			
			?>
			
			<script type="text/javascript">
			
				alert("Saida inserida com sucesso.");
				window.location="?p=index-estoque-clarofixo&es=inserir-dados-saida-clarofixo";
			
			</script>
			
		<?php

			
		}
		
		function limpaArray($val){
			
			return trim($val);
			
		}

if ( isset($_POST['action']) && $_POST['action']=='save' ){

    //Conexão com Banco

		$data = date("Y-m-d H:i:s");
		$estoquista = $_POST['saida-estoquista'];
		$parceiro = $_POST['saida-parceiro'];
		$aparelho = $_POST['saida-aparelho'];
		$quantidade = $_POST['quatidade-esn'];
		$esnsTemp = array_map("limpaArray", $_POST['saida-esns']);
		$esns = array_unique($esnsTemp);

		$erros = array();

		if ($estoquista=="") { array_push($erros, array("campo"=>"Estoquista", "erro"=>"Selecione o Estoquista")); }
		if ($parceiro=="") { array_push($erros, array("campo"=>"Parceiro", "erro"=>"Informe o parceiro para o qual a saída será efetuada.")); }
		if ($aparelho=="") { array_push($erros, array("campo"=>"Aparelho", "erro"=>"Informe o modelo do aparelho")); }
		if ( ($quantidade!=count($esns)) || ($quantidade=="" || $esnsTemp=="")) { array_push($erros, array("campo"=>"Quantidade de Aparelhos", "erro"=>"A quantidade de aparelhos não confere. Cheque se há números ESN repetidos.")); }


			
		foreach($esns as $esn){
				
			$qry = "Select count(ESNsEntradas.esn) as count, ESNsEntradas.status, itensEntrada.id_aparelho from ESNsEntradas
					INNER JOIN itensEntrada ON (ESNsEntradas.id_entrada=itensEntrada.id_itensEntrada && itensEntrada.id_aparelho='$aparelho' )
					where ESNsEntradas.esn='$esn' && ESNsEntradas.status='Em Estoque' order by ESNsEntradas.id_esnsentrada LIMIT 1";
				
			$cont_qry = $conexao->query($qry);
				
			if(mysql_result($cont_qry,0,'count') <= 0){
					
				array_push($erros, array("campo"=>"Esn", "erro"=>"A esn $esn não consta disponível para saída no estoque interno."));
			}
		}


		if(count($erros)>0){
			
			$erroScript = $_POST['action'] . " a ". "Erro ao cadastrar saída:\\n\\n";
			
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
			
			inserirSaida();
			
			
		}


} else {
	
	?>

	<!-- SUBMENU -->
	<? include "submenu-clarofixo.php";?>
	<!-- FIM DO SUBMENU -->
	<? include ("menu-lateral-estoque-clarofixo.php") ; ?>

	<div style="margin:30px; margin-top:0px;">
		<div class="key"></div>
		<span style="font-size:14px; color:#999;">Estoque Claro Fixo</span>
		<hr size="1" color="#CCCCCC" />
		
			
		<div style="color:#069; font-size:12px; width:158px; margin-bottom:20px;">Nova Saída</div>

		<form id="submitForm" name="submitForm" method="post">

			<input type="hidden" name="action" value="save" />

		<div id="form-box" style="margin:50px; margin-left:100px;">			
		
			<div style="margin-bottom:10px;">
				
				<label for="saida-estoquista">Estoquista: </label>
			
				<select name="saida-estoquista">
					
					<?
					echo"<option value=".$USUARIO['id'].">".$USUARIO['nome']."</option>"; 
					?>
				
				</select>

				<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
				<span class="erro" id="esaida-estoquista" style="">Por favor, selecione um estoquista!</span>
			
			</div>

			<div style="margin-bottom:10px">
				
				<label for="saida-parceiro">Parceiro: </label>
			
				<select name="saida-parceiro">
					
					<option value=""></option>
					<?

					$sql = "SELECT id, nome FROM usuarios WHERE tipo_usuario='MONITOR' && (acesso_usuario='INTERNO' || acesso_usuario='EXTERNO') && status='ATIVO' order by nome";
					$parceiros = mysql_query($sql); 

					while ($array= mysql_fetch_array($parceiros)) 
					{ 
						echo"<option value=".$array['id'].">".$array['nome']."</option>"; 
					}
						
					?>

				
				</select>

				<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
				<span class="erro" id="esaida-parceiro" style="">Por favor, selecione um parceiro!</span>

			</div>
			
			<hr size="1" color="#CCCCCC" style="margin-top:30px; margin-bottom:30px;" />
			

			<div style="margin-bottom:10px">
				
				<label for="saida-aparelho">Modelo do Aparelho: </label>
			
				<select name="saida-aparelho">

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
				<span class="erro" id="esaida-aparelho" style="">Por favor, selecione o modelo do Aparelho!</span>
			
			</div>

			<div style="margin-bottom:10px">
				
				<label for="saida-esn">ESN: </label>
				<input type="text" name="saida-esn" />

				<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
				<span class="erro" id="esaida-esn" style="">Esn inválida!</span>

				<img name="saida-add-esn" src="img/add.png" style="margin-left:10px; cursor:pointer;" title="Adicionar ESN" />
				
				<div id="loader-esn-check" style="margin-left:153px; margin-top:10px; display:none;">
					
					<div style="float:left"><img src="img/loader.gif" style="display:inline-block;" /></div>
					<div style="float:left; margin-left:5px;"><span style="font-size:15px; color:#666666; "> Aguarde, o sistema está checando a ESN.</span></div>

				</div>
			
			</div>			
		
		</div> <!--  form-box -->
		
		<div id="box-table-esns" style="margin:50px; margin-bottom:0px; margin-left:100px;">
		
			<table id="table-esns-head" style="width:100%; height:40px;">
				<tr>
					<td>Estoquista: </td>
					<td>Parceiro: </td>
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
