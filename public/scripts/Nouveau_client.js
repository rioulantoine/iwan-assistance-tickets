const textareas = document.querySelectorAll('.textarea-wrapper textarea, #observation');

textareas.forEach(textarea => {
    const resizeTextarea = function() {
        this.style.height = 'auto'; 
        this.style.height = (this.scrollHeight + 20) + 'px'; 
    };
    textarea.addEventListener('input', resizeTextarea);
        resizeTextarea.call(textarea);
    });