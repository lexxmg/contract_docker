<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$contract = htmlspecialchars($_POST['contract'] ?? '');
$dateStart = htmlspecialchars($_POST['dateStart'] ?? '');
$dateEnd = htmlspecialchars($_POST['dateEnd'] ?? '');
$summ = htmlspecialchars($_POST['summ'] ?? '');
$fierstSumm = htmlspecialchars($_POST['fierstSumm'] ?? '');

//$contract = '3'; // Номер договора
//$dateStart = '01.07.2024'; // Дата начала договора +3
// $dateEnd = '25.09.2024'; // Дата окончания договора
// $summ = 220000; // Сумма всего
// $fierstSumm = 195000; // Первая сумма к выплате


$fierstSummRub = num2str($fierstSumm)['rub'];
$rub = num2str($summ)['rub']; // Склонение рубля

$month = dateConvert($dateStart)['month'];
$yaer = dateConvert($dateStart)['year'];

$pathContrac = $_SERVER['DOCUMENT_ROOT'] . '/doc-templates/template_contract.docx';
$pathStarage = $_SERVER['DOCUMENT_ROOT'] . '/storage/contract/';
$fileName = "Договор № $contract-$month.$yaer уд-го обслуживания АТС билллинг АТС ТЕЛЕКОМПРОЕКТ.docx";

$arrFiles = preg_grep( '/^([^.])/', scandir($pathStarage) );

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
$phpWord->setValue('dateStartStringMonth', dateConvert($dateStart)['stringMonth']);
$phpWord->setValue('dateStartNumDate', dateConvert($dateStart)['numDate']);
$phpWord->setValue('dateStartMonth', $month);
$phpWord->setValue('dateStartYear', $yaer);
$phpWord->setValue('dateStartDate', dateConvert($dateStart)['stringDate']);

$phpWord->setValue('dateEndNumDate', dateConvert($dateEnd)['numDate']);

$phpWord->saveAs($_SERVER['DOCUMENT_ROOT'] . '/storage/contract/' . $fileName);

// Saving the document as OOXML file...
// $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
// $objWriter->save('helloWorld.docx');

// Saving the document as ODF file...
// $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
// $objWriter->save('helloWorld.odt');
/**
 * Возвращает сумму прописью
 * @author runcore
 * @uses morph(...)
 */
function num2str($num)
{
	$nul = 'ноль';
	$ten = array(
		array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),
		array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')
	);
	$a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');
	$tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');
	$hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');
	$unit = array(
		array('копейка' , 'копейки',   'копеек',     1),
		array('рубль',    'рубля',     'рублей',     0),
		array('тысяча',   'тысячи',    'тысяч',      1),
		array('миллион',  'миллиона',  'миллионов',  0),
		array('миллиард', 'миллиарда', 'миллиардов', 0),
	);

	list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub) > 0) {
		foreach (str_split($rub, 3) as $uk => $v) {
			if (!intval($v)) continue;
			$uk = sizeof($unit) - $uk - 1;
			$gender = $unit[$uk][3];
			list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));
			// mega-logic
			$out[] = $hundred[$i1]; // 1xx-9xx
			if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; // 20-99
			else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; // 10-19 | 1-9
			// units without rub & kop
			if ($uk > 1) $out[] = morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
		}
	} else {
		$out[] = $nul;
	}
    $rub = morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
	//$out[] = morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
	//$out[] = $kop . ' ' . morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
	return ['summ' => trim(preg_replace('/ {2,}/', ' ', join(' ', $out))), 'rub' => $rub];
}

/**
 * Склоняем словоформу
 * @author runcore
 */
function morph($n, $f1, $f2, $f5)
{
	$n = abs(intval($n)) % 100;
	if ($n > 10 && $n < 20) return $f5;
	$n = $n % 10;
	if ($n > 1 && $n < 5) return $f2;
	if ($n == 1) return $f1;
	return $f5;
}

function dateConvert(string $date): array
{
    $dateArr = explode('.', $date);

    $month = [
        'января','февраля', 'марта',
        'апреля', 'мая', 'июня', 'июля',
        'августа', 'сентября', 'октября',
        'ноября', 'декабря'
    ];

    return [
        'numDate' => $date,
        'stringDate' => removeNull($dateArr[0]) . ' ' . $month[removeNull($dateArr[1]) - 1] . " $dateArr[2]",
        'stringMonth' => $month[removeNull($dateArr[1]) - 1],
        'dayNull' => $dateArr[0],
        'day' => removeNull($dateArr[0]),
        'month' => $dateArr[1],
        'year' => $dateArr[2]
    ];
}

function removeNull(string $str): string
{
    if (mb_substr($str, 0, 1) == '0') {
        return mb_substr($str, 1, 1);
    }

    return $str;
}

function ucfirst_utf8($str)
{
    return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr(mb_strtolower($str, 'utf-8'), 1, mb_strlen($str)-1, 'utf-8');
}


if (false) {
	// Контент-тип означающий скачивание
	header("Content-Type: application/octet-stream");

	// Размер в байтах
	header("Accept-Ranges: bytes");

	// Размер файла
	header("Content-Length: " . filesize($fileName));

	// Расположение скачиваемого файла
	header("Content-Disposition: attachment; filename=" . $fileName);

	// Прочитать файл
	readfile($fileName);
}

//unlink($fileName);

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '/';
header("Location: http://$host/$extra");

echo $fileName;
echo '<br>';
echo ucfirst_utf8(num2str($summ)['summ']);
echo '<br>';
echo $rub;
echo '<br>';
echo num2str($fierstSumm)['summ'];
echo '<br>';
echo $fierstSummRub;
echo '<br>';
echo dateConvert($dateEnd)['stringDate'];
echo '<br>';
echo dateConvert($dateStart)['dayNull'];
echo '<br>';

print_r($arrFiles);


echo $host;
echo $extra;
echo '<br>';
echo $uri;
exit();