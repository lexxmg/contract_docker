<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$start = dateConvert($dateStart)['stringDate'];
$end = dateConvert($dateEnd)['stringDate'];
$summ = ucfirst_utf8(num2str($summ)['summKop']);
$monthRod = dateConvert($dateEnd)['stringMonthRod'];
$set = htmlspecialchars($_POST['set'] ?? '0');

$path = $_SERVER['DOCUMENT_ROOT'] . '/doc-templates/template_act.xlsx';
$saveName = $_SERVER['DOCUMENT_ROOT'] . "/storage/act/Акт № $contract АТС ТЕЛЕКОМПРОЕКТ $monthRod $yaer.xlsx";

$tableJson = getStorage($jsonAct);

// $reader = IOFactory::createReader('Xlsx');
// $spreadsheet = $reader->load($path);
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

//print_r($spreadsheet->getActiveSheet()->getCell('E3')->getValue());

$spreadsheet->getActiveSheet()->setCellValue('E3',$end);
$spreadsheet->getActiveSheet()->setCellValue('A5',
"   Общество с ограниченной ответственностью «ТЕЛЕКОМПРОЕКТ» в лице директора Зименкова Павла Валерьевича, действующего на основании Устава, именуемое в дальнейшем «Заказчик», с одной стороны, и гражданин Российской Федерации Кочергин Алексей Игоревич, являющейся плательщиком налога на профессиональный доход, именуемая в дальнейшем «Исполнитель», с другой стороны, составили настоящий Акт приемки оказанных услуг (далее  -  Акт) по Договору об оказании услуг от $start года № $contract-$month/$yaer (далее — Договор) о нижеследующем."
);
$spreadsheet->getActiveSheet()->setCellValue('A7',
"1. Во исполнение Договора Исполнитель в период с $start года по $end года оказал Заказчику следующие услуги по удалённой настройке оборудования и программного обеспечения."
);
$spreadsheet->getActiveSheet()->setCellValue('A17',$summ);

if ($tableJson) {
	$tableJson[$set]['wasUsed'] = dateConvert($dateStart)['numDate'];

	jsonToTable($set, $spreadsheet, $tableJson);
}  

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setIncludeCharts(true);
$writer->save($saveName);



/**
 * Замисывает в таблицу из JSON
 * 
 */
function jsonToTable(int $set, object $spreadsheet, array $tableJson = []): bool
{
	$abc = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
		'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
	);

	$corStartLetter = $tableJson[$set]['firstCor'][0];
	$corEndLetter = $tableJson[$set]['lastCor'][0];

	$corStartNum = intval( substr($tableJson[$set]['firstCor'], 1) );
	$corEndNum = intval( substr($tableJson[$set]['lastCor'], 1) );


	for ($i=0; $i < ($corEndNum + 1) - $corStartNum; $i++) { 
		foreach ($abc as $key => $letter) {
			if ($letter >= $corStartLetter) {
				$cellValue = $tableJson[$set]['data'][$i]['cell'][$key - 1];
				$spreadsheet->getActiveSheet()->setCellValue($letter . $i + $corStartNum, $cellValue);
			}

			if ($letter === $corEndLetter) {
				break;
			}
		}
	}

	return true;
}