<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/PHPExcel/Classes/PHPExcel.php';

$path = $_SERVER['DOCUMENT_ROOT'] . '/doc-templates/template_act.xlsx';

$exel = PHPExcel_IOFactory::load($path);

echo $exel->getActiveSheet()->getCell('B3');