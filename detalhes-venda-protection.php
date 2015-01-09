<?
date_default_timezone_set("Brazil/East");

if (!isset($_SESSION)) {

	session_start();

}

include_once "conexao.php";
include_once "lib/class.Usuarios.php";
include_once "lib/class.VentoAdmin.php";
include_once "lib/class.Venda.php";
include_once "lib/class.VendaStatus.php";
include_once "lib/class.ProtectionAgendamento.php";

include_once "includes/protectionGlobalsVars.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>

		<title>Detalhes Venda Claro Fixo</title>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

		<style type="text/css">
			body{margin: 0 0 0 0; font-family:Arial, Helvetica, sans-serif;}

			#topo{position:relative; background:url(img/topo-bg.png) repeat-x; top:0px; height:120px; width:100%;}
		</style>
		
		<link rel="stylesheet" type="text/css" href="css/style-autocomplete.css" />
		<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.7.3.custom.css" />
		<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>
		<script type="text/javascript" src="js/jquery.mockjax.js"></script>
		<script type="text/javascript" src="js/jquery.autocomplete.js"></script>
		<!-- <script type="text/javascript" src="js/protectionDetalhes.js"></script> -->
		<script type="text/javascript" src="js/protection.js"></script>
		<script type="text/javascript" src="js/calendario.js"></script>

<script type="text/javascript" src="js/pekeUpload-protection.js"></script>
<link rel="stylesheet" type="text/css" href="css/custom.css" />
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


	</head>

<?
// Verificar se está logado
if( ! isset($_SESSION['usuario']) ) { ?>

	<script type="text/javascript">

		window.location = 'index.php';

	</script>


<? 
}

$consulta = $conexao->query("SELECT * FROM vendas_clarotv WHERE id = '".$_GET['id']."'");
$linha = mysql_fetch_array($consulta);

$venda = new Venda($linha['id']);

$conUSUARIO = $conexao->query("SELECT * FROM usuarios WHERE id = '".$_SESSION['usuario']."'");
$USUARIO = mysql_fetch_array($conUSUARIO);


if ( $_GET['e'] == '1' && $USUARIO['editar_dados'] == '1') { 
	
	$editar = '1';

}

if ( $_GET['e'] == '1' && $USUARIO['editar_instalacao'] == '1' ) {
	
	$editar_instalacao = '1';
	
}

///////////////////////////////////

		// ##################### Verifica campos em branco para finalizar venda ######################
$campos = array(

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
	"tipoplano" => "Tipo de Plano",
	"pagamento" => "Forma de Pagamento",
	"idata" => "Data da Venda",
	"vencimento" => "Dia do Vencimento",
	"status" => "Status"
);


if( isset($_POST['nome']) ) {

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
	
	// Dados Veiculo
	
	$protectionVeiculo = $_POST['fipeVeiculo'];
	$protectionMarca = $_POST['fipeMarca'];
	$protectionModelo = $_POST['fipeModelo'];
	$protectionAnoModelo = $_POST['fipeAno_modelo'];
	$protectionCilindrada = $_POST['motoCilindrada'];
	$protectionRastreador = $_POST['adicionalRastreador'];
	$protectionGnv = $_POST['adicionalGnv'];
	$protectionValorVeiculo = $_POST['valorVeiculo'];
	$protectionTxAdesao = $_POST['txAdesao'];
	$protectionMensalidade = $_POST['valorMensalidade'];

	// Agendamento e reagendamento de visita

	$dataVisita = $_POST['agendamentoProtection'];
	$horarioVisita = $_POST['horario-visita'];
	
	
	if ( $dataVisita != '' &&  $horarioVisita != '' ) {
		
		$dataVisita = explode('/', $dataVisita);
		
		$objDataAgendamento = new DateTime($dataVisita[2]."-".$dataVisita[1]."-".$dataVisita[0]. " " . $horarioVisita);
		
		if ( $linha['protectionDataVisita'] != $objDataAgendamento->format('Y-m-d H:i:s') ) {
			
			if (! protectionAgendamento::checarHorario($objDataAgendamento, $conexao) ) {

				$varerros = "A data de agendamento de escolhida não está disponível.";

			} else {

			$ptcNovoAgendamento = protectionAgendamentoFactory::Create($objDataAgendamento, $conexao);
			
			//novo agendamento

			}
			
			
		}

	} else {

		$varerros = "Data de agendamento de visita inválida. Verifique se a data e horario estão corretos.";
	}
	

	// Agendamento gravação

	/*
	if ( $_POST['agendagravacao'] ) {

		$diaGravacao = explode('/',$_POST['agendagravacao']);

		$agendGravacao = $diaGravacao[2].'-'.$diaGravacao[1].'-'.$diaGravacao[0].' '.$_POST['agendagravacaohora'].':'.$_POST['agendagravacaominutos'].':00';

	} else {

		$agendGravacao = $linha['agendagravacao'];

	}

	if($_POST['agendaentrega']) {

		$diaEntrega = explode('/',$_POST['agendaentrega']);

		$agendEntrega = $diaEntrega[2].'-'.$diaEntrega[1].'-'.$diaEntrega[0].' '.$_POST['agendaentregahora'].':'.$_POST['agendaentregaminutos'].':00';

	} else {
	
		$agendEntrega = $linha['agendaentrega'];
	
	}
	*/
	// Dados da Instalação

	$data_marcada0 = explode('/',$_POST['dataentrega']);
	$data_entrega = $data_marcada0[2].$data_marcada0[1].$data_marcada0[0];

	if($editar == '1' && $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && $_POST['datainstalacao']!='') {

		if($_POST['status'] == 'FINALIZADA') {

			$data_finalizada = explode('/',$_POST['datainstalacao']);
			$data_finalizada = $data_finalizada[2].$data_finalizada[1].$data_finalizada[0];

		}else{

			$data_finalizada = '';

		}

	}else{

		if($linha['data_instalacao'] == '' && $_POST['status'] == 'FINALIZADA') {

			$data_finalizada = date("Ymd");

		}else{

			$data_finalizada = '';

		}
	}



	// Motivos
	$motivo_restricao = $_POST['motivorestricao'];
	$motivo_cancelamento = $_POST['motivocancelamento'];
	$motivo_devolvido = $_POST['motivodevolvido'];
	$pendencia = $_POST['pendencia'];
	$dataLiberacao0 = explode('/',$_POST['dataliberacao']);
	$dataLiberacao = $dataLiberacao0[2].$dataLiberacao0[1].$dataLiberacao0[0];

	// Observações

	if(strlen($_POST['obsgravacao']) > 3) {
		
		$obs1 = $_POST['obsgravacao'];	
	
		$insertOBS1 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','1','".$obs1."')");
		
	}

	if(strlen($_POST['obsentrega']) > 3) {
		
		$obs2 = $_POST['obsentrega'];	
	
		$insertOBS2 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','2','".$obs2."')");

	}

	if(strlen($_POST['obsfinalizada']) > 3) {
		
		$obs3 = $_POST['obsfinalizada'];	
	
		$insertOBS3 = $conexao->query("INSERT INTO observacoes (id_venda,id_produto,id_usuario,data,tipo,observacao) VALUES ('".$_GET['id']."','3','".$USUARIO['id']."','".date("Y-m-d H:i:s")."','3','".$obs3."')");

	}


	if($_POST['status'] == 'RECUPERADO') {

		$obs_recuperacao = $_POST['obsrecuperacao'];

		if($obs_recuperacao) {

			$usuario_recuperacao = $USUARIO['id'];	
			$data_recuperacao = date('Y-m-d H:i:s');
		}
	}

	// Cartão

	$titularCartao = $_POST['titularCartao'];

	if(strstr($_POST['numcartao'],'XXXX-XXXX')) {
	
		$numCar = $linha['numCar'];

	} else {

		$numCar = base64_encode($_POST['numcartao']);

	}


	if(strstr($_POST['numcodseguranca'],'XX')) {

		$codSeg = $linha['codSeg'];

	} else {

		$codSeg = $_POST['numcodseguranca'];
	}

	$carVal = $_POST['mesval'].'/'.$_POST['anoval'];

	$carBan = $_POST['carbandeira'];


	$numParcelas = $_POST['numparcelas'];


	if($_POST['status'] == '') {
		
		$status = $linha['status'];
	
	} else if($_POST['status'] == 'RECUPERADO') {
		
		$status = 'PRE-ANALISE'; 
	
	} else {
		
		$status = $_POST['status']; 
	}

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


	if($_POST['agendaentrega'] == "00/00/0000" || $_POST['agendaentrega'] == "") {

		$dataAgenEntrega = $_POST['agendaentrega'];
		
		$diaEntrega = explode('/',$dataAgenEntrega);

		$agendEntrega = $diaEntrega[2].'-'.$diaEntrega[1].'-'.$diaEntrega[0].' 09:00:00';

	}
	
	if( strtoupper($_POST['status'])=='FINALIZADA' ){
		$camposInvalidos = array();
		
		//verificar documentos
		
		// *********** Faz as validacoes ************
		
		if( ($linha['status']!='FINALIZADA') || ($linha['status']=='FINALIZADA' && $USUARIO['tipo_usuario'] != 'ADMINISTRADOR')  ) {

			$excep = array("lote", "quadra", "complemento", "os", "esn", "novonumero","numchip","itelefone3","tipotel3","pontoref");
			validarCampos($campos, $excep);

		}
	}
		
		
		// ######################################################################


	function recarregarDadosForm() { ?>
	
		<script type="text/javascript">
			
			$(window).load( function() {

				<? foreach($_POST as $key=>$val) { ?>
					
					$("[name='<?=$key;?>']").val("<?=$_POST[$key];?>");
				 <?	
				}
				 ?>
	
			});
	
		</script>
	
<?  }



	//////////////////////
	// Atualizar Dados //
	////////////////////

	$iDataC = date("Y-m-d H:i:s");

	if(!$varerros) {
	
		$sucesso ="Sucesso: Dados atualizados!";
	
		if($numchip===false) {
			
			$numchipUp = '';
		
		}else{
		
			$numchipUp = $numchip;
		}
	
		$statusAntigo = $linha['status'];
	
		$update = $conexao->query("UPDATE vendas_clarotv SET os = '".$os."', esn = '".$esn."', novoNumero = '".$novoNumero."', nome = '".$nome."', nascimento = '".$nascimento."', cpf = '".$cpf."', rg = '".$rg."', org_exp = '".$org_exp."', profissao = '".$profissao."', sexo = '".$sexo."', estado_civil = '".$estado_civil."', email = '".$email."', telefone = '".$telefone."', tipo_tel1 = '".$tipo_tel1."', telefone2 = '".$telefone2."', tipo_tel2 = '".$tipo_tel2."', telefone3 = '".$telefone3."', tipo_tel3 = '".$tipo_tel3."', endereco = '".$endereco."', numero = '".$numero."', lote = '".$lote."', quadra = '".$quadra."', complemento = '".$complemento."', bairro = '".$bairro."', cidade = '".$cidade."', uf = '".$uf."', cep = '".$cep."', ponto_referencia = '".$ponto_referencia."', operador = '".$operador."', monitor = '".$monitor."', tipoLinha = '".$tipoLinha."', tipoAssinatura = '".$tipoAssinatura."', tipoPlano = '".$tipoPlano."', plano = '".$plano."', valorPlano = '".$valorPlano."', aparelho = '".$aparelho."', valorAparelho = '".$valorAparelho."', pagamento = '".$pagamento."', tipoEntrega = '".$tipoEntrega."', id_pagseguro = '".$id_pagseguro."', banco_deposito = '".$banco_deposito."', agencia_deposito = '".$agencia_deposito."', contacorrente_deposito = '".$contacorrente_deposito."', status = '".$status."', data = '".$data."', vencimento = '".$vencimento."', agendGravacao = '".$agendGravacao."', agendEntrega = '".$agendEntrega."', motivo_restricao = '".$motivo_restricao."',motivo_cancelamento = '".$motivo_cancelamento."', motivo_devolvido = '".$motivo_devolvido."', pendencia = '".$pendencia."', dataLiberacao = '".$dataLiberacao."', obs_recuperacao = '".$obs_recuperacao."', usuario_recuperacao = '".$usuario_recuperacao."', data_recuperacao = '".$data_recuperacao."', data_marcada = '".$data_entrega."', data_instalacao = '".$data_finalizada."', titularCartao = '".$titularCartao."', numCar = '".$numCar."', codSeg = '".$codSeg."', carVal = '".$carVal."', carBan = '".$carBan."', numParcelas = '".$numParcelas."', numchip = '".$numchipUp."', protectionVeiculo = '".$protectionVeiculo."', protectionMarca = '".$protectionMarca."', protectionModelo = '".$protectionModelo."', protectionAnoModelo = '".$protectionAnoModelo."', protectionCilindrada = '".$protectionCilindrada."', protectionRastreador = '".$protectionRastreador."', protectionGnv = '".$protectionGnv."', protectionValorVeiculo = '".$protectionValorVeiculo."', protectionTxAdesao = '".$protectionTxAdesao."', protectionMensalidade = '".$protectionMensalidade."' WHERE id = '".$_GET['id']."' ") or die('Ocorreu um Erro ao inserir os dados!');

		if ( isset($ptcNovoAgendamento) ) {
			
			$ptcNovoAgendamento->novoAgendamento($objDataAgendamento, $venda);
			
		}
		
		if ( strtoupper($_POST['status']) != strtoupper($linha['status']) ) {
			
			$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Atualizou status de " . strtoupper($linha['status']) . " para " . strtoupper($_POST['status']) . " (ID: ".$_GET['id'].").')");
		}
	
		if ( strtoupper($_POST['esn']) != strtoupper($linha['esn']) ) {
			
			$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Atualizou esn de " . strtoupper($linha['esn']) . " para " . strtoupper($_POST['esn']) . " (ID: ".$_GET['id'].").')");
		}

		if ( strtoupper($data_finalizada) != strtoupper($linha['data_instalacao']) ) {
			
			$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Atualizou data instalacao de " . $linha['data_instalacao'] . " para " . $data_finalizada . " (ID: ".$_GET['id'].").')");
		}


		if($_POST['status'] == strtoupper('FINALIZADA') && ( strtoupper($_POST['status']) != strtoupper($statusAntigo) )  && ($_POST['tipoEntrega'] == 'PRONTA ENTREGA' || $_POST['tipoEntrega'] == 'MOTOBOY INTERNO' || $_POST['tipoEntrega'] == 'MOTOBOY EXTERNO')) {
			
			$query = "Update ESNsSaida set status='Vendido' WHERE esn = '$esn' && status='Em Estoque'";
			$conexao->query($query);
	
			$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Baixa de ESN: $esn (ID: ".$_GET['id'].").')");
		}
		
		if($numchip!=false) {
				
			$query = "Update ESNsSaida set status='Vendido' WHERE esn = '$numchip' && status='Em Estoque'";
			$conexao->query($query);
		
			$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$iDataC."','".$_SESSION['usuario']."','Baixa de CHIP: $numchip (ID: ".$_GET['id'].").')");

		}

	}

	/////////////////
	// Insert LOG //
	///////////////

	$data = date("Y-m-d H:i:s");

	$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$_SESSION['usuario']."','Atualizou um dado no sistema (ID: ".$_GET['id'].").')");

	?>

	<script type="text/javascript">

	<? if(!$varerros) { ?>
		
			alert('<?php echo $sucesso; ?>');
			window.location = '?id=<?= $_GET['id'];?>';
		
		<?
		} else {
		?>
		
			alert('<?php echo $varerros; ?>');
		
		<? } ?>

	</script>

