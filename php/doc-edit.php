<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/core.php';

$contract = htmlspecialchars($_POST['contract'] ?? '');
$dateStart = htmlspecialchars($_POST['dateStart'] ?? '');
$dateEnd = htmlspecialchars($_POST['dateEnd'] ?? '');
$summ = htmlspecialchars($_POST['summ'] ?? '');
$fierstSumm = htmlspecialchars($_POST['fierstSumm'] ?? '');

$dataContract = [
	'contract' => $contract,
	'dateStart' => $dateStart,
	'dateEnd' => $dateEnd,
	'summ' => $summ,
	'fierstSumm' => $fierstSumm
];

setStorage($dataContract, $jsonContract);


//$contract = '3'; // Номер договора
//$dateStart = '01.07.2024'; // Дата начала договора +3
// $dateEnd = '25.09.2024'; // Дата окончания договора
// $summ = 220000; // Сумма всего
// $fierstSumm = 195000; // Первая сумма к выплате


$fierstSummRub = num2str($fierstSumm)['rub'];
$rub = num2str($summ)['rub']; // Склонение рубля

$month = dateConvert($dateStart)['month'];
$monthString = dateConvert($dateStart)['stringMonth'];
$monthStringEnd = dateConvert($dateEnd)['stringMonth'];
$yaer = dateConvert($dateStart)['year'];

$pathContrac = $_SERVER['DOCUMENT_ROOT'] . '/doc-templates/template_contract.docx';
$pathAct = $_SERVER['DOCUMENT_ROOT'] . '/doc-templates/template_act.docx';
$pathStarage = $_SERVER['DOCUMENT_ROOT'] . '/storage/contract/';
$fileName = "Договор № $contract-$month.$yaer уд-го обслуживания АТС билллинг АТС ТЕЛЕКОМПРОЕКТ.docx";


//$arrFiles = preg_grep( '/^([^.])/', scandir($pathStarage) );

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\TemplateProcessor($pathContrac);

/* Note: any element you append to a document must reside inside of a Section. */
//$document = $PHPWord->loadTemplate('Template.docx');
$phpWord->setValue('summ', "$summ");
$phpWord->setValue('summString', ucfirst_utf8(num2str($summ)['summ']));
$phpWord->setValue('rub', $rub);
$phpWord->setValue('fierstSumm', "$fierstSumm");
$phpWord->setValue('fierstSummString', ucfirst_utf8(num2str($fierstSumm)['summ']));
$phpWord->setValue('fierstSummRub', $fierstSummRub);

$phpWord->setValue('contract', $contract);

$phpWord->setValue('dateStartDayNumNull', dateConvert($dateStart)['dayNull']);
$phpWord->setValue('dateStartStringMonth', $monthString);
$phpWord->setValue('dateStartNumDate', dateConvert($dateStart)['numDate']);
$phpWord->setValue('dateStartMonth', $month);
$phpWord->setValue('dateStartYear', $yaer);
$phpWord->setValue('dateStartDate', dateConvert($dateStart)['stringDate']);

$phpWord->setValue('dateEndNumDate', dateConvert($dateEnd)['numDate']);

$phpWord->saveAs($_SERVER['DOCUMENT_ROOT'] . '/storage/contract/' . $fileName);

require $_SERVER['DOCUMENT_ROOT'] . '/php/php-excel.php';


// Saving the document as OOXML file...
// $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $objWriter->save('helloWorld.docx');

// Saving the document as ODF file...
// $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
// $objWriter->save('helloWorld.odt');

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '/';
header("Location: http://$host");