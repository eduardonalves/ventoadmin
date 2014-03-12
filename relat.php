<?php


    header("Content-type: text/html; charset=iso-8859-1", true);


//include "lib/class.controleEstoque.php";
//include "lib/class.Qualidade.php";
//include "lib/class.planilhaQualidade.php";
//include "lib/PHPExcel.php";
//include 'lib/PHPExcel/IOFactory.php';

$inputFileName = 'planilha.xlsx';

require_once 'PHPExcel/IOFactory.php';
require_once 'Classes/PHPExcel.php';
echo"..";

//$inputFileType = 'Excel5';
	//$inputFileType = 'Excel2007';

//	$inputFileType = 'Excel2003XML';
//	$inputFileType = 'OOCalc';
//	$inputFileType = 'Gnumeric';
$inputFileName = 'Classes/p1.xlsx';
$inputFileName = 'Classes/ve.xls';

$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' information using IOFactory with a defined reader type of ',$inputFileType,'<br />';

$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objPHPExcel = $objReader->load($inputFileName);
$objPHPExcel->setActiveSheetIndex(0);
//$cell = $worksheet->getCellByColumnAndRow(, 1);
//echo $cell->getValue();
//echo objPHPExcel->getTitle();
echo $objPHPExcel->getSheetCount();
echo $objPHPExcel->getActiveSheet()->getCell("B2");
;
//var_dump($objPHPExcel);
echo "..as";
//$loadedSheetNames = $objPHPExcel->getSheetNames();
//var_dump($loadedSheetNames);

foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)

{
	echo "<br><br>ROW: " . $worksheet->getHighestRow(); 
    echo "<br>COL: " .  $worksheet->getHighestColumn();
    echo "<br>COL I: ".  PHPExcel_Cell::columnIndexFromString($worksheet->getHighestColumn());
}
//echo $objPHPExcel->getActiveSheet();

// SOMENTE PARA EXCEL5
//$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//print_r($sheetData);

echo "<br><br><br><br>";
//$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//var_dump($sheetData);

spl_autoload_register("autoload");

function autoload($class) {
    
    
    include_once "lib/class." . $class . ".php";

}

$qualit = new planilhaQualidade(1);


//print_r(array_diff($a,$b));

$qualit->gravaa();

echo "<br><br>";


//echo $qualit->getStatusCode("sem intenção");

$estoque = new controleEstoque($conexao);


$parceiros = $estoque->getParceirosComSaidas();

//print_r($parceiros);

foreach($parceiros as $parceiro)
{
	
	echo "<br><br>";
	echo "<br><br>Parceiro: " . $parceiro["nome"] . " / " . $estoque->getQuantTotalParceiroEstoque($parceiro["id"]);
	
	$saidas = $estoque->getSaidas("id_parceiro ASC", "", "", $parceiro["id_parceiro"]);




foreach($saidas as $t)
{
	
	$itens = $estoque->getItensDeSaida($t["id_saida"], "", "", "itens.id_aparelho");
	//print_r($itens);
	
	echo "<br><br>";
	/*
	foreach($itens as $item)
	{
		
		echo "Parceiro: " . $t["parceiro"] . "<br>";
		echo "Item de ".$t["id_saida"].": " . $item["id_itenssaida"] . " " . $item["marca"] . " - " . $item["modelo"];
		echo "<br>";
		
	}
	*/
}






}

//$l2 = $estoque->getQuantTotalParceiro(10);
//print_r($l2);


echo "a";
$t = explode(",", "1,10");
echo count($t);
foreach($t as $d)
{
echo $d;
}
?>
