//* Homework-27

let form = document.conversion;
let inputs = form.curruncy;
let button = form.result;
let statusBar = document.querySelector('.statusBar_body');
let statusMessage = {
    failed: 'Что-то пошло не так',
    successful: 'Данные успешно получены',
    processing: 'Отправка запроса на сервер',
};
let inputStatus = {
    activeInput: null,
    otherFields: [],
    result: false,
}
function inputControl() {
    inputStatus.otherFields = [];
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].value !== '') {
            inputStatus.activeInput = inputs[i];
            continue
        }
        inputStatus.otherFields.push(inputs[i]);
    }
}
function clearInput() {
    for (let key of inputs) {
        key.value = '';
    }
    inputStatus.result = false;
    inputStatus.activeInput.readOnly = false;
    inputStatus.otherFields[0].readOnly = false;
    inputStatus.otherFields[1].readOnly = false;
}
function clearStatusBar() {
    setTimeout(() => statusBar.innerHTML = '----', 5000)
}
function clearStatusBarWait() {
    setTimeout(() => {
        if (inputStatus.result === false) {
            statusBar.innerHTML = 'Превышено время ожидания'
            setTimeout(() => {
                if (inputStatus.result === false) {
                    statusBar.innerHTML = 'Проверьте интернет и перезагрузите страницу'
                    setTimeout(() => statusBar.innerHTML = '----', 3000)        
                }
            }, 3000)
        }
    }, 6000)
}
function calculationButtonAccess() {
    let pattern = /[^0-9]/g;
    if (inputStatus.activeInput == null || inputStatus.otherFields.length > 2) {
        button.disabled = true;
        button.innerHTML = 'Введите число в одно любое поле';
    } else if (inputStatus.otherFields.length < 2) {
        button.disabled = true;
        button.classList.add('noBorder')
        button.innerHTML = 'Можно заполнить лишь одно поле';
    } else {
        button.disabled = false;
        if (button.classList.contains('noBorder')) {
            button.classList.remove('noBorder')
        }
        button.innerHTML = 'Посчитать';
    }
    if (pattern.test(inputStatus.activeInput.value)) {
        if (!button.classList.contains('noBorder')) {
            button.classList.add('noBorder')
        }
        button.innerHTML = 'Поля принимают только числа';
        button.disabled = true;
    }
    if (inputStatus.result === true) {
        if (button.classList.contains('noBorder')) {
            button.classList.remove('noBorder')
        }
        inputStatus.activeInput.readOnly = true;
        inputStatus.otherFields[0].readOnly = true;
        inputStatus.otherFields[1].readOnly = true;
        button.innerHTML = 'Очистить поля?';
    }
}
function resultInInput(data) {
    if(inputStatus.activeInput.classList.contains('firstInput')) {
        inputStatus.otherFields[0].value = (inputStatus.activeInput.value * data.RUB.toUSD).toFixed(2)
        inputStatus.otherFields[1].value = (inputStatus.activeInput.value * data.RUB.toEUR).toFixed(2)
    }
    if(inputStatus.activeInput.classList.contains('secondInput')) {
        inputStatus.otherFields[0].value = (inputStatus.activeInput.value * data.USD.toRUR).toFixed(2)
        inputStatus.otherFields[1].value = (inputStatus.activeInput.value * data.USD.toEUR).toFixed(2)
    }
    if(inputStatus.activeInput.classList.contains('thirdInput')) {
        inputStatus.otherFields[0].value = (inputStatus.activeInput.value * data.EUR.toRUR).toFixed(2)
        inputStatus.otherFields[1].value = (inputStatus.activeInput.value * data.EUR.toUSD).toFixed(2)
    }
}
inputs.forEach(el => {
    el.addEventListener('input', () => {
        inputControl()
        calculationButtonAccess()
    })
});
let clickOnButton = 0;
form.addEventListener('submit', (e) => {
    if (clickOnButton == 1) {
        clickOnButton = 0;
        e.preventDefault();
        clearInput();
        inputControl();
        calculationButtonAccess();
    } else if (clickOnButton == 0) {
        clickOnButton = 1;
        inputStatus.activeInput.readOnly = true;
        inputStatus.otherFields[0].readOnly = true;
        inputStatus.otherFields[1].readOnly = true;
        e.preventDefault();
        let request = new XMLHttpRequest();
        request.open('POST', 'currency.JSON');
        statusBar.innerHTML = statusMessage.processing;
        button.innerHTML = 'Очистить поля не дожидаясь ответа!';
        clearStatusBarWait();
        request.send();
        request.addEventListener('readystatechange', () => {
            if ((request.readyState == 4) && (request.status == 200)) {
                let data = JSON.parse(request.response)
                resultInInput(data);
                statusBar.innerHTML = statusMessage.successful;
                inputStatus.result = true;
                clearStatusBar();
                calculationButtonAccess();
            };
            if ((request.status == 404)) {
                statusBar.innerHTML = statusMessage.failed;
                clearStatusBar();
                inputStatus.result = true;
            };
        });
    }
});
let forParallax = {
    firstImg: document.querySelector('.decorationImageFirst_img'),
    secondImg: document.querySelector('.decorationImageSecond_img'),
}
function parallax(x, y) {
    forParallax.firstImg.setAttribute('style', 'left: ' + x + 'px; ' + 'top: ' + y + 'px');
    forParallax.secondImg.setAttribute('style', 'left: ' + x + 'px; ' + 'top: ' + y + 'px');
}
document.addEventListener('mousemove', (e) => {
    x = (e.clientX / window.innerWidth * 30) - 15;
    y = (e.clientY / window.innerHeight * 10) - 5;
    parallax(x, y);
})



