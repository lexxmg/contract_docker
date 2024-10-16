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

echo '<pre>';
	print_r(createJsonFromTable('A10', 'F17', $spreadsheet));
echo '</pre>';

setStorage(createJsonFromTable('A9', 'F17', $spreadsheet), $jsonAct);

if (false) {
	$tableJson = getStorage($jsonAct);

	if ($tableJson) {
		$tableJson[0][0]['wasUsed'] = dateConvert('01.01.2024')['numDate'];
		$tableJson[0][] = [
			'row' => 8,
			'sort' => 3,
			'cell' => [
					'новая строка',
					'шт.',
					'17',
					'3000',
					'51000'
			]
		];
		setStorage($tableJson, $jsonAct);
	} else {
		setStorage($table, $jsonAct);
	}
}

/**
 * Создает JSON из таблицы
 * 
 */
function createJsonFromTable(string $corStart, string $corEnd, object $spreadsheet): array
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
		foreach ($abc as $key => $letter) {
			if ($letter >= $corStartLetter) {
				$tableJson[0][$i]['wasUsed'] = 'did not use';
				$tableJson[0][$i]['row'] = $i + 1;
				$tableJson[0][$i]['sort'] = $i + 1;
				$tableJson[0][$i]['cell'][$key] = $spreadsheet->getActiveSheet()->getCell($letter . $i + $corStartNum)->getValue();
			}

			if ($letter === $corEndLetter) {
				break;
			}
		}
	}

	return $tableJson;
}