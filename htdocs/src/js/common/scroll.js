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

const pageTop = document.getElementById('pageTop');
if (pageTop) {
  pageTop.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector("header");
  const headerHeight = header ? header.offsetHeight : 0;

  // --- 1) Same-page smooth scroll for anchors like href="#anchor-about" ---
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

  // --- 2) Cross-page smooth scroll when arriving with hash (e.g. overview.html#anchor-about) ---
  if (location.hash && location.hash.startsWith("#anchor-")) {
    const target = document.querySelector(location.hash);
    if (target) {
      // small delay to ensure layout is ready
      setTimeout(() => {
        const currentHeader = document.querySelector("header");
        const currentHeaderHeight = currentHeader ? currentHeader.offsetHeight : 0;

        const position = target.getBoundingClientRect().top + window.scrollY - currentHeaderHeight;

        window.scrollTo({
          top: position,
          behavior: "smooth"
        });
      }, 50);
    }
  }
});
