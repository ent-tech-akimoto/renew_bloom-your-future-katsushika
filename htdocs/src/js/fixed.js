// Close fixed notice: remove .js-show from .fixed when the #fixed-close button is clicked
(function () {
	document.addEventListener('DOMContentLoaded', function () {
		var btn = document.getElementById('fixed-close');
		if (!btn) return;
		var fixedEl = document.querySelector('.fixed');
		if (!fixedEl) return;

		btn.addEventListener('click', function () {
			fixedEl.classList.remove('js-show');
		});

		// keyboard accessibility: allow Enter/Space
		btn.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				btn.click();
			}
		});
	});
})();

