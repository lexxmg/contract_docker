<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
// require_once $_SERVER['DOCUMENT_ROOT'] . '/src/core.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$path = $_SERVER['DOCUMENT_ROOT'] . '/doc-templates/template_act.xlsx';
// $saveName = $_SERVER['DOCUMENT_ROOT'] . "/storage/act/Акт № $contract АТС ТЕЛЕКОМПРОЕКТ $monthRod $yaer.xlsx";



// $reader = IOFactory::createReader('Xlsx');
// $spreadsheet = $reader->load($path);
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

$firstCor = htmlspecialchars($_POST['firstCor'] ?? 'A1');
$lastCor = htmlspecialchars($_POST['lastCor'] ?? 'A1');

//print_r($_POST);
$arrTable = getStorage($jsonAct);

if (isset($_POST['delete']))	{
	//echo $_POST['key'];
	unset($arrTable[$_POST['key']]);
	$arrTable = array_values($arrTable);
	setStorage($arrTable, $jsonAct);
	//$arrTable = getStorage($jsonAct);
}

if (isset($_POST['edit']))	{
	$arrTable[$_POST['key']]['edit'] = true;
	setStorage($arrTable, $jsonAct);
}

if (isset($_POST['saveEdit']))	{
	$set = $_POST['set'];
	foreach ($_POST as $key => $value) {
		$arrKey = explode('_', $key);
		if ( $arrKey[0] === 'row' ) {
			$arrTable[$set]['data'][$arrKey[1]]['cell'] = $value;
		}
	}
	$arrTable[$set]['edit'] = false;
	setStorage($arrTable, $jsonAct);
}


if ($arrTable) {
	//$arrTable = createJsonFromTable('D10', 'D15', 4, $spreadsheet, $arrTable);	
} else {
	//$arrTable = createJsonFromTable('B9', 'F15', 0, $spreadsheet);
}

if (isset($_POST['getTable'])) {
	$newTable = createJsonFromTable($firstCor, $lastCor, 0, $spreadsheet);
}

if (isset($_POST['cencelTable'])) {
	$newTable = null;
}

if (isset($_POST['addTable'])) {
	if ($arrTable) {
		$count = count($arrTable);
		$arrTable = createJsonFromTable($firstCor, $lastCor, $count, $spreadsheet, $arrTable);
		setStorage($arrTable, $jsonAct);
	} else {
		$arrTable = createJsonFromTable($firstCor, $lastCor, 0, $spreadsheet);
		setStorage($arrTable, $jsonAct);
	}
}


// $arrTable = getStorage($jsonAct);
// if ($arrTable) {
// 	$arrTable = createJsonFromTable('D10', 'D15', 4, $spreadsheet, $arrTable);	
// } else {
// 	$arrTable = createJsonFromTable('B9', 'F15', 0, $spreadsheet);
// }
// 
// $arrTable[0]['data'][6]['cell'][4] = 346;
// $arrTable[1]['data'][6]['cell'][4] = 26634;
// $arrTable[2]['data'][6]['cell'][4] = 9160;

// echo '<pre>';
// print_r($arrTable);
// echo '</pre>';

//setStorage($arrTable, $jsonAct);




/**
 * Создает JSON из таблицы
 * 
 */
function createJsonFromTable(string $corStart, string $corEnd, int $set, object $spreadsheet, array $tableJson = []): array
{
	$abc = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
		'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
	);

	$corStartLetter = $corStart[0];
	$corEndLetter = $corEnd[0];

	$corStartNum = intval( substr($corStart, 1) );
	$corEndNum = intval( substr($corEnd, 1) );


	for ($i=0; $i < ($corEndNum + 1) - $corStartNum; $i++) { 
		$tableJson[$set]['wasUsed'] = 'did not use';
		$tableJson[$set]['firstCor'] = $corStart;
    $tableJson[$set]['lastCor'] = $corEnd;
		$tableJson[$set]['edit'] = false;
		$tableJson[$set]['data'][$i]['row'] = $i + 1;
		$tableJson[$set]['data'][$i]['sort'] = $i;

		foreach ($abc as $key => $letter) {
			if ($letter >= $corStartLetter) {
				$tableJson[$set]['data'][$i]['cell'][$key - 1] = $spreadsheet->getActiveSheet()->getCell($letter . $i + $corStartNum)->getCalculatedValue();
			}

			if ($letter === $corEndLetter) {
				break;
			}
		}
	}

	return $tableJson;
}