<?
}
//recarregarDadosForm();



////////////////////////////////////
////// EXCLUIR GRAVAÇÃO ///////////
//////////////////////////////////

if(isset($_POST['excluirgravacao'])) {
	
	$excluirgravacao = $conexao->query("UPDATE vendas_clarotv SET auditor = '', gravacao = '' WHERE id = '".$_GET['id']."'");

	/////////////////
	// Insert LOG //
	///////////////

	$data = date("Y-m-d H:i:s");

	$insert_log = $conexao->query("INSERT into log_sistema (data,usuario,evento) VALUES ('".$data."','".$_SESSION['usuario']."','Excluiu uma gravação: [".$linha['gravacao']."] (ID: ".$_GET['id'].") .')");
	?>
	
	<script type="text/javascript">

		window.alert('Gravação excluída com sucesso!');

		window.location = '?e=1&id=<?= $_GET['id'];?>';


	</script>    	


<?	
}
?>

<script type="text/javascript">

	///////////////////////////////////////////

	/////////////// VALIDAÇÃO ////////////////	

	/////////////////////////////////////////



	function validar(){

	 document.forms.editar.submit();

	 return true;
		cpf = $('input[name="icpf"]').val();
		gravacao = '<?= $linha['gravacao'];?>';
		tecnico = $('select[name="tecnico"]').val();
		datainstalacao = $('input[name="datainstalacao"]').val();
		os = $('input[name="os"]').val();
		ostam = os.length;
		//////////	

		status = $('select[name="status"]').val();
		erro = 0;

		// :: verifica os :: //
		if(ostam > 0 && ostam < 8){

			alert("OS Inválida");

			$('input[name="os"]').focus();

			erro = erro+1;
			stop();

		}

	}
	$(window).load(function() {
	
		//validaru();
		checkAgendEntrega();
		
		$("#pagamento").change( 
	
		
			function ()
			{
				checkAgendEntrega();
				
				nParcelas = $("[name='numparcelas']").val();
				

				if( $(this).val()=='PAGSEGURO' )
				{

					var campos = '<option value=""></option>\
								<option value="1">1</option>\
								<option value="2">2</option>\
								<option value="3">3</option>\
								<option value="4">4</option>\
								<option value="5">5</option>\
								<option value="6">6</option>\
								';
					
					$("[name='numparcelas']").html(campos);
					
					if (nParcelas > 6)
					{
						$("[name='numparcelas']").val('6');
					}else{
					
						$("[name='numparcelas']").val(nParcelas);
						
					}

					$('<option value="Aura">Aura</option>').appendTo("#carbandeira");
					$('<option value="Elo">Elo</option>').appendTo("#carbandeira");
					$('<option value="Dinners">Dinners</option>').appendTo("#carbandeira");					
					
				}else if ( $(this).val()=='CARTÃO DE CRÉDITO' ) {
				
					var campos = '<option value=""></option>\
								<option value="1">1</option>\
								<option value="2">2</option>\
								<option value="3">3</option>\
								<option value="4">4</option>\
								<option value="5">5</option>\
								<option value="6">6</option>\
								<option value="7">7</option>\
								<option value="8">8</option>\
								<option value="9">9</option>\
								<option value="10">10</option>\
								';
					
					$("[name='numparcelas']").html(campos);
					$("[name='numparcelas']").val(nParcelas);
					
					$("#carbandeira option[value='Aura']").remove();
					$("#carbandeira option[value='Elo']").remove();
					$("#carbandeira option[value='Dinners']").remove();

						
				}
			
				

			}
		);
		
	});

	
	

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

    function cep(v){

        //Remove tudo o que não é dígito

       v=v.replace(/\D/g,"");

        //Coloca hífen entre o quarto e o quinto dígitos

        v=v.replace(/(\d{5})(\d)/,"$1-$2");

        //retorne o resultado

        return v;

    }	


    function num(v){
		        //Remove tudo o que não é dígito

       v=v.replace(/\D/g,"");

        //retorne o resultado

        return v;

    }	

    function data(v){

        //Remove tudo o que não é dígito

        v=v.replace(/\D/g,"");

        //Coloca parênteses em volta dos dois primeiros dígitos

        v=v.replace(/^(\d{2})(\d)/g,"$1/$2");
        //Coloca hífen entre o quarto e o quinto dígitos

        v=v.replace(/(\d{2})(\d)/,"$1/$2");

        return v;

    }	

    function cartaocredito(v){
        //Remove tudo o que não é dígito
        v=v.replace(/\D/g,"");
        //Coloca parênteses em volta dos dois primeiros dígitos

        v=v.replace(/^(\d{4})(\d)/g,"$1-$2");
        //Coloca hífen entre o quarto e o quinto dígitos

        v=v.replace(/(\d{4})(\d)/,"$1-$2");
        v=v.replace(/(\d{4})(\d)/,"$1-$2");

        return v;
    }	



	function mostrar(id) {
		
		document.getElementById(id).style.display = '';
	
	}

	function esconder(id) {
		
		document.getElementById(id).style.display = 'none';
	
	}

	function checkstatus(v) {


		if(v == 'CANCELADO'){ document.getElementById('mcancel').style.display = '';
							  document.getElementById('mrest').style.display = 'none';
							  document.getElementById('mdevo').style.display = 'none';
							  document.getElementById('mpend').style.display = 'none';
							  document.getElementById('obsrecupe').style.display = 'none';
							} 

		else if(v == 'RESTRIÇÃO'){ document.getElementById('mcancel').style.display = 'none';
							  document.getElementById('mrest').style.display = '';
							  document.getElementById('mdevo').style.display = 'none';
							  document.getElementById('mpend').style.display = 'none';
							  document.getElementById('obsrecupe').style.display = 'none';
								 }
								 
		else if(v == 'DEVOLVIDO'){ document.getElementById('mcancel').style.display = 'none';
							  document.getElementById('mrest').style.display = 'none';
							  document.getElementById('mdevo').style.display = '';
							  document.getElementById('mpend').style.display = 'none';
							  document.getElementById('obsrecupe').style.display = 'none';
								 }						 

		else if(v == 'PENDENTE'){ document.getElementById('mcancel').style.display = 'none';
									   document.getElementById('mrest').style.display = 'none';
									   document.getElementById('mdevo').style.display = 'none';
									   document.getElementById('mpend').style.display = '';
									   document.getElementById('obsrecupe').style.display = 'none';
									 }
									 
		else if(v == 'RECUPERADO'){ document.getElementById('mcancel').style.display = 'none';
									document.getElementById('mrest').style.display = 'none';
									document.getElementById('mdevo').style.display = 'none';
									document.getElementById('mpend').style.display = 'none';
									document.getElementById('obsrecupe').style.display = '';
		
		} else { 

			document.getElementById('mcancel').style.display = 'none';  
			document.getElementById('motivocancelamento').value = "";

			document.getElementById('mrest').style.display = 'none'; 	
			document.getElementById('motivorestricao').value = "";

			document.getElementById('mdevo').style.display = 'none';
			document.getElementById('motivodevolvido').value = "";

			document.getElementById('mpend').style.display = 'none';
			document.getElementById('pendencia').value = "";

			document.getElementById('maguardlb').style.display = 'none';
			document.getElementById('dataliberacao').value = "";

			document.getElementById('obsrecupe').style.display = 'none';
			document.getElementById('obsrecuperacao').innerHTML = "";

		}

	}


	function checkpendencia(v){

		if(v == 'Cartão Não Autorizado'){
			
			document.getElementById('maguardlb').style.display = '';

		} else {

			document.getElementById('maguardlb').style.display = 'none';
			document.getElementById('dataliberacao').value = "";

		}


	///////////////////////////////////
	///////// CHECAR CONTRATOS////////
	/////////////////////////////////


	function checkoperador(m,op){

		$('#loadoperadores').load('check-operadores-protection.php?m=' + m + '&o=' + op);

	}	




// Se for finalizar valida todos os campos

		if(status=='FINALIZADA')
		{
			
			var campos = {
				
				<?php
				$jsCampos = '';
				
				foreach($campos as $key=>$value)
				{
					if($jsCampos!='') { $jsCampos .= ",\n"; }
					$jsCampos .= "'" . $key . "' : '" . $value . "'";
				}
				
				echo $jsCampos;
				
				?>
				
				};

			
			$.each( campos, function( key, value ) {
				
				if($("#"+key).val()=='')
				{
					
					alert(value + " Inválido");


					$("#"+key).focus();


					erro = erro+1;

					stop();
					return false;
				}
			});
			
		}


		// Se GRAVADO	

		if(status == 'GRAVADO' || status == 'PENDENTE'){


		if(cpf == '' || cpf == '000.000.000-00' || cpf == '111.111.111-11')



		{



		alert("CPF Inválido");


		$('input[name="icpf"]').focus();


		erro = erro+1;

		stop();

		}	



		if(erro == 0)		

		if(gravacao == '')

		{

		alert("Status não permitido sem gravação!");
		erro = erro+1;

		}}




		// Se FINALIZADA	

		if(status == 'FINALIZADA'){

		if(cpf == '' || cpf == '000.000.000-00' || cpf == '111.111.111-11')

		{

		alert("CPF Inválido");

		$('input[name="icpf"]').focus();

		erro = erro+1;


	}	

	if(erro == 0){		

	if(gravacao == '')

	{

	alert("Status não permitido sem gravação!");

	erro = erro+1;

	}}

}

// Se Nada estiver errado:

	if(erro == 0){






	document.forms.editar.submit();


				}

				}


