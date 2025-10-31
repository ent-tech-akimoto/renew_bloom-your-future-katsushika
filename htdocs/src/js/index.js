import './device.js';
import './common/loading.js';
import './common/scroll.js';

//top
const { initSwipers } = require('./top/swiper.js');
initSwipers();

const mapBtn = require('./top/map_button.js');
const fixedBtn = require('./fixed.js');
const loading = require('./common/loading.js');
const scroll = require('./common/scroll.js');