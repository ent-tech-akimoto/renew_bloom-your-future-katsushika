import $ from 'jquery';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, Thumbs } from 'swiper/modules';


export function initSwipers() {

 // --- Top Banner Swiper ---
  const swiperEl = document.querySelector('.top-banner__swiper');
  if (!swiperEl) return; // safety check
  const wrapper = swiperEl.querySelector('.top-banner__swiper-wrapper');
  const slides = wrapper.querySelectorAll('.top-banner__swiper-slide');
  const originalSlidesCount = document.querySelectorAll('.top-banner__swiper-wrapper .top-banner__swiper-slide:not(.swiper-slide-duplicate)').length;
  
  const minSlides = 3;
  if (slides.length < minSlides) {
    // Duplicate ALL slides
    slides.forEach(slide => {
      const clone = slide.cloneNode(true);
      clone.classList.add('swiper-slide-duplicate');
      wrapper.appendChild(clone);
    });
  }
  // Banner Swiper
  if (originalSlidesCount > 1) {
  const swiper = new Swiper('.top-banner__swiper', {
    // Optional parameters
    modules: [Navigation, Pagination, Autoplay],
    slidesPerView: 'auto',
    loop: slides.length + (slides.length < minSlides ? minSlides - slides.length : 0) > 1,
    centeredSlides: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },

    // pagination
     pagination: {
      el: '.top-banner__swiper-pagination',
      clickable: true,
      renderBullet: function (index, className) {
        if (index >= originalSlidesCount) return '';
        return `<span class="${className}"></span>`;
      },
    },

    on: {
      slideChange: function () {
      const bullets = document.querySelectorAll('.top-banner__swiper-pagination span');
      bullets.forEach(b => b.classList.remove('swiper-pagination-bullet-active'));

      // Map realIndex to original slides
      const activeIndex = this.realIndex % originalSlidesCount;
      if (bullets[activeIndex]) bullets[activeIndex].classList.add('swiper-pagination-bullet-active');
      },
    },

    // Navigation 
    navigation: {
      nextEl: '.top-banner__swiper-btn--next',
      prevEl: '.top-banner__swiper-btn--prev',
    },
  });
  } else {
    // Only 1 slide → disable Swiper features
    const nextBtn = document.querySelector('.top-banner__swiper-btn--next');
    const prevBtn = document.querySelector('.top-banner__swiper-btn--prev');
    if (nextBtn) nextBtn.style.display = 'none';
    if (prevBtn) prevBtn.style.display = 'none';

    const paginationEl = document.querySelector('.top-banner__swiper-pagination');
    if (paginationEl) paginationEl.style.display = 'none';
  }
  
  const el = document.querySelector('.top-banner__swiper');
  
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
      pauseOnMouseEnter: false,
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
    // spaceBetween: 5,
    // slidesPerView: 4,
    slidesPerView: 'auto',
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
    // spaceBetween: 5,
    // slidesPerView: 4,
    slidesPerView: 'auto',
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

  // Area Gallery Swiper 
  // Resident swiper
  const areagalleryswiper1Thumb = new Swiper(".area__gallery-resident-thumb", {
    modules: [Navigation, Pagination, Thumbs],
    // spaceBetween: 5,
    // slidesPerView: 4,
    slidesPerView: 'auto',
    freeMode: true,
    watchSlidesProgress: true,
  });

  // 
  const areagalleryswiper1 = new Swiper(".area__gallery-resident", {
    modules: [Navigation, Pagination, Thumbs, Autoplay],
    spaceBetween: 10,
    slidesPerView: 1,
    speed: 800,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    thumbs: {
      swiper: areagalleryswiper1Thumb
    },
  });

  // Famous Swiper  
  const areagalleryswiper2Thumb = new Swiper(".area__gallery-famous-thumb", {
    modules: [Navigation, Pagination, Thumbs],
    // spaceBetween: 5,
    // slidesPerView: 4,
    slidesPerView: 'auto',
    freeMode: true,
    watchSlidesProgress: true,
  });

  // 
  const areagalleryswiper2 = new Swiper(".area__gallery-famous", {
    modules: [Navigation, Pagination, Thumbs, Autoplay],
    spaceBetween: 10,
    slidesPerView: 1,
    speed: 800,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false,
    },
    thumbs: {
      swiper: areagalleryswiper2Thumb
    },
  });
};