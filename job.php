<?php
$query = "SELECT esn.*, vendas.* FROM ESNsEntradas esn
RIGHT JOIN vendas_clarotv vendas ON (esn.esn = vendas.esn) WHERE esn.status='Em Estoque'";

$esns = array('3EE40E7F','3EDA9D4B','3EE0F01C','3EE40CB3','3EE40CD7','3EE40D00','3EE40D0E','3EE40D14','3EE40E4A','3EE40E4B','3EE40E4C','3EE40E51','3EE40E52','3EE40E54','3EE40E57','3EE40E5D','3EE40E5E','3EE40E63','3EE40E6A','3ee40e6c','3EE40E7F','3EE40E88','3EE40E8C','3EE40E95','3EE40E99','3EE40E9C','3EE40EB5','3EE40EFE','3EE40F07','3EE40F0B','3EE40F0E','3EE40F1A','3EE40F20','3EE40F3D','3EE40F44','3EE40F45','3EE4101E','3EE41037','3EE4104E','3EE4105C','3EE41077','3EE41090','3EE41092','3EE41097','3EE410AB','3EE410CC','3EE410EF','3EE41102','3EE429EC','3EE42DD5','3EE42DE0','3EE42EF3','3EE440A1','3EE441D7','3EE441DC','3EE44265','3EE4427A','3EE44280','3EE44292','3EE44294','3EE44320','3EE4FD99','3EE58411','3EE5842A','3EE5843A','3EE5843F','3EE5844C','3EE5844D','3EE58452','3EE58455','3EE58459','3EE84231','3EE88C6E','3EE88C74','3EE88D35','3EE8C81A','3EE8DFDC','3EE8E126','3EE8E848','3EE8E854','3EE91A4B','3EE91A50','3EE91EAE','3EE93D91','3EE93DE4E','3EE99DF9','3EE9A30F','3EE9AD14','3EEAF20D','3EEB0A55','3EEB0C6C','3EEB1410','3EEB1FD0','3EEB2017','3EEB201B','3EEB201C','3EEB2BC7','3EEB4527','3EEB488F','3EEB4A0E','3EEB4B1B','3EEB56AF','3EEB57E8','3EEB6B61','3EEBDDFC','3EEBDE66','3EEBDEB1','3EEBE0B0','3EEBE0B2','A100002666973F','A100002667A052','A10000266B98E','A100008EC2666B');
$esns = "";
$esns = array('3EEBDF0D','3EE18967','3EE1897E','3EE40CE0','3EE40D0B','3EE40F8A','3EE40F48','3EE40F4C','3EE40F31','3EE40F72','3EE40F39','3EE41019','3EE4101A','3EE41026','3EE4103D','3EE4103E','3EE44268','3EE44279','3EE440E3','3EE44314','3EE4431D','3EE8C768','3EE8C82D','3EE919F7','3EE91A98','3EE91B16','3EE9ADCD','3EEB0C7F','3EEB1456','3EEB1CBC','3EEB4412','3EEB4A2F','3EEB59A9','3EE58414','3EE40D0A','3EE410A4','3EE4419F','3EE8B68B','3EE91A5F','3EEB4A1E','3EEB4A36','3EEBDF74','3EE9AD51','3EE410D1','3EE40F92','3EE410E6','3EE410EA','3EEB4431','3EE99D79','3EE9ADEE','3EE7B741','3EE40F59','3EE42DCD','3EE40C9F','3EE40CDA','3EE40D11','3EE40F05','3EE40F42','3EE40F46','3EE40F5F','3EE41018','3EE4104F','3EE4431F','3EE4438C','3EE4427C','3EE410F0','3EE4409F','3EE8C760','3EE8E6EE','3EE91886','3EE939EB','3EE99D98','3EE9ACD0','3EE9AD11','3EE9AD26','3EEB2B63','3EE3751C','3EE40D0D','3EE40F35','3EE40FB8','3EE40FCB','3EE8E6A6','3EE8E718','3EE91A59','3EE8B915','3EE8BA9D','3EE8C649','3EE8C7FE','3EE99DD3','3EE9ACD6','3EE99E71','3EE9ADA5','3EEAF1B1','3EEB1FDA','3EEB42C6','3EEB4548','3EEB4974','3EEB6B59','3EEBDDC8','3EEB4ABB','3EE40F75','3EE40F99','3EE41030','3EE41078','3EE3AB7C','3EE99EEF','3EEAF14F','3EEAF223','3EEAF286','3EEB4557','3EEB5725');

$esns = array('3EEBDFOD');


$esns = array('A1000266A4FBD', 'A1000266950C8');

