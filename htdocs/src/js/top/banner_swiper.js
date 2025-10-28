import $ from 'jquery';
import Swiper, { Navigation, Pagination } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const swiper = new Swiper('.top-banner__swiper', {
  // Optional parameters
  loop: true,


  // If we need pagination
  pagination: {
    el: '.top-banner__swiper-pagination.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.top-banner__swiper-btn--next',
    prevEl: '.top-banner__swiper-btn--prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
  // register modules so pagination/navigation render
  // modules: [Navigation, Pagination],
});