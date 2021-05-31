let ageInput = document.querySelector('#age');
let heightInput = document.querySelector('#height');
let weightInput = document.querySelector('#weight');
let genderMaleRadio = document.querySelector('#gender-male');
let genderFemaleRadio = document.querySelector('#gender-female');
let activityRadioParent = document.querySelector('.radios-group');
let activityRadioChild = activityRadioParent.querySelectorAll('input');
let inputWrapper = document.querySelectorAll('.input__wrapper');
const resultButton = document.querySelector('.form__submit-button');
let form = document.querySelector('.counter__form');
const removeValueButton = document.querySelector('.form__reset-button');
let caloriesNormResult = document.querySelector('#calories-norm');
let caloriesGainResult = document.querySelector('#calories-maximal');
let caloriesLossResult = document.querySelector('#calories-minimal');
let resultWindow = document.querySelector('.counter__result');

class InputValidity {
    constructor(params) {
        this.$el = document.querySelector(params.selector);
        this.$el.addEventListener('change', () => {
            this.validity();
            this.resetButtonAccess();
        });
    };
    validity() {
        if (this.$el.validity.valid) {
            this.$el.classList.add('_valid');
        } else {
            if (this.$el.classList.contains('_valid')) {
                this.$el.classList.remove('_valid');
            };
        };
        this.submitButtonAccess();
    };
    submitButtonAccess() {
        let valid = 0;
        for (let key = 0; key < inputWrapper.length; key++) {
            let input = inputWrapper[key].getElementsByTagName('input')[0];
            if (input.classList.contains('_valid')) {
                valid +=1;
            };
        };
        if (valid == 3) {
            resultButton.disabled = false;
        } else {
            resultButton.disabled = true;
        };
    };
    resetButtonAccess() {
        if (ageInput.value !== '' || heightInput.value !== '' || weightInput.value !== '') {
            removeValueButton.disabled = false;
        } else {
            removeValueButton.disabled = true;
        };
    };
};

const ageValid = new InputValidity ({
    selector: '#age',
});
const heightValid = new InputValidity ({
    selector: '#height',
});
const weightValid = new InputValidity ({
    selector: '#weight',
});

form.addEventListener('submit', sendingFormDefault);
function sendingFormDefault(e) {
    e.preventDefault();
    calculation(activityRadioChild, ageInput, heightInput, weightInput, genderMaleRadio, genderFemaleRadio);
};

function calculation(activityRadioChild, ageInput, heightInput, weightInput, ...gender) {
    let activityСoefficient = 0;
    for (key in activityRadioChild) {
        if (activityRadioChild[key].checked) {
            if (key == 0) {
                activityСoefficient = 1.2;
            } else if (key == 1) {
                activityСoefficient = 1.375;
            } else if (key == 2) {
                activityСoefficient = 1.55;
            } else if (key == 3) {
                activityСoefficient = 1.725;
            } else {
                activityСoefficient = 1.9;
            };
        };
    };
    let N = 0;
    if (gender[0].checked) { //муж
        N = (10 * weightInput.value) + (6.25 * heightInput.value) - (5 * ageInput.value) + 5;
    } else { //жен
        N = (10 * weightInput.value) + (6.25 * heightInput.value) - (5 * ageInput.value) - 161;
    };
    let result = N * activityСoefficient;
    caloriesNormResult.innerHTML = result.toFixed(0);
    caloriesGainResult.innerHTML = calculationWeightGain(result);
    caloriesLossResult.innerHTML = calculatingWeightLoss(result);

    showingCalculationWindow()
    
    function calculationWeightGain(fromNorm) {
        return (fromNorm + fromNorm * 0.15).toFixed(0);
    };
    function calculatingWeightLoss(fromNorm) {
        return (fromNorm - fromNorm * 0.15).toFixed(0);
    };
};

function showingCalculationWindow() {
    if (resultWindow.classList.contains('counter__result--hidden')) {
        resultWindow.classList.remove('counter__result--hidden');
    };
};
function hidingCalculationWindow() {
    resultWindow.classList.add('counter__result--hidden');
};

removeValueButton.addEventListener('click', () => removeValueFunction());

function removeValueFunction() {
    activityRadioChild[0].checked = true;
    ageInput.value = '';
    heightInput.value = '';
    weightInput.value = '';
    genderMaleRadio.checked = true;
    removeValueButton.disabled = true;
    ageValid.validity();
    heightValid.validity();
    weightValid.validity();
    hidingCalculationWindow();
};