//echo count($esns);
$total = 0;
foreach ($esns as $esn)
{
	$query = "Select *, entradas.id_entrada as id_ent from ESNsEntradas esn 
		INNER JOIN itensEntrada itens ON (esn.id_entrada=itens.id_itensEntrada)
		INNER JOIN entradas ON (itens.id_entrada=entradas.id_entrada)
		WHERE esn.esn='". $esn . "'";
		
	$result = mysql_fetch_array($conexao->query($query));
 	print_r($result);
	if($result['qtde']>1)
	{
		$c = 0;
		$q = "DELETE FROM ESNsEntradas WHERE esn='".$esn."'";
		$conexao->query($q);
		$c += mysql_affected_rows();
		
		$q = "Update itensEntrada set qtde=qtde-1 WHERE id_itensEntrada = '".$result['id_itensEntrada']."'";
		$conexao->query($q);
		$c += mysql_affected_rows();
		
		$sst = ($c==2) ? "OK" : "FAIL1";
		
	}else{
		
		$c = 0;
		
		$q = "DELETE FROM ESNsEntradas WHERE esn='".$esn."'";
		$conexao->query($q);
		$c += mysql_affected_rows();
		
		$q = "DELETE FROM itensEntrada WHERE id_itensEntrada='".$result['id_itensEntrada']."'";
		$conexao->query($q);
		$c += mysql_affected_rows();
		
		$q = "DELETE FROM entradas WHERE id_entrada='".$result['id_ent']."'";
		$conexao->query($q);
		$c += mysql_affected_rows();
		
		$sst = ($c==3) ? "OK" : "FAIL2";
	}
	
	echo "<br><br>ESN: $esn / $sst";
/*

		$data = "02/12/2013";
	
	          $arrayData = explode("/", $data);
            $TempArrayData[0] = $arrayData[2];
            $TempArrayData[1] = $arrayData[1];
            $TempArrayData[2] = $arrayData[0];
            
            $data = implode("-", $TempArrayData);
            $data .= " " . date("H:i:s");
            

	$sql="INSERT INTO saidas (id_estoquista, id_parceiro, data) VALUES ('9','".$result["monitor"]."', '".$data."')";
    $query = mysql_query($sql);	

            $saida = "SELECT * FROM saidas ORDER BY id_saida DESC LIMIT 1";
            $queryEntrada = mysql_query($saida);
            
            $id_saida = mysql_fetch_array($queryEntrada);
           

            $sql3="INSERT INTO itenssaida (id_saida, id_aparelho, qtde) VALUES ('".$id_saida['id_saida']."', '".$result['aparelho']."', '1')" or die (mysql_error());
            $query3 = mysql_query($sql3);

            $saida2 = "SELECT * FROM itenssaida ORDER BY id_itenssaida DESC LIMIT 1";
                        $querySaida2 = mysql_fetch_array(mysql_query($saida2));
                        
                        
            $sql2="INSERT INTO ESNsSaida (id_saida,esn, status ) VALUES ('".$querySaida2['id_itenssaida']."','".$esn."','Vendido')";
            $query2 = mysql_query($sql2);
            
            $sql_up="UPDATE ESNsEntradas SET status = 'Com Parceiro' WHERE esn = '$esn'";
            mysql_query($sql_up);
	
	echo "Entrada: ". $result['id_ent'] . " / itens: " . $result['id_itensEntrada'] . " / id esn: " . $result['id_esnsentrada']  . " " .$result['esn'] . " (". $result['qtde'] . " ". $sst.")<br>";
	echo "Monitor: " . $result['monitor'] . "<br>";
	echo "Aparelho: " . $result['aparelho']; echo ($result['aparelho']!='') ? "OK<br><br>" : "<span style=\"color: red;\">FAIL</span><br><br>";
	
	$total += mysql_affected_rows();
	* */
}

//echo "<br><br>$total";
/* $query = "SELECT
   vendas_clarotv.*
FROM
   vendas_clarotv
WHERE
   esn
   IN
    (
   SELECT ESNsEntradas.esn
   
    FROM
   ESNsEntradas where status='Em Estoque')";
*/

/*$query = "Select * from ESNsEntradas WHERE status='Em Estoque'";

$result = $conexao->query($query);

$total = 0;
while($r = mysql_fetch_array($result))
{
	
	$query = "select count(esn) from vendas_clarotv where esn='" . $r['esn'] . "'";
	$res = mysql_fetch_array($conexao->query($query));
	
	$total += ($res[0]>0) ? 1:0;
	//$total++;
	echo "<br>" . $r['esn'] . ": " . $res[0];
	//echo $r['esn'];
}
*/
//echo "<br><br>Total: " . $total;
?>
