
//  template for the toast notification
const icons = {
    success: 'ti-circle-check',
    error: 'ti-circle-x',
    info: 'ti-info-circle',
    warning: 'ti-alert-triangle'
};

function toast(message, type = 'info', duration = 4000) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }

    const el = document.createElement('div');
    el.className = `toast ${type}`;
    el.innerHTML = 
       `<i class="ti ${icons[type]}"></i>
        <span>${message}</span>
        <i class="ti ti-x toast-close"></i>`;
    container.appendChild(el);

    setTimeout(() => el.classList.add('show'), 10);
    el.querySelector('.toast-close').onclick = () => remove(el);
    document.getElementById('message-toogle').value = 'false';
    setTimeout(() => remove(el), duration);
}

function remove(el) {
    el.classList.remove('show');
    setTimeout(() => el.remove(), 200);
}

//  handle if the message can be showed 
const allowedTypes = ['success', 'error', 'info', 'warning'];
document.addEventListener('DOMContentLoaded', function () {
    const messToggle = document.getElementById('message-toogle').value;
    const messType = document.getElementById('message-to-show-type').value;
    const messBody = document.getElementById('message-to-show-body').value;

    if (messToggle !== 'false' && allowedTypes.includes(messType) && messBody !== '') {
        console.log('Message : type => ' + messType + ' body => ' + messBody);
        toast(messBody, messType);
    }
});
