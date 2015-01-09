<?
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set("Brazil/East");

if(!isset($_SESSION)){ session_start(); }

include_once "conexao.php";

include_once "lib/class.Usuarios.php";
include_once "lib/class.VentoAdmin.php";
include_once "lib/class.Venda.php";
include_once "lib/class.VendaStatus.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Detalhes Venda Tech in Move</title>
<style type="text/css">
body{margin: 0 0 0 0; font-family:Arial, Helvetica, sans-serif;}

#topo{position:relative; background:url(img/topo-bg.png) repeat-x; top:0px; height:120px; width:100%;}

.campoobrigatorio{ font-size:12px; color:#06C; cursor:default; }
.campo-invalido{

	-moz-box-shadow: 1px 1px 3px #FFA4A4;
	-webkit-box-shadow: 1px 1px 3px #FFA4A4;
	box-shadow: 1px 1px 3px #FFA4A4;
	border: 1px solid #FFA4A4;
	border-radius:0.3em;

            }

.dados-cartao-mensalidade span, .dados-cartao span{
	
	display:inline-block;
	padding-top:10px;
}
</style>
</head>

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.mockjax.js"></script>
<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
<script type="text/javascript" src="js/scpt-autocomplete-esns-aparelhos.js"></script>
<script type="text/javascript" src="js/techinmove.js"></script>
<script type="text/javascript" src="js/calendario.js"></script>

<script type="text/javascript" src="js/plupload.full.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/jquery.plupload.queue/jquery.plupload.queue.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="js/i18n/pt_BR.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="js/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.7.3.custom.css" />
<link rel="stylesheet" type="text/css" href="css/custom.css" />
<script type="text/javascript" src="js/pekeUpload-techinmove.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	
	var tipo_doc = $("#tipo_documento option:selected").val();
	var time = '<?php $curTime = '-' . $_GET['id'] . "-" . time(); echo $curTime;?>';
	
	$("#tipo_documento").change( function() {

		tipo_doc = $("#tipo_documento option:selected").val();
		//alert(t.data);
		//$("#file").newData('doc-' + tipo_doc + time);
		$("#file").data = 'doc-' + tipo_doc + time;

	});

	$("#file").pekeUpload({invalidExtError:'Tipo de arquivo inv&aacute;lido', file:'arquivo', onSubmit:false, multi:false, data:'doc<?php echo $curTime;?>-', btnText:'Selecionar arquivo', venda_id:'<?php echo $_GET['id']; ?>', user_id:'<?php echo $USUARIO['id'];?>', allowedExtensions:"jpg|jpeg|gif|png|pdf", onFileSuccess: function(file,data){ location.reload(true); }});
	
});


</script>

<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>
<script type="text/javascript">

$(document).ready(function() {
	
	$(window).load( function (){
		
		$("#forma_pagamento_produto").trigger('change');
		$("#forma_pagamento_mensalidade").trigger('change');
		
	});

	$(document).on('change', '#novocontato', function(){

		if( $(this).val() !=''){
			
			$('#obsnovocontato').removeClass('campo-obrigatorio');
			$('#obsnovocontato').addClass('campo-obrigatorio');
			
		}else{
			
			$('#obsnovocontato').removeClass('campo-obrigatorio');
		}

	});
	
	$(document).on('keyup', '#obsnovocontato', function(){

		if($(this).val() !=''){
			
			$('#novocontato').removeClass('campo-obrigatorio');
			$('#novocontato').addClass('campo-obrigatorio');
			
		}else{
			
			$('#novocontato').removeClass('campo-obrigatorio');
		}
		
	});
	
	$(document).on('click', '.validade-cartao', function(){
		
		$('.ui-datepicker-calendar').css('display', 'none');
		
	});

	$(document).on('click', '.datepicker', function(){
		
		$('.ui-datepicker-calendar').css('display', 'table');
		
	});

	$(document).on('change', '#forma_pagamento_produto', function(){

		var formaPagamento = $(this).val();

		if(formaPagamento == 'Cartão de Crédito'){

			$('.dados-cartao').css('display', 'block');
			$('.dados-cartao *').attr('disabled', false);

		}else{

			$('.dados-cartao').css('display', 'none');
			$('.dados-cartao *').attr('disabled', true);

		}
	});

	$(document).on('change', '#forma_pagamento_mensalidade', function(){

		var formaPagamento = $(this).val();

		if(formaPagamento == 'Cartão de Crédito'){

			$('.dados-cartao-mensalidade').css('display', 'block');
			$('.dados-cartao-mensalidade *').attr('disabled', false);

		}else{

			$('.dados-cartao-mensalidade').css('display', 'none');
			$('.dados-cartao-mensalidade *').attr('disabled', true);

		}
	});

});



</script>

<link rel="stylesheet" type="text/css" href="css/style-autocomplete.css" />

<?
	
// Verificar se está logado
if(!isset($_SESSION['usuario'])){ ?>
<script type="text/javascript">

window.location = 'index.php'

</script>	


<? }


