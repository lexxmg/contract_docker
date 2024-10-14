<?php

if ( isset($_POST['delete']) ) {
  unlink($pathStarage . '/contract/' . $_POST['delete']);
}
$arrFilesContract = preg_grep( '/^([^.])/', scandir($pathStarage . '/contract') );

?>

<ul class="doc-list">
  <?php foreach ($arrFilesContract as $key => $item): ?>
    <li class="doc-list__item"><?=$item?>
      <div class="doc-list__button-container">
        <a class="doc-list__link doc-list--button" href="<?='/storage/contract/' . $item?>" download>скачать</a>

        <form action="" method="POST">
          <button class="doc-list__button doc-list--button"name="delete" value="<?=$item?>">удалить</button>
        </form>
      </div>
    </li>
  <?php endforeach; ?>
</ul>
