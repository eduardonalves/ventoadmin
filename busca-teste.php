
<? include "conexao.php";?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Busca Teste</title>
</head>

<body style="font-family:Arial; text-transform:capitalize;">

<?
$i = 1;
$consult = $conexao->query("SELECT * FROM vendas_clarotv WHERE produto = '2' && status = 'GRAVAR' && data LIKE '%201210%'");
while($row = mysql_fetch_array($consult)){

$num = $i++;

echo 'Plano: '.$row['plano'].' | CPF:'.$row['cpf'].'<br>';


}

echo "<br><br>".$num;
?>


</body>
</html>