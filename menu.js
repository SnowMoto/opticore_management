document.addEventListener("DOMContentLoaded", function () {
  const burger = document.getElementById("burger-menu");
  const menu = document.getElementById("mobile-menu");

  burger.addEventListener("click", function () {
    menu.classList.toggle("active");
  });
});