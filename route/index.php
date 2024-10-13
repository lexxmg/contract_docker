
<?php
require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$isPath = false;

foreach ($menu as $key => $value) {
    if ($value['path'] === $path) {
        $p = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) )[2];
        require $_SERVER['DOCUMENT_ROOT'] . "/templates/$p.php";
        $isPath = true;
    }
}

if (!$isPath) {
   require $_SERVER['DOCUMENT_ROOT'] . '/templates/error.php';
}

require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';