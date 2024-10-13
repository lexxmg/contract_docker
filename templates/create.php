
<h1>Создать договор</h1>

<form class="form-create" action="/php/doc-edit.php" method="POST">
  <label class="form-create__label"><span class="form-create__text">Номер договора</span>
    <input class="form-create__input" type="text" name="contract" value="3">
  </label>  
  <label class="form-create__label"><span class="form-create__text">Дата начала договора</span>
    <input class="form-create__input" type="text" name="dateStart" value="01.07.2024">
  </label>
  <label class="form-create__label"><span class="form-create__text">Дата окончания договора</span>
    <input class="form-create__input" type="text" name="dateEnd" value="25.09.2024">
  </label>
  <label class="form-create__label"><span class="form-create__text">Общая сумма по договору</span>
    <input class="form-create__input" type="text" name="summ" value="220000">
  </label>
  <label class="form-create__label"><span class="form-create__text">Сумма по завершению договора</span>
    <input class="form-create__input" type="text" name="fierstSumm" value="195000">
  </label>
  
  <div class="form-create__btn-container">
    <button name="send">Создать</button>
  </div>
</form>