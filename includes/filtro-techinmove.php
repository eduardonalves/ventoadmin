<?

//***********

/*

* ve = (Vendas=1, Finalizadas=2)
* me = Mes
* an = Ano

* t = Produto
* f = Forma pagamento produto
* s = status
* v = Venda de
* i = Venda ate
* di = Finalizada de
* di2 = Finalizada ate
* g = documentacao(0,1)
* tpv = Tipo de Venda(Interna Externa)
* b = buscar geral

*/

$query = "Select * from vendas_techinmove ";
$filters = "(1=1)";
if( $_GET['ve'] && $_GET['ve'] == 2 ){
	
	
	if ($ano != '' && $ano != 'todos' && $ano != '%'){
	
		$filters .= " && (YEAR(data_finalizada)='" . $ano . "')";
	}

	if ($mes != '' && $mes != 'todos' && $mes != '%'){
	
		$filters .= " && (MONTH(data_finalizada)='" . $mes . "')";
	}

	$filters .= " && (data_finalizada!='' && data_finalizada!='0000-00-00' && data_finalizada>data_venda && status='FINALIZADA')";
	
} else {

	if ($ano != '' && $ano != 'todos' && $ano != '%'){
	
		$filters .= " && (YEAR(data_venda)='" . $ano . "')";
	}

	if ($mes != '' && $mes != 'todos' && $mes != '%'){
	
		$filters .= " && (MONTH(data_venda)='" . $mes . "')";
	}

	if( $_GET['s'] && $_GET['s'] != '' && $_GET['ve'] == 1 ){
		
		$filters .= " && (status='" . $_GET['s'] ."')";

	}

}

if( $_GET['t'] && $_GET['t'] != '' ){
	
	$filters .= " && (produto='" . $_GET['t'] ."')";

}

if( $_GET['f'] && $_GET['f'] != '' ){
	
	$filters .= " && (forma_pagamento_produto='" . $_GET['f'] ."')";

}

if ( $_GET['v'] && $_GET['v'] != '' ){
		
	$dataVendaInicio = substr($_GET['v'],6,4)."-".substr($_GET['v'],3,2)."-".substr($_GET['v'],0,2);
	$filters .= " && (data_venda>='" . $dataVendaInicio . "')";
}

if ( $_GET['i'] && $_GET['i'] != '' ){
		
	$dataVendaFinal = substr($_GET['i'],6,4).substr($_GET['i'],3,2).substr($_GET['i'],0,2);
	$filters .= " && (data_venda<='" . $dataVendaFinal . "')";
}


if ( $_GET['di'] && $_GET['di'] != '' ){
		
	$dataFinalizadaInicio = substr($_GET['di'],6,4)."-".substr($_GET['di'],3,2)."-".substr($_GET['di'],0,2);
	$filters .= " && (data_finalizada>='" . $dataFinalizadaInicio . "')";
}

if ( $_GET['di2'] && $_GET['di2'] != '' ){
		
	$dataFinalizadaFinal = substr($_GET['di2'],6,4).substr($_GET['di2'],3,2).substr($_GET['di2'],0,2);
	$filters .= " && (data_finalizada<='" . $dataFinalizadaFinal . "')";
}

if ( $_GET['g'] && $_GET['g'] == 1 ){
		
	$filters .= " && (documentos!='')";
}

if ( $_GET['tpv'] && $_GET['tpv'] != '' ){
		
	$filters .= " && (tipo_venda='" . $_GET['tpv'] . "')";
}

if ( $_GET['b'] && $_GET['b'] != '' ){
		
	$filters .= ' && (';
	$campos = $conexao->query("SELECT COLUMN_NAME, DATA_TYPE FROM information_schema.columns WHERE TABLE_SCHEMA = 'db498864657' AND TABLE_NAME = 'vendas_techinmove'");

	while ( $campo = mysql_fetch_assoc($campos) ){
		
		$coluna = $campo['COLUMN_NAME'];
		
		$filters .= $coluna . " LIKE '%" . $_GET['b'] . "%' || ";
	}
	
	$filters = substr($filters, 0, -4) . ')';

}

if($USUARIO['tipo_usuario'] == 'MONITOR'){
	
		$loginMONITOR = $USUARIO['id'];
		
		$filters .= " && (monitor='" . $loginMONITOR . "')";

	}//se o usuario for supervisor, seleciono todos os monitores de um supervisor

if($USUARIO['tipo_usuario'] == 'SUPERVISOR'){ 
	
	$idsupervisor = $USUARIO['id'];
	$querymonitores = $conexao->query("SELECT * FROM usuarios WHERE supervisor = '$idsupervisor'");
	
	if( mysql_num_rows($querymonitores) > 0 ){

		$j=0;
		
		while($row = mysql_fetch_assoc($querymonitores)){

			if($j ==0){

				$filters .= " && (monitor='" . $row['id'] . "'";

			}else{

				$filters .= " ||  monitor='". $row['id'] . "'";

			}
			
			$j= $j+1;
			
		}
		
		
	} else {
		
		$filters .= " && (monitor='' && monitor!=''";
	}
	
	$filters .= ")";
}


$query .= 'WHERE ' . $filters;

$conVENDA = $conexao->query($query . ' ORDER BY ' . $ordem . ' LIMIT ' . $inicial . ', ' . $numreg);
$quantVENDA = $conexao->query(str_replace('*', 'count(*)', $query));
$quantreg = mysql_result($quantVENDA, 0, 0);

?>
