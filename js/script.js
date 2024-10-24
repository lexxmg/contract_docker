'use strict';

const table = document.querySelector('.table-edit-js');
const formSelect = document.querySelector('.form-create-select-js');
const tableContainer = document.querySelector('.create-table-js');


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
  const formContract = document.querySelector('.form-create-js');

  
  getJson('php/get-json.php', formSelect)
    .then(res => {
      createTable(res, tableContainer);
      //createTableTwo(res, tableContainer);
    });
  
  
  select.addEventListener('change', (event) => {
    formContract.set.value = event.target.value;
    
    getJson('php/get-json.php', formSelect)
    .then(res => {
      createTable(res, tableContainer);
    });
  });
}



function getJson(url, form) {
  const params = new FormData(form); 

  return fetch(url, {
    method: 'POST',
    body: params
  })
  .then(res => res.json())
  .then(data => data);
}

function createTable(arrTable, wrapper) {
  const table = document.createElement('table'),
        tbody = document.createElement('tbody');
        
  table.className = 'form-create-table';
  tbody.className = 'form-create-table__tbody';

  wrapper.innerHTML = '';
  
  
  let thead = '';
  let tr = '';
  arrTable.data.forEach(row => {
      if (row.row == 1) {
        thead = document.createElement('thead');
        thead.className = 'form-create-table__thead';
        table.append(thead);
        console.log(row.row);
      } else {
        tr = document.createElement('tr');
        tr.className = 'form-create-table__tr';
        tbody.append(tr);
      }
    row.cell.forEach((cell, i) => {
      if (row.row == 1) {
        const th = document.createElement('th');
        th.className = i === 0 ? 'form-create-table__th form-create-table__td--fix-size' : 'form-create-table__th';
        th.textContent = cell;
        thead.append(th);
      } else {
        const td = document.createElement('td');
        td.className = i !== 0 ? 'form-create-table__td form-create-table__td--text-centr' : 'form-create-table__td';
        td.textContent = cell;
        tr.append(td);
      }
    });
  }); 
  table.append(tbody);
  wrapper.append(table);
}

function createTableTwo(arrTable, wrapper) { 
  const table = `
    <table class="form-create-table">
      <thead class="form-create-table__thead">
        <tr class="form-create-table__tr">
          ${arrTable.data[0].cell.map((item, i) => {
            const className = (i === 0) ? 'form-create-table__th form-create-table__td--fix-size' : 'form-create-table__th';
            return `<th class="${className}">${item}</th>`;
          }).join('')}
        </tr>
      </thead>

      <tbody class="form-create-table__tbody">
        ${arrTable.data.slice(1).map(el => {
          return `
            <tr class="form-create-table__tr">
              ${el.cell.map((item, i) => {
                const className = (i === 0) ? 'form-create-table__td' : 'form-create-table__td form-create-table__td--text-centr';
                return `
                  <td class="${className}">${item}</td>
                `;
              }).join('')}
            </tr>
          `;
        }).join('')}
      </tbody>
    </table>
  `;

  wrapper.innerHTML = table;
}