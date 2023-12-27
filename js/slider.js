
let currentSlide = 0;

function showSlide(index) {
    const slides = document.querySelectorAll('.slide');
    const autoButtons = document.querySelectorAll('.container__wrapper-sliders-navigation-auto div');

    slides.forEach((slide, i) => {
        slide.style.transform = `translateX(-${index * 100}%)`;
    });

    autoButtons.forEach((button, i) => {
        button.style.background = i === index ? 'var(--button)' : 'transparent';
    });
}

function autoSlide() {
    currentSlide = (currentSlide + 1) % 4;
    showSlide(currentSlide);
}

// Change slide every 3 seconds (adjust as needed)
setInterval(autoSlide, 3000);

// Add event listeners for manual navigation
document.getElementById('radio1').addEventListener('change', () => showSlide(0));
document.getElementById('radio2').addEventListener('change', () => showSlide(1));
document.getElementById('radio3').addEventListener('change', () => showSlide(2));
document.getElementById('radio4').addEventListener('change', () => showSlide(3));

// Initial slide display
showSlide(0);
