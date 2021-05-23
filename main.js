//* Homework-23

//? task1 функция добавляет префикс к ключам массива

const names = ['john', 'smith', 'karl'];
const prefix = 'Mr';
const newNames = autoPrefixer(names,prefix); // ['Mr john', 'Mr smith', 'Mr karl']; 

function autoPrefixer(arr,pref) {
    let res = [];
    for (key of arr) {
        res.push(`${pref} ${key}`);
    };
    return res;
};

console.log(`task1: Новый массив: `, newNames, `, старый массив: `, names);

//? task2 функция считает кол-во указанной валюты в переданном массиве

const money1 = ['eur 10', 'usd 1', 'usd 10', 'rub 50', 'usd 5'];
const money2 = ['eur 10', 'usd 1', 'eur 5', 'rub 100', 'eur 20', 'eur 100', 'rub 200'];
const money3 = ['eur 10', 'rub 50', 'eur 5', 'rub 10', 'rub 10', 'eur 100', 'rub 200'];    

function getTotalAmount(array, currency) {
    let res = 0;
    let keyValue = [];
    for (i = 0; i < array.length; i++) {
        keyValue = array[i].split(' ');
        [cur, val] = keyValue;
        if (currency == cur) {
            summ(val);
        };
    };
    function summ(value) {
        res += Number(value);
    };
    console.log(`task2: В вашем кошельке ${res} ${currency}`);
};

getTotalAmount(money1, 'usd'); // 16

//? task3 функция находит большее значение в переданном массиве

function getMax(array) {
    let res = 0;
    if (array.length == 0) {
        return console.log('task3: Массив пуст');
    };
    for (i = 0; i < array.length; i++) {
        if (array[i] > res) {
            res = array[i];
        };
    };
    console.log(`task3: Максимальное значение в массиве - ${res}`);
};
getMax([1, 10, 8]); // 10

//? task4 функция принимает массив и если его ключ является массивом, он его 'распускает'

function flatten(...array) {
    let res = [];
    for (i = 0; i < array.length; i++) {
        if (Array.isArray(array[i])) {
            for (key of array[i]) {
                res.push(key);
            };
            continue;
        };
        res.push(array[i]);
    };
    console.log(`task4: Результат 'выпрямления' массива - `, res);
};

// flatten([]); // [] 
// flatten([1, [3, 2], 9]); // [1, 3, 2, 9] 
flatten(1, [[2], [3]], [9]); // [1, [2], [3], 9] 

//! вариант решения методом тяп-ляп для полного раскрытия массива

function flatten2(array) {
    let res = '';
    for (i = 0; i < array.length; i++) {
        if (Array.isArray(array[i])) {
            for (key of array[i]) {
                res += [,key];
            };
            continue;
        };
        res += [,array[i]];
    };
    res = res.split(',');
    res[0].length === 0 ? res = res.slice(1) : res;
    let endValue = [];
    for (key of res) {
        endValue.push(Number(key));
    };
    console.log(`task4(modified 1): Результат 'выпрямления' массива - `, endValue);
};

flatten2([1, [[2], [3]], [9]]); // [ 1, 2, 3, 9 ] 

//! вариант с рекурсией и методом concat для полного раскрытия массива

function flatten3(arr) {
    let result = mergeRecursive(arr);
    function mergeRecursive(arr) {
        let res = [];
        for (let i = 0; i < arr.length; i++)  {
            let key = arr[i];
            Array.isArray(key) ? res = res.concat(mergeRecursive(key)) : res.push(key);
        };
        return res;
    };
    console.log(`task4(modified 2): Результат 'выпрямления' массива - `, result);
};

flatten3([1, [[2], [3]], [9]]); // [ 1, 2, 3, 9 ]
