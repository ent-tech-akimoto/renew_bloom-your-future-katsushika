import $ from 'jquery';

window.addEventListener('scroll', function () {
  const wHeight = $(window).height();
  const scrollAmount = $(window).scrollTop();
  $(".js-scroll").each(function (index, element) {
    // element == this
    const targetPosition = $(this).offset().top;
    if (scrollAmount > targetPosition - wHeight + 100) {
      $(this).addClass("js-show");
    }
  });
});

document.getElementById('pageTop').addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});