$consulta = $conexao->query("SELECT *, 
						
						DATE_FORMAT(cartao_mensalidade_validade, '%m/%Y') as cartao_mensalidade_validade, 
						DATE_FORMAT(cartao_validade, '%m/%Y') as cartao_validade, DATE_FORMAT(data_venda, '%d/%m/%Y') as data_venda, 
						IF(data_finalizada!='0000-00-00', DATE_FORMAT(data_finalizada, '%d/%m/%Y'), '') as data_finalizada, 
						IF(cartao_numero!='', CONCAT('XXXX-XXXX-XXXX-', SUBSTR(AES_DECRYPT(cartao_numero, @strPass_techinmove), -4)), '') as cartao_numero, 
						IF(cartao_mensalidade_numero!='', CONCAT('XXXX-XXXX-XXXX-', SUBSTR(AES_DECRYPT(cartao_mensalidade_numero, @strPass_techinmove), -4)), '') as cartao_mensalidade_numero, 
						IF(cartao_codseg!='', CONCAT('XX', SUBSTR(AES_DECRYPT(cartao_codseg, @strPass_techinmove), -1)), '') as cartao_codseg, 
						IF(cartao_mensalidade_codseg!='', CONCAT('XX', SUBSTR(AES_DECRYPT(cartao_mensalidade_codseg, @strPass_techinmove), -1)), '') as cartao_mensalidade_codseg 
						FROM vendas_techinmove WHERE id = '".$_GET['id']."'");

$linha = mysql_fetch_array($consulta);

$conUSUARIO = $conexao->query("SELECT * FROM usuarios WHERE id = '".$_SESSION['usuario']."'");

$USUARIO = mysql_fetch_array($conUSUARIO);


if($_GET['e'] == '1' && $USUARIO['editar_dados'] == '1'){ $editar = '1';}




if($_GET['e'] == '1' && $USUARIO['editar_instalacao'] == '1'){ $editar_instalacao = '1';}


///////////////////////////////////

		// ##################### Verifica campos em branco para finalizar venda ######################
		$campos = array(

			"os" => "OS",
			"esn" => "ESN",
			"novonumero" => "Novo Número",
			"nome" => "Nome do Cliente",
			"nomemae" => "Nome da Mãe", 
			"nascd" => "Dia do Nascimento",
			"nascm" => "Mês do Nascimeno",
			"nasca" => "Ano do Nascimento",
			"icpf" => "CPF",
			"rg" => "RG",
			"orgexp" => "Orgão Expedidor do RG",
			"dataexp" => "Data Expedição do RG",
			"profissao" => "Profissão",
			"estadocivil" => "Estado Civil",
			"email" => "Email",
			"itelefone" => "Telefone",
			"tipotel1" => "Tipo de Telefone",
			"itelefone2" => "Telefone 2",
			"tipotel2" => "Tipo do telefone 2",
			"itelefone3" => "Telefone 3",
			"tipotel3" => "Tipo do Telefone 3",
			"endereco" => "Endereço",
			"numero" => "Número da Casa",
			"lote" => "Lote",
			"quadra" => "Quadra",
			"complemento" => "Complemento",
			"bairro" => "Bairro",
			"cidade" => "Cidade",
			"uf" => "Estado",
			"icep" => "CEP",
			"pontoref" => "Ponto de Referência",
			"monitor" => "Monitor",
			"operador" => "Operador",
			"tipolinha" => "Tipo da Linha",
			"tipoassinatura" => "Tipo de Assinatura",
			"tipoplano" => "Tipo de Plano",
			"plano" => "Plano",
			"valorplano" => "Valor do Plano",
			"aparelho" => "Modelo do Aparelho",
			"valoraparelho" => "Valor do Aparelho",
			"tipoEntrega" => "Tipo de Entrega",
			"pagamento" => "Forma de Pagamento",
			"idata" => "Data da Venda",
			"vencimento" => "Dia do Vencimento",
			"status" => "Status"

			);


extract($_POST, EXTR_PREFIX_ALL, "data"); 

if(strlen($_POST['obs']) > 3){
	
	$obs = array(
				
				'foto' => $USUARIO['foto'],
				'data' => date("d/m/Y"),
				'usuario' => $USUARIO['nome'],
				'obs' => utf8_decode($_POST['obs'])
				);	
	
	if($linha['observacoes']==''){
		
		$data_observacoes = json_encode( array(
									
									0 => $obs
									
									));
	}else{
		
		$data_observacoes = json_decode($linha['observacoes'], true);
		
		array_push($data_observacoes, $obs);
		
		$data_observacoes = json_encode($data_observacoes);
		
	}

}

if( $_POST['novocontato'] != '' && strlen($_POST['obsnovocontato']) > 3 ){
	
	$contato = array(
				
				'tipo' => $_POST['novocontato'],
				'data' => date("d/m/Y"),
				'usuario' => $USUARIO['nome'],
				'obs' => $_POST['obsnovocontato']
				);	
	
	if($linha['contatos']==''){
		
		$data_contatos = json_encode( array(
									
									0 => $contato
									
									));
	}else{
		
		$data_contatos = json_decode($linha['contatos'], true);
		
		array_push($data_contatos, $contato);
		
		$data_contatos = json_encode($data_contatos);
		
	}

}

if ( ( isset($data_action) ) && ( ($data_action)== 'edit') ){

	$campos = $conexao->query("SELECT COLUMN_NAME, DATA_TYPE FROM information_schema.columns WHERE TABLE_SCHEMA = 'db498864657' AND TABLE_NAME = 'vendas_techinmove'");

	while ( $campo = mysql_fetch_assoc($campos) ){
		
		$varName = "data_" . $campo['COLUMN_NAME'];

		if( isset($$varName) ){

			$queryFields .= $campo['COLUMN_NAME'];

			if($campo['COLUMN_NAME']=='data_finalizada'){

				if($USUARIO['tipo_usuario']=='ADMINISTRADOR'){
					
					if($data_status!='FINALIZADA'){
						
						$$varName = "00/00/0000";
						
					}else{
						
						$$varName = ($$varName=='') ? $$varName = $linha['data_finalizada'] : $$varName;
					}
					
					$queryFields .= '='. "STR_TO_DATE('" . $$varName . "', '%d/%m/%Y')" . ", ";
					
				}else{
					
					$queryFields .= '='. $linha['data_finalizada'] . ", ";
					
				}
			
			}elseif($campo['COLUMN_NAME']=='data_finalizada'){
				
				if($USUARIO['tipo_usuario']!='ADMINISTRADOR'){
					
					$$varName = ($$varName=='') ? $$varName = $linha['data_finalizada'] : $$varName;
					
				}
				
				$queryFields .= '='. "STR_TO_DATE('" . $$varName . "', '%d/%m/%Y')" . ", ";
			
			}elseif($campo['COLUMN_NAME']=='cartao_validade' || $campo['COLUMN_NAME']=='cartao_mensalidade_validade'){
				
				$queryFields .= '='. "STR_TO_DATE('" . $$varName . "', '%m/%Y')" . ", ";
			
			}elseif($campo['COLUMN_NAME']=='cartao_numero' || $campo['COLUMN_NAME']=='cartao_codseg' || $campo['COLUMN_NAME']=='cartao_mensalidade_numero' || $campo['COLUMN_NAME']=='cartao_mensalidade_codseg'){
				
				if($USUARIO['tipo_usuario']!='ADMINISTRADOR'){
					
					$queryFields .= '='. $campo['COLUMN_NAME'] . ", ";
				
				}else{
					
					if(strstr($$varName, 'XXXX') || strstr($$varName, 'XX')){
						
						$queryFields .= '='. $campo['COLUMN_NAME'] . ", ";
					
					}else{
					
						$queryFields .= '='. "AES_ENCRYPT('" . $$varName . "', @strPass_techinmove)" . ", ";
					
					}
					
				}
				
			}else{

				if($campo['DATA_TYPE']== 'decimal') {

					$$varName = preg_replace("/[^0-9,]/", "", $$varName);

					$$varName = str_replace(".", "", $$varName);
					$$varName = str_replace(",", ".", $$varName);

				}

				if($campo['DATA_TYPE']== 'date'){

					$newVal = "STR_TO_DATE('" . $$varName . "', '%d/%m/%Y')";
					$$varName = $newVal;

					$queryFields .= '='. $$varName . ", ";

				}else{

					$queryFields .= "='" . $$varName . "', ";
				}
			
			}

		}
		
	}


$queryFields = "Update vendas_techinmove set " . substr($queryFields,0,-2) . " where id='" .$linha['id'] . "'";
$conexao->query($queryFields);

echo $queryFields;

die();

}
if(isset($_POST['nome'])){

$os = $_POST['os'];
$esn = $_POST['esn'];
$novoNumero = $_POST['novonumero'];
$numchip = $_POST['numchip'];

// Dados Pessoais
$nome = $_POST['nome'];
$nascimento = $_POST['nascd'].'/'.$_POST['nascm'].'/'.$_POST['nasca'];
$cpf = $_POST['icpf'];
$rg = $_POST['rg'];
$org_exp = $_POST['orgexp'];
$profissao = $_POST['profissao'];
$sexo = $_POST['sexo'];
$estado_civil = $_POST['estadocivil'];
$email = $_POST['email'];
$telefone = $_POST['itelefone'];
$tipo_tel1 = $_POST['tipotel1'];
$telefone2 = $_POST['itelefone2'];
$tipo_tel2 = $_POST['tipotel2'];
$telefone3 = $_POST['itelefone3'];
$tipo_tel3 = $_POST['tipotel3'];

// Endereço Instalação
$endereco = $_POST['endereco'];	
$numero = $_POST['numero'];	
$lote = $_POST['lote'];	
$quadra = $_POST['quadra'];	
$complemento = $_POST['complemento'];	
$bairro = $_POST['bairro'];	
$cidade = $_POST['cidade'];	
$uf = $_POST['uf'];
$cep = $_POST['icep'];
$ponto_referencia = $_POST['pontoref'];

// Dados da Venda
$operador = $_POST['operador'];
$monitor = $_POST['monitor'];
$tipoLinha = $_POST['tipolinha'];
$tipoAssinatura = $_POST['tipoassinatura'];
$tipoPlano = $_POST['tipoplano'];
$plano = $_POST['plano'];
$valorPlano = $_POST['valorplano'];
$aparelho = $_POST['aparelho'];
$valorAparelho = $_POST['valoraparelho'];
$pagamento = $_POST['pagamento'];
$tipoEntrega = $_POST['tipoEntrega'];
$id_pagseguro = $_POST['id_pagseguro'];
$data0 = explode('/',$_POST['idata']);
$data = $data0[2].$data0[1].$data0[0];
$plano = $_POST['plano'];
$vencimento = $_POST['vencimento'];
$banco_deposito = $_POST['banco_deposito'];
$agencia_deposito = $_POST['agencia_deposito'];
$contacorrente_deposito = $_POST['contacorrente_deposito'];
$numchip = $_POST['numchip'];


// Observações

if(strlen($_POST['obsgravacao']) > 3){
$obs1 = $_POST['obsgravacao'];	
	
$insertOBS1 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','1','".$obs1."')");
		
}

if(strlen($_POST['obsentrega']) > 3){
$obs2 = $_POST['obsentrega'];	
	
$insertOBS2 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','2','".$obs2."')");
		
}

if(strlen($_POST['obsfinalizada']) > 3){
$obs3 = $_POST['obsfinalizada'];	
	
$insertOBS3 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','3','".$obs3."')");
		
}

// Cartão

$titularCartao = $_POST['titularCartao'];

if(strstr($_POST['numcartao'],'XXXX-XXXX')){
$numCar = $linha['numCar'];

} else {

$numCar = base64_encode($_POST['numcartao']);

}


if(strstr($_POST['numcodseguranca'],'XX')){

$codSeg = $linha['codSeg'];

} else {
$codSeg = $_POST['numcodseguranca'];
}

$carVal = $_POST['mesval'].'/'.$_POST['anoval'];

$carBan= $_POST['carbandeira'];


$numParcelas = $_POST['numparcelas'];


function validarCampos(&$campos, $excep)
{
	global $varerros;
			
	foreach($campos as $key=>$value)
	{
		if( ! in_array($key, $excep) )
		{
			if($_POST[$key]=='')
			{
				if( $varerros=='' )
				{
					$varerros = 'Campos obrigatórios não preenchidos ou Inválidos:\n\n';
					$varerros .= "$value";

				}else{
					$varerros .= ", $value";
				}

			}
		}
	}
			
}


	
	if( strtoupper($_POST['status'])=='FINALIZADA' )
	{
		$camposInvalidos = array();
		
		//verificar documentos
		
		// *********** Faz as validacoes ************
		
		if( ($linha['status']!='FINALIZADA') || ($linha['status']=='FINALIZADA' && $USUARIO['tipo_usuario'] != 'ADMINISTRADOR')  )
		{

			if($_POST['tipoEntrega']=='EMBRATEL')
			{
				$excep = array("lote", "quadra", "complemento", "os", "esn", "novonumero","numchip","itelefone3","tipotel3","pontoref");
				validarCampos($campos, $excep);

			}elseif ($_POST['tipoEntrega']=='PRONTA ENTREGA') {

				$excep = array("lote", "quadra", "complemento","numchip","itelefone3","tipotel3","pontoref");
				validarCampos($campos, $excep);
				
				
			}
		}	
	}
		
		
		// ######################################################################



function recarregarDadosForm()
{
	?>
	
	<script type="text/javascript">
	$(window).load( function() {

	<? foreach($_POST as $key=>$val)
	{
	?>
	$("[name='<?=$key;?>']").val("<?=$_POST[$key];?>");
	<?	
	}
	?>
	
	});
	
	</script>
	
	<?
}



//////////////////////
// Atualizar Dados //
////////////////////

$iDataC = date("Y-m-d H:i:s");

if(!$varerros){
	$sucesso ="Sucesso: Dados atualizados!";
	
	$statusAntigo = $linha['status'];
	
	$update = $conexao->query("UPDATE vendas_clarotv SET os = '".$os."', esn = '".$esn."', novoNumero = '".$novoNumero."', nome = '".$nome."', nascimento = '".$nascimento."', cpf = '".$cpf."', rg = '".$rg."', org_exp = '".$org_exp."', profissao = '".$profissao."', sexo = '".$sexo."', estado_civil = '".$estado_civil."', email = '".$email."', telefone = '".$telefone."', tipo_tel1 = '".$tipo_tel1."', telefone2 = '".$telefone2."', tipo_tel2 = '".$tipo_tel2."', telefone3 = '".$telefone3."', tipo_tel3 = '".$tipo_tel3."', endereco = '".$endereco."', numero = '".$numero."', lote = '".$lote."', quadra = '".$quadra."', complemento = '".$complemento."', bairro = '".$bairro."', cidade = '".$cidade."', uf = '".$uf."', cep = '".$cep."', ponto_referencia = '".$ponto_referencia."', operador = '".$operador."', monitor = '".$monitor."', tipoLinha = '".$tipoLinha."', tipoAssinatura = '".$tipoAssinatura."', tipoPlano = '".$tipoPlano."', plano = '".$plano."', valorPlano = '".$valorPlano."', aparelho = '".$aparelho."', valorAparelho = '".$valorAparelho."', pagamento = '".$pagamento."', tipoEntrega = '".$tipoEntrega."', id_pagseguro = '".$id_pagseguro."', banco_deposito = '".$banco_deposito."', agencia_deposito = '".$agencia_deposito."', contacorrente_deposito = '".$contacorrente_deposito."', status = '".$status."', data = '".$data."', vencimento = '".$vencimento."', agendGravacao = '".$agendGravacao."', agendEntrega = '".$agendEntrega."', motivo_restricao = '".$motivo_restricao."',motivo_cancelamento = '".$motivo_cancelamento."', motivo_devolvido = '".$motivo_devolvido."', pendencia = '".$pendencia."', dataLiberacao = '".$dataLiberacao."', obs_recuperacao = '".$obs_recuperacao."', usuario_recuperacao = '".$usuario_recuperacao."', data_recuperacao = '".$data_recuperacao."', data_marcada = '".$data_entrega."', data_instalacao = '".$data_finalizada."', titularCartao = '".$titularCartao."', numCar = '".$numCar."', codSeg = '".$codSeg."', carVal = '".$carVal."', carBan = '".$carBan."', numParcelas = '".$numParcelas."', numchip = '".$numchipUp."' WHERE id = '".$_GET['id']."' ") or die('Ocorreu um Erro ao inserir os dados!');

	if ( strtoupper($_POST['status']) != strtoupper($linha['status']) )
	{
	$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Atualizou status de " . strtoupper($linha['status']) . " para " . strtoupper($_POST['status']) . " (ID: ".$_GET['id'].").')");
	}
	
	if ( strtoupper($_POST['esn']) != strtoupper($linha['esn']) )
	{
	$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Atualizou esn de " . strtoupper($linha['esn']) . " para " . strtoupper($_POST['esn']) . " (ID: ".$_GET['id'].").')");
	}

	if ( strtoupper($data_finalizada) != strtoupper($linha['data_instalacao']) )
	{
	$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Atualizou data instalacao de " . $linha['data_instalacao'] . " para " . $data_finalizada . " (ID: ".$_GET['id'].").')");
	}


	if($_POST['status'] == strtoupper('FINALIZADA') && ( strtoupper($_POST['status']) != strtoupper($statusAntigo) )  && ($_POST['tipoEntrega'] == 'PRONTA ENTREGA' || $_POST['tipoEntrega'] == 'MOTOBOY INTERNO' || $_POST['tipoEntrega'] == 'MOTOBOY EXTERNO'))
	{
	$query = "Update ESNsSaida set status='Vendido' WHERE esn = '$esn' && status='Em Estoque'";
	$conexao->query($query);
	
	$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Baixa de ESN: $esn (ID: ".$_GET['id'].").')");
	
	if($numchip!=false)
	{
		$query = "Update ESNsSaida set status='Vendido' WHERE esn = '$numchip' && status='Em Estoque'";
		$conexao->query($query);
		
		$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Baixa de CHIP: $numchip (ID: ".$_GET['id'].").')");

	}

	}

}






/////////////////
// Insert LOG //
///////////////

$data = date("Y-m-d H:i:s");

$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$_SESSION['usuario']."','Atualizou um dado no sistema (ID: ".$_GET['id'].").')");


?>




<script type="text/javascript">

<?
	if(!$varerros)
	{
	
	?>
	
	alert('<?php echo $sucesso; ?>');
	window.location = '?id=<?= $_GET['id'];?>';
	
	<?
	}else{
	?>
	
	alert('<?php echo $varerros; ?>');
	
	<?
	}
	?>

</script>

<?
recarregarDadosForm();
} // fim isset post[nome]


