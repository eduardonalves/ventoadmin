<?

if($_GET["ebt"]=="n" || (! isset($_GET['ebt']) ) ){ $_GET["ebt"]=""; }

	if ( $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && strstr( $USUARIO['colunas_clarofixo'], '(status_portal)' ))
	{

		$conexao->query("create or replace view view_vendas as SELECT SQL_CACHE vendas.*, IFNULL(qualidades.status_portal, 0) as status_qualidade, 		 CASE qxerox.status_xerox     
         WHEN 1 THEN 'OK'
         ELSE 'SEM DOCUMENTAÇÂO'
      END AS status_processo
		FROM vendas_clarotv vendas
		LEFT OUTER JOIN qualidades ON ( qualidades.qualidade_id = (Select q.qualidade_id from qualidades q where (q.novo_numero=vendas.novoNumero && q.os=vendas.os) || (q.novo_numero=vendas.novoNumero && q.os='') order by  q.status_portal desc, q.created desc limit 1) )

		LEFT OUTER JOIN qualidades qxerox ON ( qxerox.qualidade_id = (Select qx.qualidade_id from qualidades qx where (qx.novo_numero=vendas.novoNumero && qx.os=vendas.os) order by qx.status_xerox desc limit 1) )");
	}

if($_GET['v']){

$datain = substr($_GET['v'],6,4).substr($_GET['v'],3,2).substr($_GET['v'],0,2);

} else { $datain = $v;}


if($_GET['i']){

$datafin = substr($_GET['i'],6,4).substr($_GET['i'],3,2).substr($_GET['i'],0,2);

} else { $datafin = $ano.$mes.'31';}


if($_GET['di']!=''){
//echo $_GET['di'];
$di0 = explode('/',$_GET['di']);
//print_r($di0);
$datafinalizada = $di0[2].$di0[1].$di0[0];


	
} else { 
	
	if($_GET['ve']==2)
	{
		$datafinalizada = $ano.$mes;
	}else{
		
		$datafinalizada = 1;
	}

	

}

if($_GET['di2']!=''){

$di0 = explode('/',$_GET['di2']);

$datafinalizada2 = $di0[2].$di0[1].$di0[0];
	
} else { 
	
	if($_GET['ve']==2)
	{
		$datafinalizada2 = $ano.$mes.'31';
		
		if ($_GET['s']=='')
		{
			$datafinalizada2.= "' && data_instalacao!='' && data_instalacao>=data && status='FINALIZADA";
		}
		
	}else{
		
		$datafinalizada2 = date('Y').date('m').'31';
	}
}



if($_GET['ve']==2)
{

	$status = "'FINALIZADA'";

}else{

	$datafinalizada2 .= "' || data_instalacao='";

//	$status = substr($status,1);
$s = explode('|',$_GET['s']);
$status = "";
foreach ($s as $key => $st){
$status .= "'".$st."'";
}
}

if($dataentrega!="")
{
	$dataentrega .= "%' && (status='GRAVADO' || status='BOLETO GERADO' || status='FINALIZADA' || status='ENTREGAR')";
}else{
	
	$dataentrega = "%'";
}

if($USUARIO['tipo_usuario'] == 'MONITOR'){ $loginMONITOR = $USUARIO['id'];}//se o usuario for supervisor, seleciono todos os monitores de um supervisor

if($USUARIO['tipo_usuario'] == 'SUPERVISOR'){ 
	
	$idsupervisor = $USUARIO['id'];	
	$querymonitores = $conexao->query("SELECT * FROM usuarios WHERE supervisor = '$idsupervisor'");	$j=0;	while($row = mysql_fetch_assoc($querymonitores)){				if($j ==0){			$MONITORES = $MONITORES.'  monitor='.$row['id'].' ' ;			}else{			$MONITORES = $MONITORES.'||  monitor='.$row['id'];		}		$j= $j+1;	}		
	}

if($_GET['s'] != ''){

if($_GET['g'] == '1'){
echo "S != 0";

	if ( $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && strstr( $USUARIO['colunas_clarofixo'], '(status_portal)' ))
	{

		$conVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao != '' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'  ORDER BY $ordem LIMIT $inicial, $numreg");
		$quantVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao != '' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
		$quantreg = mysql_num_rows($quantVENDA);


	}else{
	

		$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao != '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'  ORDER BY $ordem LIMIT $inicial, $numreg");
		$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao != '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
		$quantreg = mysql_num_rows($quantVENDA);

	}

} else if($_GET['g'] == '0'){

	if ( $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && strstr( $USUARIO['colunas_clarofixo'], '(status_portal)' ))
	{

		$conVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao = '' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
		$quantVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao = '' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
		$quantreg = mysql_num_rows($quantVENDA);


	}else{
	
		$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao = '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
		$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao = '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
		$quantreg = mysql_num_rows($quantVENDA);
	}

} else {

	if ( $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && strstr( $USUARIO['colunas_clarofixo'], '(status_portal)' ))
	{

		$conVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
		$quantVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
		$quantreg = mysql_num_rows($quantVENDA);

	}else{
	
		$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
		$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
		$quantreg = mysql_num_rows($quantVENDA);
	}

}

	if($USUARIO['tipo_usuario'] == 'SUPERVISOR')
	{	

			
		$conVENDA =	$conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && (".$MONITORES.") ORDER BY ".$ordem." LIMIT ".$inicial.", ".$numreg);
		$quantVENDA =	$conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && status IN (".$status.") && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && ($MONITORES)");
		$quantreg = mysql_num_rows($quantVENDA);

	}

} else{

/*
if($_GET['g'] == '1'){
echo "S = 0";
$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao != '' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'  ORDER BY $ordem LIMIT $inicial, $numreg");
$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao != '' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
$quantreg = mysql_num_rows($quantVENDA);

} else if($_GET['g'] == '0'){
$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && gravacao = '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && gravacao = '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ");
$quantreg = mysql_num_rows($quantVENDA);

}
*/
	if($USUARIO['tipo_usuario'] == 'SUPERVISOR')
	{	
		
		if($MONITORES=="")
		{ $MONITORES = "1=2"; }
		$conVENDA =	$conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && ($MONITORES) ORDER BY $ordem LIMIT $inicial, $numreg");
		//$quantVENDA =	$conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && (esn LIKE '%".$_GET["b"]."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && data_marcada LIKE '%".$dataentrega."%' && tipoVenda LIKE '%".$_GET['tpv']."%' && ($MONITORES) ORDER BY $ordem LIMIT $inicial, $numreg");
		//echo $conVENDA;
		$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && (msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && ($MONITORES)");
		
		//$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && (msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && data_marcada LIKE '%".$dataentrega."%' && tipoVenda LIKE '%".$_GET['tpv']."%' && ($MONITORES) ORDER BY ".$ordem." LIMIT ".$inicial.", ".$numreg);

		//$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' LIMIT 30,30");
		//$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' LIMIT 30,30");
		$quantreg = mysql_num_rows($quantVENDA); 

		} else {

		if($_GET['g'] == '1'){

			if ( $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && strstr( $USUARIO['colunas_clarofixo'], '(status_portal)' ))
			{

				$conVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && gravacao != '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'  ORDER BY $ordem LIMIT $inicial, $numreg");
				$quantVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && gravacao != '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
				$quantreg = mysql_num_rows($quantVENDA);

			}else{

				$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao != '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'  ORDER BY $ordem LIMIT $inicial, $numreg");
				$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao != '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%'");
				$quantreg = mysql_num_rows($quantVENDA);
			}

		} else if($_GET['g'] == '0'){

			if ( $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && strstr( $USUARIO['colunas_clarofixo'], '(status_portal)' ))
			{

				$conVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && gravacao = '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
				$quantVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && gravacao = '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ");
				$quantreg = mysql_num_rows($quantVENDA);

			}else{

			$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao = '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
			$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && gravacao = '' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ");
			$quantreg = mysql_num_rows($quantVENDA);
			}


		}
		else{

			if ( $USUARIO['tipo_usuario'] == 'ADMINISTRADOR' && strstr( $USUARIO['colunas_clarofixo'], '(status_portal)' ))
			{

				$conVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
				$quantVENDA = $conexao->query("SELECT * FROM view_vendas as vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && status_qualidade LIKE '%".$_GET['ebt']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ");
				$quantreg = mysql_num_rows($quantVENDA);

			}else{

				$conVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ORDER BY $ordem LIMIT $inicial, $numreg");
				$quantVENDA = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto='3' && tipoEntrega LIKE '%".$_GET['tpentrega']."%' && (esn LIKE '%".$_GET['b']."%' || msisdn LIKE '%".$_GET['b']."%' || num_ordem LIKE '%".$_GET['b']."%' || cod_autorizacao LIKE '%".$_GET['b']."%' || cpf LIKE '%".$_GET['b']."%' || nome LIKE '%".$_GET['b']."%' || novoNumero LIKE '%".$_GET['b']."%' || os LIKE '%".$_GET['b']."%' || cep LIKE '%".$_GET['b']."%') && plano LIKE '%".$_GET['t']."%' && pagamento LIKE '%".$_GET['f']."%' && (data >= '".$datain."' && data <= '".$datafin."') && (data_instalacao >= '".$datafinalizada."' && data_instalacao <= '".$datafinalizada2."') && (data_marcada LIKE '%".$dataentrega.") && tipoVenda LIKE '%".$_GET['tpv']."%' && monitor LIKE '%".$loginMONITOR."%' ");
				$quantreg = mysql_num_rows($quantVENDA);
			}
			}
	}
	
}




?>
