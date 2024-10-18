<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/php-excel-pars.php'?>

<?php if (isset($newTable)): ?>
  <?php showTable($newTable)?>
<?php endif; ?>

<form class="edit-table-form" action="" method="POST">
  <div class="edit-table-form__input-container">
    <label class="edit-table-form__label">
      <span class="edit-table-form__span">Координаты таблицы верхний левый (B9):</span>
      <input class="edit-table-form__input" type="text" name="firstCor" value="<?=$newTable[0]['firstCor'] ?? 'B9'?>">
    </label>
    <label class="edit-table-form__label">
      <span class="edit-table-form__span">Координаты таблицы нижний правый (F15):</span>
      <input class="edit-table-form__input" type="text" name="lastCor" value="<?=$newTable[0]['lastCor'] ?? 'F15'?>">
    </label>
  </div>

  <div class="edit-table-form__btn-container">
    <button class="edit-table-form__btn" name="getTable">Получить таблицу из шаблона</button>
   
    <?php if (isset($newTable)): ?>
      <button class="edit-table-form__btn" name="addTable">Добавить в конец масива</button>
      <button class="edit-table-form__btn" name="cencelTable">Отменить</button>
    <?php endif; ?>  
  </div>
</form>


<?php if (isset($arrTable)): ?>
  <?php foreach ($arrTable as $key => $table): ?>
    <?php showTable($arrTable, $key)?>
    <form action="" method="post">
      <input type="hidden" name="key" value="<?=$key?>">
      <button name="delete">удалить</button>
    </form>
  <?php endforeach; ?>
<?php endif; ?>
