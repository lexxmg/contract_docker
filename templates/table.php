<?php if ($arrayTable[$set]['edit']): ?>
  <form class="form-table-edit" action="" method="POST">
    <input type="hidden" name="set" value="<?=$set?>">
    <table class="form-create-table table-edit-js">
      <tbody class="form-create-table__tbody">
        <?php foreach ($arrayTable[$set]['data'] as $i => $value): ?>
          <?php if ($value['row'] === 1): ?>
            <thead class="form-create-table__thead">
              <?php foreach ($value['cell'] as $key => $cell): ?>
                <th class="form-create-table__th <?php echo $key === 0 ? 'form-create-table__td--fix-size' : '' ?>"><?= $cell ?></th>
              <?php endforeach; ?>
            </thead>
          <?php else: ?>
            <tr class="form-create-table__tr">
              <?php foreach ($value['cell'] as $key => $cell): ?>
                <td class="form-create-table__td <?php echo $key !== 0 ? 'form-create-table__td--text-centr' : '' ?>">
                  <input class="form-table-edit__input" type="text" name="row_<?=$i?>[]" value="<?= $cell ?>" >
                </td>
              <?php endforeach; ?>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="edit-table-form__btn-container">
      <button class="button-middle form-table-edit__btn" name="saveEdit">Сохранить</button>
      <button class="button-middle form-table-edit__btn" name="cancelEdit">Отменить</button>
    </div>
  </form>
<?php else: ?>
  <table class="form-create-table">
    <tbody class="form-create-table__tbody">
      <?php foreach ($arrayTable[$set]['data'] as $key => $value): ?>
        <?php if ($value['row'] === 1): ?>
          <thead class="form-create-table__thead">
            <?php foreach ($value['cell'] as $key => $cell): ?>
              <th class="form-create-table__th <?php echo $key === 0 ? 'form-create-table__td--fix-size' : '' ?>"><?= $cell ?></th>
            <?php endforeach; ?>
          </thead>
        <?php else: ?>
          <tr class="form-create-table__tr">
            <?php foreach ($value['cell'] as $key => $cell): ?>
              <td class="form-create-table__td <?php echo $key !== 0 ? 'form-create-table__td--text-centr' : '' ?>"><?= $cell ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endif; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>  