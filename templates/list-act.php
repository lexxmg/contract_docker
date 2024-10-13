<?php

if ( isset($_POST['delete']) ) {
  unlink($pathStarage . '/act/' . $_POST['delete']);
}
$arrFilesAct = preg_grep( '/^([^.])/', scandir($pathStarage . '/act') );

?>

<ul class="doc-list">
  <?php foreach ($arrFilesAct as $key => $item): ?>
    <li class="doc-list__item"><?=$item?>
      <div class="doc-list__button-container">
        <a class="doc-list__link doc-list--button" href="<?='/storage/act/' . $item?>" download>скачать</a>

        <form action="" method="POST">
          <button class="doc-list__button doc-list--button"name="delete" value="<?=$item?>">удалить</button>
        </form>
      </div>
    </li>
  <?php endforeach; ?>
</ul>