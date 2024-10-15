<?php

$json = getStorage($jsonContract);

if ($json) {
  $dataContract = $json;
}

$tableJson = getStorage($jsonAct);

if ($tableJson) {
  $table = $tableJson;
}

$set = 0;

?>

<h1>Создать договор</h1>

<form class="form-create" action="/php/doc-edit.php" method="POST">
  <label class="form-create__label"><span class="form-create__text">Номер договора</span>
    <input class="form-create__input" type="text" name="contract" value="<?=$dataContract['contract']?>">
  </label>  
  <label class="form-create__label"><span class="form-create__text">Дата начала договора (01.07.2024)</span>
    <input class="form-create__input" type="text" name="dateStart" value="<?=$dataContract['dateStart']?>">
  </label>
  <label class="form-create__label"><span class="form-create__text">Дата окончания договора (25.09.2024)</span>
    <input class="form-create__input" type="text" name="dateEnd" value="<?=$dataContract['dateEnd']?>">
  </label>
  <label class="form-create__label"><span class="form-create__text">Общая сумма по договору</span>
    <input class="form-create__input" type="text" name="summ" value="<?=$dataContract['summ']?>">
  </label>
  <label class="form-create__label"><span class="form-create__text">Сумма по завершению договора</span>
    <input class="form-create__input" type="text" name="fierstSumm" value="<?=$dataContract['fierstSumm']?>">
  </label>
  
  <div class="form-create__btn-container">
    <button name="send">Создать</button>
  </div>
</form>

<div class="form-create__form-wraper">
  <span><?=$table[$set][0]['wasUsed']?></span>
  <table class="form-create-table">
    <tbody class="form-create-table__tbody">
      <?php foreach ($table[$set] as $key => $value): ?>
        <?php if ($value['row'] === 1): ?>
          <thead class="form-create-table__thead">
            <?php foreach ($value['cell'] as $key => $cell): ?>
              <th class="form-create-table__th <?php echo $key === 0 ? 'form-create-table__td--fix-size' : ''?>"><?=$cell?></th>
            <?php endforeach; ?>
          </thead>
        <?php else: ?>
          <tr class="form-create-table__tr">
            <?php foreach ($value['cell'] as $key => $cell): ?>
              <td class="form-create-table__td <?php echo $key !== 0 ? 'form-create-table__td--text-centr' : ''?>"><?=$cell?></td>
            <?php endforeach; ?>
          </tr>  
        <?php endif; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>