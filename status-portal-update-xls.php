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
ini_set('max_execution_time', 0);
set_time_limit(0);
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

<?php
require_once 'lib/PHPExcel/IOFactory.php';
require_once 'lib/PHPExcel.php';

class MyReadFilter implements PHPExcel_Reader_IReadFilter 
{ 
    private $_startRow = 2; 
    private $_endRow   = 10; 
    private $_columns  = array('A', 'E'); 

    /**  Get the list of rows and columns to read  */ 
    public function __construct($startRow, $endRow, $columns) { 
        $this->_startRow = $startRow; 
        $this->_endRow   = $endRow; 
        $this->_columns  = $columns; 
    } 

    public function readCell($column, $row, $worksheetName = '') { 
        //  Only read the rows and columns that were configured 
        if ($row >= $this->_startRow && $row <= $this->_endRow) { 
            if (in_array($column,$this->_columns)) { 
                return true; 
            } 
        } 
        return false; 
    } 
} 

$camposPlanilhas = array();

$objPlanilhas = new Qualidade($conexao);

$curTipoPlanilha = $_POST["tipoPlanilha"];

//print_r($camposPlanilhaCur);

$inputFileName = 'upload/'. $_POST['unique-filename']. '.xls';

/*$objReader2 = new PHPExcel_Reader_Excel5();
$objReader2->setReadDataOnly(true);
$objPHPExcel2 = $objReader2->load($inputFileName);
$objPHPExcel2->setActiveSheetIndex(0);
*/
//$objReader = new PHPExcel_Reader_Excel5();
//$objReader = new PHPExcel();
//$objReader->setReadDataOnly(true);
//$objPHPExcel = $objReader->load($inputFileName);
//$objPHPExcel->setActiveSheetIndex(0);

//echo $objPHPExcel->getActiveSheet()->getCellByColumnAndRow('A', 1)->getValue();
function xls_to_csv_files($xlsfile,$precalculate=true,$use_states=array('visible')){
    $objReader = new PHPExcel_Reader_Excel2007;
    $objReader->setReadDataOnly(true);
    $objPHPExcel = $objReader->load($xlsfile);
    // save csv files to same path as the xls.
    $dir = dirname($xlsfile);
    $base = basename($xlsfile,".xls");

    foreach ($objReader->getWorksheetIterator() as $i=>$worksheet) {
		if(in_array($wstate,$use_states)){
            $wtitle = $worksheet->getTitle();
            $objReader->setLoadSheetsOnly($wtitle);

            $objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
            $objWriter->setPreCalculateFormulas($precalculate);
            $writer->save($dir.'/'.$base.'-'.$wtitle.'.csv');
        }
    }
}

xls_to_csv_files("/" . $inputFileName);
echo "a";
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

	$objReader = "";			
	$objPHPExcel = "";
                /**  Load $inputFileName to a PHPExcel Object  **/ 

$rowinicial = 1;
$rowfinal = 500;

function loadRows ($inicio=1){

	global $objReader;
	global $inputFileName;
	global $objPHPExcel;
	global $inputFileType;
	global $rowinicial;
	global $rowfinal;

	$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
	$objReader->setReadDataOnly(true);
	
	$filterSubset = new MyReadFilter($rowinicial,$rowfinal,range('A','O'));
	$objReader->setReadFilter($filterSubset);
	$objPHPExcel = $objReader->load($inputFileName);
    //$sheetData = $objPHPExcel->getActiveSheet()->toArray(NULL,true,true,true);
    
    echo "<pre>";
    //var_dump($sheetData);
    echo "</pre>";
}

	loadRows();
//echo $objPHPExcel->getActiveSheet()->getCellByColumnAndRow('A', 1)->getValue();
/*

$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
//echo 'Carregando ',pathinfo($inputFileName,PATHINFO_BASENAME),' information using IOFactory with a defined reader type of ',$inputFileType,'<br />';
echo "bb";
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
echo "$inputFileName";
$objPHPExcel = $objReader->load($inputFileName);
echo "dd";
$objPHPExcel->setActiveSheetIndex(0);
echo "ee";
*/

//$cell = $worksheet->getCellByColumnAndRow(, 1);
//echo $cell->getValue();
//echo objPHPExcel->getTitle();
//echo $objPHPExcel->getSheetCount();
//echo $objPHPExcel->getActiveSheet()->getCell("B2");

$totalLinhas = 65536;
//echo "Numero de linhas:" . $objPHPExcel->getActiveSheet()->getHighestRow();

$planilha = $objPlanilhas->getPlanilha($curTipoPlanilha);

$camposPlanilhaCur = $planilha['colunas'];

?>
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
		
		<td><?php 
		
			if(strstr($value, "data"))
			{
			
			$col_name = "DATA " . $planilha['status'];
			echo mb_strtoupper($col_name, "UTF-8");
			
			}else{
			
			echo mb_strtoupper($objPHPExcel->getActiveSheet()->getCell($key . "1"), "UTF-8");
			
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
		$cellVal = mb_strtoupper($objPHPExcel->getActiveSheet()->getCell($key . $i), "UTF-8");
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

				$cellVal = mb_strtoupper($objPHPExcel->getActiveSheet()->getCell($key . $i), "UTF-8");

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
		if( ($linecont+1)==500 )
		{
			$rowinicial += 500;
			
			$rowfinal = ( ($rowinicial + 500) > 65536 ) ? 65536 : $rowinicial + 500;
			echo "<td> $rowinicial / $rowfinal </td>";
			loadRows();
		}
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
