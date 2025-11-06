document.querySelectorAll('.event__calendar-select--area').forEach(el => {
  el.addEventListener('click', () => {
    const form = document.getElementById('event-calendar-filter');
    form.querySelector('.js-calendar-area').value = el.dataset.area;
    form.submit();
  });
});