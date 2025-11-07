document.addEventListener("DOMContentLoaded", function () {
  const calendar = document.querySelector(".event__calendar-flex.top");
  const before = calendar.querySelector(".before");
  const after = calendar.querySelector(".after");
  const current = calendar.querySelector("strong");
  const inputY = calendar.querySelector('input[name="y"]');
  const inputMo = calendar.querySelector('input[name="mo"]');

  // Initialize with current display
  let year = 2026;
  let month = 10;

  function updateDisplay() {
    // Update main display
    current.textContent = `${month}月`;
    // Calculate before and after
    const prevMonth = month === 1 ? 12 : month - 1;
    const nextMonth = month === 12 ? 1 : month + 1;
    const prevYear = month === 1 ? year - 1 : year;
    const nextYear = month === 12 ? year + 1 : year;

    before.textContent = `＜${prevMonth}月/${prevYear}`;
    after.textContent = `${nextMonth}月/${nextYear}＞`;

    // Update hidden inputs
    inputY.value = year;
    inputMo.value = month;
  }

  before.addEventListener("click", () => {
    if (month === 1) {
      month = 12;
      year--;
    } else {
      month--;
    }
    updateDisplay();
  });

  after.addEventListener("click", () => {
    if (month === 12) {
      month = 1;
      year++;
    } else {
      month++;
    }
    updateDisplay();
  });

  updateDisplay(); // Run once on load
});
