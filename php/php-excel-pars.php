<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . '/src/core.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$path = $_SERVER['DOCUMENT_ROOT'] . '/doc-templates/template_act.xlsx';
// $saveName = $_SERVER['DOCUMENT_ROOT'] . "/storage/act/Акт № $contract АТС ТЕЛЕКОМПРОЕКТ $monthRod $yaer.xlsx";



// $reader = IOFactory::createReader('Xlsx');
// $spreadsheet = $reader->load($path);
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

$arrTable = getStorage($jsonAct);

echo '<pre>';
	print_r($arrTable);
echo '</pre>';

$arrTable = createJsonFromTable('B9', 'F15', 0, $spreadsheet);

setStorage($arrTable, $jsonAct);


echo '<pre>';
	//print_r(getStorage($jsonAct));
echo '</pre>';



/**
 * Создает JSON из таблицы
 * 
 */
function createJsonFromTable(string $corStart, string $corEnd, int $set, object $spreadsheet): array
{
	$abc = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
		'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
	);

	$tableJson = [];

	$corStartLetter = $corStart[0];
	$corEndLetter = $corEnd[0];

	$corStartNum = intval( substr($corStart, 1) );
	$corEndNum = intval( substr($corEnd, 1) );


	for ($i=0; $i < ($corEndNum + 1) - $corStartNum; $i++) { 
		$tableJson[$set]['wasUsed'] = 'did not use';
		$tableJson[$set]['data'][$i]['row'] = $i + 1;
		$tableJson[$set]['data'][$i]['sort'] = $i + 1;

		foreach ($abc as $key => $letter) {
			if ($letter >= $corStartLetter) {
				$tableJson[$set]['data'][$i]['cell'][$key] = $spreadsheet->getActiveSheet()->getCell($letter . $i + $corStartNum)->getCalculatedValue();
			}

			if ($letter === $corEndLetter) {
				break;
			}
		}
	}

	return $tableJson;
}