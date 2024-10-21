<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/functions.php';

$jsonAct = $_SERVER['DOCUMENT_ROOT'] . '/storage/data/act.json';

$set = htmlspecialchars($_POST['set'] ?? '0');

//$v = json_decode(file_get_contents("php://input"), true);

//echo json_encode($_POST);
$arrTable = getStorage($jsonAct);

if ($arrTable) {
  echo json_encode($arrTable[$set]);
}
