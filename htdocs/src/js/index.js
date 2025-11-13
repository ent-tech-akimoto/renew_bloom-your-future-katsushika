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
  } = require('./area/area_swiper.js');
  initSwipers();
  require('./top/map_button.js');
}

if( window.pageID === 'overview' || window.pageID === 'purpose' ) {
  const { initSwipersNav } = require('./common/nav_swiper.js');
  initSwipersNav();
}

if (window.pageID === 'news') {
  const {
    initNewsModals
  } = require('./news/modal.js');
  initNewsModals();
  const {
    initCategoryButtons
  } = require('./news/cat.js');
  initCategoryButtons();
  const commonForm = require('./common/form.js');
}

if (window.pageID === 'support') {
  const modalMap = require('./support/modal_map.js');
}