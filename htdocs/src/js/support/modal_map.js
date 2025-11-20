document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("modal-map");
  const openBtn = document.getElementById("openMap");

  function openModal() {
    modal.classList.add("js-show");
    document.body.style.overflow = "hidden";
  }

  function closeModal() {
    modal.classList.remove("js-show");
    document.body.style.overflow = "";
  }

  // 1) Click button → open modal
  openBtn.addEventListener("click", (e) => {
    e.stopPropagation(); // prevent this click from triggering the "close on document click"
    openModal();
  });

  // 2) Any click anywhere after that → close modal
  document.addEventListener("click", () => {
    if (modal.classList.contains("js-show")) {
      closeModal();
    }
  });

  // 3) Stop clicks inside modal from bubbling to document *only if*
  //    you DON'T want clicking inside to close it.
  //    But in your case you WANT clicks inside to close, so we skip this.
  // modal.addEventListener("click", (e) => {
  //   e.stopPropagation();
  // });
});
