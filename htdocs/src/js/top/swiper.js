import $ from 'jquery';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, Thumbs } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export function initSwipers() {

  // Banner Swiper
  const swiper = new Swiper('.top-banner__swiper', {
    // Optional parameters
    modules: [Navigation, Pagination, Autoplay],
    loop: true,
    slidesPerView: 'auto',
    centeredSlides: true,
    watchSlidesProgress: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },

    // pagination
    pagination: {
      el: '.top-banner__swiper-pagination',
      clickable: true, 
      type: 'bullets',
    },

    // Navigation 
    navigation: {
      nextEl: '.top-banner__swiper-btn--next',
      prevEl: '.top-banner__swiper-btn--prev',
    },
  });
  
  const el = document.querySelector('.top-banner__swiper');
  console.log(el.swiper);
  
// Insta Swiper
  const instaSwiper = new Swiper('.top-insta__swiper', {
    // Optional parameters
    modules: [Navigation, Pagination, Autoplay],
    loop: true,
    slidesPerView: 'auto',
    freeMode: true,
    speed: 4000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
  });

  const instaSwiperSP = new Swiper('.top-insta__swipersp', {
    // Optional parameters
    modules: [Navigation, Pagination, Autoplay],
    loop: true,
    slidesPerView: 'auto',
    freeMode: true,
    speed: 4000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
      reverseDirection: true,
    },
    
  });

  // Topic Swiper
  const topicSwiper = new Swiper('.top-topic__swiper', {
    // Optional parameters
    modules: [Navigation, Pagination],
    loop: true,
    slidesPerView: 'auto',
    centeredSlides: true,
    // pagination
    pagination: {
      el: '.top-topic__swiper-pagination',
      clickable: true, 
      type: 'bullets',
    },
    // Navigation 
    navigation: {
      nextEl: '.top-topic__swiper-btn--next',
      prevEl: '.top-topic__swiper-btn--prev',
    },
  });


  // Gallery Swiper 
  // Resident swiper
  const galleryswiper1Thumb = new Swiper(".top-gallery__resident-thumb", {
    modules: [Navigation, Pagination, Thumbs],
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
  });

  // 
  const galleryswiper1 = new Swiper(".top-gallery__resident", {
    modules: [Navigation, Pagination, Thumbs, Autoplay],
    spaceBetween: 10,
    slidesPerView: 1,
    speed: 800,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    thumbs: {
      swiper: galleryswiper1Thumb
    },
  });

  // Famous Swiper  
  const galleryswiper2Thumb = new Swiper(".top-gallery__famous-thumb", {
    modules: [Navigation, Pagination, Thumbs],
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
  });

  // 
  const galleryswiper2 = new Swiper(".top-gallery__famous", {
    modules: [Navigation, Pagination, Thumbs, Autoplay],
    spaceBetween: 10,
    slidesPerView: 1,
    speed: 800,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    thumbs: {
      swiper: galleryswiper2Thumb
    },
  });
};