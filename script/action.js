// set today's date on the date inputs
function adjustDate() {
    // document.addEventListener("DOMContentLoaded", () => {
        const dateInput = document.getElementById("today-date");
        const today = new Date();
        // Extract components
        const year = today.getFullYear();
        // getMonth() returns 0-11, so add 1
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');

        // Format as YYYY-MM-DD
        const formattedDate = `${year}-${month}-${day}`;

        // Set the value
        dateInput.value = formattedDate;
    // });
}

 // clear form 
 function clearForm(){
    document.getElementById('_method').value = 'POST';
    document.getElementsByName('id-record')[0].value = '';
    document.getElementsByName('motif')[0].value = '';
    document.getElementsByName('montant')[0].value = '';
    adjustDate();
 }

adjustDate();

// close the form modal
const closeBtn = document.getElementById('btn-close');
closeBtn.addEventListener('click', function () {
    document.getElementById('pop-up-form').style.display = 'none';
    clearForm();
});

// show the form modal
const addButton = document.getElementById('ajout-btn');
addButton.addEventListener('click', function () {
    clearForm();
    document.getElementById('id-record').style.display = 'none';
    document.getElementById('pop-up-form').style.display = '';
});

console.log('Height of nav :' + document.querySelector('nav').offsetHeight);
console.log('Height of header :' + document.querySelector('header').offsetHeight);

// handle CRUD buttons
document.getElementById('data-table').addEventListener('click', function (e) {
    const target = e.target.closest('button');
    if (!target) return;

    const row = target.closest('tr');
    const id = row.id;

    if (target.classList.contains('btn-delete')) {
        console.log('Delete row:', id);
        document.getElementsByName('id-to-delete')[0].value = id;
        document.getElementById('pop-up-confirm').style.display = '';
        
    } else if (target.classList.contains('btn-update')) {
        //show the pop-up
        document.getElementById('id-record').style.display = '';
        document.getElementById('_method').value = 'UPDATE';
        document.getElementById('pop-up-form').style.display = '';
        const form = document.querySelector('.form-container');

        // select all value on the row
        const cells = row.querySelectorAll('td');
        const id = cells[0].textContent.trim();
        const ideglise = cells[1].textContent.trim();
        const motif = cells[2].textContent.trim();
        const montantRaw = cells[3].textContent.trim();
        const dateRaw = cells[4].textContent.trim();

        const montant = montantRaw.replace(/[^0-9]/g, '');
        const date = dateRaw.trim();

        // paste values in the form
        document.getElementsByName('id-record')[0].value = id;
        document.getElementsByName('ideglise')[0].value = ideglise;
        document.getElementsByName('motif')[0].value = motif;
        document.getElementsByName('montant')[0].value = Number(montant);
        document.getElementsByName('date-operation')[0].value = date;
        console.log('Edit row:', id);
        console.log(id, ideglise, motif, montant, date);

    }
});

// handle prompt buttons
const acceptBtn = document.getElementById('acceptBtn');
const refusBtn = document.getElementById('refusBtn');

refusBtn.addEventListener('click' , function(){
document.getElementById('pop-up-confirm').style.display = 'none';
});
