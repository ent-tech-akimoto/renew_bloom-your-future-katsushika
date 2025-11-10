const datepicker = document.querySelector(".event__form-box.date");
// const rangeInput = datepicker.querySelector("input");
const calendarContainer = document.querySelector(".event__form-modal.date");
const leftCalendar = document.querySelector(".left-side");
const rightCalendar = document.querySelector(".right-side");
const prevButtons = document.querySelectorAll(".event__date-btn.before");
const nextButtons = document.querySelectorAll(".event__date-btn.after");
const selectionEl = datepicker.querySelector(".selection")
const applyButton = datepicker.querySelector(".apply");
const cancelButton = datepicker.querySelector(".cancel");
const calendar = document.querySelector(".event__form-flex.date");
const inputFrom = calendar.querySelector('input[name="from"]');
const inputTo = calendar.querySelector('input[name="to"]');




let start = null;
let end = null;
let originalStart = null;
let originalEnd = null;

document.addEventListener("DOMContentLoaded", () => {
  const startDateFull = document.querySelector(".event__date-start p");
  const endDateFull = document.querySelector(".event__date-end p");

  if ((inputTo.value == "null" || inputTo.value == null) && (inputFrom.value == "null" || inputFrom.value == null)){
    inputTo.value = null;
    inputFrom.value = null;
    startDateFull.textContent = "-";
    endDateFull.textContent = "-";
  } else if ( inputTo.value && inputFrom.value){
    startDateFull.textContent = `${inputFrom.value.slice(0,4)}.${inputFrom.value.slice(4,6)}.${inputFrom.value.slice(6,8)}`;
    endDateFull.textContent = `${inputTo.value.slice(0,4)}.${inputTo.value.slice(4,6)}.${inputTo.value.slice(6,8)}`;
  }

});

let leftDate = new Date();
let rightDate = new Date(leftDate);
rightDate.setMonth(rightDate.getMonth() + 1);

// comment this for actual test
calendarContainer.hidden = true;

//for testing only to see the modal open
// calendarContainer.hidden = false;

console.log(calendarContainer);

// format date as YYYY-MM-DD
const formatDate = (date) => {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, "0");
  const d = String(date.getDate()).padStart(2, "0");
  return `${y}-${m}-${d}`;
};

// format date for input value as YYYYMMDD
const inputFormat = (date) => {
  const y = date.getFullYear();
  const m = String(date.getMonth() + 1).padStart(2, "0");
  const d = String(date.getDate()).padStart(2, "0");
  return `${y}${m}${d}`;
};

const createDateEl = (date, isDisabled, isToday) => {
  const span = document.createElement("span");
  span.textContent = date.getDate();
  span.classList.toggle("disabled", isDisabled);
  if (!isDisabled) {
    span.classList.toggle("today", isToday);
    span.setAttribute("data-date",formatDate(date));
  }
  span.addEventListener('click',handleDateClick)
  span.addEventListener('mouseover',handleDateMouseover)
  return span;
};

const displaySelection = () => {
  if (start && end) {
    // Convert to date parts
    const startYear = start.getFullYear();
    const startMonth = start.getMonth() + 1;
    const startDay = start.getDate();
    const startDay2Digit = String(start.getDate()).padStart(2, "0");

    const endYear = end.getFullYear();
    const endMonth = end.getMonth() + 1;
    const endDay = end.getDate();
    const endDay2Digit = String(end.getDate()).padStart(2, "0");

    // Find your elements
    const startEl = document.querySelector(".event__modal-date-start");
    const endEl = document.querySelector(".event__modal-date-end");

    // Update START date
    startEl.querySelector("strong").textContent = startDay;          // number only
    startEl.querySelector(".month").textContent = `${startMonth}月`; // month
    startEl.querySelector(".day").textContent = "日";                // (you can change dynamically if you want)
    inputFrom.value = inputFormat(start);
    // Update END date
    endEl.querySelector("strong").textContent = endDay;
    endEl.querySelector(".month").textContent = `${endMonth}月`;
    endEl.querySelector(".day").textContent = "日";
    inputTo.value = inputFormat(end);

    const startDateFull = document.querySelector(".event__date-start p");
    const endDateFull = document.querySelector(".event__date-end p");
    
    startDateFull.textContent = `${startYear}.${startMonth}.${startDay2Digit}`;
    endDateFull.textContent = `${endYear}.${endMonth}.${endDay2Digit}`;

    // console.log(formatDate(start));
    // console.log(formatDate(end));
    // Optional: if you need the year displayed somewhere
    // console.log(`期間: ${startYear}年${startMonth}月${startDay}日 〜 ${endYear}年${endMonth}月${endDay}日`);
  }
};



