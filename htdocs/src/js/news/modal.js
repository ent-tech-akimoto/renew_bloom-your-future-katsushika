export function initNewsModals() {
    // Select both form boxes and calendar boxes, excluding those inside modals
    const boxes = document.querySelectorAll('.news__form-box:not(.in-modal)');
    const formModals = document.querySelectorAll('.news__form-modal');
    
    // Function to close all modals
    const closeAllModals = () => {
        formModals.forEach(modal => {
            modal.classList.remove('js-show');
        });
    };

    // Add click event to each box
    boxes.forEach(box => {
        box.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation(); // Stop event from bubbling up
            // Get the modal type from parent's class (area, date, cate, or word)
            const parentEl = box.closest('.news__form-flex');
            if (!parentEl) return;

            const type = 
                 parentEl.classList.contains('cate') ? 'modal3' : null;
            
            if (!type) return;

            // Find the corresponding modal
            const targetModal = document.querySelector(`.news__form-modal[data-modal="${type}"]`);
            
            if (!targetModal) return;

            // If the modal is already shown, close it
            if (targetModal.classList.contains('js-show')) {
                targetModal.classList.remove('js-show');
                return;
            }

            // Close all modals first
            closeAllModals();

            // Show the target modal
            targetModal.classList.add('js-show');
        });
    });    // Close modal when clicking the close button
    const closeButtons = document.querySelectorAll('.news__modal-close');
    closeButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const modal = button.closest('.news__form-modal');
            if (modal) {
                modal.classList.remove('js-show');
            }
        });
    });
}

