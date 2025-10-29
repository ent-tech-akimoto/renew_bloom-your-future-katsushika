// Map buttons: add `js-active` to matching area div when button[data-area] is clicked
// Example: <button data-area="area1"> -> activates <div id="area1"> by adding .js-active
(function () {
	document.addEventListener('DOMContentLoaded', function () {
		var buttons = document.querySelectorAll('.top-map__button-item[data-area]');
		if (!buttons || buttons.length === 0) return;

		var areaSelector = '.top-map__detail';

		function activate(areaId, clickedButton) {
			// Toggle content areas
			var areas = document.querySelectorAll(areaSelector);
			areas.forEach(function (el) {
				if (el.id === areaId) {
					el.classList.add('js-active');
				} else {
					el.classList.remove('js-active');
				}
			});

			// Toggle button states
			buttons.forEach(function (btn) {
				if (btn === clickedButton) {
					btn.classList.add('js-active');
				} else {
					btn.classList.remove('js-active');
				}
			});
		}

		buttons.forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				var area = btn.getAttribute('data-area');
				if (!area) return;
				activate(area, btn);
			});
			// support Enter/Space for accessibility when buttons are keyboard-focused
			btn.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					btn.click();
				}
			});
		});
	});
})();

