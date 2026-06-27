const icons = {
    success: 'ti-circle-check',
    error:   'ti-circle-x',
    info:    'ti-info-circle',
    warning: 'ti-alert-triangle'
};

function toast(message, type = 'info', duration = 3000) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }

    const el = document.createElement('div');
    el.className = `toast ${type}`;
    el.innerHTML = `
        <i class="ti ${icons[type]}"></i>
        <span>${message}</span>
        <i class="ti ti-x toast-close"></i>
    `;
    container.appendChild(el);

    requestAnimationFrame(() => requestAnimationFrame(() => el.classList.add('show')));
    el.querySelector('.toast-close').onclick = () => remove(el);
    setTimeout(() => remove(el), duration);
}

function remove(el) {
    el.classList.remove('show');
    setTimeout(() => el.remove(), 200);
}