const modal = document.querySelector('.modal-overlay');
const btnCancel = document.querySelector('.btn-cancel');
const deleteButtons = document.querySelectorAll('.btn-delete-ticket');

deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault(); 
        
        
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