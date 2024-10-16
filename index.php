
<?php require($_SERVER['DOCUMENT_ROOT'] . '/templates/header.php') ?>

<? if (is_dir($pathStarage)): ?>
  <?php require($_SERVER['DOCUMENT_ROOT'] . '/templates/create.php') ?>
<? else: ?>
  <?php require($_SERVER['DOCUMENT_ROOT'] . '/templates/error-make-dir.php') ?>
<? endif; ?>

<?php require($_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php') ?>
