<?php
$row = 1;
/*
if (($handle = fopen("test.csv", "r")) !== FALSE) {

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
      //  echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
        //    echo $c . ":" . $data[$c] . "<br />\n";
        }
    }
    fclose($handle);

}*/

$inputFileName = 'upload/'. $_POST['unique-filename']. '.csv';

$query = "INSERT INTO `planilha`(`id`, `A`, `B`, `C`, `D`, `E`, `F`, `G`, `H`, `I`, `J`, `K`, `L`, `M`, `N`, `O`, `P`) VALUES ";

if (($handle = fopen($inputFileName, "r")) !== FALSE) {
	
	//$data = fgetcsv($handle, 1000, ",");
	//var_dump($data);
    $insert = "";
	$linecont = 1;
    
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ( $insert == "") { $insert = "($linecont"; }else{ $insert  = ",($linecont"; }
        $linecont++;
        
        $num = count($data);
        //echo "<p> ". ftell($handle) ." $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num || $c<=15; $c++) {
            //echo $c . ":" . $data[$c] . "<br />\n";
            
            if ( $insert == "") { $insert = "("; }
            
            if( isset($data[$c]) )
            {
				$insert .= ( $c==0 ) ? ",'$data[$c]'" : ",'$data[$c]'";
			}else{
				$insert .= ( $c==0 ) ? "''" : ",''";
			}
            
        }
        $insert .= ")";
        
        $query .= $insert;
        
    }
    fclose($handle);


//echo $query.$insert;

$queryTable = "CREATE TEMPORARY TABLE `planilha` (
  `id` int NOT NULL,
  `A` varchar(255) NOT NULL,
  `B` varchar(255) NOT NULL,
  `C` varchar(255) NOT NULL,
  `D` varchar(255) NOT NULL,
  `E` varchar(255) NOT NULL,
  `F` varchar(255) NOT NULL,
  `G` varchar(255) NOT NULL,
  `H` varchar(255) NOT NULL,
  `I` varchar(255) NOT NULL,
  `J` varchar(255) NOT NULL,
  `K` varchar(255) NOT NULL,
  `L` varchar(255) NOT NULL,
  `M` varchar(255) NOT NULL,
  `N` varchar(255) NOT NULL,
  `O` varchar(255) NOT NULL,
  `P` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$conexao->query($queryTable);

//$conexao->query($query.$insert);
echo $query.$insert;
	function getCell($column, $row)
	{
		global $conexao;
		//echo "$column - $row";
		$column = strtoupper($column);

		$cell = $conexao->query("Select $column from planilha where id='$row'");

		return mysql_result($cell, 0);

	}


}

$objPlanilhas = new Qualidade($conexao);

$curTipoPlanilha = $_POST["tipoPlanilha"];
$planilha = $objPlanilhas->getPlanilha($curTipoPlanilha);

$camposPlanilhaCur = $planilha['colunas'];

$cntLines = $conexao->query("Select count(id) as c from planilha");

$totalLinhas = mysql_result($cntLines, 0);

?>

<?php
/* ini_set('max_input_vars', 36000);
ini_set('max_input_nesting_level', 36000);
ini_set('post_max_size', '200M');
 
ini_set('set_timeout', 0);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '300M');
ini_set('upload_max_filesize', '200M');
ini_set('max_execution_time', '36800');
ini_set('session.gc_maxlifetime', '36000');
 */
?>
<meta name="http-equiv" content="Content-type: text/html; charset=UTF-8"/>

<link rel="stylesheet" type="text/css" href="css/tables.css" />

<style type="text/css">

	.up-falho {
		
		color:#FF0000;
		
	}

	.up-ok {
		
		color:#1C8C1C;
		
	}

</style>

<script type="text/javascript">
	
	$(window).load( function() {
		
		$('.btSalvar').css('display', 'block');
	});
	
	$(document).ready( function() {
		$('.btSalvar').css('display', 'none');
		
		$('.btSalvar').bind('click', function() {

			totForm = $('.saveform').length;
			
			$( ".saveform" ).each(function( index ) {

				var objForm = $(this);
				var serializedData = $(this).serialize();
				//alert(serializedData);
				$('html, body').animate({ scrollTop: 0 }, 'fast');
				request = $.ajax({
					
					url: "ajax/status-portal-update.php",
					async: false,
					type: "post",
					data: serializedData,
					success: function(data) {
						
						//alert(data);
						//$('input', this).remove();
						
						curForm = objForm.attr('data-formid');

						percent = (curForm*100) / totForm;
					
						$('#progress-bar').css('display', 'block');
						$('#load-bar').css('width', percent+'%');
						$('#load-label').html('Dados ' + percent + '% salvos.');
						
						if ( percent == 100 )
						{
							$('.btSalvar').css('display', 'none');
							
						}
						
					}
					});

			});
		});
	});

</script>

<div id="label-importacao" style="width:98%; margin-left:10px; margin-top:10px; font-size:14px; color:#999;">
<b>Importando arquivo:</b> <?php echo $_POST["original-filename"]; ?>
<br />

<b>Tipo de Planilha:</b> <?php echo $planilha['label']; ?>
</div>