// Fim function

		function validadata(val,id){
			
		tam = val.length;
		datastr = val.split("/");
		novadata = datastr[2]+datastr[1]+datastr[0];

		var dt = new Date();
		ano = dt.getFullYear();
		if((dt.getMonth() + 1) < 10){ mes = '0'+ (dt.getMonth() + 1); } else { mes = (dt.getMonth() + 1);}
		if((dt.getDate() + 1) < 10){ dia = '0'+ dt.getDate(); } else { dia = dt.getDate();}

		hoje = ano + "" + mes + "" + dia;

		if(tam < 10 || novadata < hoje){
			
		 $(id).stop().animate({backgroundColor: '#ffcece', border:"1px solid #ABABAB", padding:'1px', color:'#9a0000'},2000);	
			
			} else if(tam < 1 || tam >= 10) {
				
		 $(id).stop().animate({backgroundColor: '#a2ff4f', color:'#428c00'},800, function(){
		 $(id).animate({backgroundColor: '#ffffff', color:'#000000'},1200);
			 
			 });	
				
				
			}
			
			
			}


		//

		function validaos(val,id){
			
			
		tam = val.length;


		if(tam < 8){
			
		 $(id).stop().animate({backgroundColor: '#ffcece', border:"1px solid #ABABAB", padding:'1px', color:'#9a0000'},2000);	
			
			} else if(tam < 1 || tam >= 8) {
				
		 $(id).stop().animate({backgroundColor: '#a2ff4f', color:'#428c00'},800, function(){
		 $(id).animate({backgroundColor: '#ffffff', color:'#000000'},1200);
			 
			 });	
				
				
			}
			
			
			}

		//

		function excluir(){if(confirm("Tem certeza que deseja excluir esta gravação?")){
			
			document.forms.excluirgravacao.submit();
			
			} }

		function verificatipoentrega(v){
			
			if(v == "EMBRATEL"){
				$('#pagamento').html('<option value="BOLETO">BOLETO</option><option value="CARTÃO DE CRÉDITO">CARTÃO DE CRÉDITO</option><option value="GRÁTIS">GRÁTIS</option>'); 
				$('#pagamento').append(''); 
				}
			
			if(v == "MOTOBOY INTERNO" || v == "MOTOBOY EXTERNO"){
				$('#pagamento').html('<option value="DINHEIRO">DINHEIRO</option><option value="BOLETO">BOLETO</option><option value="CARTÃO DE CRÉDITO">CARTÃO DE CRÉDITO</option><option value="DEPÓSITO">DEPÓSITO</option><option value="GRÁTIS">GRÁTIS</option><option value="PAGSEGURO">PAGSEGURO</option>'); 
				$('#pagamento').append(''); 
				}
			
			if(v == "PRONTA ENTREGA"){
				$('#pagamento').html('<option value="DINHEIRO">DINHEIRO</option><option value="CARTÃO DE CRÉDITO">CARTÃO DE CRÉDITO</option><option value="GRÁTIS">GRÁTIS</option>'); 
				$('#pagamento').append(''); 
				}
			
			}

</script>















<body onLoad="checkoperador('<?= $linha['monitor'];?>','<?= $linha['operador'];?>');">

<div id="result"></div>


<form name="excluirgravacao" action="" method="post">

<input type="hidden" name="excluirgravacao" />

</form>










<div id="topo">







<img src="img/LOGO-VENTO-p.png" />







</div>















<table border="0" width="100%" style="font-size:14px;">















<form id="formEditar" name="editar" action="" method="post">















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
<td><b>Cliente:</b></td>
<td>

<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO")) ) {?>

	<input type="text" name="nome" size="40" value="<?= $linha['nome']; ?>" />

<? } else { ?>

	<?= ucwords($linha['nome']); ?>
	<input type="hidden" name="nome" size="40" value="<?= $linha['nome']; ?>" />
</td>

<? } ?>

</td>
</tr>


<tr>
<td><b>Nome da Mãe:</b></td>

<td>

<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO")) ) {?>

	<input type="text" name="nomemae" size="40" value="<?= $linha['nome_mae']; ?>" />

<? } else { ?>

	<?= ucwords($linha['nome_mae']); ?>
	<input type="hidden" name="nomemae" size="40" value="<?= $linha['nome_mae']; ?>" />
</td>

<? } ?>

</td>
</tr>


<tr>
<td><b>Nascimento:</b></td>

<td>
<? 
$linhanascimento = explode('/',$linha['nascimento']);	
if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO")) ) {
?>

<select name="nascd" id="nascd">

	<option value=""></option>

<? $d = 1; while($d <= 31){ $dn = $d++;?>

<option value="<?= sprintf("%02d", $dn); ?>" <? if($linhanascimento[0] == sprintf("%02d", $dn)){?> selected="selected"<? } ?>> <?= sprintf("%02d", $dn); ?></option>

<? } ?>
</select>


<select name="nascm" id="nascm">
<option value=""></option>

<? $m = 1; while($m <= 12){ $mn = $m++;?>
<option value="<?= sprintf("%02d", $mn); ?>"  <? if($linhanascimento[1] == sprintf("%02d", $mn)){?> selected="selected"<? } ?>> <?= sprintf("%02d", $mn); ?></option>
<? } ?>

</select>


<select name="nasca" id="nasca">

<option value=""></option>
<? $a = date('Y'); while($a > 1900){ $an = $a--;?>
<option value="<?= $an; ?>" <? if($linhanascimento[2] == $an){?> selected="selected"<? } ?>> <?= $an; ?></option>

<? } ?>

</select>


<? } else { ?>

<?= ucwords($linha['nascimento']); ?>


<input type="hidden" name="nascd" value="<?= $linhanascimento[0]; ?>" />
<input type="hidden" name="nascm" value="<?= $linhanascimento[1]; ?>" />
<input type="hidden" name="nasca" value="<?= $linhanascimento[2]; ?>" />

</td>

<? } ?>
</td>
</tr>


