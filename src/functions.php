<?php

/**
* Вывод меню
* showMenu($menu, 'title', SORT_DESC, 'main-menu bottom')
*/
function showMenu(array $array, string $key, $sort, $className = '')
{
    require($_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php');
}

/**
* Сортировка массива
* arraySort($array, 'sort_key', SORT_ASC) по возрастанию
* arraySort($array, 'sort_key', SORT_DESC) по убыванию
*/
function arraySort(array $array, $key = 'sort', $sort = SORT_ASC): array
{
    array_multisort(array_column($array, $key), $sort, $array);

    return $array;
}

/**
* Если путь существует
* isCurrentUrl('/route/directory/') true
*/
function isCurrentUrl(string $url): bool
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $url;
}

/**
* Создаёт запись в файле, принимает масссив
*
*/
function setStorage(array $array, string $json): bool
{
    return file_put_contents( $json, json_encode($array) ) ? true : false;
}

/**
* Читает из файла JSON, возвращает масссив или false
* getStorage($_SERVER['DOCUMENT_ROOT'] . '/storage/json.json')
*/
function getStorage(string $json)
{
    if ( is_file($json) ) {
        return json_decode(file_get_contents($json), true);
    } else {
        return false;
    }
}

/**
 * Возвращает сумму прописью
 * num2str(1000.23)
 * num2str(1000)
 * 
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
    $outKop = $out;
    $outKop[] = $rub;
	$outKop[] = $kop . ' ' . morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
    
	return [
        'summ' => trim(preg_replace('/ {2,}/', ' ', join(' ', $out))), // сумма прописью без копеек
        'summKop' => trim(preg_replace('/ {2,}/', ' ', join(' ', $outKop))), // сумма прописью с копейками
        'rub' => $rub,
        'out' => $out
    ];
}

/**
 * Склоняем словоформу
 * 
 * morph(100, 'рубль', 'рубля', 'рублей')
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

/**
 * Пареобразует дату
 * 
 * @uses removeNull(string $str): string
 */
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

/**
 * удаляет ноль в начале
 */
function removeNull(string $str): string
{
    if (mb_substr($str, 0, 1) == '0') {
        return mb_substr($str, 1, 1);
    }

    return $str;
}

/**
 * Далает первую букву заглавной
 */
function ucfirst_utf8($str)
{
    return mb_substr(mb_strtoupper($str, 'utf-8'), 0, 1, 'utf-8') . mb_substr(mb_strtolower($str, 'utf-8'), 1, mb_strlen($str)-1, 'utf-8');
}
