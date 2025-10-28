import $ from 'jquery';
import Swiper, { Navigation, Pagination } from 'swiper';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const swipersp = new Swiper('.top-insta__swipersp', {
  // Optional parameters
  loop: true,
  loopAdditionalSlides: 3,
  slidesPerView: 'auto',
  centeredSlides: true,

  // If we need pagination
  pagination: {
    el: '.top-insta__swipersp-pagination',
  },

  // Navigation arrows
  navigation: {
    // match the classes in your HTML (you use "btn" not "button")
    nextEl: '.top-insta__swipersp-btn--next',
    prevEl: '.top-insta__swipersp-btn--prev',
  },
  
  // register modules so pagination/navigation render
  // modules: [Navigation, Pagination],
});