////////////////////////////////////
////// EXCLUIR GRAVAÇÃO ///////////
//////////////////////////////////



if(isset($_POST['excluirgravacao'])){
	
$excluirgravacao = $conexao->query("UPDATE vendas_clarotv SET auditor = '', gravacao = '' WHERE id = '".$_GET['id']."'");

/////////////////
// Insert LOG //
///////////////

$data = date("Y-m-d H:i:s");

$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$_SESSION['usuario']."','Excluiu uma gravação: [".$linha['gravacao']."] (ID: ".$_GET['id'].") .')");


	?>
	
<script type="text/javascript">

window.alert('Gravação excluída com sucesso!');

window.location = '?e=1&id=<?= $_GET['id'];?>'


</script>    	


<?	
}
?>



<body>

	<div id="result"></div>


	<form name="excluirgravacao" action="" method="post">

		<input type="hidden" name="excluirgravacao" />

	</form>

	<div id="topo">

		<img src="img/LOGO-VENTO-p.png" />

	</div>


	<table border="0" width="100%" style="font-size:14px;">

		<form id="formEditar" name="editar" action="" method="post">
		
		<input id="action" type="hidden" name="action" value="edit">
		
		
		<tr align="center" style="color:#999; font-size:18px; font-weight:bold;\">

			<td colspan="2"><? if($editar == '1'){?> Editar Venda <? } else { ?>Detalhes da Venda <? } ?> <hr size="1" color="#ccc" /></td>

		</tr>

		<? if($linha['protocolo']) {?>
		<tr align="center" style="color:#999; font-size:16px;">

		<td colspan="2"><b>Protocolo:</b>
		<?= $linha['protocolo']; ?></td>
		</tr>

		<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>
		<? } ?>

		<tr>
			<td><b>Razão Social:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input type="text" class="campo-obrigatorio" name="razao_social" id="razao_social" size="40" value="<?= $linha['razao_social']; ?>"  style="float:left;" />


			<? } else { ?>


				<?= $linha['razao_social']; ?>

				<input type="hidden" name="razao_social" size="40" value="<?= $linha['razao_social']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<tr>
			<td><b>CNPJ:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input type="text" class="campo-obrigatorio" name="cnpj" id="cnpj" size="20" value="<?= $linha['cnpj']; ?>"  style="float:left;" />


			<? } else { ?>


				<?= $linha['cnpj']; ?>

				<input type="hidden" name="cnpj" size="20" value="<?= $linha['cnpj']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<tr>
			<td><b>Email Principal:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input class="campo-obrigatorio" type="text" id="email_principal" name="email_principal" value="<?= $linha['email_principal']; ?>" size="30" />


			<? } else { ?>


				<?= $linha['email_principal']; ?>

				<input type="hidden" name="email_principal" size="20" value="<?= $linha['email_principal']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<tr>
			<td><b>Email Alternativo:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input class="" type="text" id="email_alternativo" name="email_alternativo" value="<?= $linha['email_alternativo']; ?>" size="30" />


			<? } else { ?>


				<?= $linha['email_alternativo']; ?>

				<input type="hidden" name="email_alternativo" size="20" value="<?= $linha['email_alternativo']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<tr>
			<td><b>Site:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input type="text" id="site" name="site" value="<?= $linha['site']; ?>"  size="30" />


			<? } else { ?>


				<?= $linha['site']; ?>

				<input type="hidden" name="site" size="20" value="<?= $linha['site']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<tr>
			<td><b>Telefone:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input class="campo-obrigatorio mask" data-masktype="telefone" type="text" id="telefone1" name="telefone1" maxlength="16" size="20" value="<?= $linha['telefone1']; ?>" /> 

				<select name="tipo_telefone1">

					<option value="Residencial" <?php if($linha['tipo_telefone1']=='Residencial'){ echo "selected=\"selected\""; } ?>>Residencial</option> 
					<option value="Celular" <?php if($linha['tipo_telefone1']=='Celular'){ echo "selected=\"selected\""; } ?>>Celular</option>
					<option value="Comercial" <?php if($linha['tipo_telefone1']=='Comercial'){ echo "selected=\"selected\""; } ?>>Comercial</option>


			<? } else { ?>


				<?= $linha['telefone1']; ?> (<?= $linha['tipo_telefone1']; ?>)

				<input type="hidden" name="telefone1" size="20" value="<?= $linha['telefone1']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<? if( $linha['telefone2'] != '' ) {?>
		<tr>
			<td><b>Telefone 2:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input class="mask" data-masktype="telefone" type="text" id="telefone2" name="telefone2" maxlength="16" size="20" value="<?= $linha['telefone2']; ?>" /> 

				<select name="tipo_telefone2">

					<option value="Residencial" <?php if($linha['tipo_telefone2']=='Residencial'){ echo "selected=\"selected\""; } ?>>Residencial</option> 
					<option value="Celular" <?php if($linha['tipo_telefone2']=='Celular'){ echo "selected=\"selected\""; } ?>>Celular</option>
					<option value="Comercial" <?php if($linha['tipo_telefone2']=='Comercial'){ echo "selected=\"selected\""; } ?>>Comercial</option>


			<? } else { ?>


				<?= $linha['telefone2']; ?> (<?= $linha['tipo_telefone2']; ?>)

				<input type="hidden" name="telefone2" size="20" value="<?= $linha['telefone2']; ?>" />

			</td>
			
			<? } ?>

		</tr>
		<? } ?>

		<? if( $linha['telefone3'] != '' ) {?>
		<tr>
			<td><b>Telefone 3:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input class="mask" data-masktype="telefone" type="text" id="telefone3" name="telefone3" maxlength="16" size="20" value="<?= $linha['telefone3']; ?>" /> 

				<select name="tipo_telefone3">

					<option value="Residencial" <?php if($linha['tipo_telefone3']=='Residencial'){ echo "selected=\"selected\""; } ?>>Residencial</option> 
					<option value="Celular" <?php if($linha['tipo_telefone3']=='Celular'){ echo "selected=\"selected\""; } ?>>Celular</option>
					<option value="Comercial" <?php if($linha['tipo_telefone3']=='Comercial'){ echo "selected=\"selected\""; } ?>>Comercial</option>


			<? } else { ?>


				<?= $linha['telefone3']; ?> (<?= $linha['tipo_telefone3']; ?>)

				<input type="hidden" name="telefone3" size="20" value="<?= $linha['telefone3']; ?>" />

			</td>
			
			<? } ?>

		</tr>
		<? } ?>

		<tr>
			
			<td colspan="2"><hr size="1" color="#CCC"></td>
		
		</tr>
		
		<tr>
			<td><b>Pessoa Contato:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input type="text" id="pessoa_contato" name="pessoa_contato" value="<?= $linha['pessoa_contato']; ?>"  size="30" />


			<? } else { ?>


				<?= $linha['pessoa_contato']; ?>

				<input type="hidden" name="pessoa_contato" size="20" value="<?= $linha['pessoa_contato']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<tr>
			<td><b>Pessoa Responsável:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input type="text" id="pessoa_responsavel" name="pessoa_responsavel" value="<?= $linha['pessoa_responsavel']; ?>"  size="30" />


			<? } else { ?>


				<?= $linha['pessoa_responsavel']; ?>

				<input type="hidden" name="pessoa_responsavel" size="20" value="<?= $linha['pessoa_responsavel']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<tr>
			
			<td colspan="2"><hr size="1" color="#CCC"></td>
		
		</tr>

		<tr>

			<td><b>CEP:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<input class="campo-obrigatorio mask" type="text" id="cep" onkeyup="return getEndereco()" onchange="return getEndereco()" name="cep" size="30" maxlength="9" value="<?= $linha['cep']; ?>">

				<? } else { ?>

				<?= ucwords($linha['cep']); ?>

				<input type="hidden" size="40" name="cep" value="<?= $linha['cep']; ?>" />

				<? } ?>

			</td>

		</tr>
		
		<tr>
			<td valign="top"><b>Endereço:</b></td>

			<td>

			<? if( $editar == '1' ) {?>


				<input type="text" class="campo-obrigatorio" id="endereco" name="endereco" value="<?= $linha['endereco']; ?>"  size="25" />
				Nº: <input type="text" class="campo-obrigatorio" size="5" name="numero" value="<?= $linha['numero']; ?>" onKeyPress="mascara(this,soNumeros);" /> <br />
		</tr>
		<tr>
			
			<td>&nbsp;</td>
			
			<td>
			<br>
			Lote: <input type="text" size="5" name="lote" value="<?= $linha['lote']; ?>" /> 
			Quadra: <input type="text" size="5" name="quadra" value="<?= $linha['quadra']; ?>" />


			<? } else { ?>


				<?= $linha['endereco']; ?>, <?= $linha['numero']; ?>
				<br><br>
				<?php if($linha['lote']!=''){ ?> <b>Lote:</b> <?= $linha['lote']; ?><?php } ?>
				<?php if($linha['quadra']!=''){ ?> <b>Quadra:</b> <?= $linha['quadra']; ?><?php } ?>

				<input type="hidden" name="endereco" size="20" value="<?= $linha['endereco']; ?>" />
				<input type="hidden" name="numero" size="20" value="<?= $linha['numero']; ?>" />
				<input type="hidden" name="lote" size="20" value="<?= $linha['lote']; ?>" />
				<input type="hidden" name="quadra" size="20" value="<?= $linha['quadra']; ?>" />

			</td>
			
			<? } ?>

		</tr>

		<tr>
			
			<td><b>Complemento:</b></td>
			
			<td>
				
				<? if( $editar == '1' ) {?>
					
					<input type="text" size="40" name="complemento" value="<?= $linha['complemento']; ?>" /> 
					
				<?php }else{ ?>
				
					 <?= $linha['complemento']; ?>
					 
					 <input type="hidden" name="complemento" size="20" value="<?= $linha['complemento']; ?>" />
				
				<?php } ?>
			</td>
			
		</tr>

		<tr>

			<td><b>Bairro:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<input class="campo-obrigatorio" type="text" size="40" name="bairro" value="<?= $linha['bairro']; ?>" />

				<? } else { ?>

				<?= ucwords($linha['bairro']); ?>

				<input type="hidden" size="40" name="bairro" value="<?= $linha['bairro']; ?>" />

				<? } ?>

			</td>

		</tr>

		<tr>

			<td><b>Cidade:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<input class="campo-obrigatorio" type="text" size="40" name="cidade" value="<?= $linha['cidade']; ?>" />

				<? } else { ?>

				<?= ucwords($linha['cidade']); ?>

				<input type="hidden" size="40" name="cidade" value="<?= $linha['cidade']; ?>" />

				<? } ?>

			</td>

		</tr>

		<tr>

			<td><b>Estado:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<select class="campo-obrigatorio" name="estado" id="estado">

						<option value=""></option>

						<option value="AC" <?php echo ($linha['estado']=='AC') ? 'selected="selected"' : ''; ?>>Acre</option>
						<option value="AL" <?php echo ($linha['estado']=='AL') ? 'selected="selected"' : ''; ?>>Alagoas</option>
						<option value="AM" <?php echo ($linha['estado']=='AM') ? 'selected="selected"' : ''; ?>>Amazonas</option>
						<option value="AP" <?php echo ($linha['estado']=='AP') ? 'selected="selected"' : ''; ?>>Amapá</option>
						<option value="BA" <?php echo ($linha['estado']=='BA') ? 'selected="selected"' : ''; ?>>Bahia</option>
						<option value="CE" <?php echo ($linha['estado']=='CE') ? 'selected="selected"' : ''; ?>>Ceará</option>
						<option value="DF" <?php echo ($linha['estado']=='DF') ? 'selected="selected"' : ''; ?>>Distrito Federal</option>
						<option value="ES" <?php echo ($linha['estado']=='ES') ? 'selected="selected"' : ''; ?>>Espírito Santo</option>
						<option value="GO" <?php echo ($linha['estado']=='GO') ? 'selected="selected"' : ''; ?>>Goiás</option>
						<option value="MA" <?php echo ($linha['estado']=='MA') ? 'selected="selected"' : ''; ?>>Maranhão</option>
						<option value="MG" <?php echo ($linha['estado']=='MG') ? 'selected="selected"' : ''; ?>>Minas Gerais</option>
						<option value="MS" <?php echo ($linha['estado']=='MS') ? 'selected="selected"' : ''; ?>>Mato Grosso do Sul</option>
						<option value="MT" <?php echo ($linha['estado']=='MT') ? 'selected="selected"' : ''; ?>>Mato Grosso</option>
						<option value="PA" <?php echo ($linha['estado']=='PA') ? 'selected="selected"' : ''; ?>>Pará</option>
						<option value="PB" <?php echo ($linha['estado']=='PB') ? 'selected="selected"' : ''; ?>>Paraíba</option>
						<option value="PE" <?php echo ($linha['estado']=='PE') ? 'selected="selected"' : ''; ?>>Pernambuco</option>
						<option value="PI" <?php echo ($linha['estado']=='PI') ? 'selected="selected"' : ''; ?>>Piauí</option>
						<option value="PR" <?php echo ($linha['estado']=='PR') ? 'selected="selected"' : ''; ?>>Paraná</option>
						<option value="RJ" <?php echo ($linha['estado']=='RJ') ? 'selected="selected"' : ''; ?>>Rio de Janeiro</option>
						<option value="RN" <?php echo ($linha['estado']=='RN') ? 'selected="selected"' : ''; ?>>Rio Grande do Norte</option>
						<option value="RO" <?php echo ($linha['estado']=='RO') ? 'selected="selected"' : ''; ?>>Rondônia</option>
						<option value="RR" <?php echo ($linha['estado']=='RR') ? 'selected="selected"' : ''; ?>>Roraima</option>
						<option value="RS" <?php echo ($linha['estado']=='RS') ? 'selected="selected"' : ''; ?>>Rio Grande do Sul</option>
						<option value="SC" <?php echo ($linha['estado']=='SC') ? 'selected="selected"' : ''; ?>>Santa Catarina</option>
						<option value="SE" <?php echo ($linha['estado']=='SE') ? 'selected="selected"' : ''; ?>>Sergipe</option>
						<option value="SP" <?php echo ($linha['estado']=='SP') ? 'selected="selected"' : ''; ?>>São Paulo</option>
						<option value="TO" <?php echo ($linha['estado']=='TO') ? 'selected="selected"' : ''; ?>>Tocantins</option>

					</select>

				<? } else { ?>

				<?= ucwords($linha['estado']); ?>

				<input type="hidden" size="40" name="estado" value="<?= $linha['estado']; ?>" />

				<? } ?>

			</td>

		</tr>

		<tr>

			<td><b>Referência:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<textarea id="referencia" name="referencia" rows="3" cols="56"><?= $linha['referencia']; ?></textarea>

				<? } else { ?>

				<?= ucwords($linha['referencia']); ?>

				<input type="hidden" size="40" name="referencia" value="<?= $linha['referencia']; ?>" />

				<? } ?>

			</td>

		</tr>

		<tr id="documentos">
			
			<td colspan="2"><hr size="1" color="#CCC" style="margin-bottom:20px"></td>
		
		</tr>

