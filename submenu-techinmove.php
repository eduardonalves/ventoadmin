<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<table border="0" width="100%" class="submenu" cellspacing="0" onmouseover="loadsize(document.getElementById('pagesize').innerHTML);">
<tr align="center">
<td></td>

<td width="120px" style="cursor:pointer" <? if($_GET['p'] == 'techinmove'){?>class="submenuselected"<? }?> onClick="window.location = '?p=techinmove'">

Vendas
</td>

<? if($USUARIO['inserir_dados'] == 1){?>
<td width="150px" style="cursor:pointer" <? if($_GET['p'] == 'inserir-dados-techinmove'){?>class="submenuselected"<? }?> onClick="window.location = '?p=inserir-dados-techinmove'">
Inserir Dados
</td>
<? } ?>

<!-- 
<td width="140px" style="cursor:pointer" <? if($_GET['p'] == 'estatisticas-techinmove'){?>class="submenuselected"<? }?> onClick="window.location = '?p=estatisticas-techinmove'">
Estat&iacute;sticas
</td>
-->
<td></td>
</tr>
</table>
