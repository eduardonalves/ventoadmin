<?php
include_once('conexao.php');

ini_set('memory_limit', '1000M');
ini_set('max_execution_time','600');
?>
<meta charset="UTF-8">

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

$inputFileName = 'upload/'. $_POST['unique-filename']. '.xls';
$inputFileName = 'upload/com2.xls';

$query = "INSERT INTO `planilha`(`id`, `A`, `B`, `C`, `D`, `E`, `F`, `G`, `H`, `I`, `J`, `K`, `L`, `M`, `N`, `O`, `P`, `Q`, `R`, `S`, `T`, `U`, `V`, `W`, `X`, `Y`, `Z`) VALUES ";

require_once 'lib/PHPExcel/IOFactory.php';
require_once 'lib/PHPExcel.php';

$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
$cacheSettings = array( 'memoryCacheSize' => '10GB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

$inputFileName = 'upload/com2.xls';
echo "a";
//$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = new PHPExcel_Reader_Excel5();
echo "b";
//$objReader = PHPExcel_IOFactory::createReader($inputFileType);

$objReader->setReadDataOnly(true);
echo "c";
//$objPHPExcel = $objReader->load($inputFileName);
echo "d";
//$objPHPExcel->setActiveSheetIndex(0);

//echo $objPHPExcel->getActiveSheet()->getCellByColumnAndRow('C', 1)->getValue();
//echo $objPHPExcel->getActiveSheet()->getCell('C1')->getValue();
//$linhas = $objPHPExcel->getActiveSheet()->getHighestRow();

$colunas =  array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
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
$insert = "";

for ($i=1; $i <= 65000; $i++)
{
	
	if ( $i==1 || $contadora== 1500 ) {	
		
		loadRange($i);
		$contadora = 1;
		
	}else{
	
		$contadora++;
	}

	$insert .= ($insert=="") ? "('$i'" : ",('$i'";

//echo 'B'.$i . " - " . $objPHPExcel->getActiveSheet()->getCell('J' . $i)->getValue() . "<br>";

	foreach ( $colunas as $coluna )
	{

		$insert .= ",'" . $objPHPExcel->getActiveSheet()->getCell($coluna . $i)->getValue() . "'";
		
	}
	
	$insert .= ")";
//$objPHPExcel->getActiveSheet()->getCellCacheController()->deleteCacheData('J' . $i);
}


echo $query.$insert;
die();

?>
