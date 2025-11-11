// export function initMapButtons() {
//   const mapButtons = document.querySelectorAll('.map-btn');
//   const mainFormBox = document.querySelector('.event__form-box.area:not(.in-modal)');
//   const modalFormBox = document.querySelector('.event__form-box.area.in-modal');
//   const areaInput = document.getElementById('areaInput');
//   const locateBtn = document.querySelector('.common__btn-w.event__modal-map-btn');
//   const modal = document.querySelector('.event__form-modal.area');

//   // Coordinates mapped by data-area
//   const areaCoordinates = {
//     main:   { lat: 35.7101, lng: 139.8107 },
//     tora:   { lat: 35.7572, lng: 139.8701 },
//     kochi:  { lat: 35.7175, lng: 139.8260 },
//     iris:   { lat: 35.7443, lng: 139.8308 },
//     wing:   { lat: 35.7055, lng: 139.8358 },
//     monchi: { lat: 35.7258, lng: 139.8322 },
//   };

//   let selectedAreas = [];

//   const updateFormBoxes = () => {
//     mainFormBox.innerHTML = '';
//     modalFormBox.innerHTML = '';

//     selectedAreas.forEach(id => {
//       const button = document.querySelector(`.map-btn[data-id="${id}"]`);
//       if (!button) return;
//       const area = button.dataset.area;
//       const text = button.textContent.trim();
//       const spanHTML = `<span class="event__form-select--area ${area}" data-area="${area}" data-id="${id}">${text}</span>`;
//       mainFormBox.insertAdjacentHTML('beforeend', spanHTML);
//       modalFormBox.insertAdjacentHTML('beforeend', spanHTML);
//     });

//     areaInput.value = selectedAreas.join(',');

//     // Attach close click handler to newly inserted spans
//     document.querySelectorAll('.event__form-select--area').forEach(span => {
//       span.addEventListener('click', (e) => {
//         // Only remove if the after/close button is clicked (simulate)
//         // Optional: you can check e.offsetX/y if needed for :after, here we assume any click on span closes
//         const id = span.dataset.id;

//         // Remove from selectedAreas
//         selectedAreas = selectedAreas.filter(x => x !== id);

//         // Remove js-active from corresponding map-btn
//         const btn = document.querySelector(`.map-btn[data-id="${id}"]`);
//         if (btn) btn.classList.remove('js-active');

//         // Remove modal if open
//         if (modal && modal.classList.contains('js-show')) {
//           modal.classList.remove('js-show');
//         }

//         // Update boxes
//         updateFormBoxes();
//       });
//     });
//   };

//   // --- Original toggle behavior ---
//   mapButtons.forEach(button => {
//     button.addEventListener('click', () => {
//       const id = button.dataset.id;

//       if (button.classList.contains('js-active')) {
//         button.classList.remove('js-active');
//         selectedAreas = selectedAreas.filter(x => x !== id);
//       } else {
//         button.classList.add('js-active');
//         selectedAreas.push(id);
//       }

//       updateFormBoxes();
//     });
//   });

//   // --- Initialize selectedAreas from pre-active buttons ---
//   selectedAreas = Array.from(mapButtons)
//     .filter(btn => btn.classList.contains('js-active'))
//     .map(btn => btn.dataset.id);

//   updateFormBoxes();

//   // --- Handle 現在地付近 button ---
//   if (locateBtn) {
//     locateBtn.addEventListener('click', () => {
//       if (modal && !modal.classList.contains('js-show')) {
//         modal.classList.add('js-show');
//       }

//       if (!navigator.geolocation) {
//         alert('位置情報がサポートされていません。');
//         return;
//       }

//       navigator.geolocation.getCurrentPosition(
//         pos => {
//           const { latitude, longitude } = pos.coords;

//           const calcDistance = (lat1, lng1, lat2, lng2) => {
//             const R = 6371;
//             const dLat = ((lat2 - lat1) * Math.PI) / 180;
//             const dLng = ((lng2 - lng1) * Math.PI) / 180;
//             const a =
//               Math.sin(dLat / 2) ** 2 +
//               Math.cos((lat1 * Math.PI) / 180) *
//               Math.cos((lat2 * Math.PI) / 180) *
//               Math.sin(dLng / 2) ** 2;
//             const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
//             return R * c;
//           };

