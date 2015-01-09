<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<table border="0" width="100%" class="submenu" cellspacing="0" onmouseover="loadsize(document.getElementById('pagesize').innerHTML);">
<tr align="center">
<td></td>

<td width="120px" style="cursor:pointer" <? if($_GET['p'] == 'clarofixo'){?>class="submenuselected"<? }?> onClick="window.location = '?p=clarofixo'">

Vendas
</td>

<? if($USUARIO['inserir_dados'] == 1){?>
<td width="150px" style="cursor:pointer" <? if($_GET['p'] == 'inserir-dados-consulta-clarofixo'){?>class="submenuselected"<? }?> onClick="window.location = '?p=inserir-dados-consulta-clarofixo'">
Consulta
</td>

<td width="150px" style="cursor:pointer" <? if($_GET['p'] == 'inserir-dados-clarofixo'){?>class="submenuselected"<? }?> onClick="window.location = '?p=inserir-dados-clarofixo'">
Inserir Dados
</td>
<? } ?>

<td width="140px" style="cursor:pointer" <? if($_GET['p'] == 'estatisticas-clarofixo'){?>class="submenuselected"<? }?> onClick="window.location = '?p=estatisticas-clarofixo'">
Estat&iacute;sticas
</td>

<?

if($USUARIO["tipo_usuario"]!="AUDITOR" || $USUARIO["id"] == 3)
{
	?>
	
<td width="120px" style="cursor:pointer" <? if($_GET['p'] == 'index-estoque-clarofixo'){?>class="submenuselected"<? }?> onClick="window.location = '?p=index-estoque-clarofixo'">

ESTOQUE
</td>
	<?
	}
	?>

<td></td>
</tr>
</table>
