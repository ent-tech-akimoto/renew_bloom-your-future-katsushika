import './device.js';
import './common/loading.js';
import './common/scroll.js';


if (window.pageID === 'top') {
  const { initSwipers } = require('./top/swiper.js');
  initSwipers();
  require('./top/map_button.js');
  require('./fixed.js');
  require('./common/loading.js');
  require('./common/scroll.js');
}

if (window.pageID === 'event') {
  const { initEventModals } = require('./event/modal.js');
  initEventModals();
}