//           // Sort buttons by distance using data-area
//           const sorted = Array.from(mapButtons)
//             .map(btn => {
//               const id = btn.dataset.id;
//               const area = btn.dataset.area;
//               const loc = areaCoordinates[area];
//               const distance = calcDistance(latitude, longitude, loc.lat, loc.lng);
//               return { id, distance };
//             })
//             .sort((a, b) => a.distance - b.distance)
//             .map(item => item.id);

//           // Set all buttons as js-active
//           mapButtons.forEach(btn => btn.classList.add('js-active'));

//           // Update selectedAreas with nearest → furthest
//           selectedAreas = sorted;
//           updateFormBoxes();
//         },
//         err => {
//           alert('位置情報の取得に失敗しました。');
//           console.error(err);
//         }
//       );
//     });
//   }
// }

export function initMapButtons() {
  const mapButtons = document.querySelectorAll('.map-btn');
  const mainFormBox = document.querySelector('.event__form-box.area:not(.in-modal)');
  const modalFormBox = document.querySelector('.event__form-box.area.in-modal');
  const areaInput = document.getElementById('areaInput');
  const locateBtn = document.querySelector('.common__btn-w.event__modal-map-btn');
  const modal = document.querySelector('.event__form-modal.area');

  // Coordinates mapped by data-area
  const areaCoordinates = {
    main:   { lat: 35.7101, lng: 139.8107 },
    tora:   { lat: 35.7572, lng: 139.8701 },
    kochi:  { lat: 35.7175, lng: 139.8260 },
    iris:   { lat: 35.7443, lng: 139.8308 },
    wing:   { lat: 35.7055, lng: 139.8358 },
    monchi: { lat: 35.7258, lng: 139.8322 },
  };

  // This array maintains click order
  let selectedAreas = [];

  const updateFormBoxes = () => {
    mainFormBox.innerHTML = '';
    modalFormBox.innerHTML = '';

    selectedAreas.forEach(id => {
      const button = document.querySelector(`.map-btn[data-id="${id}"]`);
      if (!button) return;
      const area = button.dataset.area;
      const text = button.textContent.trim();
      const spanHTML = `<span class="event__form-select--area ${area}" data-area="${area}" data-id="${id}">${text}</span>`;
      mainFormBox.insertAdjacentHTML('beforeend', spanHTML);
      modalFormBox.insertAdjacentHTML('beforeend', spanHTML);
    });

    areaInput.value = selectedAreas.join(',');
  };

  // Delegate span click to remove selected area (no duplicate listeners)
  [mainFormBox, modalFormBox].forEach(box => {
    box.addEventListener('click', (e) => {
      if (!e.target.classList.contains('event__form-select--area')) return;

      const id = e.target.dataset.id;
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

      updateFormBoxes();
    });
  });

  // Initialize selectedAreas in click/DOM order
  selectedAreas = Array.from(mapButtons)
    .filter(btn => btn.classList.contains('js-active'))
    .map(btn => btn.dataset.id);

  updateFormBoxes();

  // Handle 現在地付近 button
  // --- 現在地付近ボタン ---
  if (locateBtn) {
    locateBtn.addEventListener('click', () => {
      if (modal && !modal.classList.contains('js-show')) {
        modal.classList.add('js-show');
      }

      if (!navigator.geolocation) {
        alert('位置情報がサポートされていません。');
        return;
      }

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
              if (!loc) return { id, distance: 999999 }; // safety fallback
              const distance = calcDistance(latitude, longitude, loc.lat, loc.lng);
              return { id, distance };
            })
            .sort((a, b) => a.distance - b.distance)
            .map(item => item.id);

          // 全部選択状態にする
          mapButtons.forEach(btn => btn.classList.add('js-active'));

          // 並びは近い順
          selectedAreas = sorted;

          // ★このときだけ「nearby」モードにする
          if (areaOrderInput) {
            areaOrderInput.value = 'nearby';  // <- NEW / highlighted
          }

          updateFormBoxes();
        },
        err => {
          alert('位置情報の取得に失敗しました。');
          console.error(err);
        }
      );
    });
  }
}
