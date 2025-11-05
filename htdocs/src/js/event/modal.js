export function initEventModals() {
  
    const formBoxes = document.querySelectorAll('.event__form-box:not(.in-modal)');
    const formModals = document.querySelectorAll('.event__form-modal');
    
    // Function to close all modals
    const closeAllModals = () => {
        formModals.forEach(modal => {
            modal.classList.remove('js-show');
        });
    };

    // Add click event to each form box
    formBoxes.forEach(box => {
        box.addEventListener('click', (e) => {
            e.preventDefault();
            
            // Get the modal type from the box's class (area, date, cate, or word)
            const type = box.classList.contains('area') ? 'modal1' :
                        box.classList.contains('date') ? 'modal2' :
                        box.classList.contains('cate') ? 'modal3' :
                        box.classList.contains('word') ? 'modal4' : null;
            
            if (!type) return;

            // Find the corresponding modal
            const targetModal = document.querySelector(`.event__form-modal[data-modal="${type}"]`);
            
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
    });

    // Close modal when clicking the close button
    const closeButtons = document.querySelectorAll('.event__modal-close');
    closeButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const modal = button.closest('.event__form-modal');
            if (modal) {
                modal.classList.remove('js-show');
            }
        });
    });

    // Close modal when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.event__form-box:not(.in-modal)') && 
            !e.target.closest('.event__form-modal')) {
            closeAllModals();
        }
    });
}
