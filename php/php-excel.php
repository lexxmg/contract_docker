<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

$path = $_SERVER['DOCUMENT_ROOT'] . '/doc-templates/template_act.xlsx';

// $reader = IOFactory::createReader('Xlsx');
// $spreadsheet = $reader->load($path);
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);

//print_r($spreadsheet->getActiveSheet()->getCell('E3')->getValue());

$spreadsheet->getActiveSheet()->setCellValue('E3',dateConvert($dateEnd)['stringDate']);
$spreadsheet->getActiveSheet()->setCellValue('A5',
"   Общество с ограниченной ответственностью «ТЕЛЕКОМПРОЕКТ» в лице директора Зименкова Павла Валерьевича, действующего на основании Устава, именуемое в дальнейшем «Заказчик», с одной стороны, и гражданин Российской Федерации Кочергин Алексей Игоревич, являющейся плательщиком налога на профессиональный доход, именуемая в дальнейшем «Исполнитель», с другой стороны, составили настоящий Акт приемки оказанных услуг (далее  -  Акт) по Договору об оказании услуг от 01 октября 2024 (новая дата) года № 4-10/2024 (далее — Договор) о нижеследующем."
);

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setIncludeCharts(true);
$writer->save($_SERVER['DOCUMENT_ROOT'] . "/storage/act/featuredemo.xlsx");

// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
// $writer->save($_SERVER['DOCUMENT_ROOT'] . "/storage/act/featuredemo.pdf");