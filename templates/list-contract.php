<?php

if ( isset($_POST['delete']) ) {
  //print_r($_POST);
  unlink($pathStarage . '/contract/' . $_POST['delete']);
}

?>

<ul>
  <?php foreach ($arrFilesContract as $key => $item): ?>
    <li><?=$item?>
      <a href="<?='storage/contract/' . $item?>" download>скачать</a>
      <form action="" method="POST">
       
        <button name="delete" value="<?=$item?>">удалить</button>
      </form>
    </li>
  <?php endforeach; ?>
</ul>
