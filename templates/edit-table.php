<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/php-excel-pars.php'?>

<form class="edit-table-form" action="" method="POST">
  <div class="edit-table-form__input-container">
    <label class="edit-table-form__label">
      <span class="edit-table-form__span">Координаты таблицы верхний левый (B9):</span>
      <input class="edit-table-form__input" type="text" name="firstCor" value="B9">
    </label>
    <label class="edit-table-form__label">
      <span class="edit-table-form__span">Координаты таблицы нижний правый (F15):</span>
      <input class="edit-table-form__input" type="text" name="lastCor" value="F15">
    </label>
  </div>

  <div class="edit-table-form__btn-container">
    <button class="edit-table-form__btn" name="getTable">Получить таблицу из шаблона</button>
    <button class="edit-table-form__btn" name="saveTable">Получить таблицу из шаблона и сохранить в базе</button>
    <button class="edit-table-form__btn" name="addTable">Добавить в конец масива</button>
  </div>
</form>

<?php if (isset($newTable)): ?>
  <?php showTable($newTable)?>
<?php endif; ?>

<?php if ($arrTable): ?>
  <?php showTable($arrTable, 0)?>
<?php endif; ?>
