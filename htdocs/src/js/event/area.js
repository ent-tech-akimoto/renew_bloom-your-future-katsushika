export function initMapButtons() {
    const mapButtons = document.querySelectorAll('.map-btn');
    const mainFormBox = document.querySelector('.event__form-box.area:not(.in-modal)');
    const modalFormBox = document.querySelector('.event__form-box.area.in-modal');
    const areaInput = document.getElementById('areaInput');
    
    // Function to update form boxes based on active map buttons
    const updateFormBoxes = () => {
        // Clear existing selections
        mainFormBox.innerHTML = '';
        modalFormBox.innerHTML = '';
        const selectedAreas = [];
        
        // Add spans for each active area
        mapButtons.forEach(button => {
            if (button.classList.contains('js-active')) {
                const area = button.dataset.area;
                const id = button.dataset.id;
                const text = button.textContent.trim();
                selectedAreas.push(id);

                // Add to main form box
                mainFormBox.innerHTML += `
                    <span class="event__form-select--area ${area}" data-area="${area}" data-id="${id}">${text}</span>
                `;
                
                // Add to modal form box
                modalFormBox.innerHTML += `
                    <span class="event__form-select--area ${area}" data-area="${area}" data-id="${id}">${text}</span>
                `;
            }
        });

        // Update hidden input value
        areaInput.value = selectedAreas.join(',');
    };

    // Add click event to each map button
    mapButtons.forEach(button => {
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
