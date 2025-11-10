document.addEventListener("DOMContentLoaded", () => {
  // Select all forms on the page (or just one, if only one exists)
  const forms = document.querySelectorAll("form");

  forms.forEach((form) => {
    // Add listener to every submit event in the form
    form.addEventListener("submit", () => {
      const inputs = form.querySelectorAll("input, textarea, select");

      inputs.forEach((el) => {
        // Disable elements that are empty, null, or just whitespace
        if (!el.value || el.value.trim() === "") {
          el.disabled = true;
        }
      });
    });
  });
});