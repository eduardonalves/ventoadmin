<?php
ini_set('memory_limit', '1000M');
ini_set('max_execution_time','600');
?>
<meta charset="UTF-8">
<?php

require_once 'lib/PHPExcel/IOFactory.php';
require_once 'lib/PHPExcel.php';

$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
$cacheSettings = array( 'memoryCacheSize' => '10GB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

$inputFileName = 'upload/com2.xls';

$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
//$objReader = new PHPExcel_Reader_Excel5();
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
//$objReader = new PHPExcel();
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load($inputFileName);
$objPHPExcel->setActiveSheetIndex(0);

//echo $objPHPExcel->getActiveSheet()->getCellByColumnAndRow('C', 1)->getValue();
echo $objPHPExcel->getActiveSheet()->getCell('C1')->getValue();
$linhas = $objPHPExcel->getActiveSheet()->getHighestRow();
$colunas =  $objPHPExcel->getActiveSheet()->getHighestColumn();
echo "<br>Colunas: " . $colunas;


class MyReadFilter implements PHPExcel_Reader_IReadFilter
{
	
	private $minRow;
	private $maxRow;	

	public function __construct($row, $range=500) {
	
		$this->minRow = $row;
		$this->maxRow = ($row + $range) - 1;
	}

	public function readCell($column, $row, $worksheetName = '') {
		// Read title row and rows 20 - 30
		if ( $row >= $this->minRow && $row <= $this->maxRow ) {
			return true;
		}
		
		return false;
	}
}

//$objReader = new PHPExcel_Reader_Excel2007();

function loadRange($row=1){

global $objReader;
global $objPHPExcel;
global $inputFileName;

$objReader->setReadFilter( new MyReadFilter($row, 1500) );
$objPHPExcel = $objReader->load($inputFileName);

}

$a  = array();

$contadora = 1;

for ($i=1; $i <= 65000; $i++)
{
	
	if ( $i==1 || $contadora== 1500 ) {	
		
loadRange($i);
		$contadora = 1;
	}else{
	
		$contadora++;
	}


//echo 'B'.$i . " - " . $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getValue() . "<br>";
$t = $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getValue();
if ($t==NULL) { break; }
$a[$i]  = $t;
//$objPHPExcel->getActiveSheet()->getCellCacheController()->deleteCacheData('J' . $i);
}
echo "<pre>";
print_r($a);
echo "</pre>";

/*
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);

$objReader = PHPExcel_IOFactory::createReader($inputFileType); 

$objPHPExcel = $objReader->load($inputFileName);
$objWorksheet = $objPHPExcel->getActiveSheet();

$a = array();

foreach ($objWorksheet->getRowIterator() as $row) {
  $cellIterator = $row->getCellIterator();
  $cellIterator->setIterateOnlyExistingCells(false); 

  foreach ($cellIterator as $cell) {
    $a[] = $cell->getValue();
  }
echo "<pre>";
print_r($a);

echo "</pre>";
	/*
	Your cells contents here :
	$value_cell_A = $a[0];
	$value_cell_B = $a[1];
	...
	$value_cell_Z = $a[25];
	$value_cell_AA = $a[26];
        $value_cell_AB = $a[27];
        etc...

	then you can use them in this loop	
	*/

	// clear the array for the next line
	//unset($a);
//}



?>