<tr>
<td><b>CPF/CNPJ:</b></td>
<td>
<? if(
($editar == '1' && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") )) /*||
($editar =='1' && $USUARIO['tipo_usuario']=='MONITOR'  && $USUARIO['acesso_usuario']=='EXTERNO' && 
($linha['status']=='DEVOLVIDO' || $linha['status']=='SEM CONTATO') )*/ ) {?>

<input type="text" name="icpf" size="40" onKeyPress="mascara(this,cpf)" maxlength="14" value="<?= $linha['cpf']; ?>" />

<? } else { ?>

<?= $linha['cpf']; ?>

<input type="hidden" name="icpf" size="40" onKeyPress="mascara(this,cpf)" maxlength="14" value="<?= $linha['cpf']; ?>" />

</td>
<? } ?>

</td>
</tr>


<tr>
<td><b>RG:</b></td>
<td>
<? if(
($editar == '1' &&  ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="rg" size="40" value="<?= $linha['rg']; ?>" />

<? } else { ?>

<?= $linha['rg']; ?>

<input type="hidden" name="rg" size="40" value="<?= $linha['rg']; ?>" />
</td>
<? } ?>

</td>
</tr>


<tr>
<td><b>Org. Exp.:</b></td>
<td>

<? if(
($editar == '1')  && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="orgexp" size="40" value="<?= $linha['org_exp']; ?>" />

<? } else { ?>

<?= $linha['org_exp']; ?>

<input type="hidden" name="orgexp" size="40"  value="<?= $linha['org_exp']; ?>" />

</td>

<? } ?>

</td>

</tr>


<tr>
<td><b>Data Exp.:</b></td>
<td>

<? if(
($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="dataexp" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<? if($linha['data_exp'] != ''){ echo substr($linha['data_exp'],6,2)."/".substr($linha['data_exp'],4,2)."/".substr($linha['data_exp'],0,4); } ?>" />

<? } else { ?>

<? if($linha['data_exp'] != ''){ echo substr($linha['data_exp'],6,2)."/".substr($linha['data_exp'],4,2)."/".substr($linha['data_exp'],0,4);} ?>

<input type="hidden" name="dataexp" value="<? if($linha['data_exp'] != ''){ echo substr($linha['data_exp'],6,2)."/".substr($linha['data_exp'],4,2)."/".substr($linha['data_exp'],0,4); } ?>" />

<? } ?>
</td>

</tr>


<tr>
<td><b>Profissão:</b></td>
<td>
<? if(
($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="profissao" size="40" value="<?= $linha['profissao']; ?>" />

<? } else { ?>

<?= $linha['profissao']; ?>

<input type="hidden" name="profissao" size="40" value="<?= $linha['profissao']; ?>" />

</td>

<? } ?>
</td>
</tr>


<tr>
<td><b>Sexo:</b></td>
<td>

<? if(
($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="radio" name="sexo" id="sexo1" <? if($linha['sexo'] == 'Masculino'){?> checked="checked" <? } ?> value="Masculino" /> Masculino 
<input type="radio" name="sexo" id="sexo2" <? if($linha['sexo'] == 'Feminino'){?> checked="checked" <? } ?> value="Feminino" /> Feminino

<? } else { ?>

<?= $linha['sexo']; ?>

<input type="hidden" name="sexo" size="40" value="<?= $linha['sexo']; ?>" />
</td>

<? } ?>

</td>
</tr>


<tr>
<td><b>Estado Civil:</b></td>
<td>
<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<select name="estadocivil" id="estadocivil" >

	<option value="Solteiro" <? if($linha['estado_civil'] == 'Solteiro'){?> selected="selected" <? } ?>>Solteiro</option>
	<option value="Casado" <? if($linha['estado_civil'] == 'Casado'){?> selected="selected" <? } ?>>Casado</option>
	<option value="Desquitado" <? if($linha['estado_civil'] == 'Desquitado'){?> selected="selected" <? } ?>>Desquitado</option>
	<option value="Separado" <? if($linha['estado_civil'] == 'Separado'){?> selected="selected" <? } ?>>Separado</option>
	<option value="Divorciado" <? if($linha['estado_civil'] == 'Divorciado'){?> selected="selected" <? } ?>>Divorciado</option> 
	<option value="Viúvo" <? if($linha['estado_civil'] == 'Viúvo'){?> selected="selected" <? } ?>>Viúvo</option> 

</select>

<? } else { ?>

<?= $linha['estado_civil']; ?>

	<input type="hidden" name="estadocivil" size="40" maxlength="14" value="<?= $linha['estado_civil']; ?>" />
</td>

<? } ?>

</td>
</tr>


<tr>
<td><b>Email:</b></td>

<td>
<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="email" size="40" value="<?= $linha['email']; ?>" />

<? } else { ?>
<?= strtolower($linha['email']); ?>

<input type="hidden" name="email" size="40" value="<?= $linha['email']; ?>" />

</td>
<? } ?>

</td>
</tr>



<tr>
<td><b>Telefone:</b></td>

<td>
<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="itelefone" size="20" onKeyPress="mascara(this,telefone)" maxlength="15" value="<?= $linha['telefone']; ?>" />

<select name="tipotel1">

	<option value=""></option>
	<option value="Residencial" <? if($linha['tipo_tel1'] == 'Residencial'){?> selected="selected" <? } ?>>Residencial</option> 
	<option value="Celular" <? if($linha['tipo_tel1'] == 'Celular'){?> selected="selected" <? } ?>>Celular</option>
	<option value="Comercial" <? if($linha['tipo_tel1'] == 'Comercial'){?> selected="selected" <? } ?>>Comercial</option>

</select>

<? } else { ?>

<?= $linha['telefone'].' <span style="color:#343434; font-size: 12px;">('.$linha['tipo_tel1'].')</span>'; ?>

<input type="hidden" name="itelefone" value="<?= $linha['telefone']; ?>" />
<input type="hidden" name="tipotel1" value="<?= $linha['tipo_tel1']?>" />

</td>
<? } ?>
</td>
</tr>


<? if( ($linha['telefone2'] != '' || $editar=='1' ) ){?>

<tr>
<td><b>Telefone2:</b></td>
<td>

<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>
<input type="text" name="itelefone2" size="20" onKeyPress="mascara(this,telefone)" maxlength="15" value="<?= $linha['telefone2']; ?>" />

<select name="tipotel2">

	<option value=""></option>
	<option value="Residencial" <? if($linha['tipo_tel2'] == 'Residencial'){?> selected="selected" <? } ?>>Residencial</option> 
	<option value="Celular" <? if($linha['tipo_tel2'] == 'Celular'){?> selected="selected" <? } ?>>Celular</option>
	<option value="Comercial" <? if($linha['tipo_tel2'] == 'Comercial'){?> selected="selected" <? } ?>>Comercial</option>

</select>

<? } else { ?>

<?= $linha['telefone2'].' <span style="color:#343434; font-size: 12px;">('.$linha['tipo_tel2'].')</span>'; ?>

<input type="hidden" name="itelefone2" value="<?= $linha['telefone2']; ?>" />
<input type="hidden" name="tipotel2" value="<?= $linha['tipo_tel2']?>" />

</td>

<? } ?>

</td>

</tr>


<? } ?>

<? if( ($linha['telefone3'] != '' || $editar=='1') ){?>

<tr>
<td><b>Telefone3:</b></td>
<td>
<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="itelefone3" size="20" onKeyPress="mascara(this,telefone)" maxlength="15" value="<?= $linha['telefone3']; ?>" />

<select name="tipotel3">

	<option value=""></option>
	<option value="Residencial" <? if($linha['tipo_tel3'] == 'Residencial'){?> selected="selected" <? } ?>>Residencial</option> 
	<option value="Celular" <? if($linha['tipo_tel3'] == 'Celular'){?> selected="selected" <? } ?>>Celular</option>
	<option value="Comercial" <? if($linha['tipo_tel3'] == 'Comercial'){?> selected="selected" <? } ?>>Comercial</option>

</select>


<? } else { ?>

<?= $linha['telefone3'].' <span style="color:#343434; font-size: 12px;">('.$linha['tipo_tel3'].')</span>'; ?>

<input type="hidden" name="itelefone3" value="<?= $linha['telefone3']; ?>" />
<input type="hidden" name="tipotel3" value="<?= $linha['tipo_tel3']?>" />

</td>
<? } ?>
</td>

</tr>


<? } ?>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<tr>

<td><b>Endereço:</b></td>

<td>

<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" size="27" name="endereco" value="<?= $linha['endereco']; ?>" /> Nº: <input type="text" size="5" name="numero" value="<?= $linha['numero']; ?>" onKeyPress="mascara(this,soNumeros);" /> <br /> Lote: <input type="text" size="5" name="lote" value="<?= $linha['lote']; ?>" /> Quadra: <input type="text" size="5" name="quadra" value="<?= $linha['quadra']; ?>" />

<? } else { ?>

<? echo ucwords($linha['endereco']); if($linha['numero']){echo ', '.$linha['numero'];} if($linha['lote']){echo ' - Lote: '.$linha['lote'];} if($linha['quadra']){echo ' - Quadra: '.$linha['quadra'];} ?>

<input type="hidden" size="40" name="endereco" value="<?= $linha['endereco']; ?>" />
<input type="hidden" size="40" name="numero" value="<?= $linha['numero']; ?>" />
<input type="hidden" size="40" name="lote" value="<?= $linha['lote']; ?>" />
<input type="hidden" size="40" name="quadra" value="<?= $linha['quadra']; ?>" />

</td>

<? } ?>

</td>

</tr>


<tr>
<td><b>Complemento:</b></td>

<td>
<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>
<input type="text" size="40" name="complemento" value="<?= $linha['complemento']; ?>" />

<? } else { ?>
<?= ucwords($linha['complemento']); ?>

<input type="hidden" size="40" name="complemento" value="<?= $linha['complemento']; ?>" />

</td>
<? } ?>

</td>
</tr>


<tr>
<td><b>Bairro:</b></td>
<td>

<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>
<input type="text" size="40" name="bairro" value="<?= $linha['bairro']; ?>" />

<? } else { ?>

<?= ucwords($linha['bairro']); ?>

<input type="hidden" size="40" name="bairro" value="<?= $linha['bairro']; ?>" />

</td>

<? } ?>
</td>
</tr>


