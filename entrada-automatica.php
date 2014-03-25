<?php

$query = "Select * from vendas_clarotv INNER JOIN usuarios ON (usuarios.id=vendas_clarotv.monitor) WHERE esn!='' && vendas_clarotv.status LIKE '%ENVIAR%' order by usuarios.nome";

$result = $conexao->query($query);

while($r = mysql_fetch_array($result))
{
	$esn = strtoupper($r["esn"]);
	
	$query = "Select * from ESNsEntradas WHERE esn='$esn'";
	
	
	$entradas = $conexao->query($query);
	
	if(mysql_num_rows($entradas)>0)
	{
	$entrada = mysql_fetch_array($entradas);
	
	$ap_query = "Select * from itensEntrada where id_itensEntrada='".$entrada["id_entrada"]."'";
	$ap = mysql_fetch_array($conexao->query($ap_query));
	$aparelho =$ap["id_aparelho"];
	
	//echo "ID: ". $r["id"]."<br>Monitor: ".$r["monitor"] . "<br>". "ESN: ". $r["esn"]."<br>Aparelho: " . $aparelho;
	
/*
	$data = "05/11/2013";
	
	          $arrayData = explode("/", $data);
            $TempArrayData[0] = $arrayData[2];
            $TempArrayData[1] = $arrayData[1];
            $TempArrayData[2] = $arrayData[0];
            
            $data = implode("-", $TempArrayData);
            $data .= " " . date("H:i:s");
            

	$sql="INSERT INTO saidas (id_estoquista, id_parceiro, data) VALUES ('9','".$r["monitor"]."', '".$data."')";
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
	}else{
		
		echo "<br>Data: ". $r["data"] . " ESN: " . $esn . " - ". $r["nome"] . ":".$r["monitor"]." - ".$r["aparelho"]. " " .$r["valorAparelho"];

	$data = "05/11/2013";
    $arrayData = explode("/", $data);
    $TempArrayData[0] = $arrayData[2];
    $TempArrayData[1] = $arrayData[1];
    $TempArrayData[2] = $arrayData[0];
           
    $data = implode("-", $TempArrayData);
    $data .= " " . date("H:i:s");

    $nf = "0001";
           
    $estoquista = 9;
    $origem = "Claro";
    
    $aparelho = 0;
    
    if($r["valorAparelho"]=="79,00" || $r["valorAparelho"]=="79,90")
    {
		$aparelho = 2;
	}elseif($r["valorAparelho"]=="49,00")
	{
		$aparelho = 3;
	}else{
		$aparelho = 0;
		
	}
		
		if($aparelho!=0)
		{
			echo $aparelho;


// DA A ENTRADA E LOGO EM SEGUIDA A SAIDA
/*
		$sql="INSERT INTO entradas (data, nf, id_estoquista, origem) VALUES ('".$data."','".$nf."','$estoquista','".$origem."')" or die (mysql_error());
		$query = mysql_query($sql);

        $sql4= "SELECT * FROM aparelhos WHERE id_aparelho = '$aparelho'";
        $query4 = mysql_query($sql4);
        $apArray = mysql_fetch_array($query4);                  
        $varConta = $apArray['estoque'];
        $varConta = $apArray['estoque'];   
        $varResult = $varConta + $quantidade_itens;

           
        $sql5= "UPDATE aparelhos SET estoque = '".$varResult."' WHERE id_aparelho = '$aparelho'";
        $query5=mysql_query($sql5);

        $entrada = "SELECT * FROM entradas ORDER BY id_entrada DESC LIMIT 1";
        $queryEntrada = mysql_query($entrada);

        $id_entrada = mysql_fetch_array($queryEntrada);                

        $sql3="INSERT INTO itensEntrada (qtde, id_entrada, id_aparelho) VALUES ('1', '".$id_entrada['id_entrada']."', '".$aparelho."')" or die (mysql_error());
        $query3 = mysql_query($sql3);

            $status = "Em estoque";
                       
            $entrada2 = "SELECT * FROM itensEntrada ORDER BY id_itensEntrada DESC LIMIT 1";
            $queryEntrada2 = mysql_fetch_array(mysql_query($entrada2));

            $sql2="INSERT INTO ESNsEntradas (id_entrada, esn, status ) VALUES ('".$queryEntrada2['id_itensEntrada']."','".$esn."','".$status."')";
            $query2 = mysql_query($sql2);


	$sql="INSERT INTO saidas (id_estoquista, id_parceiro, data) VALUES ('9','".$r["monitor"]."', '".$data."')";
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


// #######################################
*/

		}else{
			echo "<span style=\"color:red;\">ERROR</span>";
		}
/*


*/
	}
}

?>

