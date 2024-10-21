<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/php/php-excel-pars.php'?>


<?php if (isset($newTable)): ?>
  <div class="edit-table__wrapper">
    <?php showTable($newTable)?>
  </div>
<?php endif; ?>


<form class="edit-table-form" action="" method="POST">
  <?php if (!isset($newTable)):?>
    <div class="edit-table-form__input-container">
      <label class="edit-table-form__label">
        <span class="edit-table-form__span">Координаты таблицы верхний левый (B9):</span>
        <input class="edit-table-form__input" type="text" name="firstCor" value="<?=$newTable[0]['firstCor'] ?? 'B9'?>">
      </label>
      <label class="edit-table-form__label">
        <span class="edit-table-form__span">Координаты таблицы нижний правый (F15):</span>
        <input class="edit-table-form__input" type="text" name="lastCor" value="<?=$newTable[0]['lastCor'] ?? 'F16'?>">
      </label>
    </div>

    <div class="edit-table-form__btn-container">
      <button class="button-big edit-table-form__btn" name="getTable">Получить таблицу из шаблона</button>
    </div>
  <?php endif;?>

  
  <?php if (isset($newTable)): ?>
    <div class="edit-table-form__btn-container">
      <input type="hidden" name="firstCor" value="<?=$newTable[0]['firstCor'] ?? 'B9'?>">
      <input type="hidden" name="lastCor" value="<?=$newTable[0]['lastCor'] ?? 'F16'?>">
      <button class="button-big edit-table-form__btn" name="addTable">Добавить в конец масива</button>
      <button class="button-norm edit-table-form__btn" name="cencelTable">Отменить</button>
    </div>
  <?php endif; ?>  
</form>


<?php if (isset($arrTable)): ?>
  <div class="edit-table-container">
    <?php foreach ($arrTable as $key => $table): ?>
      <div class="edit-table__wrapper">
        <?php showTable($arrTable, $key)?>
      </div>

      <form action="" method="post">
        <input type="hidden" name="key" value="<?=$key?>">

        <?php if (!$table['edit']): ?>
          <div class="edit-table-form__btn-container">
            <button class="button-middle edit-table-form__btn" name="edit">редактировать</button>
            <button class="button-norm edit-table-form__btn" name="delete">удалить</button>
          </div>
        <?php endif; ?>
      </form>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
