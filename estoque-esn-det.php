<!--Referencias -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.3.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/ui-lightness/jquery-ui-1.7.3.custom.css" />
<script type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="jquery.validate.js" type="text/javascript"></script>


<!-- Layout - COMEÇO --> 
<style type="text/css">
.erro{color:#C00; font-size:12px;}

#campoDinamico{width:850px;}


</style>
<!-- SUBMENU -->
<? include "submenu-clarofixo.php";?>
<!-- FIM DO SUBMENU -->

<? include ("menu-lateral-estoque-clarofixo.php"); ?>

<center>
    <table border="0" width="1000px">

        <tr valign="bottom" height="40px" align="left">
        <td style="font-size:14px; color:#999;">Detalhamento de ESNs</td>
        
        </tr>

        <tr>
        <td><hr size="1" color="#CCCCCC" /></td>
        </tr>

    </table>
<!-- Layout FIM -->




<!-- Formulário FIM -->
<div style="width:1000px; text-align:left; margin-bottom:30px;">

<form method="post">

<br />
<br />
<label for="esns" style="font-size:14px;">N&uacute;meros de ENS:<br /></label>
<br />
<textarea name="esns" style="width:1000px; height:100px; margin-left:0px;"><?php echo $_POST['esns']; ?></textarea>
<span style="float:left; margin-left:0px;font-size:12px">(Separe com virgula para mais de uma esn.)</span>
<input type="submit" value="Detalhar ESNs" style="float:right; margin-right:0px;" />

</form>

<br />
<br />

<?php

	if(isset($_POST['esns']))
	{
		echo "<table id=\"tb\" width=\"1000px\" paddging=\"5\" style=\"font-size:13px\">";

		echo "<tr align=\"left\" style=\"background-color:#CCCCCC;\">";
		echo "<th>Esn</th><th>Entrada como:</th><th>Entrada em:</th><th>Nota</th><th>Origem</th><th>Status Interno</th><th>Saida como:</th><th>Saida em:</th><th>Parceiro</th><th>Status Externo</th>";
		echo "</tr>";		

		$i = 0;
		
		$esns = explode(",", $_POST['esns']);
		
		foreach($esns as $key=>$esn)
		{
			
			$esn = strtoupper(trim($esn));
			$query = "SELECT ifnull(esne.esn,'-') as Esn, ifnull(concat(aparelhos.marca, ' - ', aparelhos.modelo), '-') as 'Entrada como:',
ifnull(DATE_FORMAT( entradas.data , '%d/%c/%Y %H:%i:%s' ), '-') as 'Entrada em:', ifnull(entradas.nf, '-') as Nota, ifnull(entradas.origem,'-') as Origem,
ifnull(esne.status,'-') as 'Status Interno',
ifnull(concat(aparelhossaida.marca, ' - ', aparelhossaida.modelo), '-') as 'Saida como:',
ifnull(DATE_FORMAT( saidas.data , '%d/%c/%Y %H:%i:%s' ), '-') as 'Saida em:',
usuarios.nome as Parceiro,
esns.status as 'Status Externo'
FROM ESNsEntradas esne
LEFT JOIN entradas ON (entradas.id_entrada=esne.id_entrada)
LEFT JOIN ESNsSaida esns ON (esns.esn=esne.esn)
LEFT JOIN saidas ON (saidas.id_saida=esns.id_saida)
LEFT JOIN usuarios ON (usuarios.id=saidas.id_parceiro)
LEFT JOIN itensEntrada itens ON (esne.id_entrada=itens.id_itensEntrada)
LEFT JOIN itenssaida ON (esns.id_saida=itenssaida.id_itenssaida)
LEFT JOIN aparelhos ON (aparelhos.id_aparelho=itens.id_aparelho)
LEFT JOIN aparelhos as aparelhossaida ON (aparelhossaida.id_aparelho=itenssaida.id_aparelho)
WHERE esne.esn='".$esn."' order by entradas.id_entrada desc, esns.id_esnssaida desc limit 1";


			$line = $conexao->query($query);

			if (mysql_num_rows($line)<=0)
			{

				
				$class=(($i%2)==0) ? "color:#717171" : "color:#717171";
				echo "<tr style=\"$class\">";
				echo "<td>" . trim($esn) . "</td>";
				echo "<td>" . "Nao foi dada entrada" . "</td>";
				echo "</tr>";
				
			}
			
			while ($detEsns = mysql_fetch_assoc($line))
			{
				
				$class=(($i%2)==0) ? "color:#717171" : "color:#717171";
				echo "<tr style=\"$class\">";
				
				foreach($detEsns as $key=>$value)
				{
					
					echo "<td>$value</td>";
				}
				
				echo "</tr>";

			}
		}

		echo "</table>";
	}

?>
</form>
</div>
</center>

