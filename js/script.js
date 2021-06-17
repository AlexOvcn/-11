//* Homework-28


let reg_login = /[^A-z\-_]/; // /[\*%$#@!~`+()&№^.,/?'";:{[\\\]=|}]/
let reg_name = /[^А-я]/; 
let reg_pass = /[^A-z0-9+*_\-.]/;

/*
Логин: английские буквы в любом регистре, подчеркивание и дефис (Можно использовать один символ дефиса или подчеркивания, и не более одного вхождения)
Имя: русские буквы в любом регистре
Дата: 2021-01-31
Пароль: английские буквы в любом регистре, цифры, знаки: +*_- и точка 
*/

let regExpOfInputsForFormOne = [reg_login, reg_name, reg_pass];
let idsOfInputsForFormOne = ['login', 'name', 'pass'];
let formOne = document.querySelector('#formOne')
let inputs = formOne.querySelectorAll('.sectionOne-formOne__element_input')

for (let i = 0; i < inputs.length; i++) {
    let id = idsOfInputsForFormOne[i];
    let reg = regExpOfInputsForFormOne[i];
    inputs[i].addEventListener('input', () => check(id, reg))
}

function check(id, reg){ //функция проверки полей, принимает значение id поля и регулярное выражение для него
    let input = document.getElementById(id);
    let value = document.getElementById(id).value;
    if (reg.test(value) === false && value.length > 0){
        if (id == 'login') {
            if(value.match(/[-_]/g) !== null && value.match(/[-_]/g).length > 1 ) {
                input.style.border = '2px groove rgb(255, 115, 115)';
                return false;
            }
        }
        input.style.border = '2px groove rgb(91, 190, 91)';
        return true;
    } else if (value.length <= 0) {
        input.style.border = '2px groove rgb(192, 192, 192)';
    }
    else {
        input.style.border = '2px groove rgb(255, 115, 115)';
        return false;
    }
}

let eyePass = document.getElementById('eye');
let inputPass = document.getElementById('pass');
eyePass.addEventListener('mouseover', showPass)
eyePass.addEventListener('mouseout', hiddenPass)
function showPass() {
    inputPass.setAttribute('type', 'text')
}
function hiddenPass() {
    inputPass.setAttribute('type', 'password')
}

let inputsData = formOne.querySelectorAll('.sectionOne-formOne__element_dataBlock--input');
let blockData = formOne.querySelector('.sectionOne-formOne__element_dataBlock')

// дата от 1970-2021 года
let reg_date1 = /^(2{1}0{1}([0-1]{1}[0-9]{1}|2{1}[0-1]{1}))|1{1}9{1}[7-9]{1}[0-9]{1}$/;
let reg_date2 = /^0{1}[0-9]{1}|1{1}[0-2]{1}$/;
let reg_date3 = /^[0-2]{1}[0-9]{1}|3{1}0{1}$/;
let reg_dataSomeLetter = /[^0-9]/;
let regExpForDataInputsFromFormOne = [reg_date1, reg_date2, reg_date3];

for (let i = 0; i < inputsData.length; i++) {
    let reg = regExpForDataInputsFromFormOne[i];
    let input = inputsData[i];
    input.addEventListener('input', () => dataInput(input, reg, i));
}

let valid = ['empty', 'empty', 'empty'];
function dataInput(inp, reg, ind) {
    inp.value = inp.value.replace(reg_dataSomeLetter, '');
    if (reg.test(inp.value)) {
        valid[ind] = 'valid';
    } else if (inp.value === '') {
        valid[ind] = 'empty';
    } else {
        valid[ind] = 'invalid';
    }
    if (valid[0] === 'valid' && valid[1] === 'valid' && valid[2] === 'valid') {
        blockData.style.border = '2px groove rgb(91, 190, 91)';
    } else if (valid[0] === 'empty' && valid[1] === 'empty' && valid[2] === 'empty') {
        blockData.style.border = '2px groove rgb(192, 192, 192)';
    } else {
        blockData.style.border = '2px groove rgb(255, 115, 115)';
    }
}
let formTwo = document.querySelector('#formTwo')
let buttonForTwoForm = formTwo.querySelector('#button_twoForm')
let textarea = formTwo.message
let messageField = document.querySelector('.sectionTwo-messageOfUsers-messagesField')
formTwo.addEventListener('submit', (e) => {
    e.preventDefault();
    let messageField_emptyField = messageField.querySelector('.sectionTwo-messageOfUsers-messagesField__empty');
    if (messageField_emptyField !== null) {
        messageField.removeChild(messageField_emptyField);
    }
    let valueName = e.path[0].name.value;
    messageFieldRender(valueName);
    formTwo.name.value = '';
    formTwo.message.value = '';
})

textarea.addEventListener('input', (e) => textareaShowEmail(e))

let valueTextarea;
function textareaShowEmail(e) {
    valueTextarea = e.path[0].value
    let reg__email = /([0-9A-z_-]+@[0-9A-z_^\.]+\.[a-z]{2,3})/g
    valueTextarea = valueTextarea.replace(reg__email, "<span class='mainTextInComment-email'>$1</span>")
}
function getDecimalNumber(num, addOne) {
    if (addOne) {
        num = num + 1
    }
    let numToString = String(num)
    if (numToString.length === 1) {
        return `0${numToString}`
    } else {
        return numToString
    }
}
function messageFieldRender(valueName) {
    let newComment = document.createElement('div');
    let timeMark = `${new Date().getFullYear()}.${getDecimalNumber(new Date().getMonth(), true)}.${getDecimalNumber(new Date().getDate(), false)}  ${getDecimalNumber(new Date().getHours(), false)}:${getDecimalNumber(new Date().getMinutes(), false)}`
    newComment.innerHTML = `<p class="mainTextInComment"><span class="mainTextInComment-name">${valueName}: </span>${valueTextarea}</p> <p class='timeMarkInComment'>${timeMark}</p>`;
    messageField.prepend(newComment);
}