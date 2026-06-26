// just to handle visual text on what filter the user is doing 
const selectInput = document.getElementById('to-filter');
document.getElementsByClassName('state')[0].textContent = "(" + selectInput.value + ")";
selectInput.addEventListener('input' , function(){
    const value = selectInput.value;
    document.getElementsByClassName('state')[0].textContent = "(" + value + ")";
});

//  adjust date input value
function adjustDate() {
        const begin = document.getElementsByName('date-begin');
        const end = document.getElementsByName('date-end');

        const today = new Date();
        // Extract components
        const year = today.getFullYear();
        // getMonth() returns 0-11, so add 1
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const day = String(today.getDate()).padStart(2, '0');

        // Format as YYYY-MM-DD
        const formattedDateBegin = `${year}-${month}-${day}`;
        const formattedDateEnd =  `${year}-${month}-${day}`;
        
        // bind the values
        begin[0].value = formattedDateBegin;
        end[0].value = formattedDateEnd;
}

adjustDate();