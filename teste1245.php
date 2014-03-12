<html>
<head>
<title>Teste</title>
<script type="text/javscript" src="js/jquery.js"></script>

<?php

phpinfo();
	// Aqui entra o action do formulário - pra onde os dados serão enviados
	$cURL = curl_init('http://172.16.0.31');
	curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);

	// Definimos um array seguindo o padrão:
	//  '<name do input>' => '<valor inserido>'
	$dados = array(
		'login' => 'admin',
		'senha' =>1234,
		
	);

	// Iremos usar o método POST
	curl_setopt($cURL, CURLOPT_POST, true);
	// Definimos quais informações serão enviadas pelo POST (array)
	curl_setopt($cURL, CURLOPT_POSTFIELDS, $dados);
    curl_setopt($cURL, CURLOPT_REFERER, 'http://172.16.0.31');

 
   
    $resultado = curl_exec($cURL);
    var_dump($resultado);
    curl_close($cURL);


?>


</head>
<body>
</body>

</html>