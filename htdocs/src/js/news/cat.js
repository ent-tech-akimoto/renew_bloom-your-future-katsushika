export function initCategoryButtons() {
  const catButtons = document.querySelectorAll('.cat-btn');
  const mainFormBox = document.querySelector('.news__form-box.cate:not(.in-modal)');
  const modalFormBox = document.querySelector('.news__form-box.cate.in-modal');
  const cateInput = document.getElementById('cateInput');

  if (!catButtons.length || !cateInput) return;

  // keep track of selected IDs in click order
  let selected = [];

  const updateFormBoxes = () => {
    if (mainFormBox) mainFormBox.innerHTML = '';
    if (modalFormBox) modalFormBox.innerHTML = '';

    selected.forEach(id => {
      const btn = [...catButtons].find(b => b.dataset.id === id);
      if (!btn) return;

      const slug = btn.dataset.cat;
      const text = btn.textContent.trim();
      const span = `<span class="news__form-select" data-cat="${slug}" data-id="${id}">${text}</span>`;

      if (mainFormBox) mainFormBox.insertAdjacentHTML('beforeend', span);
      if (modalFormBox) modalFormBox.insertAdjacentHTML('beforeend', span);
    });

    cateInput.value = selected.join(',');
    
    // ➜ Add this
    if (mainFormBox && selected.length === 0) {
      mainFormBox.innerHTML = '<span class="news__form-box-select default">カテゴリーを絞り込む</span>';
    }
    if (modalFormBox && selected.length === 0) {
      modalFormBox.innerHTML = '<span class="news__form-box-select default">カテゴリーを絞り込む</span>';
    }
  };

  catButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.dataset.id;

      if (btn.classList.toggle('js-active')) {
        // add to end if newly activated
        selected.push(id);
      } else {
        // remove if deactivated
        selected = selected.filter(x => x !== id);
      }

      updateFormBoxes();
    });
  });

  // initial state from PHP (js-active)
  selected = [...catButtons]
    .filter(btn => btn.classList.contains('js-active'))
    .map(btn => btn.dataset.id);

  // --- Add this: default select all if nothing is active ---
  // if (!selected.length) {
  //   selected = [...catButtons].map(btn => btn.dataset.id);
  //   catButtons.forEach(btn => btn.classList.add('js-active'));
  // }

  updateFormBoxes();
}
