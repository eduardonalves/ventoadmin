<?php
header("access-control-allow-origin: *" );
header('Content-Type: text/html; charset=utf-8');
?>
<script type="text/javascript">

$.ajax({     /*   retrieve data     */
        url: "http://www.4gmaxclaro.com.br/assine/",
        dataType: "json",
        success: function(data){
            //alert(data);
        }
 });

</script>


	<?php
		
	
	if($_POST){
		mb_internal_encoding("UTF-8"); 
		//$conexao = mysql_connect("186.202.152.54","edukate","MysqlLogOn") or die("Erro na conexão");
		//$banco = mysql_select_db("edukate");
			
		//$conexao = mysql_connect("db498864657.db.1and1.com","dbo498864657","TiDevV3nt000") or die("Erro na conexão");
		//$banco = mysql_select_db("db498864657");

		$conexao = mysql_connect("db512657722.db.1and1.com","dbo512657722","MysqlLogOn") or die("Erro na conexão");
		$banco = mysql_select_db("db512657722");

		mysql_set_charset("UTF8", $conexao);
			$cpf = $_POST['cpf'];
			$nome=$_POST['nome'];
			$nascimento = $_POST['nascimento'];
			$rg= $_POST['rg'];
			$org_exp= $_POST['org_exp'];
			$profissao= $_POST['profissao'];
			$sexo= $_POST['sexo'];
			$estado_civil= $_POST['estado_civil'];
			$email= $_POST['email'];
			$telefone= $_POST['telefone'];
			$endereco= $_POST['endereco'];
			$numero= $_POST['numero'];
			$bairro= $_POST['bairro'];
			$cidade= $_POST['cidade'];
			$uf= $_POST['uf'];
			$cep= $_POST['cep'];
			$plano= $_POST['plano'];
			$pagamento= mb_strtoupper($_POST['pagamento'], "UTF-8");
			$operador= 1329;
			$produto = 1;
			$tipoVenda = "INTERNET";
			$data_venda = date("Ymd");
			$data=date("Ymd");
			$vencimento = $_POST['vencimento'];
			$pontos = $_POST['pontos'];
			$celular = $_POST['celular'];
			
			$status="PRE-ANALISE";
			$monitor = '3179';
			$sql="INSERT INTO vendas_clarotv (nome, cpf, nascimento, rg, org_exp, profissao, sexo, estado_civil, email, telefone, tipo_tel1, telefone2, tipo_tel2, endereco, numero, bairro, cidade, uf, cep, plano, pagamento, operador, tipoVenda, produto, data, data_venda, monitor, status, vencimento, pontos ) VALUES ('".$nome."', '".$cpf."', '".$nascimento."', '".$rg."', '".$org_exp."', '".$profissao."', '".$sexo."', '".$estado_civil."', '".$email."', '".$telefone."', 'Residencial', '".$celular."', 'Celular', '".$endereco."', '".$numero."', '".$bairro."', '".$cidade."', '".$uf."', '".$cep."','".$plano."','".$pagamento."','".$operador."', '".$tipoVenda."', '".$produto."', '".$data."', '".$data_venda."', '".$monitor."', '".$status."', '".$vencimento."', '".$pontos."' )";
			$count=1;
			if($count == 1){
				$result=mysql_query($sql);
				if($result){
					echo "ok";
				}
				$count=$count+1;
			}
			
		//if(isset($cpf)){ echo '<p id="cpf">'.$cpf.'</p>';}
		
		mysql_close($conexao) ; 
		
	}
	
	
	?>
