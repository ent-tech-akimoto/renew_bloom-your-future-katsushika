export function initCategoryButtons() {
    const catButtons = document.querySelectorAll('.cat-btn');
    const mainFormBox = document.querySelector('.event__form-box.cate:not(.in-modal)');
    const modalFormBox = document.querySelector('.event__form-box.cate.in-modal');
    const cateInput = document.getElementById('cateInput');
    
    document.addEventListener("DOMContentLoaded", () => {
    const cateInput = document.getElementById("cateInput");
    if (!cateInput.value) {
        cateInput.value = null;
    }
    });
    // Function to update form boxes based on active category buttons
    const updateFormBoxes = () => {
        
        // Clear existing selections
        mainFormBox.innerHTML = '';
        modalFormBox.innerHTML = '';
        const selectedCategories = [];
        
        // Add spans for each active category
        catButtons.forEach(button => {
            if (button.classList.contains('js-active')) {
                const category = button.dataset.cat;
                const id = button.dataset.id;
                const text = button.textContent.trim();
                selectedCategories.push(id);

                // Create span HTML with consistent formatting
                const spanHtml = `<span class="event__form-select" data-cat="${category}" data-id="${id}">${text}</span>`;
                
                // Add to main form box
                mainFormBox.innerHTML += spanHtml;
                
                // Add to modal form box
                modalFormBox.innerHTML += spanHtml;
            }
        });

        // Update hidden input value
        if (cateInput) {
            cateInput.value = selectedCategories.join(',');
        }
    };

    // Add click event to each category button
    catButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Toggle active state
            button.classList.toggle('js-active');
            
            // Update form boxes
            updateFormBoxes();
        });
    });

    // Initialize form boxes with current active buttons
    updateFormBoxes();
}
