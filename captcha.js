// JavaScript CAPTCHA setup
const words = ["sunset", "banana", "planet", "coffee", "castle", "dragon", "forest", "tiger", "cloud", "rocket"];
const randomWord = words[Math.floor(Math.random() * words.length)];
document.addEventListener("DOMContentLoaded", function () {
    const captchaWordEl = document.getElementById("captchaWord");
    const captchaAnswerEl = document.getElementById("captchaAnswer");

    if (captchaWordEl && captchaAnswerEl) {
        captchaWordEl.textContent = randomWord;
        captchaAnswerEl.value = randomWord;
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const error = urlParams.get('error');

    if (success) {
        alert("Thank you! Your message was sent successfully.");
    }

    if (error) {
        alert("Error: " + decodeURIComponent(error));
    }
});