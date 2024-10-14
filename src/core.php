<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/main-menu.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/functions.php';

$pathStarage = $_SERVER['DOCUMENT_ROOT'] . '/storage';
$jsonContract = $_SERVER['DOCUMENT_ROOT'] . '/storage/data/contract.json';
$jsonAct = $_SERVER['DOCUMENT_ROOT'] . '/storage/data/act.json';

$dataContract = array(
	'contract' => 1,
	'dateStart' => '01.01.2024',
	'dateEnd' => '01.03.2024',
	'summ' => 220000,
	'fierstSumm' => 195000
);