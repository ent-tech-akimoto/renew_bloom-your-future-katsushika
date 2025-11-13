
// export function initCalendarMapButtons() {
//   // Ensure DOM is loaded
//   if (document.readyState === 'loading') {
//     document.addEventListener('DOMContentLoaded', runInit);
//   } else {
//     runInit();
//   }

//   function runInit() {
//     const mapButtons = document.querySelectorAll('.map-btn');
//     const mainFormBox = document.querySelector('.event__calendar-box.area');
//     const modalFormBox = document.querySelector('.event__form-box.area.in-modal');
//     const areaInput = document.getElementById('areaInput');
//     const locateBtn = document.querySelector('.event__modal-map-btn');
//     const modal = document.querySelector('.event__form-modal.area');

//     if (!mainFormBox || !modalFormBox || !areaInput) return;

//     // Coordinates mapped by data-area
//     const areaCoordinates = {
//       main:   { lat: 35.7101, lng: 139.8107 },
//       tora:   { lat: 35.7572, lng: 139.8701 },
//       kochi:  { lat: 35.7175, lng: 139.8260 },
//       iris:   { lat: 35.7443, lng: 139.8308 },
//       wing:   { lat: 35.7055, lng: 139.8358 },
//       monchi: { lat: 35.7258, lng: 139.8322 },
//     };

//     let selectedAreas = [];

//     // --- Update displayed spans and hidden input ---
//     const updateFormBoxes = () => {
//       mainFormBox.innerHTML = '';
//       modalFormBox.innerHTML = '';

//       selectedAreas.forEach(id => {
//         const button = document.querySelector(`.map-btn[data-id="${id}"]`);
//         if (!button) return;
//         const area = button.dataset.area;
//         const text = button.textContent.trim();
//         const spanHTML = `<span class="event__calendar-select--area ${area}" data-area="${area}" data-id="${id}">${text}</span>`;
//         mainFormBox.insertAdjacentHTML('beforeend', spanHTML);
//         modalFormBox.insertAdjacentHTML('beforeend', spanHTML);
//       });

//       areaInput.value = selectedAreas.join(',');

//       // Add click handler to remove selected span
//       document.querySelectorAll('.event__calendar-select--area').forEach(span => {
//         span.addEventListener('click', () => {
//           const id = span.dataset.id;
//           selectedAreas = selectedAreas.filter(x => x !== id);

//           const btn = document.querySelector(`.map-btn[data-id="${id}"]`);
//           if (btn) btn.classList.remove('js-active');

//           if (modal && modal.classList.contains('js-show')) modal.classList.remove('js-show');

//           updateFormBoxes();
//         });
//       });
//     };

//     // --- Toggle map buttons ---
//     mapButtons.forEach(button => {
//       button.addEventListener('click', () => {
//         const id = button.dataset.id;

//         if (button.classList.contains('js-active')) {
//           button.classList.remove('js-active');
//           selectedAreas = selectedAreas.filter(x => x !== id);
//         } else {
//           button.classList.add('js-active');
//           selectedAreas.push(id);
//         }

//         updateFormBoxes();
//       });
//     });

//     // --- Initialize selectedAreas from pre-active buttons ---
//     selectedAreas = Array.from(mapButtons)
//       .filter(btn => btn.classList.contains('js-active'))
//       .map(btn => btn.dataset.id);

//     updateFormBoxes();

//     // --- Handle "現在地付近" geolocation button ---
//     if (locateBtn) {
//       locateBtn.addEventListener('click', () => {
//         if (modal && !modal.classList.contains('js-show')) modal.classList.add('js-show');

//         if (!navigator.geolocation) {
//           alert('位置情報がサポートされていません。');
//           return;
//         }

//         navigator.geolocation.getCurrentPosition(
//           pos => {
//             const { latitude, longitude } = pos.coords;

//             const calcDistance = (lat1, lng1, lat2, lng2) => {
//               const R = 6371; // km
//               const dLat = ((lat2 - lat1) * Math.PI) / 180;
//               const dLng = ((lng2 - lng1) * Math.PI) / 180;
//               const a =
//                 Math.sin(dLat / 2) ** 2 +
//                 Math.cos((lat1 * Math.PI) / 180) *
//                 Math.cos((lat2 * Math.PI) / 180) *
//                 Math.sin(dLng / 2) ** 2;
//               const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
//               return R * c;
//             };

//             // Sort areas by distance
//             const sorted = Array.from(mapButtons)
//               .map(btn => {
//                 const id = btn.dataset.id;
//                 const area = btn.dataset.area;
//                 const loc = areaCoordinates[area];
//                 const distance = calcDistance(latitude, longitude, loc.lat, loc.lng);
//                 return { id, distance };
//               })
//               .sort((a, b) => a.distance - b.distance)
//               .map(item => item.id);

//             mapButtons.forEach(btn => btn.classList.add('js-active'));
//             selectedAreas = sorted;
//             updateFormBoxes();
//           },
//           err => {
//             alert('位置情報の取得に失敗しました。');
//             console.error(err);
//           }
//         );
//       });
//     }
//   }
// }

