document.addEventListener("DOMContentLoaded", () => {
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
});

// close the form modal
const closeBtn = document.getElementById('btn-close');
closeBtn.addEventListener('click', function () {
    document.getElementById('pop-up-form').style.display = 'none';
});

// show the form modal
const addButton = document.getElementById('ajout-btn');
addButton.addEventListener('click', function () {
    document.getElementById('pop-up-form').style.display = '';
});