<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


<tr id="agendentregaarea">
<td><b>Agend. Entrega:</b></td>
<td>
<? 

$dataAgendada0 = explode('-',$linha['agendEntrega']);
$dataAgendada = substr($dataAgendada0[2],0,2).'/'.$dataAgendada0[1].'/'.$dataAgendada0[0];

$horaAgendada0 = explode(':',$linha['agendEntrega']);
$horaAgendada = substr($horaAgendada0[0],-2,2);
$minutoAgendado = $horaAgendada0[1];

if($_GET['e'] == '1' && $USUARIO['inserir_gravacao'] == '1'){
	
?>

<input type="text" id="agendaentrega" name="agendaentrega"  onKeyUp="validadata(this.value,agendaentrega)" onKeyPress="mascara(this,data)" maxlength="10" value="<? if($dataAgendada != '00/00/0000' && $dataAgendada != ''){ echo $dataAgendada;}?>" /> às 
<select name="agendaentregahora">
<option></option>
<? for($h=8;$h<22;$h++){?>
<option <? if($horaAgendada == sprintf("%02d", $h) && $dataAgendada != '00/00/0000' && $dataAgendada != ''){?>selected="selected"<? } ?>><?= sprintf("%02d", $h); ?></option>
<? } ?>

</select>
<b>:</b>
<select name="agendaentregaminutos">
<option></option>
<? for($m = 00;$m<60;$m=$m+5){?>
<option <? if($minutoAgendado == sprintf("%02d", $m) && $dataAgendada != '00/00/0000' && $dataAgendada != ''){?>selected="selected"<? } ?>><?= sprintf("%02d", $m); ?></option>
<? } ?>
</select>

<? } else{?>

<?= $dataAgendada; ?> <? if($horaAgendada > 7){ echo ' às '.$horaAgendada.':'.$minutoAgendado; }?>

<? } ?>

</td>
</tr>
