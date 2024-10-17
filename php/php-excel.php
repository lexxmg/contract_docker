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

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setIncludeCharts(true);
$writer->save($saveName);


$tableJson = getStorage($jsonAct);

if ($tableJson) {
	$tableJson[$set]['wasUsed'] = dateConvert($dateStart)['numDate'];
  $tableJson[$set]['data'][6] = [
		'row' => 8,
		'sort' => 3,
		'cell' => [
				'новая строка',
				'шт.',
				'17',
				'3000',
				'51'
		]
	];
	setStorage($tableJson, $jsonAct);
} else {
	setStorage($table, $jsonAct);
}