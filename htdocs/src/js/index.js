import './device.js';
import './common/loading.js';
import './common/scroll.js';

const CURRENT_PAGE = document.documentElement.dataset.page;


if (window.pageID === 'top') {
  const {
    initSwipers
  } = require('./top/swiper.js');
  initSwipers();
  require('./top/map_button.js');
  require('./fixed.js');
  require('./common/loading.js');
  require('./common/scroll.js');
}

if (window.pageID === 'event') {
  const {
    initEventModals
  } = require('./event/modal.js');
  initEventModals();
  const {
    initMapButtons
  } = require('./event/area.js');
  initMapButtons();
  const {
    initCategoryButtons
  } = require('./event/cat.js');
  initCategoryButtons();
  const commonCalendar = require('./common/calendar.js');
  const commonForm = require('./common/form.js');
  const textArea = require('./event/textarea.js');
}

if (window.pageID === 'calendar') {
  const {
    initEventModals
  } = require('./event/modal.js');
  initEventModals();
  const {
    initCalendarMapButtons
  } = require('./event/calendar_area.js');
  initCalendarMapButtons();
  // const calendarDate = require('./event/calendar_date.js');
}

if (window.pageID === 'area') {
  const {
    initSwipers
  } = require('./top/swiper.js');
  initSwipers();
  require('./top/map_button.js');
}