<tr>
<td><b>Cidade:</b></td>

<td>
<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {
$uf = $linha['uf'];	
?>

<input type="text" size="26" name="cidade" value="<?= $linha['cidade']; ?>" /> - <select name="uf">
<option value="AC" <? if($uf == 'AC'){ echo 'selected="selected"'; } ?>>AC</option>  
<option value="AL" <? if($uf == 'AL'){ echo 'selected="selected"'; } ?>>AL</option>  
<option value="AM" <? if($uf == 'AM'){ echo 'selected="selected"'; } ?>>AM</option>  
<option value="AP" <? if($uf == 'AP'){ echo 'selected="selected"'; } ?>>AP</option>  
<option value="BA" <? if($uf == 'BA'){ echo 'selected="selected"'; } ?>>BA</option>  
<option value="CE" <? if($uf == 'CE'){ echo 'selected="selected"'; } ?>>CE</option>  
<option value="DF" <? if($uf == 'DF'){ echo 'selected="selected"'; } ?>>DF</option>  
<option value="ES" <? if($uf == 'ES'){ echo 'selected="selected"'; } ?>>ES</option>  
<option value="GO" <? if($uf == 'GO'){ echo 'selected="selected"'; } ?>>GO</option>  
<option value="MA" <? if($uf == 'MA'){ echo 'selected="selected"'; } ?>>MA</option>  
<option value="MG" <? if($uf == 'MG'){ echo 'selected="selected"'; } ?>>MG</option>  
<option value="MS" <? if($uf == 'MS'){ echo 'selected="selected"'; } ?>>MS</option>  
<option value="MT" <? if($uf == 'MT'){ echo 'selected="selected"'; } ?>>MT</option>  
<option value="PA" <? if($uf == 'PA'){ echo 'selected="selected"'; } ?>>PA</option>  
<option value="PB" <? if($uf == 'PB'){ echo 'selected="selected"'; } ?>>PB</option>  
<option value="PE" <? if($uf == 'PE'){ echo 'selected="selected"'; } ?>>PE</option>  
<option value="PI" <? if($uf == 'PI'){ echo 'selected="selected"'; } ?>>PI</option>  
<option value="PR" <? if($uf == 'PR'){ echo 'selected="selected"'; } ?>>PR</option>  
<option value="RJ" <? if($uf == 'RJ' || $uf == ''){ echo 'selected="selected"'; } ?>>RJ</option>  
<option value="RN" <? if($uf == 'RN'){ echo 'selected="selected"'; } ?>>RN</option>  
<option value="RO" <? if($uf == 'RO'){ echo 'selected="selected"'; } ?>>RO</option>  
<option value="RR" <? if($uf == 'RR'){ echo 'selected="selected"'; } ?>>RR</option>  
<option value="RS" <? if($uf == 'RS'){ echo 'selected="selected"'; } ?>>RS</option>  
<option value="SC" <? if($uf == 'SC'){ echo 'selected="selected"'; } ?>>SC</option>  
<option value="SE" <? if($uf == 'SE'){ echo 'selected="selected"'; } ?>>SE</option>  
<option value="SP" <? if($uf == 'SP'){ echo 'selected="selected"'; } ?>>SP</option>  
<option value="TO" <? if($uf == 'TO'){ echo 'selected="selected"'; } ?>>TO</option> 

</select>



<? } else { ?>

<?= ucwords($linha['cidade'].' - '.$linha['uf']); ?>

<input type="hidden" size="26" name="cidade" value="<?= $linha['cidade']; ?>" />
<input type="hidden" size="26" name="uf" value="<?= $linha['uf']; ?>" />

</td>
<? } ?>
</td>
</tr>


<tr>
<td><b>CEP:</b></td>
<td>

<? if( 
( ($editar == '1' || $USUARIO['id']==3179) && ($USUARIO['tipo_usuario']!='MONITOR'  && $USUARIO['acesso_usuario']!='EXTERNO') ) /*|| 
($editar =='1' && $USUARIO['tipo_usuario']=='MONITOR'  && $USUARIO['acesso_usuario']=='EXTERNO' 
&& ($linha['status']=='DEVOLVIDO' || $linha['status']=='SEM CONTATO') )*/  ) {?>

<input type="text" size="40" name="icep" onKeyPress="mascara(this,cep)" maxlength="9" value="<?= $linha['cep']; ?>" />

<? } else { ?>

<?= $linha['cep']; ?>
<input type="hidden" size="40" name="icep" onKeyPress="mascara(this,cep)" maxlength="9" value="<?= $linha['cep']; ?>" />

</td>
<? } ?>

</td>
</tr>

<tr>
<td><b>Ponto Ref.:</b></td>
<td><? if(
( $editar == '1' && ( ($USUARIO['tipo_usuario']!='MONITOR'  && $USUARIO['acesso_usuario']!='EXTERNO') )) ) {?>

<textarea name="pontoref" rows="3" cols="30"><?= $linha['ponto_referencia']; ?></textarea>

<? } else { ?>

<?= $linha['ponto_referencia']; ?>

<input type="hidden" name="pontoref" value="<?= $linha['ponto_referencia']; ?>" />

<? } ?></td>

</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<tr align="left">
<td><b>Consultor:</b></td>
<td>
<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<select type="text" id="monitor" name="monitor" onChange="checkoperador(this.value,'<?= $linha['operador'];?>')">
<option value=""></option>
<? 
$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE grupo LIKE '%0007%' && tipo_usuario = 'MONITOR' ORDER BY nome ASC");

while($MONITORES = mysql_fetch_array($conMONITORES)){
?>

<option value="<?= $MONITORES['id'];?>" <? if($linha['monitor'] == $MONITORES['id']){?> selected="selected" <? } ?>><?= $MONITORES['nome'];?></option>

<? } ?>

</select> 

<? } else {

$conMONITORES = $conexao->query("SELECT * FROM usuarios WHERE id = '".$linha['monitor']."' ORDER BY nome ASC");
$MONITORES = mysql_fetch_array($conMONITORES);	

	?>

<?= $MONITORES['nome']; ?>

<input type="hidden" name="monitor" value="<?= $linha['monitor']; ?>" />
<? } ?>

</td>
</tr>


<tr align="left">
<td><b>Operador:</b></td>
<td>

<?
$conOPERADORES1 = $conexao->query("SELECT * FROM operadores WHERE operador_id = '".$linha['operador']."'");
$OPERADORES1 = mysql_fetch_array($conOPERADORES1);	

if( ($editar == '1' && ($USUARIO['tipo_usuario'] == 'ADMINISTRADOR' || $USUARIO['id']==3129)) && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {

?>

<!--
<div id="loadoperadores" style="position:relative"></div> 
-->

<select type="text" id="operador" name="operador">

<option value="<?= $linha['operador']; ?>"><?= $OPERADORES1['nome'];?></option>
<option value="<?= $linha['operador']; ?>"></option>

<? 
$conOPERADORES = $conexao->query("SELECT * FROM operadores WHERE grupo LIKE '%0007%' && status != 'DESLIGADO' ORDER BY nome ASC");

while($OPERADORES = mysql_fetch_array($conOPERADORES)){

?>


<option value="<?= $OPERADORES['operador_id'];?>" <? if($linha['operador'] == $OPERADORES['operador_id']){?> selected="selected" <? } ?>>

<?= $OPERADORES['nome'];?>
</option>

<? } ?>

</select>


<? } else { ?>

<?= $OPERADORES1['nome']; ?>

<input type="hidden" name="operador" value="<?= $linha['operador']; ?>" />

<? } ?>

</td>
</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<tr>
	<td><b>Veículo: </b></td>

	<td>
	<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>
	

		
		<select name="fipeVeiculo" id="fipeVeiculo" class="eventChange">
			
			<option value="0">Selecione o tipo de Veículo</option>
			<option value="carro" <?php if ( $linha['protectionVeiculo'] == 'carro' ) { echo "selected=\"selected\""; } ?>>Carro</option>
			<option value="moto" <?php if ( $linha['protectionVeiculo'] == 'moto' ) { echo "selected=\"selected\""; } ?>>Moto</option>
		
		</select>
		
		<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	
	<?php } else { ?>

		<input type="hidden" name="fipeVeiculo" value="<?php echo $linha['protectionVeiculo']; ?>" />
		<?php echo ucwords($linha['protectionVeiculo']); ?>
	
	<?php } ?>
	</td>
</tr>

<?php
	
	include_once "lib/class.protectionFipe.php";
	
	//$conFipe = new Connection("localhost","root","vento","extrair");
	$protectionFipe = new protectionFipe($conexao);
	
?>

<tr>
	<td><b>Marca: </b></td>
	
	<td>

	<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

		<select name="fipeMarca" id="fipeMarca" class="eventChange clearOnChange_fipeVeiculo">
			
			<option value=""></option>
			
			<?php 
			
			foreach($protectionFipe->getMarcas($linha['protectionVeiculo']) as $marca){
				
				if ( $marca['id'] == $linha['protectionMarca'] ) {
					
					$selected = " selected=\"selected\"";
					
				} else {
					
					$selected = "";
				}
				
				echo "<option value=\"" . $marca['id'] . "\"" . $selected . ">" . $marca['nome'] . "</option>";
				
			}
			
			?>
		
		</select>
		
		<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	
	<?php } else { ?>
		
		<input type="hidden" name="fipeMarca" value="<?php echo $linha['protectionMarca']; ?>" />
		<?php $marca = $protectionFipe->getMarca($linha['protectionMarca']); echo ucwords($marca['nome']); ?>
	
	<?php } ?>
	</td>
</tr>

<tr>
	<td><b>Modelo: </b></td>
	
	<td>
		<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>
		<select name="fipeModelo" id="fipeModelo" class="eventChange clearOnChange_fipeVeiculo clearOnChange_fipeMarca">
			
			<option value=""></option>

			<?php 
			
			foreach($protectionFipe->getModelos($linha['protectionMarca']) as $modelo){

				if ( $modelo['id'] == $linha['protectionModelo'] ) {
					
					$selected = " selected=\"selected\"";
					
				} else {
					
					$selected = "";
				}
				
				echo "<option value=\"" . $modelo['id'] . "\"" . $selected . ">" . $modelo['nome'] . "</option>";
				
			}
			
			?>
		
		</select>
		
		<span class="campoobrigatorio" title="Campo Obrigatório">*</span>

	<?php } else { ?>
		
		<input type="hidden" name="fipeModelo" value="<?php echo $linha['protectionModelo']; ?>" />
		<?php $modelo = $protectionFipe->getModelo($linha['protectionModelo']); echo ucwords($modelo['nome']); ?>
	
	<?php } ?>
	
	</td>
