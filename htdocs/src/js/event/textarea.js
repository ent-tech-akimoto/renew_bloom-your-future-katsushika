document.querySelectorAll('textarea').forEach(textarea => {
  textarea.addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
    }
  });
});