const applyHighlighting = () => {
  // clear previous highlighting
  const dateElements = document.querySelectorAll("span[data-date]");
  for (const dateEl of dateElements) {
    dateEl.classList.remove("range-start", "range-end", "in-range");
  }

  // highlight the start date
  if (start) {
    const startDate = formatDate(start);
    const startEl = document.querySelector(`span[data-date="${startDate}"]`);
    if (startEl) {
      startEl.classList.add("range-start");
      // if (!end) startEl.classList.add("range-end");
    }
  }

  // highlight the end date
  if (end) {
    const endDate = formatDate(end);
    const endEl = document.querySelector(`span[data-date="${endDate}"]`);
    if (endEl) {
      endEl.classList.add("range-end");
    }
  }

  // highlight the dates between start and end
  if (start && end) {
    for (const dateEl of dateElements) {
      const date = new Date(dateEl.dataset.date);
      if (date > start && date < end) {
        dateEl.classList.add("in-range");
      }
    }
  }

};

const handleDateMouseover = (event) => {
  const hoverEl = event.target;
  if (start && !end) {
    applyHighlighting(); // reset highlighting
    const hoverDate = new Date(hoverEl.dataset.date);

    datepicker.querySelectorAll("span[data-date]").forEach((dateEl) => {
      const date = new Date(dateEl.dataset.date);

      if (date > start && date < hoverDate && start < hoverDate) {
        dateEl.classList.add("in-range");
      }
    });
  }
};



const handleDateClick = (event) => {
  const dateEl = event.target;
  const selectedDate = new Date(dateEl.dataset.date);

  if (!start || (start && end)) {
    // first click or selecting a new range
    start = selectedDate;
    end = null;
  } else if (selectedDate < start) {
    // clicked date is before the start date
    start = selectedDate;
  } else {
    // otherwise, set it as the end
    end = selectedDate;
  }
  applyHighlighting();
  displaySelection();
};



// function to render calendar header label
const renderCalendar = (calendar, year, month) => {
  const label = calendar.querySelector(".label");
  label.textContent = new Date(year, month).toLocaleString("ja",
    {
      year: "numeric",
      month: "long",
    }
  ); // Month YYYY
  const datesContainer = calendar.querySelector(".event__modal-date-dates");
  console.log(datesContainer)
  datesContainer.innerHTML = "";

  // start on the first Sunday of the month
  const startDate = new Date(year, month, 1);
  startDate.setDate(startDate.getDate() - startDate.getDay());

  // end in 6 weeks or 42 days
  const endDate = new Date(startDate);
  endDate.setDate(endDate.getDate() + 42);

  const fragment = document.createDocumentFragment();
  while (startDate < endDate) {
    const isDisabled = startDate.getMonth() !== month;
    const isToday = formatDate(startDate) === formatDate(new Date());
    const dateEl = createDateEl(startDate, isDisabled, isToday);
    fragment.appendChild(dateEl);
    startDate.setDate(startDate.getDate() + 1);
  }
  datesContainer.appendChild(fragment);

  applyHighlighting();
};

// render both calendars
const updateCalendars = () => {
  renderCalendar(leftCalendar, leftDate.getFullYear(), leftDate.getMonth());
  renderCalendar(rightCalendar, rightDate.getFullYear(), rightDate.getMonth());
};


// show datepicker
datepicker.addEventListener("click", () => {
  originalStart = start;
  originalEnd = end;
  calendarContainer.hidden = false;
});

// hide datepicker when clicked outside
document.addEventListener("click", (event) => {
  if (
    !calendarContainer.contains(event.target) &&
    !datepicker.contains(event.target)
  ) {
    calendarContainer.hidden = true;
  }
});

// navigate previous month

prevButtons.forEach(prevbtn => {
  prevbtn.addEventListener('click', () => {
    leftDate.setMonth(leftDate.getMonth() - 1);
    rightDate.setMonth(rightDate.getMonth() - 1);
    updateCalendars();
  });
});

// navigate next month
nextButtons.forEach(nextbtn => {
  nextbtn.addEventListener('click', () => {
    leftDate.setMonth(leftDate.getMonth() + 1);
    rightDate.setMonth(rightDate.getMonth() + 1);
    updateCalendars();
  });
});

// // handle apply selection click
// applyButton.addEventListener("click", () => {
//   if (start && end) {
//     const startDate = start.toLocaleDateString("en");
//     const endDate = end.toLocaleDateString("en");
//     rangeInput.value = `${startDate} ${endDate}`;
//     calendarContainer.hidden = true;
//   }
// });

// // handle cancel selection click
// cancelButton.addEventListener("click", () => {
//   start = originalStart;
//   end = originalEnd;
//   applyHighlighting();
//   displaySelection();
//   calendarContainer.hidden = true;
// });


// initialize the datepicker
updateCalendars();
