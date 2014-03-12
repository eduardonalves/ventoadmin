<meta name="http-equiv" content="Content-type: text/html; charset=UTF-8"/>

<link rel="stylesheet" type=text/css href="css/tables.css" />
<link rel="stylesheet" type=text/css href="css/paginacao.css" />

<?php
// Verificar se está logado

if(!isset($_SESSION['usuario'])){ ?>

	

<script type="text/javascript">

<!-- window.location = 'index.php' -->

</script>	

	

	

<?php } 

$saidaTexto = new Accents( Accents::UTF_8, Accents::ISO_8859_1 );

$objPlanilhas = new planilhaQualidade($conexao);

$statusQualidade = $_POST["filtro-status"];
$orderRelatorio = "";

if (isset($_POST["relatorio-order"]))
{
	$tiposStatus = $objPlanilhas->getTiposPlanilhas();
	$orderTipo = $_POST["relatorio-order-tipo"];
	
	switch($orderTipo)
	{

		case "DESC":
		
			$orderTipo = "ASC";
			break;

		case "ASC":
		
			$orderTipo = "DESC";
			break;

		default:

			$orderTipo = "ASC";
			break;

	}
	

	
	switch($_POST["relatorio-order"])
	{
		
		case "data-status":
		
		$orderRelatorio = "order by data_status_qualidade_4, data_status_qualidade_3, data_status_qualidade_2,data_status_qualidade_1 ,data_status_qualidade_5";
		break;
		
		case "numero":
		
		$orderRelatorio = "order by novoNumero";
		break;

		case "documentacao":
		
		$orderRelatorio = "order by status_processo";
		break;


		case "status-qualidade":
		
		$orderRelatorio = "order by status_qualidade";
		break;

	}
	
	if($orderRelatorio!="")
	{
	$orderRelatorio .= " " . $orderTipo;
	}
	
}

$mes = "0112";

if(isset($_POST["filtro-mes"]) && $_POST["filtro-mes"]!="n")
{
	$mes = $_POST["filtro-mes"].$_POST["filtro-mes"];
	
}

$ano = "1000".date("Y");

if(isset($_POST["filtro-ano"]) && $_POST["filtro-ano"]!="n")
{

	$ano = $_POST["filtro-ano"].$_POST["filtro-ano"];
	
	
}
	
	$dataInicio = substr($ano,0,4) . "-" . substr($mes,0,2) . "-10 00:00:00";
	$dataFinal = substr($ano,4,4) . "-" . substr($mes,2,2) . "-10 00:00:00";


$paginacao = new Paginacao($objPlanilhas->getTotalRegistros($statusQualidade));
$planilhaVendas = $objPlanilhas->getPlanilha("$statusQualidade","","$dataInicio","$dataFinal","$orderRelatorio",$paginacao->getLimites());

$colunas = array(
				
				"data-status" => "DATA STATUS",
				"numero" => "NÚMERO",
				"documentacao" => "DOCUMENTAÇÃO",
				"status-qualidade" => "STATUS QUALIDADE"
				
				
				);

if(isset($_POST["colunas-option"]))
{
	$novaString = "";
	
	foreach($_POST["colunas-option"] as $key=>$value)
	{
		$novaString .= "(" . $value . ") ";
	}
	
	$conexao->query("UPDATE usuarios SET colunas_status_qualidade ='" . $novaString . "' WHERE id = '".$USUARIO['id']."'");
	
	echo "<script type=\"text/javascript\">
	
			window.location = location.href; 
		</script>";
}

function verificaColuna($coluna)
{
	global $USUARIO;
	
	$consulta = strstr($USUARIO['colunas_status_qualidade'],"($coluna)");
	
	if($consulta)
	{
		return "checked=\"checked\"";
		
	}else{
		
		return false;
		
	}
}

function verificaColunaIcon($coluna)
{
	global $orderTipo;
	
	if($_POST["relatorio-order"]==$coluna)
	{
		if ($orderTipo=="DESC")
		{

			echo "<img src=\"img/seta-d.png\" title=\"Ordem descrescente\" alt=\"Ordem descrescente\" />";
		
		}else{

			echo "<img src=\"img/seta-u.png\" title=\"Ordem crescente\" alt=\"Ordem crescente\" />";
		}
	}
}

