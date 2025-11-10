import Swiper from 'swiper';

export function initSwipersNav() {

  // Nav Swiper
  const swipernav = new Swiper('.nav-swiper', {
    // Optional parameters

    slidesPerView: 'auto',
    watchSlidesProgress: true,
  });
};