export function initCalendarMapButtons() {
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runInit);
  } else {
    runInit();
  }

  function runInit() {
    const mapButtons = document.querySelectorAll('.map-btn');
    const mainFormBox = document.querySelector('.event__calendar-box.area');
    const modalFormBox = document.querySelector('.event__form-box.area.in-modal');
    const areaInput = document.getElementById('areaInput');
    const locateBtn = document.querySelector('.event__modal-map-btn');
    const modal = document.querySelector('.event__form-modal.area');
    const areaOrderInput = document.getElementById('areaOrderInput');

    if (!mainFormBox || !modalFormBox || !areaInput) return;

    const areaCoordinates = {
      main: { lat: 35.770909792881874, lng: 139.8624680874483 },
      tora: { lat: 35.75753015921082, lng: 139.88038875772045 },
      kochi: { lat: 35.75972343115677, lng: 139.8452226324852 },
      iris: { lat: 35.742737257711084, lng: 139.82608050469457 },
      wing: { lat: 35.73565864018385, lng: 139.84274709611046 },
      monchi: { lat: 35.71712051458683, lng: 139.85809638146586 },
    };

    let selectedAreas = [];

    const updateFormBoxes = () => {
      mainFormBox.innerHTML = '';
      modalFormBox.innerHTML = '';

      selectedAreas.forEach(id => {
        const button = document.querySelector(`.map-btn[data-id="${id}"]`);
        if (!button) return;
        const area = button.dataset.area;
        const text = button.textContent.trim();
        const spanHTML = `
          <span class="event__calendar-select--area ${area}" data-area="${area}" data-id="${id}">
            ${text}<span class="btn-close"></span>
          </span>`;
        mainFormBox.insertAdjacentHTML('beforeend', spanHTML);
        modalFormBox.insertAdjacentHTML('beforeend', spanHTML);
      });

      areaInput.value = selectedAreas.join(',');
    };

    // Delegate click for removing selected area
    [mainFormBox, modalFormBox].forEach(box => {
      box.addEventListener('click', e => {
        if (!e.target.classList.contains('btn-close')) return;
        const parent = e.target.closest('.event__calendar-select--area');
        if (!parent) return;
        const id = parent.dataset.id;
        selectedAreas = selectedAreas.filter(x => x !== id);
        const btn = document.querySelector(`.map-btn[data-id="${id}"]`);
        if (btn) btn.classList.remove('js-active');
        updateFormBoxes();
      });
    });

    // Map button toggle
    mapButtons.forEach(button => {
      button.addEventListener('click', () => {
        const id = button.dataset.id;
        if (button.classList.contains('js-active')) {
          button.classList.remove('js-active');
          selectedAreas = selectedAreas.filter(x => x !== id);
        } else {
          button.classList.add('js-active');
          selectedAreas.push(id);
        }

        locateBtn.classList.remove('js--active');
        document.querySelector(`.event__modal-map--loading`).classList.remove('js--active');
        const areaOrderInput = document.getElementById('areaOrderInput');
        if (areaOrderInput) areaOrderInput.removeAttribute('value');
        updateFormBoxes();
      });
    });

    // --- Initialize from URL parameter or default ---
    const urlParams = new URLSearchParams(window.location.search);
    const areaParam = urlParams.get('area');

    if (areaParam) {
      // Use the URL parameter
      selectedAreas = areaParam.split(',').filter(Boolean);
    } else {
      // Default: all button IDs in DOM order
      selectedAreas = Array.from(mapButtons).map(btn => btn.dataset.id);
    }

    // Add js-active to buttons based on selectedAreas
    selectedAreas.forEach(id => {
      const btn = document.querySelector(`.map-btn[data-id="${id}"]`);
      if (btn) btn.classList.add('js-active');
    });

    // Reflect initial state in the form boxes and hidden input
    updateFormBoxes();

    // --- Locate button logic ---
    if (locateBtn) {
      locateBtn.addEventListener('click', () => {
        if (!navigator.geolocation) {
          alert('位置情報がサポートされていません。');
          return;
        }

        if (locateBtn.classList.contains('js--active')) {
          locateBtn.classList.remove('js--active');
          document.querySelector(`.event__modal-map--loading`).classList.remove('js--active');
          const areaOrderInput = document.getElementById('areaOrderInput');
          if (areaOrderInput) areaOrderInput.removeAttribute('value');
        }
        else {
          locateBtn.classList.add('js--active');
          document.querySelector(`.event__modal-map--loading`).classList.add('js--active');
          navigator.geolocation.getCurrentPosition(
            pos => {
              const { latitude, longitude } = pos.coords;

              const calcDistance = (lat1, lng1, lat2, lng2) => {
                const R = 6371;
                const dLat = ((lat2 - lat1) * Math.PI) / 180;
                const dLng = ((lng2 - lng1) * Math.PI) / 180;
                const a =
                  Math.sin(dLat / 2) ** 2 +
                  Math.cos((lat1 * Math.PI) / 180) *
                  Math.cos((lat2 * Math.PI) / 180) *
                  Math.sin(dLng / 2) ** 2;
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                return R * c;
              };

              const sorted = Array.from(mapButtons)
                .map(btn => {
                  const id = btn.dataset.id;
                  const area = btn.dataset.area;
                  const loc = areaCoordinates[area];
                  if (!loc) return { id, distance: 999999 };
                  const distance = calcDistance(latitude, longitude, loc.lat, loc.lng);
                  return { id, distance };
                })
                .sort((a, b) => a.distance - b.distance)
                .map(item => item.id);

              mapButtons.forEach(btn => btn.classList.add('js-active'));
              selectedAreas = sorted;

              if (areaOrderInput) areaOrderInput.value = 'nearby';
              updateFormBoxes();

              setTimeout(() => {
                document.querySelector(`.event__modal-map--loading`).classList.remove('js--active');
              }, 1000);
            },
            err => {
              alert('位置情報の取得に失敗しました。');
              console.error(err);
            }
          );
        }
      });
    }
  }
}