function verificaFiltro($nomeFiltro, $valorFiltro)
{
	if(isset($_POST[$nomeFiltro]))
	{
		if ($_POST[$nomeFiltro]==$valorFiltro)
		{ 
			return true;
		}
	}
	
	return false;
}
?>

<link rel="stylesheet" type="text/css" href="css/custom.css" />
<script type="text/javascript" src="js/pekeUpload.js"></script>

<style type="text/css">



#blackout{position:fixed; top:0px; left:0px; width:100%; height:100%; background-color:#000; z-index:200; opacity: 0.6; display:none; }



#colunas{position:fixed; padding-bottom:20px; width:400px; background-color:#FFF; top:30px; left:-50%; margin: 0 0 0 -200px; z-index:300; display:none; opacity: 0;



-webkit-border-radius: 10px;

border-radius: 10px;



-webkit-box-shadow:  0px 0px 10px 2px #999;

        

box-shadow:  0px 0px 10px 2px #999;

}



.close{position:absolute; right:6px; top:3px; font-size:12px;     background: none repeat scroll 0 0 #B6B6B6;

	border-radius: 15px;

	color: #FFFFFF;

	float: right;

	height: 15px;

	line-height: 15px;

	padding: 3px;

	margin-top:4px;

	text-align: center;

	width: 15px;

	cursor:pointer;}

.colunas-option{
	
	margin-bottom:10px;
	font-size:14px;
	left:20px;
	
	}


</style>

<script type="text/javascript">

	function _GET(name)
	{
	  var url   = window.location.search.replace("?", "");
	  var itens = url.split("&");

	  for(n in itens)
	  {
		if( itens[n].match(name) )
		{
		  return decodeURIComponent(itens[n].replace(name+"=", ""));
		}
	  }
	  return null;
	}

	$(document).ready( function() {
		
		$(".link-paginacao").live("click", function(event) {
			
			event.preventDefault();
			
			var urlAction = $(this).attr("href");
			
			$("#form-filtro-relatorios").attr("action", urlAction);
			$("#form-filtro-relatorios").trigger("submit");
			
		});
		
		$(".tabela-relatorio-coluna").live("click", function() {
			
			var idcoluna = $(this).attr("id");
			var coluna = idcoluna.replace("tabela-relatorio-coluna-","");
			
			$("#form-filtro-relatorios-relatorio-order").val(coluna);
			$("#form-filtro-relatorios").trigger("submit");
			
		});

		$("#select-paginacao").live("change", function() {
			
			
			var url = location.href;
			var url_h = url.replace("&reg_pg=<?php echo $paginacao->getQuantRegistro(); ?>", "");
			var urlAction = url_h + "&reg_pg=" + $("#select-paginacao").val();
			
			$("#form-filtro-relatorios").attr("action", urlAction);
			$("#form-filtro-relatorios").trigger("submit");
			
			//window.location.href = url_h + "&reg_pg=" + $("#select-paginacao").val();
			
		});
		
		$(".bt-detalhes").live("click", function(){
			
			var id = $(this).attr("id");
			
			Popup = window.open ('status-portal-detalhes.php?id='+id,'Popup',
			'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,\
			resizable=no,width=630,height=600,left=430,top=30');

		});

		$("#statusForm").live("submit", function(event, x){
		
		if(x!==true) {return false; }
		
		});
			
			
			$("#bt-submit").live("click", function(){

				if($("#tipoPlanilha").val()==0)
				{
					alert(decodeURIComponent(escape("Tipo de planilha não selecionado.")));
					return false;
				}else
				
				{

					if($("#file").val()=="")
					{
						alert(decodeURIComponent(escape("Arquivo de planilha não selecionado.")));
						return false;

					}
				}
			 });

		$("#file").pekeUpload({invalidExtError:'Tipo de arquivo inv&aacute;lido', file:'arquivo', onSubmit:true, multi:false, data:'<?php $curTime = time(); echo $curTime;?>', btnText:'Selecionar arquivo', allowedExtensions:"xls", onFileSuccess: function(file,data){ $("#statusForm").trigger("submit", [true]);}});
		
		$("#button-importar-toggle").click( function(){
			
			$("#importar-box").toggle(100, "linear");
			
			var imagename = $("#img-button-importar-toggle").attr("src");
			
			if (imagename=="img/seta-d.png")
			{
				$("#img-button-importar-toggle").attr("src", "img/seta-u.png");
			
			}else{
				
				$("#img-button-importar-toggle").attr("src", "img/seta-d.png");
			}
		
		});

	});

	function mostrarcolunas()
	{ 

		$('#colunas').fadeIn(1); 
		$('#blackout').fadeIn(500);	
		$('#colunas').animate({left:'50%',opacity:'1'},500);

	 }



	function escondercolunas()
	{  
		$('#colunas').fadeOut(500);
		$('#blackout').fadeOut(500);
		$('#colunas').animate({left:'-50%',opacity:'0'},500);
	}