</tr>

<tr>
	<td><b>Ano Modelo: </b></td>
	
	<td>
		<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>
		<select name="fipeAno_modelo" id="fipeAno_modelo" class="eventChange clearOnChange_fipeVeiculo clearOnChange_fipeMarca clearOnChange_fipeModelo">
			
			<option value=""></option>

			<?php 
			
			foreach($protectionFipe->getAnos($linha['protectionModelo']) as $ano){

				if ( $ano['id'] == $linha['protectionAnoModelo'] ) {
					
					$selected = " selected=\"selected\"";
					
				} else {
					
					$selected = "";
				}
				
				$cotaParticipacao = getCotaParticipacao($ano['valor']);
				
				echo "<option value=\"" . $ano['id'] . "\"" . $selected . " data-cota-participacao=\"" . $cotaParticipacao . "\" data-valor=\"" . $ano['valor'] . "\">" . $ano['nome'] . "</option>";
				
			}
			
			?>

		</select>
		
		<span class="campoobrigatorio" title="Campo Obrigatório">*</span>
	
	<?php } else { ?>
		
		<input type="hidden" name="fipeAno_modelo" value="<?php echo $linha['protectionAnoModelo']; ?>" />
		<?php $anoModelo = $protectionFipe->getAno($linha['protectionAnoModelo']); echo ucwords($anoModelo['nome']); ?>
	
	<?php } ?>
	
	</td>
</tr>

<tr class="lineCilindradas" <?php if ($linha['protectionCilindrada'] =='') { ?>style="display:none;"<?php } ?>>
	<td><b>Cilindradas:</b></td>
	<td>

		<select name="motoCilindrada" id="motoCilindrada" class="eventChange">
			
			<option value="">Selecione a Cilindrada</option>
			<option value="300cc">300 Cilindradas</option>
			<option value="xxxcc">Outra</option>
		
		</select>

	</td>
</tr>

<tr class="lineFipeVal ">
	<td><b>Valor FIPE:</b></td>
	<td class="fipeVal clearOnChange_fipeVeiculo clearOnChange_fipeMarca clearOnChange_fipeModelo">
	<?php
		
		echo "R$ " . number_format(substr($linha['protectionValorVeiculo'],0,-2) . "." . substr($linha['protectionValorVeiculo'],-2),2,",",".");
	?>
	</td>
	<input type="hidden" name="valorVeiculo" value="<?php echo $linha['protectionValorVeiculo']; ?>" />
</tr>

<tr class="lineFipeCota">
	<td><b>Cota de Part.:</b></td>
	<td class="fipeCota clearOnChange_fipeVeiculo clearOnChange_fipeMarca clearOnChange_fipeModelo">
	<?php 

	function getCotaParticipacao($valor){

		$cotaParticipacao = 60000;
		
		global $linha;
		
		if ( $linha['protectionVeiculo'] == 'carro' && (int) $valor > 20000 ) {

			$cotaParticipacao = ($valor*3) /100;

			//$cotaParticipacao = number_format($cotaParticipacao,2,'.','');
			$cotaParticipacao = (string) $cotaParticipacao;

			$cota = explode(".", $cotaParticipacao);

			if ( count($cota) == 2 ) {

				if (strlen($cota[1]) < 2 ){

					$cota[1] .= "0";
					
				}

				$cotaParticipacao = $cota[0].$cota[1];

			} else {

				$cotaParticipacao .= "";

			}

		}
		
		return $cotaParticipacao;
		
	}
	
	$cotaParticipacaoAtual = getCotaParticipacao( substr($linha['protectionValorVeiculo'],0,-2));
	
	?>

	<?php echo "R$ " . number_format(substr($cotaParticipacaoAtual,0,-2),0,"",".") . "," . substr($cotaParticipacaoAtual,-2); ?>
	</td>
</tr>

<tr>

<td><b>Tipo Plano:</b></td>

<td>

<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<select name="tipoplano" id="tipoplano" onChange="verificatipoplano(this.value);" class="eventChange">

<?php 

foreach ($PLANOS as $planoId=>$plano) {

?>
	<option value="<?= $planoId; ?>" <?php if ($linha['tipoPlano']==$planoId) { ?>selected="selected"<?php } ?>><?= $PLANOS[$planoId]; ?></option>

<?php
	
}
?>

</select>

<? } else { ?>

<?= ($linha['tipoPlano'] == 1) ? "Adesão" : "Migração"; ?>

<input type="hidden" name="tipoplano" value="<?= $linha['tipoPlano']; ?>" />

<? } ?>

</td>

</tr>

<tr align="left">
	<td><b>Adicionais.:</b></td>
	<td>
		<? if( ($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {
		
			$locked = "";
		
		} else {
		
			$locked = "disabled";
			
		} ?>
		<span id="iBoxAdicionalGnv">
			<input class="eventClick" type="checkbox" id="adicionalGnv" name="adicionalGnv" value="gnv" <?php echo $locked; ?> /><label for="adicionalGnv" style="font-size:14px;">Gás Natural Veicular</label>
		</span>
		
		<span id="iBoxAdicionalRastreador">
			<input class="eventClick" type="checkbox" id="adicionalRastreador" name="adicionalRastreador" value="rastreador" checked="checked" <?php echo $locked; ?> /><label for="adicionalRastreador" style="font-size:14px;">Rastreador</label>
		</span>
			
	</td>
</tr>

<tr align="left" id="linetxAdesao">
	<td><b>Taxa Adesão:</b></td>
	<td id="txAdesao" class="clearOnChange_fipeVeiculo clearOnChange_fipeMarca clearOnChange_fipeModelo">
	<?php
		
		echo "R$ " . number_format(substr($linha['protectionTxAdesao'],0,-2) . "." . substr($linha['protectionTxAdesao'],-2),2,",",".");
	?>
	</td>
	
	<input type="hidden" name="txAdesao" value="<?php echo $linha['protectionTxAdesao']; ?>" />

</tr>

<tr align="left" id="lineValorMensalidade">
	<td><b>Mensalidade:</b></td>
	<td id="valorMensalidade" class="clearOnChange_fipeVeiculo clearOnChange_fipeMarca clearOnChange_fipeModelo">
	<?php
		
		echo "R$ " . number_format(substr($linha['protectionMensalidade'],0,-2) . "." . substr($linha['protectionMensalidade'],-2),2,",",".");
	?>
	</td>
	<td><input type="hidden" name="valorMensalidade" value="<?php echo $linha['protectionMensalidade']; ?>" /></td>

</tr>

<tr align="left">

<td><b>Pagamento:</b></td>

<td>

<? if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<select name="pagamento" id="pagamento" onchange="verificapagamento(this.value);">

	<option value="CARTÃO DE CRÉDITO" <? if($linha['pagamento'] == 'CARTÃO DE CRÉDITO'){?>selected="selected"<? } ?>>CARTÃO DE CRÉDITO</option>
	<option value="DINHEIRO" <? if($linha['pagamento'] == 'DINHEIRO'){?>selected="selected"<? } ?>>DINHEIRO</option>	
	<option value="PAGSEGURO" <? if($linha['pagamento'] == 'PAGSEGURO'){?>selected="selected"<? } ?>>PAGSEGURO</option>

</select>


<? } else { ?>


<?= $linha['pagamento']; ?>

	<input type="hidden" id="pagamento" name="pagamento" value="<?= $linha['pagamento']; ?>" />

<? } ?>

</td>

</tr>

<tr id="pagseguroid" <? if($linha['pagamento'] != 'PAGSEGURO'){?> style="display:none" <? } ?>>
<td><b>Indentificação Pagseguro:</b></td>
<td>
<? if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>


<input type="text" name="id_pagseguro" size="40" value="<?= $linha['id_pagseguro']; ?>" />
<? } else { ?>
<?= $linha['id_pagseguro']; ?>
<input type="hidden" name="id_pagseguro" value="<?= $linha['id_pagseguro']; ?>" />
<? } ?>
</td>
</tr>

<tr>
<td><b>Data da Venda:</b></td>
<td>
<? if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="idata" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<?= substr($linha['data'],6,2)."/".substr($linha['data'],4,2)."/".substr($linha['data'],0,4); ?>" />
<? } else { ?>
<?= substr($linha['data'],6,2)."/".substr($linha['data'],4,2)."/".substr($linha['data'],0,4); ?>
<input type="hidden" name="idata" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<?= substr($linha['data'],6,2)."/".substr($linha['data'],4,2)."/".substr($linha['data'],0,4); ?>" />
<? } ?>
</td>
</tr>


<tr>
<td><b>Vencimento:</b></td>
<td>
<? if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="vencimento" size="4" value="<?=$linha['vencimento'];?>" /> 

<? } else { ?>

<?= $linha['vencimento']; ?>

<input type="hidden" name="vencimento" size="4" value="<?=$linha['vencimento'];?>" /> 

<? } ?>

</td>
</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<? if($linha['pagamento'] == 'CARTÃO DE CRÉDITO' || $linha['pagamento'] == 'PAGSEGURO'){ ?>


<tr>

<td><b>Nome do Titular:</b></td>
<td>

<? if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="titularCartao" size="30" value="<?=$linha['titularCartao'];?>" /> <span style="font-size:12px; color:#999; font-style:italic">(Nome impresso no cartão)</span>

<? } else {

if($linha['numCar']){ echo $linha['titularCartao']; } ?>

<input type="hidden" name="titularCartao" size="50" value="<?=$linha['titularCartao'];?>" /> 

<? } ?>

</td>
</tr>



<tr>
<td><b>Cartão Crédito:</b></td>
<td>
<? 

if( $linha['status'] == 'GRAVADO'){

$numDecoCartao = base64_decode($linha['numCar']);
} else {

if($linha['numCar'] != ''){		
$numDecoCartao = 'XXXX-XXXX-XXXX-'.substr(base64_decode($linha['numCar']),15,4);
} else{ $numDecoCartao = "";}

}

if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>


<input type="text" name="numcartao" size="50" onKeyPress="mascara(this,cartaocredito)" onChange="mascara(this,cartaocredito)" maxlength="19" value="<?=$numDecoCartao;?>" /> 

