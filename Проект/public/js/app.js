'use strict';

function togglePasswordVisibility() {
    const togglePasswordBtn = document.getElementById('toggle-password');
    if (!togglePasswordBtn) return;

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

function setupLoginTestCopy() {
    if (window.location.pathname !== '/login') return;

    const parent = document.querySelector('.for-test');
    if (!parent) return;

    parent.addEventListener('click', (e) => {
        const testItem = e.target.closest('.test-item');
        if (testItem) {
            const textToCopy = testItem.querySelector('span').innerText;
            navigator.clipboard.writeText(textToCopy);
        }
    });
}

function setActiveLink() {
    const loc = location.pathname;
    const links = document.querySelectorAll("ul li a");
    links.forEach(link => {
        const href = link.getAttribute("href");
        const path = href.replace(/https?:\/\/[^\/]+(\/\S*)?/g, (m, p = "") => {
            return p || "/";
        });
        if (path == loc){
            link.classList.add("active");
        }
    });
}

function initHomeSlider() {
    if (window.location.pathname !== '/') return;

    const slider = document.querySelector('.slider');
    const sliderList = document.querySelector('.slider-list');
    const sliderItems = document.querySelectorAll('.slider-item');
    const prevBtn = document.querySelector('.pagination-action.prev');
    const nextBtn = document.querySelector('.pagination-action.next');
    const paginationFrom = document.querySelector('.pagination-nums .from');
    const paginationTo = document.querySelector('.pagination-nums .to');

    if (!sliderList || !sliderItems.length) return;

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
        currentIndex = currentIndex > 0 ? currentIndex - 1 : totalSlides - 1;
        updateSlider();
    });

    nextBtn.addEventListener('click', () => {
        currentIndex = currentIndex < totalSlides - 1 ? currentIndex + 1 : 0;
        updateSlider();
    });

    window.addEventListener('resize', updateSlider);
    updateSlider();
}

var phoneInput = document.querySelector('input[type=tel]');

if(phoneInput){
    var getInputNumbersValue = function (input) {
        return input.value.replace(/\D/g, '');
    }

    var formatPhoneNumber = function (nums) {
        if (!nums) return "";

        if (nums[0] === "9") {
            nums = "7" + nums;
        } else if (nums[0] === "8") {
            nums = "7" + nums.substring(1);
        } else if (nums[0] !== "7") {
            nums = "7" + nums;
        }

        nums = nums.substring(0, 11);
        let formatted = "+7";

        if (nums.length > 1) {
            formatted += "(" + nums.substring(1, 4);
        }
        if (nums.length >= 5) {
            formatted += ")-" + nums.substring(4, 7);
        }
        if (nums.length >= 8) {
            formatted += "-" + nums.substring(7, 9);
        }
        if (nums.length >= 10) {
            formatted += "-" + nums.substring(9, 11);
        }

        return formatted;
    }

    var onPhonePaste = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input);
        var pasted = e.clipboardData || window.clipboardData;
        if (pasted) {
            var pastedText = pasted.getData('Text');
            if (/\D/g.test(pastedText)) {
                input.value = formatPhoneNumber(inputNumbersValue);
                return;
            }
        }
    }

    var onPhoneInput = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input);

        if (!inputNumbersValue) {
            input.value = "";
            return;
        }

        var formattedValue = formatPhoneNumber(inputNumbersValue);
        input.value = formattedValue;

        var cursorPos = input.selectionStart;
        var oldLength = input.value.length;
        if (cursorPos <= oldLength) {
            input.setSelectionRange(cursorPos, cursorPos);
        }
    }

    var onPhoneKeyDown = function (e) {
        var inputValue = e.target.value.replace(/\D/g, '');
        if (e.keyCode == 8 && inputValue.length == 1) {
            e.target.value = "";
        }
    }

    var onPhoneFocus = function (e) {
        var input = e.target;
        if (input.value === "") {
            input.value = "+7";
            input.setSelectionRange(2, 2);
        }
    }

    phoneInput.addEventListener('keydown', onPhoneKeyDown);
    phoneInput.addEventListener('input', onPhoneInput, false);
    phoneInput.addEventListener('paste', onPhonePaste, false);
    phoneInput.addEventListener('focus', onPhoneFocus);
}

function openEditModal(data, urlTemplate) {
    document.getElementById('m_fio').value = data.fio || '';
    document.getElementById('m_phone').value = data.phone || '';
    document.getElementById('m_email').value = data.email || '';
    document.getElementById('m_login').value = data.login || '';
    document.getElementById('m_role').value = data.role || 'client';
    const form = document.getElementById('editForm');
    form.action = urlTemplate.replace(':id', data.id);
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('visible');
    maskPhoneInput(document.getElementById('m_phone'));
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('visible');
    modal.classList.add('hidden');
}

