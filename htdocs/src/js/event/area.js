export function initMapButtons() {
  const mapButtons = document.querySelectorAll('.map-btn');
  const mainFormBox = document.querySelector('.event__form-box.area:not(.in-modal)');
  const modalFormBox = document.querySelector('.event__form-box.area.in-modal');
  const areaInput = document.getElementById('areaInput');

  // Keep track of selected areas in click order
  let selectedAreas = [];

  // Function to refresh displayed spans and hidden input
  const updateFormBoxes = () => {
    // Clear boxes
    mainFormBox.innerHTML = '';
    modalFormBox.innerHTML = '';

    // Build spans in the order of selectedAreas
    selectedAreas.forEach(id => {
      const button = document.querySelector(`.map-btn[data-id="${id}"]`);
      if (!button) return;
      const area = button.dataset.area;
      const text = button.textContent.trim();

      const spanHTML = `<span class="event__form-select--area ${area}" data-area="${area}" data-id="${id}">${text}</span>`;

      mainFormBox.insertAdjacentHTML('beforeend', spanHTML);
      modalFormBox.insertAdjacentHTML('beforeend', spanHTML);
    });

    // Update hidden input value
    areaInput.value = selectedAreas.join(',');
  };

  // Handle button click
  mapButtons.forEach(button => {
    button.addEventListener('click', () => {
      const id = button.dataset.id;

      if (button.classList.contains('js-active')) {
        // Deselect
        button.classList.remove('js-active');
        selectedAreas = selectedAreas.filter(x => x !== id);
      } else {
        // Select
        button.classList.add('js-active');
        selectedAreas.push(id);
      }

      updateFormBoxes();
    });
  });

  // Initialize form with any pre-active buttons
  selectedAreas = Array.from(mapButtons)
    .filter(btn => btn.classList.contains('js-active'))
    .map(btn => btn.dataset.id);

  updateFormBoxes();
}
