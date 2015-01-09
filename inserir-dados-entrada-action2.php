<?php

    //Conexão com Banco


function limpaArray($val){
	
	return trim($val);
	
}

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
		
		$query3 = "INSERT INTO ESNsEntradas(id_entrada, esn, status) VALUES ('".$idItensEntrada."','".$esn."','Em Estoque')";
		$conexao->query($query3);
		//echo "Entrada de $esn: OK<br>";
		
		
	}
	
	?>
	
	<script type="text/javascript">
	
		alert("Entrada inserida com sucesso.");
		window.location="?p=?p=index-estoque-clarofixo&es=inserir-dados-entrada-clarofixo2";
	
	</script>
	
<?php

	
}
?>
