document.addEventListener("DOMContentLoaded", () => {
  const modal = document.getElementById("modal-map");
  const openBtn = document.getElementById("openMap");
  const closeBtn = modal.querySelector(".support__modal-close");
  const bg = modal.querySelector(".support__modal-bg");

  function openModal() {
    modal.classList.add("js-show");
    document.body.style.overflow = "hidden";
  }

  function closeModal() {
    modal.classList.remove("js-show");
    document.body.style.overflow = "";
  }

  openBtn.addEventListener("click", openModal);
  closeBtn.addEventListener("click", closeModal);
  bg.addEventListener("click", closeModal);
});
