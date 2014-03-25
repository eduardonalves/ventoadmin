<?php
/*
$query = "Select * from vendas_clarotv INNER JOIN usuarios ON (usuarios.id=vendas_clarotv.monitor) WHERE esn!='' && vendas_clarotv.status LIKE '%ENVIAR%' order by usuarios.nome";

$result = $conexao->query($query);

while($r = mysql_fetch_array($result))
{
	$esn = $r["esn"];
	
	$query = "Select * from ESNsEntradas WHERE esn='$esn'";
	
	
	$entradas = $conexao->query($query);
	
	if(mysql_num_rows($entradas)>0)
	{
	$entrada = mysql_fetch_array($entradas);
	
	$ap_query = "Select * from itensEntrada where id_itensEntrada='".$entrada["id_entrada"]."'";
	$ap = mysql_fetch_array($conexao->query($ap_query));
	$aparelho =$ap["id_aparelho"];
	
	//echo "ID: ". $r["id"]."<br>Monitor: ".$r["monitor"] . "<br>". "ESN: ". $r["esn"]."<br>Aparelho: " . $aparelho;
	
*/
	$query = "SELECT esn, nf, id_aparelho FROM ESNsEntradas esne 
INNER JOIN itensEntrada ON (itensEntrada.id_itensEntrada=esne.id_entrada)
INNER JOIN entradas ON (entradas.id_entrada=esne.id_entrada)
WHERE esne.status='Em Estoque' && (id_aparelho='7')";


$result = $conexao->query($query);
$i = 1;

while($r = mysql_fetch_array($result))
{
	$data = "21/01/2014";
	
	          $arrayData = explode("/", $data);
            $TempArrayData[0] = $arrayData[2];
            $TempArrayData[1] = $arrayData[1];
            $TempArrayData[2] = $arrayData[0];
            
            $data = implode("-", $TempArrayData);
            $data .= " " . date("H:i:s");
            
            $aparelho = $r['id_aparelho'];
            $esn = $r['esn'];

/*	
	$sql="INSERT INTO saidas (id_estoquista, id_parceiro, data) VALUES ('3234','3176', '".$data."')";
    $query = mysql_query($sql);	

            $saida = "SELECT * FROM saidas ORDER BY id_saida DESC LIMIT 1";
            $queryEntrada = mysql_query($saida);
            
            $id_saida = mysql_fetch_array($queryEntrada);
           

            $sql3="INSERT INTO itenssaida (id_saida, id_aparelho, qtde) VALUES ('".$id_saida['id_saida']."', '".$aparelho."', '1')" or die (mysql_error());
            $query3 = mysql_query($sql3);

            $saida2 = "SELECT * FROM itenssaida ORDER BY id_itenssaida DESC LIMIT 1";
                        $querySaida2 = mysql_fetch_array(mysql_query($saida2));
                        
                        
            $sql2="INSERT INTO ESNsSaida (id_saida,esn, status ) VALUES ('".$querySaida2['id_itenssaida']."','".$esn."','Em Estoque')";
            $query2 = mysql_query($sql2);
            
            $sql_up="UPDATE ESNsEntradas SET status = 'Com Parceiro' WHERE esn = '$esn'";
            mysql_query($sql_up);
    
 */
		echo "<br>$i - ESN: " . $esn . " - ". $aparelho;
		$i++;

}

?>

