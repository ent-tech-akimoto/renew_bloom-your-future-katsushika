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

  // If there's only one original slide, mark it so CSS can target it
  const realSlides = wrapper.querySelectorAll('.top-banner__swiper-slide:not(.swiper-slide-duplicate)');
  if (realSlides.length === 1) {
    realSlides.forEach(s => s.classList.add('only-child'));
  } else {
    realSlides.forEach(s => s.classList.remove('only-child'));
  }
  
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
    const progressBar = document.querySelector('.top-banner__progress');
    if (nextBtn) nextBtn.style.display = 'none';
    if (prevBtn) prevBtn.style.display = 'none';
    if (progressBar) progressBar.style.display = 'none';

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

  // Topic Swiper Logic
  // --- Top Banner Swiper ---
  const topicswiperEl = document.querySelector('.top-topic__swiper');
  if (!topicswiperEl) return; // safety check
  const topicwrapper = topicswiperEl.querySelector('.top-topic__swiper-wrapper');
  const topicslides = topicwrapper.querySelectorAll('.top-topic__swiper-slide');
  const topicoriginalSlidesCount = topicwrapper.querySelectorAll('.top-topic__swiper-slide:not(.swiper-slide-duplicate)').length;
  
  const topicminSlides = 10;
  const originalCount = topicoriginalSlidesCount;
  // Only duplicate if total slides < minSlides
  if (originalCount < topicminSlides) {
    const topicslidesArray = Array.from(topicslides); // convert NodeList to array
    // Calculate how many times we need to duplicate
    const timesToDuplicate = Math.ceil((topicminSlides - originalCount) / originalCount);

    for (let i = 0; i < timesToDuplicate; i++) {
      topicslidesArray.forEach(slide => {
        const clone = slide.cloneNode(true);
        clone.classList.add('swiper-slide-duplicate');
        topicwrapper.appendChild(clone);
      });
    }
  }

  // Topic Swiper
  if (topicoriginalSlidesCount > 1) {
    const topicSwiper = new Swiper('.top-topic__swiper', {
      // Optional parameters
      modules: [Navigation, Pagination],
      loop: true,
      loopedSlides: 1,
      loopAdditionalSlides: 2,
      slidesPerView: 'auto',
      centeredSlides: true,
      
      // pagination
      pagination: {
        el: '.top-topic__swiper-pagination',
        clickable: true, 
        type: 'bullets',
        renderBullet: function (index, className) {
          if (index >= topicoriginalSlidesCount) return '';
          return `<span class="${className}"></span>`;
        },
      },
      
      on: {
        slideChange: function () {
        const bullets = document.querySelectorAll('.top-topic__swiper-pagination span');
        bullets.forEach(b => b.classList.remove('swiper-pagination-bullet-active'));

        // Find the real slide that represents the center
        const total = topicoriginalSlidesCount;
        let activeIndex = this.realIndex % total;

        // Normalize in case of negative index (looping backward)
        if (activeIndex < 0) activeIndex += total;

        if (bullets[activeIndex]) bullets[activeIndex].classList.add('swiper-pagination-bullet-active');
      },
      },

      // Navigation 
      navigation: {
        nextEl: '.top-topic__swiper-btn--next',
        prevEl: '.top-topic__swiper-btn--prev',
      },
    });
  } else {
    // Only 3 slide → disable Swiper features
    const topicnextBtn = document.querySelector('.top-topic__swiper-btn--next');
    const topicprevBtn = document.querySelector('.top-topic__swiper-btn--prev');
    if (topicnextBtn) topicnextBtn.style.display = 'none';
    if (topicprevBtn) topicprevBtn.style.display = 'none';

    const topicpaginationEl = document.querySelector('.top-topic__swiper-pagination');
    if (topicpaginationEl) topicpaginationEl.style.display = 'none';
    
  };


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
};