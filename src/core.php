<?php

$pathStarage = $_SERVER['DOCUMENT_ROOT'] . '/storage';
$arrFilesContract = preg_grep( '/^([^.])/', scandir($pathStarage . '/contract') );
$arrFilesAct = preg_grep( '/^([^.])/', scandir($pathStarage . '/act') );