<tr>
<td valign="top"><b>Documentos:</b></td>

		<td style="font-size:12px;">
			<?php
			
			$documentos = array();
			$documentos = json_decode($linha['documentos'], true);

			
			?>
			
			<?php
			
			if( gettype($documentos) == 'array')
			{
				foreach($documentos as $documento)
				{
			?>

				<?php

				if( strstr($documento, 'cnh') )
				{
				
					echo "CNH: ";
				
				}elseif( strstr($documento, 'compres') ){
					
					echo "Comp. Residência: ";
					
				}elseif (strstr($documento, 'nfisc')) {
					
					echo "N.Fiscal: ";

				}elseif (strstr($documento, 'docdut')) {
					
					echo "D.U.T.: ";
				}	

				$t1 = explode(".", $documento);
				$t2 = explode("-", $t1[0]);
				
				$time = $t2[count($t2)-2];
				?>
				<a href="#" onclick="Popup=window.open('upload/techinmove/<?php echo $documento; ?>','Popup-doc','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,left=430,top=30');"> <?php echo $documento; ?></a> ( Em: <?php echo date("d/m/Y", $time);?> )<br><br>
			<?php
				}
			}
			?>
			<?php
			if( ($USUARIO['tipo_usuario']== 'ADMINISTRADOR' && $editar==1) || ($USUARIO['inserir_gravacao'] == '1' && $editar==1) )
				{
			?>
			<select id="tipo_documento" name="tipo_documento">
				<option value="cnh">CNH</option>
				<option value="compres">Comp. Residência</option>
				<option value="nfisc">Nota Fiscal</option>
				<option value="docdut">D.U.T.</option>
			</select>
			<input id="file" type="file" name="arquivo" style="border-left: 1px solid #CCCCCC; padding-left:3px;display:block; float:left; clear:both;" />
			
			<?php } ?>
		</td>
	



