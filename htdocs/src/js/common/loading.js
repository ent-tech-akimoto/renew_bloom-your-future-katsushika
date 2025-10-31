document.addEventListener('DOMContentLoaded', function() {
  const images = Array.from(document.querySelectorAll('img')).filter(
    img => !img.complete && img.loading !== 'lazy'
  );
  const loadedImagesTotal = images.length;
  let loadedImages = 0;

  const loadingBar = document.getElementById('loadingBar');
  const loadingWrapper = document.getElementById('loading');
  const mainContent = document.getElementById('main');

  // Calculate and set circle radius using Pythagoras:
  // radius = sqrt((halfWidth)^2 + (height)^2)
  function setCircleRadius() {
    if (!loadingWrapper) return;
    const halfWidth = window.innerWidth / 2;
    const height = window.innerHeight;
    const radius = Math.sqrt(halfWidth * halfWidth + height * height);
    // expose as CSS variable (px)
    loadingWrapper.style.setProperty('--circle-radius', `${Math.ceil(radius)}px`);
  }

  // initialize radius and update on resize (debounced)
  setCircleRadius();
  let resizeTimer;
  window.addEventListener('resize', () => {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(setCircleRadius, 120);
  });

  function updateProgressBar(percent) {
    if (!loadingBar) return;
    loadingBar.style.setProperty('--progress', `${Math.min(Math.max(percent, 0), 100)}%`);
  }

  function finishLoading() {
    if (loadingWrapper) loadingWrapper.classList.add('js-hide');
    if (mainContent) {
      setTimeout(() => {
        mainContent.style.display = 'block';
      }, 400);
    }
  }

  // If there are no images to track, show a quick progress animation then finish
  if (loadedImagesTotal === 0) {
    let progress = 0;
    const interval = setInterval(() => {
      progress += 4;
      updateProgressBar(Math.min(progress, 100));
      if (progress >= 100) {
        clearInterval(interval);
        setTimeout(finishLoading, 300);
      }
    }, 30);
    return;
  }

  function updateProgress() {
    loadedImages++;
    const percentComplete = Math.min((loadedImages / loadedImagesTotal) * 100, 100);
    updateProgressBar(percentComplete);
    if (loadedImages >= loadedImagesTotal) {
      setTimeout(finishLoading, 500);
    }
  }

  // Attach listeners
  images.forEach(img => {
    if (img.complete) {
      updateProgress();
    } else {
      img.addEventListener('load', updateProgress);
      img.addEventListener('error', updateProgress);
    }
  });
});
