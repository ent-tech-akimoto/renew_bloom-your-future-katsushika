import $ from 'jquery';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

const swiper = new Swiper('.top-banner__swiper', {
  // Optional parameters
  modules: [Navigation, Pagination],
  loop: true,
  slidesPerView: 'auto',
  centeredSlides: true,
  // If we need pagination
  pagination: {
    el: '.top-banner__swiper-pagination',
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
});

const swipersp = new Swiper('.top-insta__swipersp', {
  // Optional parameters
  modules: [Navigation, Pagination],
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

const topicSwiper = new Swiper('.top-topic__swiper', {
  // Optional parameters
  modules: [Navigation, Pagination],
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


var galleryswiper1 = new Swiper(".top-gallery__resident", {
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });
    var galleryswiper1Thumb = new Swiper(".top-gallery__resident-thumb", {
      spaceBetween: 10,
      thumbs: {
        swiper: galleryswiper1,
      },
    });