<div id="progress-bar" style=" display: none; overflow:hidden; border:1px solid #E5E5E5; margin-left:10px;width:98%; position:relative;  float:left; margin-bottom:15px;margin-top:15px;">
	
	<span id="load-bar" style="display:block; width:0%; background-color:#E5E5E5; position:absolute;height:20px;padding:3px;"></span>
	<span id="load-label" style="color:#7F7F7F; position:relative;height:20px;padding:3px;display:block;"></span>

</div>

<div id="import" style="display:block; position:relative; float:right; margin-right:27px;margin-bottom:15px;">
	<input type="button" value="Salvar Dados" name='salvar' class='btSalvar' style="display:none"; />
</div>

<br style="clear:both" />
<center>
<table id="tabela-status-importacao" width="96%">
	<form class="saveform" data-formid="1">
	<tr style="padding-top:5px; padding-bottom:3px; background-color:#565656; text-align:center;color:#FFF; font-size:14px; font-weight:bold;" class="tr1">
		
		<td style="width:50px;">LINHA</td>
		
		<?php 
		foreach($camposPlanilhaCur as $key=>$value)
		{

		?>
		
		<td>
		<?php 
			if(strstr($value, "data"))
			{
			
			$col_name = "DATA " . $planilha['status'];
			echo strtoupper($col_name);

			}else{

			echo getCell($key, "1");
				
			}
			

			?>
		</td>

		<?php
		}
		?>
		
		<td style="width:80px">STATUS</td>
	</tr>
	
	<?php
	
	$insertLine = array();
	$insertLine['Qualidade'] = array();
	$linecont = 0;
	$formcont = 2;
	

	for($i=2; $i<=$totalLinhas; $i++)
	{
		$status = "up-ok";
		$cellVal = mb_strtoupper(getCell($key, $i), "UTF-8");
		if ( $i < $rowinicial ) { continue; }
		if($cellVal==""){  break; }

	?>
	
	<tr id="line-<?php echo $i;?>" style="display:table-row" class="tb-line">
		
		<td><?php echo $i-1; ?></td>
				
		<?php
		$updateArray = array();
		$updateArray['status_portal'] = $curTipoPlanilha;
		
		foreach($camposPlanilhaCur as $key=>$value)
		{
		?>
		
		<td>
		
			<?php

				$cellVal = mb_strtoupper(getCell($key, $i), "UTF-8");

				if(strstr($value, "novo_numero") || strstr($value, "Numero"))
				{
					//$cellVal = (int) $cellVal;
					Qualidade::maskTel($cellVal);
					
					$updateArray['novo_numero'] = $cellVal;
				}
				
				elseif(strstr($value, "status_data"))
				{
					if($curTipoPlanilha!=4 && $curTipoPlanilha!=5)
					{
						$cellVal = date("Y-m-d H:i:s", strtotime($cellVal));
												
						$updateArray["status_data"] = $cellVal;
						
					}else{
						
						$cellVal_toUp =  substr($cellVal, 0, 4) . "-" . substr($cellVal, 4, 2) . "-01 00:00:00";
						$updateArray["status_data"] = $cellVal_toUp;
						
						$cellVal = substr($cellVal, 4, 2) . "-" . substr($cellVal, 0, 4);
						
					}
				}elseif(strstr($value, "status_xerox"))
				{

						if(strstr($cellVal, "SEM"))
						{
							$updateArray["status_xerox"] = 0;
						
						}else{
							$updateArray["status_xerox"] = 1;
						}
						
				}elseif($value == "os")
				{

					$updateArray["os"] = $cellVal;
						
				}
				
				echo $cellVal;
				
			?>
		
		</td>
		
		<?php
		}
		
		//array_push($insertLine['Qualidade'], $updateArray);
		
		?>
		<?php
		
		foreach($camposPlanilhaCur as $key=>$value)
		{
		
		echo "\n<input type=\"hidden\" name=\"Qualidade[" . ($linecont) . "][" . $value . "]\" value=\"" . $updateArray[$value] . "\">";
		echo "\n<input type=\"hidden\" name=\"Qualidade[" . ($linecont) . "][status_portal]\" value=\"" . $curTipoPlanilha . "\">";


		}

		?>

		<?php $linecont++; ?>
		
		<?php
		if ( $linecont >= 500 )
		{
			
			echo "</form>";
			echo "<form name=\"save" . time() . "\" class=\"saveform\" data-formid=\"" . $formcont . "\">";
			
			$formcont++;
			$linecont = 0;
		}
		?>
		<td id="<?php echo $i;?>" class="<?php echo $status; ?>">OK</td>
		
	</tr>
	<?php

		
	}
	?>
	</form>
</table>
<div id="numero_linhas" style="display:block; position:relative; margin-top:20px; float:left; margin-left:27px;margin-bottom:15px;">
	Total de linhas: <span class='totallinhas'><?php echo $totalLinhas-1; ?></span>
</div>

<div id="import" style="display:block; position:relative; margin-top:20px; float:right; margin-right:27px;margin-bottom:15px;">
	<input type="button" value="Salvar Dados" name='salvar' class='btSalvar' style="display:none"; />
</div>

</center>
<?php
//var_dump($objPHPExcel);
//echo "..as";
//$loadedSheetNames = $objPHPExcel->getSheetNames();
//var_dump($loadedSheetNames);

/*foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)

{
	echo "<br><br>ROW: " . $worksheet->getHighestRow(); 
    echo "<br>COL: " .  $worksheet->getHighestColumn();
    echo "<br>COL Index: ".  PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());
}*/

//print_r($_POST);

?>
