const ajaxUrl = '/wordpress/wp-admin/admin-ajax.php';

document.addEventListener('DOMContentLoaded', function () {
  const outerInput = document.querySelector('.event__form-flex.word textarea.event__form-box.word[name="keyword"]');
  const modalInput = document.querySelector('.event__form-modal.word[data-modal="modal4"] textarea.event__form-box.word');
  const suggestList = document.querySelector('.event__form-modal.word[data-modal="modal4"] .event__modal-word');

  if (!outerInput || !modalInput || !suggestList) return;

  modalInput.value = outerInput.value;

  let timer = null;
  // ▼ サジェストを取得して <ul> に出力
  function fetchSuggest(keyword) {
    clearTimeout(timer);

    if (!keyword) {
      suggestList.innerHTML = '';
      return;
    }
    timer = setTimeout(function () {
      const url = `${ajaxUrl}?action=event_keyword_suggest&q=${encodeURIComponent(keyword)}`;
      fetch(url)
        .then(res => res.json())
        .then(data => {
          if (!data.success) return;

          const words = data.data;
          suggestList.innerHTML = '';

          if (!words.length) {
            const li = document.createElement('li');
            li.textContent = '候補がありません';
            li.classList.add('is-empty');
            suggestList.appendChild(li);
            return;
          }
          words.forEach(word => {
            const li = document.createElement('li');
            li.textContent = word;
            suggestList.appendChild(li);
          });
        })
        .catch(err => console.warn('suggest error', err));
    }, 200);
  }
  // ▼ 外側入力時：モーダルへ同期＋候補取得
  outerInput.addEventListener('input', e => {
    modalInput.value = e.target.value;
    fetchSuggest(e.target.value);
  });
  // ▼ モーダル入力時：外側へ同期＋候補取得
  modalInput.addEventListener('input', e => {
    outerInput.value = e.target.value;
    fetchSuggest(e.target.value);
  });
  // ▼ 候補クリックで両方に反映
  suggestList.addEventListener('click', e => {
    const li = e.target.closest('li');
    if (!li || li.classList.contains('is-empty')) return;
    const text = li.textContent;
    modalInput.value = text;
    outerInput.value = text;
  });
});