</tr>
<a name="documentos"></a>		

		
		<tr>
			
			<td colspan="2"><hr size="1" color="#CCC"></td>
		
		</tr>
		<tr>

			<td><b>Produto:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<select class="campo-obrigatorio" id="produto" name="produto">

						<option value=""></option>

						<option value="SITE STANDART" <?php echo ($linha['produto']=='SITE STANDART') ? 'selected="selected"' : ''; ?>>SITE STANDART</option>
						<option value="SITE PERSONALIZADO" <?php echo ($linha['produto']=='SITE PERSONALIZADO') ? 'selected="selected"' : ''; ?>>SITE PERSONALIZADO</option>
						
						<option value=""></option>

						<option value="CATÁLOGO STANDART 50 PRODUTOS" <?php echo ($linha['produto']=='CATÁLOGO STANDART 50 PRODUTOS') ? 'selected="selected"' : ''; ?>>CATÁLOGO STANDART 50 PRODUTOS</option>
						<option value="CATÁLOGO STANDART 100 PRODUTOS" <?php echo ($linha['produto']=='CATÁLOGO STANDART 100 PRODUTOS') ? 'selected="selected"' : ''; ?>>CATÁLOGO STANDART 100 PRODUTOS</option>
						<option value="CATÁLOGO STANDART 250 PRODUTOS" <?php echo ($linha['produto']=='CATÁLOGO STANDART 250 PRODUTOS') ? 'selected="selected"' : ''; ?>>CATÁLOGO STANDART 250 PRODUTOS</option>
						<option value="CATÁLOGO STANDART 500 PRODUTOS" <?php echo ($linha['produto']=='CATÁLOGO STANDART 500 PRODUTOS') ? 'selected="selected"' : ''; ?>>CATÁLOGO STANDART 500 PRODUTOS</option>

						<option value=""></option>

						<option value="CATÁLOGO PAGSEGURO 50 PRODUTOS" <?php echo ($linha['produto']=='CATÁLOGO PAGSEGURO 50 PRODUTOS') ? 'selected="selected"' : ''; ?>>CATÁLOGO PAGSEGURO 50 PRODUTOS</option>
						<option value="CATÁLOGO PAGSEGURO 100 PRODUTOS" <?php echo ($linha['produto']=='CATÁLOGO PAGSEGURO 100 PRODUTOS') ? 'selected="selected"' : ''; ?>>CATÁLOGO PAGSEGURO 100 PRODUTOS</option>
						<option value="CATÁLOGO PAGSEGURO 250 PRODUTOS" <?php echo ($linha['produto']=='CATÁLOGO PAGSEGURO 250 PRODUTOS') ? 'selected="selected"' : ''; ?>>CATÁLOGO PAGSEGURO 250 PRODUTOS</option>
						<option value="CATÁLOGO PAGSEGURO 500 PRODUTOS" <?php echo ($linha['produto']=='CATÁLOGO PAGSEGURO 500 PRODUTOS') ? 'selected="selected"' : ''; ?>>CATÁLOGO PAGSEGURO 500 PRODUTOS</option>

						<option value=""></option>

						<option value="LOJA VIRTUAL" <?php echo ($linha['produto']=='LOJA VIRTUAL') ? 'selected="selected"' : ''; ?>>LOJA VIRTUAL</option>

					</select>

				<? } else { ?>

				<?= ucwords($linha['produto']); ?>

				<input type="hidden" size="40" name="produto" value="<?= $linha['produto']; ?>" />

				<? } ?>

			</td>

		</tr>

		<tr>

			<td></td>

			<td>
				<? if( $editar == '1' ) {?>
					Valor:
					<input class="campo-obrigatorio mask" value="<?php echo $linha['valor_produto']; ?>" data-masktype="moeda" class="campo-obrigatorio" id="valor_produto" name="valor_produto" type="text" style="width:120px;">

					Pagamento:
					<select class="campo-obrigatorio" id="forma_pagamento_produto" name="forma_pagamento_produto">
					
						<option <? if($linha['forma_pagamento_produto'] == 'Boleto'){?> selected="selected" <? } ?>>Boleto</option>
						<option <? if($linha['forma_pagamento_produto'] == 'Cartão de Crédito'){?> selected="selected" <? } ?>>Cartão de Crédito</option>
						<option <? if($linha['forma_pagamento_produto'] == 'Cheque'){?> selected="selected" <? } ?>>Cheque</option>
						<option <? if($linha['forma_pagamento_produto'] == 'Dinheiro'){?> selected="selected" <? } ?>>Dinheiro</option>
					
					</select>
				<? } else { ?>
				
				R$ <?= number_format($linha['valor_produto'], 2, ",", "."); ?> pago com <b><?php echo $linha['forma_pagamento_produto']; ?></b>

				<input type="hidden" size="40" name="valor_produto" value="<?= $linha['valor_produto']; ?>" />
				<input type="hidden" size="40" name="forma_pagamento_produto" value="<?= $linha['forma_pagamento_produto']; ?>" />

				<? } ?>
				
				
				<div class="dados-cartao" <?php if($linha['forma_pagamento_produto']!='Cartão de Crédito') { echo 'style="display:none;"'; } ?>>
					
					<h5 style=" color:#0066CC; font-weight:normal; margin-bottom:5px;">Dados do Cartão</h5>

					<span>Bandeira:
						<select id="cartao_bandeira" name="cartao_bandeira">
						
							<option value=""></option>

							<option value="Visa" <? if($linha['cartao_bandeira'] == 'Visa'){?> selected="selected" <? } ?>>Visa</option>
							<option value="MasterCard" <? if($linha['cartao_bandeira'] == 'MasterCard'){?> selected="selected" <? } ?>>MasterCard</option>
							<option value="Hipercard" <? if($linha['cartao_bandeira'] == 'Hipercard'){?> selected="selected" <? } ?>>Hipercard</option>
							<option value="American Express" <? if($linha['cartao_bandeira'] == 'American Express'){?> selected="selected" <? } ?>>American Express</option>
						
						</select>
					</span>
					<br>
					<span>Titular: </span><span><input type="text" size="30" name="cartao_titular" placeholder="Nome conforme escrito no cartão" value="<?php echo $linha['cartao_titular']; ?>"></span>
					<br>
					<span>Número Cartao: <input type="text" class="campo-obrigatorio mask" data-masktype="cartao" name="cartao_numero" size="40" maxlength="19" value="<?=$linha['cartao_numero'];?>" placeholder="9999-9999-9999-9999" /> </span>
					<br>
					<span>
						Validade:
						<input type="text" class="validade-cartao" size="2" name="cartao_validade" value=<?php echo $linha['cartao_validade'];?>>
					</span>

					<span>Cód. Seg.: </span><span><input type="text" name="cartao_codseg" size="1" onKeyPress="mascara(this,cartaocredito)" onChange="mascara(this,cartaocredito)" maxlength="3" value="<?=$linha['cartao_codseg'];?>" /> </span><span style="font-size:12px; color:#666">(3 últimos digitos no verso)</span>

				</div>

			</td>

		</tr>
		
		<tr>
			
			<td colspan="2"><hr size="1" style="border-bottom: 1px dashed #EDEDED;" color="#FFF" /></td>
		
		</tr>
		
		<tr>

			<td valign="top"><b>Mensalidade:</b></td>

			<td>

				<? if( $editar == '1' ) {?>

					Vencimento:
					<select class="campo-obrigatorio" id="vencimento" name="vencimento">

						<option value="5" <?php echo ($linha['vencimento']=='5') ? 'selected="selected"' : ''; ?>>5</option>
						<option value="10" <?php echo ($linha['vencimento']=='10') ? 'selected="selected"' : ''; ?>>10</option>
						<option value="15" <?php echo ($linha['vencimento']=='15') ? 'selected="selected"' : ''; ?>>15</option>
						<option value="20" <?php echo ($linha['vencimento']=='20') ? 'selected="selected"' : ''; ?>>20</option>

					</select>

					Valor:
					<input class="campo-obrigatorio mask" data-masktype="moeda" class="campo-obrigatorio" id="mensalidade" name="mensalidade" value="<?php echo $linha['mensalidade']; ?> type="text" style="width:120px;">

					<br><br>

					Forma Pagamento:
					<select class="campo-obrigatorio" id="forma_pagamento_mensalidade" name="forma_pagamento_mensalidade">
					
						<option value="Boleto" <?php echo ($linha['forma_pagamento_mensalidade']=='Boleto') ? 'selected="selected"' : ''; ?>>Boleto</option>
						<option value="Cartão de Crédito" <?php echo ($linha['forma_pagamento_mensalidade']=='Cartão de Crédito') ? 'selected="selected"' : ''; ?>>Cartão de Crédito</option>
						<option value="Cheque" <?php echo ($linha['forma_pagamento_mensalidade']=='Cheque') ? 'selected="selected"' : ''; ?>>Cheque</option>
						<option value="Dinheiro" <?php echo ($linha['forma_pagamento_mensalidade']=='Dinheiro') ? 'selected="selected"' : ''; ?>>Dinheiro</option>
					
					</select>
				
				<? } else { ?>

				R$ <?= number_format($linha['mensalidade'], 2, ",", "."); ?> pago com <b><?php echo $linha['forma_pagamento_mensalidade']; ?></b>

				<input type="hidden" size="40" name="mensalidade" value="<?= $linha['mensalidade']; ?>" />
				<input type="hidden" size="40" name="forma_pagamento_produto" value="<?= $linha['forma_pagamento_mensalidade']; ?>" />

				<? } ?>

				<div class="dados-cartao-mensalidade" <?php if($linha['forma_pagamento_mensalidade']!='Cartão de Crédito') { echo 'style="display:none;"'; } ?>>
					
					<h5 style=" color:#0066CC; font-weight:normal; margin-bottom:5px;">Dados do Cartão</h5>

					<span>Bandeira:
						<select id="cartao_mensalidade_bandeira" name="cartao_mensalidade_bandeira">
						
							<option value=""></option>

							<option value="Visa" <? if($linha['cartao_mensalidade_bandeira'] == 'Visa'){?> selected="selected" <? } ?>>Visa</option>
							<option value="MasterCard" <? if($linha['cartao_mensalidade_bandeira'] == 'MasterCard'){?> selected="selected" <? } ?>>MasterCard</option>
							<option value="Hipercard" <? if($linha['cartao_mensalidade_bandeira'] == 'Hipercard'){?> selected="selected" <? } ?>>Hipercard</option>
							<option value="American Express" <? if($linha['cartao_mensalidade_bandeira'] == 'American Express'){?> selected="selected" <? } ?>>American Express</option>
						
						</select>
					</span>
					<br>
					<span>Titular: </span><span><input type="text" size="30" value="<? echo $linha['cartao_mensalidade_titular']; ?>" name="cartao_mensalidade_titular" placeholder="Nome conforme escrito no cartão"></span>
					<br>
					<span>Número Cartao: <input type="text" class="campo-obrigatorio mask" data-masktype="cartao" name="cartao_mensalidade_numero" size="40" maxlength="19" value="<? echo $linha['cartao_mensalidade_numero'];?>" placeholder="9999-9999-9999-9999" /> </span>
					<br>
					<span>
						Validade:
						<input type="text" class="validade-cartao" name="cartao_mensalidade_validade" value="<?php echo $linha['cartao_mensalidade_validade'];?>" size="2">
					</span>

					<span>Cód. Seg.: </span><span><input type="text" name="cartao_mensalidade_codseg" size="1"  maxlength="3" value="<?=$linha['cartao_mensalidade_codseg'];?>" /> </span><span style="font-size:12px; color:#666">(3 últimos digitos no verso)</span>
				</div>
			</td>

		</tr>


		<tr>
			
			<td colspan="2"><hr size="1" color="#CCC"></td>
		
		</tr>

		<?php if($editar=='1'){ ?>
		<tr>

			<td valign="top"><b>Novo Contato:</b></td>

			<td>
				<? if( $editar == '1' ) {?>
					
					<select id="novocontato" name="novocontato">

						<option value="">Selecione o tipo de contato</option>

						<option value="email">Email</option>
						<option value="telefonema">Telefonema</option>
						<option value="visita">Visita</option>

					</select>
					
					<br><br>
					
					<textarea id="obsnovocontato" name="obsnovocontato" placeholder="Observação do contato" cols="56"></textarea>

				<? } else { ?>

				<?= ucwords($linha['produto']); ?>

				<input type="hidden" size="40" name="produto" value="<?= $linha['produto']; ?>" />

				<? } ?>

			</td>

			<tr><td>&nbsp;</td></tr>

		</tr>
		
		<?php } ?>
		
		<?php
		
		if($linha['contatos']!=''){
			
			$contatos = json_decode($linha['contatos']);
			
			echo "<tr>";
			echo "<td valign=\"top\"><b>Contatos:</b></td>";
			echo "<td>";
	
			foreach($contatos as $contato){
			?>

				<span style="color:#787878; font-size:11px;">
				<b><?= ucwords($contato->tipo);?> por <?= $contato->usuario;?> </b> em <?= $contato->data;?>
				</span><br />
				<?= $contato->obs;?>
				<br><br>

			<?php
			}
			
			echo "</td>";
			echo "</tr>";
		}
		?>

		<tr>

			<td><b>Data Venda:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<input class="campo-obrigatorio datepicker" type="text" value="<?php echo $linha['data_venda']; ?>" maxlength="10" onkeypress="mascara(this,data)" size="10" name="data_venda">

				<? } else { ?>

				<?= $linha['data_venda']; ?>

				<input type="hidden" size="40" name="data_venda" value="<?= $linha['data_venda']; ?>" />

				<? } ?>

			</td>

		</tr>
		
		<tr><td colspan="2">&nbsp;</td></tr>
		
		<?php if($linha['data_finalizada']!=''){ ?>

		<tr>

			<td><b>Data Finalizada:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<input class="campo-obrigatorio datepicker" type="text" value="<?php echo $linha['data_finalizada']; ?>" maxlength="10" onkeypress="mascara(this,data)" size="10" name="data_finalizada">

				<? } else { ?>

				<?= $linha['data_finalizada']; ?>

				<input type="hidden" size="40" name="data_finalizada" value="<?= $linha['data_finalizada']; ?>" />

				<? } ?>

			</td>

		</tr>
		
		<?php } ?>
		
		<? if( $editar == '1' ) {?>
		<tr>

			<td><b>Nova Obs.:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<input type="text" size="40" autocomplete="off" name="obs">

				<? } else { ?>

				<?= $linha['data_finalizada']; ?>

				<input type="hidden" size="40" name="cep" value="<?= $linha['data_finalizada']; ?>" />

				<? } ?>

			</td>

		</tr>		
		<? } ?>
		<tr><td>&nbsp;</td></tr>

		<?php
		
		if($linha['observacoes']!=''){
			
			$observacoes = json_decode($linha['observacoes']);
			
			echo "<tr>";
			echo "<td valign=\"top\"><b>Observações:</b></td>";
			echo "<td>";
	
			foreach($observacoes as $observacao){
			?>

				<span style="color:#787878; font-size:11px;">
				<? if($observacao->foto!=''){?>
				<img src="img/fotos/<?= $observacao->foto;?>.jpg" class="fotouser" border="1" width="40" align="left" />
				<? } ?>
				<b> <?= $observacao->usuario;?> </b> em <?= $observacao->data;?>
				</span><br />
				<?= utf8_encode($observacao->obs);?>
				<br><br>

			<?php
			}
			
			echo "</td>";
			echo "</tr>";
		}
		?>

		
		<tr>

			<td><b>Status:</b></td>

			<td>
				<? if( $editar == '1' ) {?>

					<select class="campo-obrigatorio" id="status" name="status">
					
						<option>Status1</option>
						<option>Status2</option>
						<option>Status3</option>
						<option>Status4</option>
					
					</select>

				<? } else { ?>

				<?= ucwords($linha['status']); ?>

				<input type="hidden" size="40" name="status" value="<?= $linha['status']; ?>" />

				<? } ?>

			</td>

		</tr>

		<tr><td colspan="2">&nbsp;</td></tr>
		
		<tr><td colspan="2"><div id="uploader" style="border-radius:0.5em !important"></div></td></tr>

