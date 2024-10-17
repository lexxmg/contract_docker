<?php

$json = getStorage($jsonContract);

if ($json) {
  $dataContract = $json;
}

$tableJson = getStorage($jsonAct);

// if ($tableJson) {
//   $table = $tableJson;
// }

$set = htmlspecialchars($_POST['set'] ?? '0');

?>

<h1>Создать договор</h1>

<form class="form-create" action="/php/doc-edit.php" method="POST">
  <input type="text" name="set" value="<?=$set?>">
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

<?php if ($tableJson): ?>
  <div class="form-create__form-wraper">
    <form action="" method="POST">
      <select name="set">
        <?php foreach ($tableJson as $key => $value): ?>
          <option value="<?=$key?>"><?=$value['wasUsed']?></option>
        <?php endforeach; ?>
      </select>

      <button>применить</button>
    </form>

    <span><?=$tableJson[$set]['wasUsed']?></span>
    
    <?=showTable($tableJson, $set)?>
  </div>
<?php endif; ?>