<? } else { 

if($linha['numCar']){ echo 'XXXX-XXXX-XXXX-'.substr(base64_decode($linha['numCar']),15,4); } ?>
<input type="hidden" name="numcartao" size="50" value="<?=$linha['numCar'];?>" /> 

<? } ?>
</td>
</tr>


<tr>
<td><b>Cód. Segurança:</b></td>
<td>
<? 
if( $linha['status'] == 'GRAVADO'){
$numDecoCodSeg = $linha['codSeg'];
} else {

if($linha['codSeg'] != ''){	

$numDecoCodSeg = 'XX'.substr($linha['codSeg'],2,1);

} else { $numDecoCodSeg = "";}

}

if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>


<input type="text" name="numcodseguranca" size="50" onKeyPress="mascara(this,cartaocredito)" onChange="mascara(this,cartaocredito)" maxlength="3" value="<?=$numDecoCodSeg;?>" /> 

<? } else { 

if($linha['numCar']){ echo 'XX'.substr($linha['codSeg'],2,1); } ?>
<input type="hidden" name="numcodseguranca" size="50" value="<?=$linha['codSeg'];?>" /> 
<? } ?>
</td>
</tr>

<tr>
<td><b>Validade:</b></td>
<td>

<? 
$ValidadeCartao = explode('/',$linha['carVal']);

if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<select name="mesval">
<option value=""></option>
<? for($i=1;$i<=12;$i++){ ?>
<option value="<?= sprintf("%02d",$i);?>" <? if($i == $ValidadeCartao[0]){?> selected="selected" <? } ?>><?= sprintf("%02d",$i);?></option>
<? } ?>
</select>

<select name="anoval">
<option value=""></option>
<? for($i=date('Y');$i<=(date('Y')+15);$i++){ ?>
<option value="<?= sprintf("%02d",$i);?>" <? if($i == $ValidadeCartao[1]){?> selected="selected" <? } ?>><?= sprintf("%02d",$i);?></option>
<? } ?>
</select>

<? } else { 

if($linha['numCar']){ echo $linha['carVal']; } ?>

<input type="hidden" name="numcartao" size="50" value="<?=$linha['carVal'];?>" /> 

<? } ?>

</td>
</tr>


<tr>

<td><b>Bandeira:</b></td>
<td>

<? if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>


<select id="carbandeira" name="carbandeira">
<option value=""></option>

<option value="Visa" <? if($linha['carBan'] == 'Visa'){?> selected="selected" <? } ?>>Visa</option>
<option value="MasterCard" <? if($linha['carBan'] == 'MasterCard'){?> selected="selected" <? } ?>>MasterCard</option>
<option value="Hipercard" <? if($linha['carBan'] == 'Hipercard'){?> selected="selected" <? } ?>>Hipercard</option>
<option value="American Express" <? if($linha['carBan'] == 'American Express'){?> selected="selected" <? } ?>>American Express</option>

<?php
if( $linha['pagamento'] == 'PAGSEGURO' )
{
?>

<option value="Aura" <? if($linha['carBan'] == 'Aura'){?> selected="selected" <? } ?>>Aura</option>
<option value="Elo" <? if($linha['carBan'] == 'Elo'){?> selected="selected" <? } ?>>Elo</option>
<option value="Dinners" <? if($linha['carBan'] == 'Dinners'){?> selected="selected" <? } ?>>Dinners</option>


<?php } ?>

</select>

<? } else {

if($linha['numCar']){ echo $linha['carBan']; } ?>

<input type="hidden" name="carbandeira" size="50" value="<?=$linha['carBan'];?>" /> 

<? } ?>

</td>
</tr>


<tr>
<td><b>Parcelas:</b></td>
<td>


<? 

if(($editar == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

	<? if($linha['pagamento'] == 'CARTÃO DE CRÉDITO'){ ?>

		<select name="numparcelas">
		<option value=""></option>
		<option value="1" <? if($linha['numParcelas'] == '1'){?> selected="selected" <? } ?>>1</option>
		<option value="2" <? if($linha['numParcelas'] == '2'){?> selected="selected" <? } ?>>2</option>
		<option value="3" <? if($linha['numParcelas'] == '3'){?> selected="selected" <? } ?>>3</option>
		<option value="4" <? if($linha['numParcelas'] == '4'){?> selected="selected" <? } ?>>4</option>
		<option value="5" <? if($linha['numParcelas'] == '5'){?> selected="selected" <? } ?>>5</option>
		<option value="6" <? if($linha['numParcelas'] == '6'){?> selected="selected" <? } ?>>6</option>
		<option value="7" <? if($linha['numParcelas'] == '7'){?> selected="selected" <? } ?>>7</option>
		<option value="8" <? if($linha['numParcelas'] == '8'){?> selected="selected" <? } ?>>8</option>
		<option value="9" <? if($linha['numParcelas'] == '9'){?> selected="selected" <? } ?>>9</option>
		<option value="10" <? if($linha['numParcelas'] == '10'){?> selected="selected" <? } ?>>10</option>
		</select>

	<? }elseif($linha['pagamento'] == 'PAGSEGURO'){ ?>

		<select name="numparcelas">
		<option value=""></option>
		<option value="1" <? if($linha['numParcelas'] == '1'){?> selected="selected" <? } ?>>1</option>
		<option value="2" <? if($linha['numParcelas'] == '2'){?> selected="selected" <? } ?>>2</option>
		<option value="3" <? if($linha['numParcelas'] == '3'){?> selected="selected" <? } ?>>3</option>
		<option value="4" <? if($linha['numParcelas'] == '4'){?> selected="selected" <? } ?>>4</option>
		<option value="5" <? if($linha['numParcelas'] == '5'){?> selected="selected" <? } ?>>5</option>
		<option value="6" <? if($linha['numParcelas'] == '6'){?> selected="selected" <? } ?>>6</option>
		</select>


	<?php } ?>

<? } else { 

if($linha['numCar']){ echo $linha['numParcelas']; } ?>

<input type="hidden" name="numparcelas" size="50" value="<?=$linha['numParcelas'];?>" /> 

<? } ?>

</td>
</tr>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<? } ?>





<? /*

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


<tr>
<td><b>Gravação:</b></td>

<td>
<? if($linha['gravacao'] == '' && $USUARIO['inserir_gravacao'] == '1'){?>
<img src="img/record.png" width="20" align="absmiddle" style="cursor:pointer" title="Inserir Gravação" onClick="window.location = 'upload-gravacao-simples-clarofixo.php?id=<?= $linha['id'];?>&u=<?= $USUARIO['id'];?>'" /> <span style="font-size:13px;">Inserir Gravação </span>

<? } else if($linha['gravacao'] != '') {?>

<img src="img/play-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Ouvir Gravação" onClick="javascript:window.location = 'http://172.16.0.30/audio/clarofixo/orig/<?= $linha['gravacao'];?>'" /> <span style="font-size:13px;">Ouvir Gravação </span>
&nbsp; &nbsp; &nbsp;


<? if($editar == 1){?>
<img src="img/delete-icon.png" width="20" align="absmiddle" style="cursor:pointer" title="Excluir Gravação" onClick="javascript:excluir();" /> <span style="font-size:13px;">Excluir Gravação </span>
<? } ?>

<? } ?>
</td>

</tr> */ ?>

<tr><td colspan="2">&nbsp;</td></tr>

<tr>

<td valign="top"><b>Documento:</b></td>

<?php

	if($linha['gravacao'] == '' && $USUARIO['inserir_gravacao'] == '1' && $editar==1 || 1==1)
	{
	?>	
	
		<td style="font-size:12px;">
			<?php
			
			$documentos = array();
			
			if( substr($linha['gravacao'], 0,1) != '[' )
			{
				if( $linha['gravacao'] != '' )
				{
					$documentos = (string) $linha['gravacao'];
				}
			
			}else{
				
				$documentos = json_decode($linha['gravacao'], true);
			}
			
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
				<a href="#" onclick="Popup=window.open('upload/protection/<?php echo $documento; ?>','Popup-doc','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,left=430,top=30');"> <?php echo $documento; ?></a> ( Em: <?php echo date("d/m/Y", $time);?> )<br><br>
			<?php
				}
			}else{
				?>
				<a href="#" onclick="Popup=window.open('upload/protection/<?php echo $linha['gravacao']; ?>','Popup-doc','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,left=430,top=30');"> <?php echo $linha['gravacao']; ?></a><br><br>
			<?php
			}
			?>
			<select id="tipo_documento" name="tipo_documento">
				<option value="cnh">CNH</option>
				<option value="compres">Comp. Residência</option>
				<option value="nfisc">Nota Fiscal</option>
				<option value="docdut">D.U.T.</option>
			</select>
			<input id="file" type="file" name="arquivo" style="border-left: 1px solid #CCCCCC; padding-left:3px;display:block; float:left; clear:both;" />
		</td>
	
	<?php	
	}elseif ( ($linha['gravacao'] != '') ) {
		
	?>	

		<td>
			<a href="#" onclick="Popup=window.open('upload/documentos/<?php echo $linha['gravacao']; ?>','Popup-doc','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,left=430,top=30');"> <?php echo $linha['gravacao']; ?></a>
		</td>
		
	<?php
	}

?>



</tr>

<?php /*

<tr>

<td><b>Auditor:</b></td>

<td>

<? 

$conAUDITOR = $conexao->query("SELECT * FROM usuarios WHERE id='".$linha['auditor']."'");
$AUDITOR = mysql_fetch_array($conAUDITOR);

echo $AUDITOR['nome'];

?></td>

</tr>
*/ ?>
<? 
$tipoOBS = '1';
include "includes/observacoes.php";
?>


<? if($linha['obs_gravacao']){?>
<tr><td colspan="2"><hr size="1" style="border-bottom: 1px dashed #EDEDED;" color="#FFF" /></td></tr>		

<tr>
<td><b>Obs.:</b></td>
<td>

<?= $linha['obs_gravacao'];?>
</td>
</tr>

<? } ?>


<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<? // include "includes/agendamento-gravacao.php";?>

<!-- <tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr> -->

<?php

$agendamentos = protectionAgendamento::getAgendamentos($venda, $conexao);

