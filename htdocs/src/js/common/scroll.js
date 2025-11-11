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

document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector("header");
  const headerHeight = header ? header.offsetHeight : 0;

  document.querySelectorAll('a[href^="#anchor-"]').forEach(anchor => {
    anchor.addEventListener("click", e => {
      const targetId = anchor.getAttribute("href");
      if (targetId === "#" || targetId === "" || !document.querySelector(targetId)) return;
      e.preventDefault();

      const target = document.querySelector(targetId);
      const position = target.getBoundingClientRect().top + window.scrollY - headerHeight;

      window.scrollTo({
        top: position,
        behavior: "smooth"
      });
    });
  });
});
