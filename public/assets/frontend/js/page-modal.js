//================ Page Modal ======================//
function toggleModal(id) {
    const modal = document.getElementById(id);
    const backdrop = document.querySelector('.modal_backdrop');
    const allModals = document.querySelectorAll('.rs-product-make-offer');

    if (!modal || !backdrop) return;
    
    allModals.forEach(m => {
        m.classList.remove('active');
        m.style.display = 'none';
    });
    modal.style.display = 'flex';
    backdrop.style.display = 'block';

    setTimeout(() => {
        modal.classList.add('active');
        backdrop.classList.add('active');
    }, 10);
}

function closeAllModals() {
    const allModals = document.querySelectorAll('.rs-product-make-offer');
    const backdrop = document.querySelector('.modal_backdrop');

    allModals.forEach(m => {
        m.classList.remove('active');
        m.style.display = 'none';
    });

    backdrop.classList.remove('active');
    setTimeout(() => {
        backdrop.style.display = 'none';
    }, 300);
}


