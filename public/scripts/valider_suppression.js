const modal = document.querySelector('.modal-overlay');
const btnCancel = document.querySelector('.btn-cancel');
const btnConfirm = document.querySelector('.btn-confirm');
const deleteButtons = document.querySelectorAll('.btn-delete-ticket');

let deleteUrl = '';

deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        deleteUrl = this.href;
        btnConfirm.href = deleteUrl;

        modal.classList.add('active');
    });
});

btnCancel.addEventListener('click', function() {
    modal.classList.remove('active');
});

modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        modal.classList.remove('active');
    }
});