<?php

$json = getStorage($jsonContract);

if ($json) {
  $dataContract = $json;
} 
print_r(num2str(1000.25)['summ']);
echo '<br>';
print_r(ucfirst_utf8(num2str(1000.23)['summKop']));
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