// just to handle visual text on what filter the user is doing 
const selectInput = document.getElementById('to-filter');
document.getElementsByClassName('state')[0].textContent = "(" + selectInput.value + ")";
selectInput.addEventListener('input' , function(){
    const value = selectInput.value;
    document.getElementsByClassName('state')[0].textContent = "(" + value + ")";
});