if ( $agendamentos!==false && count($agendamentos) > 0 ) {

	$ultimoAgendamento = new DateTime($agendamentos[0]->dataAgendamento);
	
	$horariosDisponiveis = protectionAgendamento::getHorariosLivres($ultimoAgendamento, $conexao);
	
	array_push($horariosDisponiveis, $ultimoAgendamento->format('H:i'));
	
	asort($horariosDisponiveis);

} else {
	//var_dump($agendamentos);
	//$horariosDisponiveis = protectionAgendamento::getHorariosLivres($dataPtcAgendamento, $conexao);
	
}

?>

<? if(($editar == '1' || $editar_instalacao == '1') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>
<tr>

<td><b><?php echo ($agendamentos === false) ? 'Data Visita' : 'Reagend. Visita';?>:</b></td>

<td>



<input type="text" name="agendamentoProtection" class="datepicker eventChange" onkeydown="return false;" size="20" onKeyPress="mascara(this,data)" maxlength="10" value="<?php if (count($agendamentos) > 0 && $agendamentos!==false) {  echo $ultimoAgendamento->format('d/m/Y'); } ?>" />

<select id="horario-visita" name="horario-visita">

	<?php  
	
	if (count($agendamentos) > 0 && $agendamentos!==false) {

		foreach ($horariosDisponiveis as $horario) {
			
			if ( $horario == $ultimoAgendamento->format('H:i') ) {
				
				echo "<option value=\"" . $horario . ":00\" selected=\"selected\">" . $ultimoAgendamento->format('d/m/Y') . " às " . $horario . "</option>";
			
			} else {
				
				echo "<option value=\"" . $horario . ":00\">" . $ultimoAgendamento->format('d/m/Y') . " às " . $horario . "</option>";
				
			}

		}
	
	} else {
		
		echo "<option value=\"\"></option>";
	}
	
	?>
	

</select>
</td>
</tr>

<? } else { ?>

<tr>
<td></td><td><b>Agendamentos de Visita:</b></td>
</tr>

<? } ?>




<?php 

if ( $agendamentos!==false && count($agendamentos)>0 ) {
	for ( $i=0; $i<= count($agendamentos)-1; $i++ ) {
	
?>

		<tr>
			<td></td>
			<td style="font-size:12px; color:#666666;"><b><?php echo ($i==count($agendamentos)-1) ? "Agendado" : "Reagendado";?></b>: <?php echo $agendamentos[$i]->dataAgendamento; ?></td>
			<td style="font-size:12px; color:#666666;"></td>
		</tr>

<?php
	}
}
?>

<? 
$tipoOBS = '2';
include "includes/observacoes.php";
?>


<? if($linha['obs1']){ ?>
<tr><td colspan="2"><hr size="1" style="border-bottom: 1px dashed #EDEDED;" color="#FFF" /></td></tr>		

<tr>
<td><b>Obs.:</b></td>
<td>
<?= $linha['obs1']; ?>
</td>
</tr>
<? } ?>


<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>


<tr>
<td><b>Data Finalizada:</b></td>
<td>


<? if(($editar == '1' && $USUARIO['tipo_usuario'] == 'ADMINISTRADOR') && ( ($USUARIO['tipo_usuario']!="MONITOR" && $USUARIO['acesso_usuario']!="EXTERNO") ) ) {?>

<input type="text" name="datainstalacao" placeholder="ex:(dd/mm/aaaa)" size="40" onKeyPress="mascara(this,data)" maxlength="10" value="<? if($linha['data_instalacao'] != ''){ echo substr($linha['data_instalacao'],6,2)."/".substr($linha['data_instalacao'],4,2)."/".substr($linha['data_instalacao'],0,4); } ?>" />

<? } else {?>

<? echo substr($linha['data_instalacao'],6,2)."/".substr($linha['data_instalacao'],4,2)."/".substr($linha['data_instalacao'],0,4); ?>
<input type="hidden" name="datainstalacao" value="<? if($linha['data_instalacao'] != ''){ echo substr($linha['data_instalacao'],6,2)."/".substr($linha['data_instalacao'],4,2)."/".substr($linha['data_instalacao'],0,4); } ?>" />

<? } ?>


</td>
</tr>


<? 
$tipoOBS = '3';
include "includes/observacoes.php";
?>

<? if($linha['obs']){ ?>
<tr><td colspan="2"><hr size="1" style="border-bottom: 1px dashed #EDEDED;" color="#FFF" /></td></tr>		

<tr>
<td><b>Obs.:</b></td>
<td>
<?= $linha['obs']; ?>
</td>

</tr>
<? } ?>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<tr>
<td><b>Status:</b></td>
<td>
<?php 
/*
if ( 
		( 
			($editar == '1') 
			|| ($_GET['e']=='1' &&  $linha['status']=='SEM CONTATO' && $USUARIO['acesso_usuario']=='EXTERNO') 
			|| ($_GET['e']=='1' &&  $linha['status']=='SEM COBERTURA') 
			|| ($_GET['e']=='1' &&  $linha['status']=='DEVOLVIDO') 
			) 
		
		&& ($USUARIO['tipo_usuario'] == 'SUPERVISOR' || $USUARIO['tipo_usuario'] == 'MONITOR' || $USUARIO['tipo_usuario'] == 'ADMINISTRADOR') 
	)  {
*/
if ( 
		( 
			($editar == '1') 
			|| ($_GET['e']=='1')
		) 
		
		// && ($USUARIO['tipo_usuario'] == 'SUPERVISOR' || $USUARIO['tipo_usuario'] == 'MONITOR' || $USUARIO['tipo_usuario'] == 'ADMINISTRADOR') 
	)  {

?>
	<select id="status" name="status" onChange="checkstatus(this.value)">

<?php 
	

	foreach( $venda->Status->getFluxo() as $key=>$value)
	{
		echo '<option value="' . $key . '">' . $value . '</option>';
	}
	

?>

	</select>	



<script>

	$(window).load(function () {
		$("[name='status']").trigger("change");


	});

</script>
<?php 
}else{
	
?>
<?= $linha['status']; ?>
<input type="hidden" name="status" value="<?= $linha['status']; ?>" />
<?php } ?>
</td>
</tr>




<? if($linha['status'] == 'CANCELADO' || $_GET['e'] == '1'){?>
<!-- MOTIVO CANCELAMENTO -->

<tr id="mcancel" <? if($linha['status'] != 'CANCELADO'){ ?> style="display:none" <? } ?>>
<td><b>Motivo:</b></td>
<td>
<!-- // EXCESSAO PARA SUPER USUARIO DE INTERNET -->
<? if($_GET['e'] == '1' && ($USUARIO['id']==3227 || $USUARIO['tipo_usuario'] == 'MONITOR' || $USUARIO['tipo_usuario'] == 'ADMINISTRADOR')) { ?>

<select name="motivocancelamento" id="motivocancelamento">

<option value=""></option>

<option value="Inviabilidade Técnica" <? if($linha['motivo_cancelamento'] == 'Inviabilidade Técnica'){?>selected="selected"<? } ?>>Inviabilidade Técnica</option>

<option value="Falta de Dinheiro" <? if($linha['motivo_cancelamento'] == 'Falta de Dinheiro'){?>selected="selected"<? } ?>>Falta de Dinheiro</option>

<option value="Venda Perdida para a Concorrência" <? if($linha['motivo_cancelamento'] == 'Venda Perdida para a Concorrência'){?>selected="selected"<? } ?>>Venda Perdida para a Concorrência</option>

<option value="Desistência do Cliente" <? if($linha['motivo_cancelamento'] == 'Desistência do Cliente'){?>selected="selected"<? } ?>>Desistência do Cliente</option>

<option value="Endereço Não Encontrado" <? if($linha['motivo_cancelamento'] == 'Endereço Não Encontrado'){?>selected="selected"<? } ?>>Endereço Não Encontrado</option>

<option value="Área de Risco" <? if($linha['motivo_cancelamento'] == 'Área de Risco'){?>selected="selected"<? } ?>>Área de Risco</option>

<option value="Cancelado no VSALES" <? if($linha['motivo_cancelamento'] == 'Cancelado no VSALES'){?>selected="selected"<? } ?>>Cancelado no VSALES

</option>
<option value="Número Inválido" <? if($linha['motivo_cancelamento'] == 'Número Inválido'){?>selected="selected"<? } ?>>Número Inválido</option>

</select>

<? } else {?>

<?= $linha['motivo_cancelamento']; ?>

<? } ?>
</td>
</tr>
<? } ?>

<? if($linha['obs_recuperacao'] != '' || $_GET['e'] == '1'){?>

<tr><td colspan="2"><hr size="1" color="#ccc" /></td></tr>

<tr id="obsrecupe" <? if($linha['obs_recuperacao'] == ''){ ?> style="display:none" <? } ?>>

<td><b>Obs. Recuperação:</b></td>

<td>

<? if(($_GET['e'] == '1') && $linha['obs_recuperacao'] == '') { ?>

<textarea name="obsrecuperacao" id="obsrecuperacao" rows="3" cols="30"></textarea>

<? } else {?>


<?= $linha['obs_recuperacao']; ?> <br />

<? 

$conVendaRecuperada = $conexao->query("SELECT nome FROM usuarios WHERE id = '".$linha['usuario_recuperacao']."'");
$usuarioRecuperada = mysql_fetch_array($conVendaRecuperada);

$dataRecuperada = substr($linha['data_recuperacao'],8,2).'/'.substr($linha['data_recuperacao'],5,2).'/'.substr($linha['data_recuperacao'],0,4).' às '.substr($linha['data_recuperacao'],11);

?>

<span style="color:#787878; font-size:11px;">
<b>Recuperada por:</b> <?= $usuarioRecuperada['nome'];?>&nbsp;
em <?= $dataRecuperada;?>
</span>



<? } ?>

</td>

</tr>

<? } ?>

</form>

</table>

<br />
<br />

<? if( ($USUARIO['id']== 3179 && $_GET['e']==1) || ($editar == '1' || $editar_instalacao == '1') || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'LOGISTICA') || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR' && $linha['status'] == 'DEVOLVIDO') || ($_GET['e'] == '1' && $USUARIO['tipo_usuario'] == 'MONITOR' && ($linha['status'] == 'SEM CONTATO' || $linha['status'] == 'SEM COBERTURA'))) {?>

<center>

<img class="bt-sal" src="img/salvar.png" height="25" onClick="javascript:validar();" style="cursor:pointer" />

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
