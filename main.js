//* Homework-22

//? task1 Реализуйте функцию removeElement(array, item) для удаления элемента item из массива array

const array = [1, 2, 3, 4, 5, 6, 7];
function removeElement(array, item) {
    let res = [];
    for (key of array) {
        if (key == item) {
            continue;
        };
        res.push(key);
    };
    console.log(res);
};

removeElement(array, 5);

//? task2 Улучшите функцию из предыдущего задания для удаления нескольких элементов из массива removeElements(array, item1, ... itemN)

const array2 = ['Kiev', 'Beijing', 'Lima', 'Saratov'];
function removeElements(array, ...items) {
    let res = [];
    let arrayTwoOutput = '';
    for (keyMain of array) {
        for (key of items) {
            if (keyMain == key) {
                arrayTwoOutput = key;
                break;
            };
        };
        if (keyMain == arrayTwoOutput) {
            continue;
        };
        res.push(keyMain);
    };
    console.log(res);
};

removeElements(array2, 'Lima', 'Berlin', 'Kiev');

//? task3 Функция unique(array) должна возвращать новый массив, не содержащий дубликатов

//! решение при помощи цикла for (имеется фильтрация пробельного символа)
const result = unique(['top', 'bottom', ' top', 'left']);
function unique(tags) {
    let functionOutput = [];
    for (i = 0; i < tags.length; i++) {
        if (typeof tags[i] !== 'number') {
            tags[i] = tags[i].trim();
        };
        if (functionOutput.indexOf(tags[i]) === -1) {
            functionOutput.push(tags[i]);
        };
    };
    return functionOutput; 
};

console.log(result);

//! вариант решения с помощью метода .filter
const result2 = unique2([2, 1, 1, 3, 2]);
function unique2(array) {
    let newArray = array.filter(function(value, index) {
        return index == array.indexOf(value);
    });
    return newArray;
};

console.log(result2);

//? task4 Функция difference(array1, array2) должна находить разницу между массивами, т.е. возвращать новый массив, содержащий значения, которые содержались в array1, но не содержались в array2

const array3 = [7, -2, 10, 5, 0];
const array4 = [0, 10];
const difference = (array3, array4) => {
    let res = [];
    for (value of array3) {
        if (array4.indexOf(value) == -1) {
            res.push(value);
        };
    };
    return res;
};
const result4 = difference(array3, array4);
console.log(result4);

//? task5 Найдите максимальный элемент в двумерном массиве

const max = (array) => {
    let res = 0;
    for (i = 0; i < array.length; i++) {
        for (value of array[i]) {
            if (value > res) {
                res = value;
            };
        };
    };
    return res;
};
const m = max([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);

console.log(m);