<?

$conGravacaoRetirada = $conexao->query("SELECT *, 
												usuarios.nome AS nome,
												DATE_FORMAT(log_sistema.data, '%d/%m/%Y às %H:%i:%s') AS dataevento
												FROM log_sistema 
												INNER JOIN usuarios
												ON usuarios.id = log_sistema.usuario
												WHERE  
												log_sistema.evento LIKE '%Excluiu uma gravação%' && 
												log_sistema.evento LIKE '%(ID: ".$_GET['id'].")%' 
												ORDER BY log_sistema.id ASC
										");
										
while($GravacaoRetirada = mysql_fetch_array($conGravacaoRetirada)){										

$gravacaoRE = explode('[',$GravacaoRetirada['evento']);
$gravacaoRE = explode(']',$gravacaoRE[1]);
$gravacaoRE = $gravacaoRE[0];

?>

<tr>
<td><b>Gravação retirada:</b></td>
<td>
<img src="img/play-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Ouvir Gravação" onClick="javascript:window.location = 'http://172.16.0.30/audio/clarofixo/orig/<?= $gravacaoRE;?>'" /> <span style="font-size:13px;">Ouvir Gravação </span>
<br />
<span style="color:#787878; font-size:11px;">
<b>Retirada por:</b> <?= $GravacaoRetirada['nome'];?>&nbsp;
em <?= $GravacaoRetirada['dataevento'];?>
</span>
</td>
</tr>


<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<? } ?>


</form>

</table>

<br />
<br />

<? if( ($USUARIO['id']== 3179 && $_GET['e']==1) || ($editar == '1' || $editar_instalacao == '1') || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'LOGISTICA') || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR' && $linha['status'] == 'DEVOLVIDO') || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR' && ($linha['status'] == 'SEM CONTATO' || $linha['status'] == 'SEM COBERTURA'))) {?>

<center>

<img class="bt-submit-form" data-formulario="editar" src="img/salvar.png" height="25" style="cursor:pointer" />

<img src="img/cancelar.png" height="25" onClick="window.location = '?id=<?= $_GET['id'];?>'" style="cursor:pointer" />

</center>

<? } else {?>

<center>

<? if($USUARIO['editar_dados'] == 1 || $USUARIO['editar_instalacao'] == 1 || ($USUARIO['tipo_usuario'] == 'LOGISTICA') || ($USUARIO['tipo_usuario'] == 'MONITOR' && ($linha['status'] == 'DEVOLVIDO' || $linha['status'] == 'SEM CONTATO' || $linha['status'] == 'SEM COBERTURA') ) ){?>


<img src="img/editar.png" height="25" onClick="window.location = '?id=<?= $_GET['id'];?>&e=1'" style="cursor:pointer" /> 

<? } ?>

<img src="img/imprimir.png" height="25" onClick="javascript:print();" style="cursor:pointer" />

</center>

<? } ?>


</body>

</html>
