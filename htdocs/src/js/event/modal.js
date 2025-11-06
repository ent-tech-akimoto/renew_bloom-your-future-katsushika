export function initEventModals() {
    // Select both form boxes and calendar boxes, excluding those inside modals
    const boxes = document.querySelectorAll('.event__form-box:not(.in-modal), .event__calendar-box');
    const formModals = document.querySelectorAll('.event__form-modal');
    
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
            const parentEl = box.closest('.event__form-flex, .event__calendar-flex');
            if (!parentEl) return;

            const type = parentEl.classList.contains('area') ? 'modal1' :
                        parentEl.classList.contains('date') ? 'modal2' :
                        parentEl.classList.contains('cate') ? 'modal3' :
                        parentEl.classList.contains('word') ? 'modal4' : null;
            
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
    });    // Close modal when clicking the close button
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
        // If clicked inside a modal or a box, don't close
        if (e.target.closest('.event__form-box:not(.in-modal)') || 
            e.target.closest('.event__calendar-box') ||
            e.target.closest('.event__form-modal')) {
            return;
        }
        closeAllModals();
    });
}
