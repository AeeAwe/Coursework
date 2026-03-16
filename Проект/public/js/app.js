'use strict';

const togglePasswordBtn = document.getElementById('toggle-password');
if (togglePasswordBtn) {
    const passwordInput = document.getElementById('password');
    const openIcon = document.querySelector('.open');
    const closeIcon = document.querySelector('.close');
    togglePasswordBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const isPassword = passwordInput.type === 'password';
        if (isPassword) {
            passwordInput.type = 'text';
            openIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            closeIcon.classList.add('hidden');
            openIcon.classList.remove('hidden');
        }
    });
}

if (window.location.pathname === '/login') {
    const parent = document.querySelector('.for-test');
    if (parent) {
        parent.addEventListener('click', (e) => {
            const clickedElement = e.target;
            const testItem = clickedElement.closest('.test-item');
            if (testItem) {
                const textToCopy = testItem.querySelector('span').innerText;
                navigator.clipboard.writeText(textToCopy)
                    .then(() => {
                        console.log('Текст скопирован: ', textToCopy);
                    })
                    .catch(err => {
                        console.error('Ошибка при копировании: ', err);
                    });
            }
        });
    }
}

const checkLocate = () => {
    const loc = location.pathname;
    const links = document.querySelectorAll("ul li a");
    links.forEach(link => {
        const href = link.getAttribute("href");
        const path = href.replace(/https?:\/\/[^\/]+(\/\S*)?/g, (m, p = "") => {
            return p || "/";
        });
        if (path == loc){
            link.classList.add("active");
        };
    });
};
checkLocate();

if (window.location.pathname === '/') {
    const slider = document.querySelector('.slider');
    const sliderList = document.querySelector('.slider-list');
    const sliderItems = document.querySelectorAll('.slider-item');
    const prevBtn = document.querySelector('.pagination-action.prev');
    const nextBtn = document.querySelector('.pagination-action.next');
    const paginationFrom = document.querySelector('.pagination-nums .from');
    const paginationTo = document.querySelector('.pagination-nums .to');

    let currentIndex = 0;
    const totalSlides = sliderItems.length;
    paginationTo.textContent = totalSlides.toString().padStart(2, '0');

    function updateCounter() {
        paginationFrom.textContent = (currentIndex + 1).toString().padStart(2, '0');
    }

    function updateSlider() {
        const slideWidth = sliderItems[0].offsetWidth;
        const gap = parseInt(window.getComputedStyle(sliderList).getPropertyValue('gap'));
        const totalOffset = currentIndex * (slideWidth + gap);
        sliderList.style.transform = `translateX(-${totalOffset}px)`;
        updateCounter();
    }
    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = totalSlides - 1;
        }
        updateSlider();
    });
    nextBtn.addEventListener('click', () => {
        if (currentIndex < totalSlides - 1) {
            currentIndex++;
        } else {

            currentIndex = 0;
        }
        updateSlider();
    });
    window.addEventListener('resize', updateSlider);
    updateSlider();
}
