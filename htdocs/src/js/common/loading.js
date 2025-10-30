document.addEventListener('DOMContentLoaded', function () {
  const images = Array.from(document.querySelectorAll('img')).filter(
    (img) => img.loading !== 'lazy'
  );
  const totalImages = images.length;
  let loadedImages = 0;

  const countElement = document.getElementById('loadingNum');
  const loadingWrapper = document.getElementById('loading');
  const mainContent = document.getElementById('main');

  function finishLoading() {
    loadingWrapper.classList.add('js--after-counter');
    setTimeout(function () {
      loadingWrapper.classList.add('js--hide');
      setTimeout(function () {
        loadingWrapper.style.display = 'none';
        if (mainContent) mainContent.style.display = 'block';
      }, 500);
    }, 800);
  }

  function updateProgress() {
    loadedImages++;
    const percentComplete = Math.round((loadedImages / totalImages) * 100);
    countElement.textContent = percentComplete + '%';
    if (loadedImages === totalImages) {
      setTimeout(finishLoading, 500);
    }
  }

  if (totalImages === 0) {
    setTimeout(finishLoading, 500);
  } else {
    images.forEach(function (image) {
      let counted = false;
      function countOnce() {
        if (!counted) {
          counted = true;
          updateProgress();
        }
      }
      image.addEventListener('load', countOnce);
      image.addEventListener('error', countOnce);
      // If already complete, still wait for load/error event
      if (image.complete) {
        // Some browsers fire 'load' immediately, but to be safe:
        setTimeout(countOnce, 50);
      }
    });
  }
});
