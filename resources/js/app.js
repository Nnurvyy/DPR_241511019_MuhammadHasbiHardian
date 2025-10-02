import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.querySelectorAll("button").forEach(btn => {
  btn.addEventListener("click", () => {
    document.querySelectorAll("button").forEach(b => b.classList.remove("active-btn"));
    btn.classList.add("active-btn");
  });
});
