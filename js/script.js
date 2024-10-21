'use strict';

const table = document.querySelector('.table-edit-js');
const formSelect = document.querySelector('.form-create-select-js');

if (table) {
  const cost = table.rows[1].cells[4];

  table.addEventListener('keyup', (event) => {
    const target = event.target;
    const count = target.value;
    const price = target.parentNode.nextElementSibling.firstElementChild.value;
    const summ = target.parentNode.nextElementSibling.nextElementSibling.firstElementChild;
    
    summ.value = count * price;

    let result = 0;
    for (let i = 1; i < table.rows.length - 1; i++) {
      const el = table.rows[i];
      const value = el.cells[4].firstElementChild.value;
      
      result += +value;
    }
    table.rows[7].cells[4].firstElementChild.value = result;
  });
}

if (formSelect) {
  const select = document.querySelector('.form-create-select__select-js');
  const btnSelect = document.querySelector('.form-create-select__btn-js');

  select.addEventListener('change', () => {
   btnSelect.click();
  });
}