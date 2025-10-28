import $ from 'jquery';
import Swiper, { Navigation, Pagination } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const topicSwiper = new Swiper('.top-topic__swiper', {
  // Optional parameters
  loop: true,
  loopAdditionalSlides: 3,
  slidesPerView: 'auto',
  centeredSlides: true,

  // If we need pagination
  pagination: {
    el: '.top-topic__swiper-pagination',
  },
  
  // register modules so pagination/navigation render
  // modules: [Navigation, Pagination],
});