function maskPhoneInput(input) {
    if (!input) return;

    var getInputNumbersValue = function (input) {
        return input.value.replace(/\D/g, '');
    }

    var formatPhoneNumber = function (nums) {
        if (!nums) return "";

        if (nums[0] === "9") {
            nums = "7" + nums;
        } else if (nums[0] === "8") {
            nums = "7" + nums.substring(1);
        } else if (nums[0] !== "7") {
            nums = "7" + nums;
        }

        nums = nums.substring(0, 11);
        let formatted = "+7";

        if (nums.length > 1) {
            formatted += "(" + nums.substring(1, 4);
        }
        if (nums.length >= 5) {
            formatted += ")-" + nums.substring(4, 7);
        }
        if (nums.length >= 8) {
            formatted += "-" + nums.substring(7, 9);
        }
        if (nums.length >= 10) {
            formatted += "-" + nums.substring(9, 11);
        }

        return formatted;
    }

    var onPhonePaste = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input);
        var pasted = e.clipboardData || window.clipboardData;
        if (pasted) {
            var pastedText = pasted.getData('Text');
            if (/\D/g.test(pastedText)) {
                input.value = formatPhoneNumber(inputNumbersValue);
                return;
            }
        }
    }

    var onPhoneInput = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input);

        if (!inputNumbersValue) {
            input.value = "";
            return;
        }

        var formattedValue = formatPhoneNumber(inputNumbersValue);
        input.value = formattedValue;

        var cursorPos = input.selectionStart;
        if (cursorPos <= formattedValue.length) {
            input.setSelectionRange(cursorPos, cursorPos);
        }
    }

    var onPhoneKeyDown = function (e) {
        var inputValue = e.target.value.replace(/\D/g, '');
        if (e.keyCode == 8 && inputValue.length == 1) {
            e.target.value = "";
        }
    }

    var onPhoneFocus = function (e) {
        var input = e.target;
        if (input.value === "") {
            input.value = "+7";
            input.setSelectionRange(2, 2);
        }
    }

    input.removeEventListener('keydown', onPhoneKeyDown);
    input.removeEventListener('input', onPhoneInput);
    input.removeEventListener('paste', onPhonePaste);
    input.removeEventListener('focus', onPhoneFocus);

    input.addEventListener('keydown', onPhoneKeyDown);
    input.addEventListener('input', onPhoneInput, false);
    input.addEventListener('paste', onPhonePaste, false);
    input.addEventListener('focus', onPhoneFocus);
}

function setupUserEditModal(urlTemplate) {
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('js-open-edit')) {
            const b = e.target.closest('.js-open-edit');
            openEditModal({
                id: b.dataset.id,
                fio: b.dataset.fio,
                phone: b.dataset.phone,
                email: b.dataset.email,
                login: b.dataset.login,
                role: b.dataset.role,
            }, urlTemplate);
        }
    });
}

function openEditAbonementModal(data, urlTemplate) {
    document.getElementById('a_name').value = data.name || '';
    document.getElementById('a_visits').value = data.visits || '';
    document.getElementById('a_price').value = data.price || '';
    document.getElementById('a_description').value = data.description || '';
    const form = document.getElementById('editAbonementForm');
    form.action = urlTemplate.replace(':id', data.id);
    const modal = document.getElementById('editAbonementModal');
    modal.classList.remove('hidden');
    modal.classList.add('visible');
}

function setupAbonementEditModal(urlTemplate) {
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('js-edit-abonement')) {
            const b = e.target.closest('.js-edit-abonement');
            openEditAbonementModal({
                id: b.dataset.id,
                name: b.dataset.name,
                visits: b.dataset.visits,
                price: b.dataset.price,
                description: b.dataset.description,
            }, urlTemplate);
        }
    });
}

function openEditScheduleModal(data, urlTemplate) {
    document.getElementById('s_name').value = data.name || '';
    const dateValue = data.date ? data.date.substring(0, 16) : '';
    document.getElementById('s_date').value = dateValue;
    document.getElementById('s_trainer_id').value = data.trainer_id || '';
    document.getElementById('s_capacity').value = data.capacity || 15;
    const form = document.getElementById('editScheduleForm');
    form.action = urlTemplate.replace(':id', data.id);
    const modal = document.getElementById('editScheduleModal');
    modal.classList.remove('hidden');
    modal.classList.add('visible');
}

function openStatusScheduleModal(data, urlTemplate) {
    document.getElementById('status_select').value = data.status || 'active';
    const form = document.getElementById('statusScheduleForm');
    form.action = urlTemplate.replace(':id', data.id);
    const modal = document.getElementById('statusScheduleModal');
    modal.classList.remove('hidden');
    modal.classList.add('visible');
}

function setupScheduleEditModal(editUrlTemplate, statusUrlTemplate) {
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('js-edit-schedule')) {
            const b = e.target.closest('.js-edit-schedule');
            openEditScheduleModal({
                id: b.dataset.id,
                name: b.dataset.name,
                date: b.dataset.date,
                trainer_id: b.dataset.trainer_id,
                capacity: b.dataset.capacity,
            }, editUrlTemplate);
        }
        if (e.target && e.target.classList.contains('js-change-status')) {
            const b = e.target.closest('.js-change-status');
            openStatusScheduleModal({
                id: b.dataset.id,
                status: b.dataset.status,
            }, statusUrlTemplate);
        }
    });
}

function startEasterEgg() {
    const gojo = document.getElementById('gojo-easter-egg');
    const gwvuq = document.getElementById('gwvuq-easter-egg');
    if (!gojo || !gwvuq) return;
    if (gojo.classList.contains('active') || gwvuq.classList.contains('active')) return;

    gojo.style.display = 'block';
    gwvuq.style.display = 'block';
    gojo.classList.remove('leaving');
    gwvuq.classList.remove('leaving');
    gojo.classList.add('active');
    gwvuq.classList.add('active');

    setTimeout(() => {
        gojo.classList.add('leaving');
        gwvuq.classList.add('leaving');
        setTimeout(() => {
            gojo.classList.remove('active', 'leaving');
            gwvuq.classList.remove('active', 'leaving');
            gojo.style.display = 'none';
            gwvuq.style.display = 'none';
        }, 1000);
    }, 8000);
}

document.addEventListener('DOMContentLoaded', function() {
    togglePasswordVisibility();
    setupLoginTestCopy();
    setActiveLink();
    initHomeSlider();
});