</script>


<div id="blackout"></div>



<div id="colunas">

	<div class="close" onclick="escondercolunas();">X</div>
	
	<div id="colunas-label" style="position:relative; width:100%; margin-top:15px; margin-left:15px;height:40px; color:#999; font-weight:bold; font-size:14px;">
		COLUNAS VIS&Iacute;VEIS
	</div>
	
	<div id="colunas-options" style="width:97%; margin-left:auto; margin-right:auto;">

		<form name="colunas" method="post">
			
			<?php
			
			foreach($colunas as $key=>$value)
			{
			?>
			<div id="option-<?php echo $key; ?>" class="colunas-option" style="position:relative; width:50%; float:left;">
				<input type="checkbox" name="colunas-option[]" <?php echo verificaColuna("$key"); ?> value="<?php echo $key; ?>" /> <?php echo $saidaTexto->clear($value); ?>
			</div>
			<?php
			}
			?>
		
		<img src="img/salvar.png" onClick="javascript:document.forms.colunas.submit();" width="100" style="clear:both; position:relative; float:left;cursor:pointer; display:block; left:20px; margin-top:15px;" />
		
		</form><!-- colunas -->

	</div><!-- colunas-options -->


</div><!-- colunas -->

<div id="main" style="position:relative; width:1000px; margin-right:auto; margin-left:auto;font-size:14px; color:#999;">
	
	<div id="importar-label" style="position:relative; display:block;padding-top:30px;">
	
		<span style="float:left;">STATUS PORTAL</span>
		<span id="button-importar-toggle" style="cursor: pointer; float:right; border:1px solid #CCCCCC; padding:5px;">Importar <img id="img-button-importar-toggle" src="img/seta-u.png" style="width:9px;" /></span>
	
	</div><!-- importar-label -->
	
	<hr style="width:100%; display:block; float:left;" size="1" color="#CCCCCC" />
	
	<div id="conteudo" style="width:1000px; margin-top:50px; margin-left:auto; margin-right:auto; position:relative; background-color:#CCC">
		
		<div id="importar-box" style=" position:relative; display:none; width:850px; margin-left:auto; margin-right:auto; margin-bottom:150px;">
		
			<form id="statusForm" name="statusForm" method="post" action="?p=configuracoes&es=4-update" enctype="multipart/form-data">
				
				<input type="hidden" name="unique-filename" value="<?php echo $curTime; ?>" />
				
				<label for="tipoPlanilha" style="display:block; width:100%">Tipo de Planilha:</label>
				
				<select id="tipoPlanilha" name="tipoPlanilha" style="min-width:250px; border:1px solid #BFBFBF;">
				
					<option value="0">N&atilde;o Selecionado</option>
				<?php
				
				$tiposPlanilhas = $objPlanilhas->getTiposPlanilhas("nao", 2);
				
				foreach($tiposPlanilhas as $key=>$value)
				{
					if($key!=0)
					{
				?>
					<option value="<?php echo $key; ?>"><?php echo $saidaTexto->Clear($value); ?></option>
				<?php
					}
				}
				?>
				
				</select><!-- tipoPlanilha -->
				
				<input id="file" type="file" name="arquivo" style="border-left: 1px solid #CCCCCC; padding-left:3px;display:block; float:right;" />
				
				<input id="bt-submit" type="submit" value="Importar Planilha" style="margin-top:40px; clear:right; min-width:140px; display:block; float:left;" />
				
			</form><!-- statusForm -->
		
		</div><!-- importar-box -->
		
		<div id="relatorios" style="float:left;position:relative; width:100%;">
			
			<span style="position: relative; float:left; color:#000000; width:100%; background-color:#F5F5F5; padding:5px;">RELAT&Oacute;RIO DE STATUS</span>
			
			<div id="relatorios-filtro-box" style="position:relative;">
				
				<form id="form-filtro-relatorios" name="form-filtro-relatorios" method="post" action="">
					
					<span id="link-limpa-filtros" style="position:relative; display:block; float:left; color:#000000; font-size:14px; margin-left:10px; margin-top:20px; text-align:center;">
						Mostrar: <a href="?p=configuracoes&m=&an=&es=4" style="text-decoration:none; color:#000000; font-weight:bold;">Todos</a>
					</span>
					
					<span id="relatorios-filtro-status" style="position:relative; float:left; display:block; margin-left:15px; margin-top:14px;">
						
						<label for="filtro-status">| Status: </label>
						
						<select name="filtro-status">
							
							<option value="n">Todos</option>
							
							<?php
							$tiposPlanilhas = $objPlanilhas->getTiposPlanilhas();
							
							foreach($tiposPlanilhas as $key=>$value)
							{
							?>
							
							<option value="<?php echo $key; ?>" <?php if(verificaFiltro("filtro-status", "$key")) { echo "selected=\"selected\""; } ?>><?php echo $saidaTexto->Clear($value); ?></option>
							<?php 
							}
							?>
						</select>
						
					</span><!-- relatorios-filtro-mes -->

					<span id="relatorios-filtro-mes" style="position:relative; float:left; display:block; margin-left:15px; margin-top:14px;">
						
						<label for="filtro-mes">| M&ecirc;s: </label>
						
						<select name="filtro-mes">
							
							<option value="n" >Todos</option>
							<option value="01" <?php if(verificaFiltro("filtro-mes", 1)) { echo "selected=\"selected\""; } ?>>Janeiro</option>
							<option value="02" <?php if(verificaFiltro("filtro-mes", 2)) { echo "selected=\"selected\""; } ?>>Fevereiro</option>
							<option value="03" <?php if(verificaFiltro("filtro-mes", 3)) { echo "selected=\"selected\""; } ?>>Mar&ccedil;o</option>
							<option value="04" <?php if(verificaFiltro("filtro-mes", 4)) { echo "selected=\"selected\""; } ?>>Abril</option>
							<option value="05" <?php if(verificaFiltro("filtro-mes", 5)) { echo "selected=\"selected\""; } ?>>Maio</option>
							<option value="06" <?php if(verificaFiltro("filtro-mes", 6)) { echo "selected=\"selected\""; } ?>>Junho</option>
							<option value="07" <?php if(verificaFiltro("filtro-mes", 7)) { echo "selected=\"selected\""; } ?>>Julho</option>
							<option value="08" <?php if(verificaFiltro("filtro-mes", 8)) { echo "selected=\"selected\""; } ?>>Agosto</option>
							<option value="09" <?php if(verificaFiltro("filtro-mes", 9)) { echo "selected=\"selected\""; } ?>>Setembro</option>
							<option value="10" <?php if(verificaFiltro("filtro-mes", 10)) { echo "selected=\"selected\""; } ?>>Outubro</option>
							<option value="11" <?php if(verificaFiltro("filtro-mes", 11)) { echo "selected=\"selected\""; } ?>>Novembro</option>
							<option value="12" <?php if(verificaFiltro("filtro-mes", 12)) { echo "selected=\"selected\""; } ?>>Dezembro</option>
							
						</select>
						
					</span><!-- relatorios-filtro-mes -->

					<span id="relatorios-filtro-ano" style="position:relative; float:left; display:block; margin-left:15px; margin-top:14px;">
						
						<label for="filtro-ano">| Ano: </label>
						
						<select name="filtro-ano">
							
							<option value="n">Todos</option>
							
							<?php
							$listaAnos = "";
							
							function carregaListaAnos()
							{
								global $listaAnos;
								global $conexao;
								
								$sql_allVendas = $conexao->query("Select * from vendas_clarotv where novoNumero!='' order by data");
								
								while($allVendas = mysql_fetch_assoc($sql_allVendas))
								{
									$anoData = substr($allVendas["data"],0,4);
									
									if (!in_array($anoData, $listaAnos))
									{
										array_push($listaAnos, $anoData);
									}
									
									for($i=1; $i<=5; $i++)
									{
										
										$anoData = substr($allVendas["data_status_qualidade_".$i], 0,4 );
										
										if (!in_array($anoData, $listaAnos))
										{
											array_push($listaAnos, $anoData);
										}
										
									}
									
								}
								
								sort($listaAnos);
							}// fnct carregaListaAnos
							
							
							if(!isset($_POST["listAnos"]))
							{
								$listaAnos = array();
								
								carregaListaAnos();
								
							}else{
								$listaAnos = json_decode($_POST["listAnos"]);
							}
							
							
							foreach($listaAnos as $key=>$value)
							{
								echo "<option value=\"$value\" "; if(verificaFiltro("filtro-ano", $value)) { echo "selected=\"selected\""; } echo ">$value</option>";
							}

							?>
							
						</select>
						
					</span><!-- relatorios-filtro-ano -->

					<span id="relatorios-submit" style="position:relative; float:left; display:block; margin-left:15px; margin-top:14px;">
						
						<input type="submit" value="OK" style="display:block; width:30px; height:25px; font-size:10px;" />
						
						<input id="form-filtro-relatorios-relatorio-order" type="hidden" name="relatorio-order" />
						<input id="form-filtro-relatorios-relatorio-order-tipo" type="hidden" name="relatorio-order-tipo" value="<?php echo $orderTipo; ?>" />
						
					</span><!-- relatorios-submit -->
					
					<span id="relatorios-select-paginacao" style="position:relative; float:right; display:block; margin-left:15px; margin-top:14px; margin-right:10px;">
					
						Mostrar:
						<select id="select-paginacao" name="select-paginacao">

							<?php
							
							foreach ($paginacao->getOpcoes() as $key=>$value)
							{
								if($paginacao->getQuantRegistro() == $value)
								{
									$optPageSelecionada = " selected=\"selected\"";
								
								}else{
									
									$optPageSelecionada = "";
								}
								
								echo "<option value=\"" . $value . "\" . $optPageSelecionada>" . $value . "</option>";
							}
							
							?>

						</select>
						<?php
						
							echo "<input type=\"hidden\" name=\"listAnos\" value='".json_encode($listaAnos)."' />";
						
						?>
					
					</span><!-- relatorios-select-paginacao -->

					<span id="relatorios-bt-colunas" style="position:relative; cursor:pointer; float:right; display:block; margin-left:15px; margin-top:16px;">
					
						<img src="img/gear.png" width="20" style="cursor:pointer" onclick="mostrarcolunas();" title="Selecionar Colunas Vis&iacute;veis"  />
					
					</span><!-- relatorios-bt-colunas -->


				</form><!-- form-filtro-relatorios -->
				
			</div><!-- relatorios-filtro-box -->
			
			<div id="estatisticas" style="position:relative; float:left; clear:both; margin:20px; margin-top:40px;">
				
				<?php
				
				$estatisticas = $objPlanilhas->getEstatisticas();

				echo "<span id=\"estatistica-total\" style=\"display:block; float:left; width:100%; margin-bottom:10px;\"><b>". $estatisticas["total_registros"] . " </b>registros encontrados.</span>";

				foreach($estatisticas["relatProcessos"] as $key=>$value)
				{
					echo "<span id=\"estatistica-processo\" style=\"display:block; float:left; width:100%;\"><b>" . $saidaTexto->clear($objPlanilhas->getTiposProcessos($key)) . ": </b>" . $value . " registros encontrados.</span>";
				}
				
				echo "<br /><br /><br />";

				foreach($estatisticas["relatStatus"] as $key=>$value)
				{
					echo "<span id=\"estatistica-qualidade\" style=\"display:block; float:left; width:100%;\"><b>" . $saidaTexto->clear($objPlanilhas->getTiposPlanilhas("$key")) . ": </b>" . $value . " registros encontrados.</span>";
				}
				
				$num = "21977187623";
				Qualidade::maskTel($num);
				$data = "20081002";
				Qualidade::toFullData($data);
				//echo $num . " " . $data;
				Qualidade::toShortData($data);
				//echo "<br>$data";
				?>

			</div><!-- estatisticas -->
			
			<div id="paginacao1" class="paginacao" style="margin-bottom:-30px; margin-top:30px;">
				
				<?php
				
				$paginacao->gravaPaginacao();
				
				?>
				
			</div><!-- paginacao -->

			<div id="tabela-relatorio-box" style="position:relative; float:left; width:1000px; margin-top:50px;">
			
			<table id="tabela-relatorio" width="100%">
			
				<tr style="padding-top:5px; padding-bottom:3px; background-color:#565656; text-align:center;color:#FFF; font-size:14px; font-weight:bold;" class="tr1">
				<?php 
				foreach($colunas as $key=>$value)
					{
						if(verificaColuna($saidaTexto->clear($key)))
						{
					?>
					<td id="tabela-relatorio-coluna-<?php echo $key;?>" class="tabela-relatorio-coluna <?php echo $orderTipo; ?>" style="cursor:pointer;"><?php echo $saidaTexto->clear($value); ?> <?php echo verificaColunaIcon($key); ?></td>
				<?php
						}
					}
				
				?>
					<td></td>

				</tr>
				
				<?php
			
				foreach ($planilhaVendas as $value)
				{
					
					if ($value["status_qualidade"]==0)
					{
						
						$dataStatus = "";
						
					}else{
						
						$dataStatus = $value["data_status_qualidade_" . $value["status_qualidade"]];
					
					}
					
					$numero = $saidaTexto->clear($value["novoNumero"]);
					$statusProcesso = $saidaTexto->clear($objPlanilhas->getTiposProcessos($value["status_processo"]));
					$statusQualidade = $saidaTexto->clear($objPlanilhas->getTiposPlanilhas($value["status_qualidade"]));
					$id = $value["id"];
				?>
				<tr class="tb-line">
				<?php 
				foreach($colunas as $key=>$value)
					{
						
						if (verificaColuna($key)) { 
						
						switch($key)
						{
							
							case ("data-status"):
							
				?>
				
					<td><?php echo $dataStatus; ?></td>
				
				<?php
							
							break;

							case ("numero"):
							
				?>
				
					<td><?php if (verificaColuna($key)) { echo $numero; }?></td>
				
				<?php
							
							break;

							case ("documentacao"):
							
				?>
				
				<td><?php if (verificaColuna($key)) { echo $statusProcesso; }?></td>
				
				<?php
							
							break;

							case ("status-qualidade"):
							
				?>
				
				<td><?php if (verificaColuna($key)) { echo $statusQualidade; }?></td>
				
				<?php
							
							break;

						}
						}
					}
				
				?>
					
					<td width="26px"><img id="<?php echo $id; ?>" class="bt-detalhes" src="img/icone-mais.png" style="width:13px; padding:0; cursor:pointer;" alt="Exibir detalhes deste n&uacute;mero" title="Exibir detalhes deste n&uacute;mero" /></td>

				</tr>
				<?php
				}
				?>

			</table><!-- tabela-relatorio -->
			
			</div><!-- tabela-relatorio-box -->
			
			<div id="paginacao2" class="paginacao">
				
				<?php
				
				$paginacao->gravaPaginacao();
				
				?>
				
			</div><!-- paginacao -->
			
		</div><!-- relatorios -->
			
	</div><!-- conteudo -->

</div><!-- main -->

