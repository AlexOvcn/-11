//* Homework-20

//? TASK ONE: циклы (for, for..of, for..in, while, do..while), их разница и способ написания. (В данном примере задача функции вернуть сумму переданных ей аргументов)

//! использование массива и цикла for

let sum = (array) => {
    if (array.length === 0) {
        return 0
    };
    let result = 0;
    for (i = 0; i < array.length; i++) {
        result += array[i]
    };
    return "Сумма чисел равна: " + result
}
console.log(sum([1, 2, 3]))

//! использование цикла for..of (цикл делает обход по значениям набора аргументов)

let sum2 = (...arguments) => {
    if (arguments.length === 0) {
        return 0
    };
    let result = 0;
    for (let argument of arguments) {
        result += argument
    };
    return "Сумма чисел равна: " + result
}
console.log(sum2(1, 2, 3))

//! использование цикла for..in (цикл делает обход по индексам набора аргументов)

let sum3 = (...arguments) => {
    if (arguments.length === 0) {
        return 0
    };
    let result = 0;
    for (let key in arguments) {
        result += arguments[key]
    };
    return "Сумма чисел равна: " + result
}
console.log(sum3(1, 2, 3))

//! использование цикла while

let sum4 = (...arguments) => {
    if (arguments.length === 0) {
        return 0
    };
    let result = 0;
    let i = 0;
    while (i < arguments.length) {
        result += arguments[i];
        i++;
    }
    return "Сумма чисел равна: " + result
}
console.log(sum4(1, 2, 3))

//! использование цикла while..do

let sum5 = (...arguments) => {
    if (arguments.length === 0) {
        return 0
    };
    let result = 0;
    let i = 0;
    do {
        result += arguments[i];
        i++;
    } while (i < arguments.length)
    return "Сумма чисел равна: " + result
}
console.log(sum5(1, 2, 3))

//? TASK TWO: функция принимает два угла (целое цисло от 0 до 360) и возвращает разницу между ними

let diff = (angleOne, angleTwo) => {
    if (angleOne < 0 || angleTwo < 0 || angleOne > 360 || angleTwo > 360) {
        return "Некорректное значение"
    }
    let difference = function(angleOne, angleTwo) {
        if (angleTwo > 180 && angleOne === 0) {
            angleOne += 360
        }
        if (angleOne > 180 && angleTwo === 0) {
            angleTwo += 360
        }
        let result = angleOne - angleTwo
        if (result < 0) {
            result *= -1
        }
        return "Разница углов равна: " + result
    }
    return difference(angleOne, angleTwo)
}
console.log(diff(0, 190))

//? TASK THREE: Данная функция проверяет - является ли число переданное в аргумент функции совершенным, а конкретно: A)Находит делители числа B)Сравнивает сумму делителей с числом из аргумента функции B)Если эти значения равны, то число является совершенным

const checkingPerfectNumber = function(num) {
    if (num <= 0) {
        return "Некорректное значение"
    }
    const DivisorsOfNumber = (num) => {
        let allDivisorsOfNumber = [];
        for (i = 0; i < num; i++) {
            if (num % i == 0) {
                allDivisorsOfNumber.push(i);
            }
        }
        return allDivisorsOfNumber
    }
    let allDivisorsOfNumber = DivisorsOfNumber(num);
    let result = 0;
    for (i = 0; i < allDivisorsOfNumber.length; i++) {
        result += allDivisorsOfNumber[i]
    };
    if (result === num) {
        return `Это совершенное число, его делители: ${allDivisorsOfNumber}`
    }
    return "Это несовершенное число"
}
console.log(checkingPerfectNumber(6))

//? Необязательная задача (в дополение к 3ей задаче, алгоритм взят с той же стр. wikipedia) Алгоритм построения чётных совершенных чисел описан в IX книге Начал Евклида, где было доказано, что число (2 ** (p - 1)) * ((2 ** p) - 1) является совершенным, если число (2 ** p) - 1 является простым (т. н. простые числа Мерсенна).

let perfectNumberFrom = (num) => {
    const checkingSimpleNumber = (num) => {
        if (num <= 1) {
            return 1
        }
        const checkingTheNumberDividers = (num, acc) => {
            if (num % acc == 0) {
                return acc
            }
            return checkingTheNumberDividers(num, acc + 1)
        }
        let simpleNumber = checkingTheNumberDividers(num, 2);
        if (num === simpleNumber) {
            return true
        } else {
            return false
        }
    }
    if (checkingSimpleNumber(num) === true) {
        return `Исходя из формулы, совершенное число от простого числа ${num} равняется: ` + (2 ** (num - 1)) * ((2 ** num) - 1)
    } else {
        return "Данное значение не является простым числом"
    }
}

console.log(perfectNumberFrom(2))