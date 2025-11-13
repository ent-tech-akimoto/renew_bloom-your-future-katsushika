
import $ from 'jquery';
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay, Thumbs } from 'swiper/modules';


export function initSwipers() {
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